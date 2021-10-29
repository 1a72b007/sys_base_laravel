<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Models\Menus;

class RolePermissions extends Model
{
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    
    public function __construct()
    {
        $this->table = config('permission.table_names')['role_has_permissions'];
    }

    protected $primaryKey = 'id'; 
    // protected $dateFormat = 'U';  //時間戳轉換unxtime

    //create時允許的欄位
    protected $fillable = [
    ];

    function permissions(){
        return $this->belongsTo(Permissions::class, "permission_id", "id"); 
    }

    function role(){
        return $this->belongsTo(Role::class, "role_id", "id"); 
    }

    function menus(){
        return $this->belongsTo(Menus::class, "menu_id", "id"); 
    }
}
