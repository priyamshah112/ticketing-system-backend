<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UI extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'ui';
    protected $primaryKey = 'id';
    protected $fillable = [
        'subject',
        'category',
        'link',
        'file',
    ];
}
