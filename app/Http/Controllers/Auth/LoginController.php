<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use App\Repositories\RolePermissionRepository;

use App\Models\User;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    private $redirectTo = '';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->redirectTo = "";
       
    }

    public function login(Request $request)
    {
        $rules = [
            'account' => 'required|string',
            'password' => 'required|string',
        ];

        $message = [
            'account.required' => '請輸入帳號',
            'password.required' => '請輸入密碼',
        ];

        $validator = $this->customValidation($request, $rules, $message);
        if ($validator->fails())
        {
            return back()->withInput()->withErrors($validator);
        }

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if (method_exists($this, 'hasTooManyLoginAttempts') &&
            $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        if ($this->attemptLogin($request)) {

            $user_id = Auth::user()->id;
            $role_permission_repo = new RolePermissionRepository();
            $permissions = $role_permission_repo->getPermissionByUser($user_id);
            $user_permissions = [];
            
            foreach($permissions as $permission){
                $user_permissions[ $permission->href ][ $permission->sys_tag ] = $permission->toArray();
            }

            //第一個可以讀取的頁面網址
            $first_href = $role_permission_repo->getPermissionByUserFirst($user_id);
            if(empty($first_href->href)){
               Auth::logout();
               return redirect('/admin')->with('message', '此帳號沒有任何頁面的權限，請聯絡管理員');
            }
            $this->redirectTo = $first_href->href;
            Session::put("user_permissions", $user_permissions);
            Session::put("user", User::where("id", $user_id)->first()->toArray());
            Session::save();

            return $this->sendLoginResponse($request);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }
    
    /**
     * logout controller instance.
     *
     * @return void
     */
    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        if ($response = $this->loggedOut($request)) {
            return $response;
        }

        return Redirect::back()->with('message','Operation Successful !');
    }

    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function username()
    {
        return 'account';
    }
}
