<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionSeeder extends Seeder
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

        DB::table($tableNames['permissions'])->insert([
            "name" => "讀取",
            "guard_name" => "web",
            "sys_tag" => "read",
            "is_default" => "1"
        ]);

        DB::table($tableNames['permissions'])->insert([
            "name" => "新增",
            "guard_name" => "web",
            "sys_tag" => "create",
            "is_default" => "1"
        ]);

        DB::table($tableNames['permissions'])->insert([
            "name" => "編輯",
            "guard_name" => "web",
            "sys_tag" => "update",
            "is_default" => "1"
        ]);

        DB::table($tableNames['permissions'])->insert([
            "name" => "刪除",
            "guard_name" => "web",
            "sys_tag" => "delete",
            "is_default" => "1"
        ]);

        DB::commit();
    }
}
