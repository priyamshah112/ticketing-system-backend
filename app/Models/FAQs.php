<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FAQs extends Model
{
    use HasFactory;
    protected $table = 'faqs';
    protected $primaryKey = 'id';
    protected $fillable = [
        'category',
        'question',
        'answer',
        'enable',
    ];
}
