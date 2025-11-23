<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PayMentForm extends Model
{
    protected $table = 'pay_ment_forms';

    protected $fillable = [
        'pay_ment_form_id',
        'owner_id',
        'pay_ment_form',
        'type',
    ];
}
