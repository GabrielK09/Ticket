<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Historical extends Model
{
    protected $table = 'historicals';

    protected $fillable = [
        'owner_id',
        'customer_id',
        'techinical_id',
        'description',
        'customer_id',
        'customer',
        'enterprise',
        'techinical_id',
        'techinical',
        'old_status',
        'new_status',
    ];
}
