<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Managers extends Model
{
    use HasFactory;
    protected $table = 'managers';
    protected $primaryKey = 'id';
    protected $fillable = [
        'manager_name',
        'enable',
    ];

}
