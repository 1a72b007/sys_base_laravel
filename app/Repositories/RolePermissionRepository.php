<?php

namespace App\Repositories;

use App\Models\RolePermissions;
use Illuminate\Support\Facades\DB;
use App\Models\Menus;
class RolePermissionRepository
{
    private $permission_tableNames = '';

    public function __construct()
    {
        $this->permission_tableNames = config('permission.table_names');
    }

    /**
     * 抓取欄位資料
     * @param array $where    設定條件
     * @param mixed $select       限定輸出的欄位，若不送參數則不更動CI的預設值
     * @param mixed $order_by       設定排序
     * @param bool $return_type       限定輸出陣列或單一物件或數列數
     * @param int $offset
     * @param int $limit
     */    
    public function getRolePermission($where = [], $select = [], $return_type = 'array', $order_by = [], $offset = '', $limit = '')
    {
        
        $query = DB::table($this->permission_tableNames['role_has_permissions'])
                   ->join($this->permission_tableNames['permissions'], $this->permission_tableNames['permissions'].'.id', '=', $this->permission_tableNames['role_has_permissions'].'.permission_id')
                   ->join('menus', 'menus.id', '=', $this->permission_tableNames['role_has_permissions'].'.menu_id')
                   ->join('roles', 'roles.id', '=', $this->permission_tableNames['role_has_permissions'].'.role_id');

        if (count($where) > 0) {

            $query->Where($where);

        }
        
        if (count($select) > 0) {
            foreach ($select as $key => $value) {
                if (is_numeric($key)) {
                    $query->addSelect($value);
                } else {
                    $query->addSelect("$key as $value");
                }
            }
        } else {
            $query->select($this->permission_tableNames['role_has_permissions'].'.*');
        }

        if (count($order_by) > 0) {
            foreach ($order_by as $key => $value) {
                $query->orderByRaw($key, $value);
            }
        } else {
            $query->orderByRaw($this->permission_tableNames['role_has_permissions'].".id DESC");
        }

        if (strlen($offset) > 0) {
            $query->offset($offset)->limit($limit);
        }

        return $this->final_action($return_type, $query);
    }
    
    private function final_action($action = null, $query)
    {
        switch ($action) {
            case 'array':
                $result = $query->get()->toArray();
                break;
            case 'obj':
                $result = $query->get();
                break;
            case 'count':
                $result = $query->count();
                break;
            case 'echo':
                $result = $query->toSql();
                break;
            case 'first':
                $result = $query->first();
                break;
            case 'sql':
                break;
        }
        
        return $result;
    }

    public function create($role_id, $menu_id, $permission_id)
    {
        $role_permission = new RolePermissions();

        $role_permission->role_id = $role_id;
        $role_permission->menu_id = $menu_id;
        $role_permission->permission_id = $permission_id;
        $role_permission->is_use = 0;
        $role_permission->save();

    }

    public function getPermissionByUser($user_id)
    {
        $result = RolePermissions::select($this->permission_tableNames['role_has_permissions'].'.permission_id', DB::raw('max('.$this->permission_tableNames['role_has_permissions'].'.is_use) as is_use'), $this->permission_tableNames['role_has_permissions'].'.menu_id',  $this->permission_tableNames['permissions'].'.sys_tag', 'menus.href')
            ->join($this->permission_tableNames['model_has_roles'], $this->permission_tableNames['model_has_roles'].'.role_id', '=', $this->permission_tableNames['role_has_permissions'].'.role_id')
            ->join('menus', 'menus.id', '=', $this->permission_tableNames['role_has_permissions'].'.menu_id')
            ->join($this->permission_tableNames['permissions'], $this->permission_tableNames['permissions'].'.id', '=', $this->permission_tableNames['role_has_permissions'].'.permission_id')
            ->where($this->permission_tableNames['model_has_roles'].'.model_id', '=', $user_id)
            ->groupBy($this->permission_tableNames['role_has_permissions'].'.menu_id', $this->permission_tableNames['role_has_permissions'].'.permission_id')
            ->get(); 

        return $result;
    }

    public function getPermissionByUserFirst($user_id)
    {
        $result = RolePermissions::select('menus.href')
            ->join($this->permission_tableNames['model_has_roles'], $this->permission_tableNames['model_has_roles'].'.role_id', '=', $this->permission_tableNames['role_has_permissions'].'.role_id')
            ->join('menus', 'menus.id', '=', $this->permission_tableNames['role_has_permissions'].'.menu_id')
            ->where($this->permission_tableNames['model_has_roles'].'.model_id', '=', $user_id)
            ->where($this->permission_tableNames['role_has_permissions'].'.is_use', '=', 1)
            ->where($this->permission_tableNames['role_has_permissions'].'.permission_id', '=', 1)
            ->groupBy($this->permission_tableNames['role_has_permissions'].'.menu_id', $this->permission_tableNames['role_has_permissions'].'.permission_id')
            ->first(); 

        return $result;
    }

    public function getPermissionDropdownByRole($menuId, $role_id)
    {
        $permission_parent =  Menus::select('menus.parent_id')
            ->join($this->permission_tableNames['role_has_permissions'], $this->permission_tableNames['role_has_permissions'].'.menu_id', '=', 'menus.id')
            ->where('menus.menu_id', '=', $menuId)
            ->where($this->permission_tableNames['role_has_permissions'].'.permission_id', '=', 1)
            ->where($this->permission_tableNames['role_has_permissions'].'.is_use', '=', 1)
            ->where($this->permission_tableNames['role_has_permissions'].'.role_id', '=', $role_id)
            ->groupBy("menus.parent_id");

        $result = Menus::select('menus.*')
            ->joinSub($permission_parent, 'permission_parent', function ($join) {
                $join->on('menus.id', '=', 'permission_parent.parent_id');
            })
            ->where('menus.slug', '=', 'dropdown')
            ->get();

        return $result;
    }

    public function getPermissionDropdownByUser($menuId, $user_id)
    {
        $permission_parent =  Menus::select('menus.parent_id')
            ->join($this->permission_tableNames['role_has_permissions'], $this->permission_tableNames['role_has_permissions'].'.menu_id', '=', 'menus.id')
            ->join($this->permission_tableNames['model_has_roles'], $this->permission_tableNames['model_has_roles'].'.role_id', '=', $this->permission_tableNames['role_has_permissions'].'.role_id')
            ->where('menus.menu_id', '=', $menuId)
            ->where($this->permission_tableNames['role_has_permissions'].'.permission_id', '=', 1)
            ->where($this->permission_tableNames['role_has_permissions'].'.is_use', '=', 1)
            ->where($this->permission_tableNames['model_has_roles'].'.model_id', '=', $user_id)
            ->groupBy("menus.parent_id");

        $result = Menus::select('menus.*')
            ->joinSub($permission_parent, 'permission_parent', function ($join) {
                $join->on('menus.id', '=', 'permission_parent.parent_id');
            })
            ->where('menus.slug', '=', 'dropdown')
            ->orderBy('menus.sequence', 'ASC')
            ->get();

        return $result;
    }

    public function getPermissionMenusByUser($menuId, $user_id)
    {
        $result = Menus::select('menus.*')
            ->join($this->permission_tableNames['role_has_permissions'], $this->permission_tableNames['role_has_permissions'].'.menu_id', '=', 'menus.id')
            ->join($this->permission_tableNames['model_has_roles'], $this->permission_tableNames['model_has_roles'].'.role_id', '=', $this->permission_tableNames['role_has_permissions'].'.role_id')
            ->where('menus.menu_id', '=', $menuId)
            ->where($this->permission_tableNames['role_has_permissions'].'.permission_id', '=', 1)
            ->where($this->permission_tableNames['role_has_permissions'].'.is_use', '=', 1)
            ->where($this->permission_tableNames['model_has_roles'].'.model_id', '=', $user_id)
            ->groupBy('menus.id')
            ->orderBy('menus.sequence', 'asc')
            ->get(); 

        return $result;
    }

    public function update($id, $is_use)
    {

        $role_permission = RolePermissions::find($id);
        $role_permission->is_use = $is_use;
        $result = $role_permission->save();

        return $result;
    }

}
