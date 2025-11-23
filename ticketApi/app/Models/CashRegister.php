<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CashRegister extends Model
{
    protected $primaryKey = 'cash_register_id';

    protected $table = 'cash_registers';

    protected $fillable = [
        'cash_register_id',
        'owner_id',
        'customer_id',
        'pay_ment_form_id',
        'pay_ment_form', 
        'customer', 
        'input_value', 
        'output_value', 
        'balance', 
    ];
}
