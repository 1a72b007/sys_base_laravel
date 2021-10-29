<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;
use App\Models\Menus;

class RolePermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tableNames = config('permission.table_names');

        DB::beginTransaction();

        $roles = DB::table($tableNames["roles"])->get();
        $menus = Menus::select("id")
                    ->where("slug", "!=", "dropdown")
                    ->where("menu_id", 1)
                    ->get();
        $permissions = DB::table($tableNames["permissions"])->get();
        foreach($roles as $role){
            foreach($menus as $menu){
                foreach($permissions as $permission){
                    $is_use = 0;
                    if(($role->name == "admin")
                        ||($menu->href == "/admin/dashboard")){
                        $is_use = 1;
                    }
                    $this->insertRolePermission($tableNames, $role->id, $menu->id, $permission->id, $is_use);
                }
            }
        }

        DB::commit();
    }

    public function insertRolePermission($tableNames, $role_id, $menu_id, $permission_id, $is_use)
    {
        DB::table($tableNames["role_has_permissions"])->insert([
            "role_id" => $role_id,
            "menu_id" => $menu_id,
            "is_use" => $is_use,
            "permission_id" => $permission_id,
        ]);
    }
}
