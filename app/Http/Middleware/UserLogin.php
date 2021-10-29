<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

use App\Models\Users;

class UserLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if(Session::has("user")){
            $user = Session::get("user");
            isset($user["id"]) ? null: function(){
                throw new HttpResponseException(response("No Auth", 403));
            };

            Users::where('id', $user["id"])->firstOr(function(){
                throw new HttpResponseException(response("No Auth", 403));
            });
        }else{
            throw new HttpResponseException(response("No Auth", 403));
        }

        return $next($request);
    }
}
