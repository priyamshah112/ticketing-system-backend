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
        'asset_name',
        'device_name',
        'hardware_type',
        'unit_price',
        'description',
        'device_number',
        'brand',
        'model',
        'serial_number',
        'floor',
        'section',
        'assigned_to',
        'assigned_on',
        'service_tag',
        'express_service_code',
        'warranty_expire_on',
        'status',
        'location',
        'notes',
        'enable',
    ];


    public function user(){
        return $this->hasOne('App\Models\User', 'id', 'assigned_to');
    }
}
