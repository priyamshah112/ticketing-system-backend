<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;
    //
    protected $table = 'role_manager';
    protected $primaryKey = 'id';
    protected $fillable = [
        'role_name',
        'enable',
    ];

    public function roleAccess(){
        return $this->hasMany('App\Models\RoleAccess', 'role_id', 'id');
    }
}
