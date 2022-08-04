<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UI extends Model
{
    use HasFactory;
    protected $table = 'ui';
    protected $primaryKey = 'id';
    protected $fillable = [
        'subject',
        'category',
        'link',
        'file',
        'enable',
    ];
}
