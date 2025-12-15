<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Historical extends Model
{
    protected $table = 'historicals';

    protected $fillable = [
        'owner_id',
        'customer_id',
        'technical_id',
        'description',
        'customer_id',
        'customer',
        'enterprise',
        'technical_id',
        'technical',
        'old_status',
        'new_status',
    ];
}
