<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Models\Permission AS SpatiePermission;

class Permissions extends SpatiePermission
{
    use HasFactory;

    public function rolePermissions(){
        return $this->hasMany(RolePermissions::class, "permission_id", "id");
    }
    
    public function hasRolePermissions(){
        return $this->hasMany(RolePermissions::class, "permission_id", "id")
                ->select([
                    'permission_id',
                    'menu_id',
                    'role_id',
                ])
                ->groupBy('permission_id', 'menu_id');
                
    }
}
