<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $table = 'tickets';
    protected $fillable = [
        'subject',
        'assigned_to',
        'priority',
        'product_id',
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
