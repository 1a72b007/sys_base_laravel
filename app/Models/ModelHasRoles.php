<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role;

class ModelHasRoles extends Model
{
    use HasFactory;

    protected $table = "model_has_roles";

    protected $guarded = [];

    public function users(){
        return $this->belongsToMany(User::class, "model_id", "id");
    }

    public function roles(){
        return $this->belongsTo(Role::class, "role_id", "id");
    }
}
