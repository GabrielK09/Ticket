<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $table = 'customers';

    protected $fillable = [
        'owner_id',
        'customer_id',
        'company_name',
        'trade_name',
        'cnpj_cpf',
        'phone', 
        'cep',
        'address',
        'number',
        'active'
    ];
}
