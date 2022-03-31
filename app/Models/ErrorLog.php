<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ErrorLog extends Model
{
    const ExceptionMessage = "Somthing Went wrong";

    protected $fillable = [
        'function', 'filename', 'line', 'exception'
    ];
}
