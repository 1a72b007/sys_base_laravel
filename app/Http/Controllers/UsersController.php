<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{
    User,
    Store,
    Common
};
use App\Http\Requests\User\{
    ProfileModify as RequetsProfileModify
};
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Exceptions\HttpResponseException;
use Exception as GlobalException;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Arr;

class UsersController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        // $this->middleware('admin');
    }

    public function index()
    {
        $you = auth()->user();
        
        $roles = Role::all()->toArray();

        $users = User::with('modelHasRoles', 'roles')->get()->toArray();

        return view('dashboard.admin.usersList', compact('users', 'roles', 'you'));
    }

    public function store(Request $request)
    {

        $rules = [
            'name'       => 'required|min:1|max:256',
            'account' => ['required', 'string', 'max:255', 'unique:users,account,NULL,id,deleted_at,NULL'],
            'password' => 'required|string|min:6',
            'password_confirmation' => 'required|string|same:password|min:6',
            'role_id' => 'required|array',
            'email' => 'nullable|email',
            'picinfo' => ' mimes:jpg,jpeg,png'
        ];

        $message = [
            'name.required' => '請輸入人員名稱', 
            'account.required' => '請輸入帳號',
            'account.unique' => '此帳號已使用過',
            'password.required' => '請輸入密碼',
            'password.min' => '密碼最少需輸入6字元',
            'password_confirmation.required' => '請輸入確認密碼',
            'password_confirmation.min' => '確認密碼最少需輸入6字元',
            'password_confirmation.same' => '密碼與確認密碼不相符',
            'role_id.required' => '請選擇權限群組',
            'picinfo.mimes' => '照片請選擇png、jpg、jpeg格式'
        ];

        $validator = $this->customValidation($request, $rules, $message);
        if ($validator->fails())
        {
            return back()->withInput()->withErrors($validator);
        }

        //圖片base64路徑
        $base64_url = "";
        if($request->hasFile('picinfo')){
            $mime_type = $request->file('picinfo')->getMimeType();
            $img_base64 = base64_encode(file_get_contents($request->file('picinfo')->path()));
            $base64_url = "data:".$mime_type.";base64,".$img_base64;
        }

        $user = new User();
        $user->password = Hash::make($request->input('password'));
        $user->name       = $request->input('name');
        $user->account      = $request->input('account');
        $user->email      = $request->input('email');
        $user->picinfo      =  $base64_url;
        $user->remark      = $request->input('remark');

        $roles = Role::find($request->input('role_id'))->toArray();

        foreach($roles as $role){
            $user->assignRole(''.$role['name'].'');
        }
        $user->save();

        $request->session()->flash('message', '新增成功');
        return redirect()->route('users.index');
    }

    public function show($id)
    {
        $user = User::with('modelHasRoles')->find($id)->makeVisible(['picinfo']);
        $user->roles = Arr::pluck($user->modelHasRoles, 'role_id');
        return json_encode($user);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $user = User::with('position','modelHasRoles')->find($request->input('id'))->makeVisible(['picinfo']);
        $user->roles = Arr::pluck($user->modelHasRoles, 'role_id');
        return json_encode($user);
    }

    public function update(Request $request, $id)
    {
        $rules = [
            'name'       => 'required|min:1|max:256',
            'role_id' => 'required|array',
            'picinfo' => ' mimes:jpg,jpeg,png'
        ];

        $message = [
            'name.required' => '請輸入人員名稱',
            'role_id.required' => '請選擇權限群組',
            'picinfo.mimes' => '照片請選擇png、jpg、jpeg格式'
        ];

        $validator = $this->customValidation($request, $rules, $message);
        if ($validator->fails())
        {
            return back()->withErrors($validator);
        }
       
        $user = User::find($request->input('id'));
        $user->name       = $request->input('name');
        $user->email       = $request->input('email');
        $user->remark      = $request->input('remark');
        $original_role = $request->input('original_role');
        $role_id = $request->input('role_id');

        //如果有傳圖片且
        if($request->hasFile('picinfo')){
            $mime_type = $request->file('picinfo')->getMimeType();
            $img_base64 = base64_encode(file_get_contents($request->file('picinfo')->path()));
            $base64_url = "data:".$mime_type.";base64,".$img_base64; //圖片base64路徑
            $user->picinfo      =  $base64_url;
        }elseif(!$request->hasFile('picinfo') && $request->input('del_img') == "Y"){
            $user->picinfo      =  "";
        }
     

        $roles = Role::find($request->input('role_id'))->toArray();
        foreach($roles as $role){
            $user->assignRole(''.$role['name'].'');
        }
        if(!empty($original_role)){
            $original_role = explode(",", $original_role);
            foreach($original_role as $original){
                if(!in_array($original, $role_id)){
                //     $roles = Role::find($original)->toArray();
                //     $user->assignRole(''.$roles['name'].'');
                // }else{
                    $roles = Role::find($original)->toArray();
                    $user->removeRole(''.$roles['name'].'');
                }
            }
        }
            
        $user->save();
        $request->session()->flash('message', '更新成功');
        return redirect()->route('users.index');
    }

    public function destroy(Request $request)
    {
        $id = $request->input("id");
        $user = User::find($id);
        if($user){
            $user->delete();
        }
        $request->session()->flash('message', '刪除成功');
        return redirect()->route('users.index');
    }

    public function resetPassword($user_id){

        $user = User::where("id", $user_id)
            ->firstOr(function(){
                throw new HttpResponseException(response(["result" => "", "message" => "Not Found User"], 400));
            });
        $random_password = rand(1000,9999);

        DB::beginTransaction();

        try {
            $user->password = Hash::make($random_password);
            $user->save();
        
        } catch (GlobalException $e) {
            DB::rollBack();
            throw new HttpResponseException(response(["result" => json_encode($e), "message" => "The server failed"], 500));
        }

        DB::commit();

        return response($random_password, 200);

    }

    public function profile(){
        $user = User::where("id", Auth::user()->id)
            ->firstOr(function(){
                throw new HttpResponseException(response(["result" => "", "message" => "Not Found User"], 400));
            });

        return view('user.profile', compact( 
            'user'
        ));

    }

    public function profileModify(RequetsProfileModify $request){

        $user = User::where("id", Auth::user()->id)
            ->firstOr(function(){
                throw new HttpResponseException(response(["result" => "", "message" => "Not Found User"], 400));
            });

        DB::beginTransaction();

        try {
            $user->fill($request->validated())->save();
        } catch (GlobalException $e) {
            DB::rollBack();
            return back()->withErrors($e->getMessage());
        }
        DB::commit();

        $request->session()->flash('message', '儲存成功');
        return redirect()->route('user.profile');

    }

    public function changePassword(Request $request){

        $user = User::where("id", Auth::user()->id)
            ->firstOr(function(){
                throw new HttpResponseException(response(["result" => "", "message" => "Not Found User"], 400));
            });

        if (!Hash::check($request->old_password, $user->password)) {
            throw new HttpResponseException(response(["Old Password Is Wrong"], 400));
        }

        if (strlen($request->new_password) < 6) {
            throw new HttpResponseException(response(["New password need to more 6 charater"], 400));
        }

        DB::beginTransaction();

        try {
            $user->password = Hash::make($request->new_password);
            $user->save();
        } catch (GlobalException $e) {
            DB::rollBack();
            $message = "The server failed";
            if ($e->getCode() == 1) {
                $message = $e->getMessage();
            }
            throw new HttpResponseException(response(["result" => $e->getMessage(), "message" => $message], 500));
        }

        DB::commit();

        return response(null, 204);

    }

   
}
