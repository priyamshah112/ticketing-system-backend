<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketActivity extends Model
{
    use HasFactory;
    protected $table = 'ticket_activity';
    protected $fillable = [
        'ticket_id',
        'activity_by',
        'message',
        'images',
        'status',
    ];
}
