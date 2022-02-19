<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Software extends Model
{
    use HasFactory;
    protected $table = 'software_inventory';
    protected $primaryKey = 'id';
    protected $fillable = [
        'name',
        'version',
        'key',
        'assigned_to',
        'assigned_on',
        'expiry_date',
        'status',
        'notes',
        'enable',
    ];


    public function user(){
        return $this->hasOne('App\Models\User', 'id', 'assigned_to');
    }
}
