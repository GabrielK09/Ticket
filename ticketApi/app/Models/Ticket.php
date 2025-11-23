<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $primaryKey = 'ticket_id';

    protected $table = 'tickets';

    protected $fillable = [
        'ticket_id',
        'ticket_code',
        'owner_id',
        'customer_id',
        'title',
        'description',
        'priority',
        'location',
        'customer',
        'location_value',
        'increase_value',
        'increase_tpye',
        'discount_value',
        'discount_type',
        'base_value',
        'total_value',
        'status',
        'date_paid',
        'in_progress',
        'finish',
        'canceled'
    ];
}
