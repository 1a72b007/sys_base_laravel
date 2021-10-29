<?php

namespace App\Http\Controllers;

use App\Models\Menus;
use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\RolePermissions;
use App\Models\Permissions;
use Illuminate\Support\Facades\DB;
use App\Repositories\RolePermissionRepository;
use Illuminate\Support\Arr;

class RolesController extends Controller
{
    private $permission_tableNames = '';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->permission_tableNames = config('permission.table_names');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = DB::table('roles')
        ->select('roles.*')
        ->get();
        return view('dashboard.roles.index', array(
            'roles' => $roles,
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'name'       => 'required'
        ];

        $message = [
            'name.required' => '請輸入群組名稱'
        ];

        $validator = $this->customValidation($request, $rules, $message);
        if ($validator->fails())
        {
            return back()->withErrors($validator);
        }

        //新增權限群組
        $role = new Role();
        $role->name = $request->input('name');
        $role->save();

        $copy_role = $request->input("copy_role"); //複製對象群組id
        //判斷是否有選擇複製對象
        if(empty($copy_role)){

            $menus = Menus::select("id", "href")
                            ->where("slug", "link")
                            ->where("menu_id", 1)
                            ->get();
    
            $permissions = Permissions::where("is_default", 1)->get(); //取得預設

            foreach($menus as $menu){
                $is_use = 0;

                if($menu->href == "/admin/dashboard"){
                    $is_use = 1;
                }
    
                foreach($permissions as $permission){
    
                    $role_permission = new RolePermissions();

                    $role_permission->role_id = $role->id;
                    $role_permission->menu_id = $menu->id;
                    $role_permission->permission_id = $permission->id;
                    $role_permission->is_use = $is_use;
                    $role_permission->save();
                }
    
            }

        }else{
            $copy_role_permissions = RolePermissions::where("role_id", $copy_role)->get(); //取得複製對象的權限

            DB::beginTransaction();
            foreach($copy_role_permissions as $copy_permission){

                $role_permission_model = new RolePermissions();
                $role_permission_model->role_id = $role->id;
                $role_permission_model->menu_id = $copy_permission->menu_id;
                $role_permission_model->permission_id = $copy_permission->permission_id;
                $role_permission_model->is_use = $copy_permission->is_use;
                $role_permission_model->save();

            }
            DB::commit();

        }
        
        return back()->with('message', '新增成功');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // return view('dashboard.roles.edit', array(
        //     'role' => Role::where('id', '=', $id)->first()
        // ));
        $role_permission_repo = new RolePermissionRepository();

        $where = [
            [$this->permission_tableNames['role_has_permissions'].'.role_id', '=', $id],
            [$this->permission_tableNames['role_has_permissions'].'.menu_id', '!=', 1]
        ];
        
        //權限方式數量
        $permission_num = Permissions::whereHas('hasRolePermissions', function($query) use ($id) {
                                            $query->where("role_id", $id);
                                        })->count();

        $role_permissions = $role_permission_repo->getRolePermission($where, [
            $this->permission_tableNames['role_has_permissions'].'.id AS id',
            $this->permission_tableNames['permissions'].'.name AS permissions_name', 
            'menus.id AS menu_id', 
            'menus.parent_id AS parent_id', 
            'menus.name AS menu_name', 
            $this->permission_tableNames['role_has_permissions'].'.is_use', 
        ], 'array', ['menus.sequence' => "ASC", $this->permission_tableNames['permissions'].'.id' => "ASC" ]);

        $dropdowns = Menus::where([['menu_id', '=', 1], ['slug', '=', 'dropdown']])->get();
        // $menu_id_ary = Arr::pluck($role_permission, 'menu_name');
        $permission_ary = [];
        foreach($role_permissions as $permission){
            $permission_ary[$permission->menu_id]['data'][] = $permission;
            $permission_ary[$permission->menu_id]['menu_name'] = $permission->menu_name;
            $permission_ary[$permission->menu_id]['parent_id'] = $permission->parent_id;
        }

        $role_permissions_ids = Arr::pluck($role_permissions, 'id'); //將role_permission的id整合成陣列
        
        $result['role'] = Role::where('id', '=', $id)->first();
        $result['permission'] = $permission_ary;
        $result['role_permissions_ids'] = $role_permissions_ids;
        $result['dropdowns'] = $dropdowns;
        $result['permission_num'] = $permission_num;
        
        return json_encode($result);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {

        $rules = [
            'name'       => 'required'
        ];

        $message = [
            'name.required' => '請輸入群組名稱'
        ];
        
        $validator = $this->customValidation($request, $rules, $message);
        if ($validator->fails())
        {
            return back()->withErrors($validator);
        }

        $role_id = $request->input('id');

        $role = Role::where('id', '=',  $role_id)->first();
        $role->name = $request->input('name');
        $role->save();

        //dashboard保持權限全開
        $dashboard_permission = RolePermissions::where([
                                                    ['role_id', '=', $role_id], 
                                                    ['menu_id', '=', 1],
                                                    ['is_use', '=', 0]
                                                ])
                                                ->update(['is_use' => 1]);

        //勾選的權限id
        $permission_id = $request->input("permission_id");

        $role_permission_repo = new RolePermissionRepository();

        if(empty($permission_id)){
            $permission_id = [];
        }
        //所有的權限id
        $role_permissions_ids = $request->input("role_permissions_ids");

        if(empty($role_permissions_ids)){
            $role_permissions_ids = [];
        }else{
            $role_permissions_ids = explode(",", $role_permissions_ids);
        }
        
        //id存在勾選的權限則更新1，不存在則更新0
        foreach($role_permissions_ids as $id){
            if(in_array($id, $permission_id)){
                $role_permission_repo->update($id, 1);
            }else{
                $role_permission_repo->update($id, 0);
            }
        }

        return back()->with('message', '更新成功');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $request)
    {
        $role = Role::where('id', '=', $id)->first();
        $role->rolePermissions()->delete();
        $role->delete();

        return back()->with('message', '刪除成功');
    }
}
