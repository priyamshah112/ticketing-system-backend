<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoleAccess extends Model
{
    use HasFactory;
    protected $table = 'role_access';
    protected $primaryKey = 'id';
    protected $fillable = [
        'role_id',
        'manager_id',
        'mode', // View or Edit
        'enable',
    ];

    public function manager(){
        return $this->hasOne('App\Models\Managers', 'id', 'manager_id');
    }
}
