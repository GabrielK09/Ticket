<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PayMentTicket extends Model
{
    protected $table = 'pay_ment_tickets';

    protected $fillable = [
        'pay_ment_ticket_id',
        'owner_id',
        'enterprise',
        'amount_paid',
    ];
}
