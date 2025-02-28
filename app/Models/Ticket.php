<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ticket extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tickets';
    protected $fillable = [
        'subject',
        'assigned_to',
        'priority',
        'created_by',
        'status',
        'closed_at',
        'closed_by',
    ];

    public function ticketActivity(){
        return $this->hasMany('App\Models\TicketActivity', 'ticket_id', 'id');
    }
    public function user(){
        return $this->hasOne('App\Models\User', 'id', 'created_by');
    }
    public function support(){
        return $this->hasOne('App\Models\User', 'id', 'assigned_to');
    }
}
