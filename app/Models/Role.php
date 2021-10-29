<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Models\Role AS SpatieRole;

class Role extends SpatieRole
{
    use HasFactory;

    public function rolePermissions()
    {
        return $this->hasMany(RolePermissions::class, "role_id"); 
    }
}
