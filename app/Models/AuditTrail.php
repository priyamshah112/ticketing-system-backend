<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditTrail extends Model
{
    use HasFactory;
    protected $table = 'audit_trails';
    protected $primaryKey = 'id';
    protected $fillable = [
        'message',
        'operation',
        'manager'
    ];
}
