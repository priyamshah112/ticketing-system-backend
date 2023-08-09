<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Inventory extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'inventory';
    protected $primaryKey = 'id';
    protected $fillable = [
        'name',
        'category_id',
        'version',
        'key',
        'device_name',
        'description',
        'device_number',
        'brand',
        'model',
        'serial_number',
        'floor',
        'section',
        'express_service_code',
        'warranty_expire_on',
        'location',
        'notes',
        'expiry_date',
        'price',
        'type',
        'assigned_to',
        'assigned_on'
    ];
    protected $hidden = [ 'deleted_at' ];


    public function category(){
        return $this->hasOne('App\Models\Category', 'id', 'category_id');
    }
    
    public function user(){
        return $this->hasOne('App\Models\User', 'id', 'assigned_to');
    }
}
