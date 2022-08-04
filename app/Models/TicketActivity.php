<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TicketActivity extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'ticket_activity';
    protected $fillable = [
        'ticket_id',
        'activity_by',
        'message',
        'files',
        'status',
    ];
}
