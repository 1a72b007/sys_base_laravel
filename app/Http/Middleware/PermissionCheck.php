<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Models\RolePermission;
use App\Repositories\RolePermissionRepository;
use Illuminate\Support\Arr;
use App\Models\RoleHierarchy;

class PermissionCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $method = $request->method();
        $has_permission = 1;
        switch ($method) {
            case 'GET':
                $has_permission = getActionPermission('read');
                break;
                
            case 'POST':
                $has_permission = getActionPermission('create') || getActionPermission('update');
                break;

            case 'PUT':
                $has_permission = getActionPermission('create') || getActionPermission('update');
                break;

            case 'PATCH':
                $has_permission = getActionPermission('update');
                break;

            case 'DELETE':
                $has_permission = getActionPermission('delete');
                break;
        }
        if($has_permission != 1) {
            abort('403');
        }
        return $next($request);
    }
}
