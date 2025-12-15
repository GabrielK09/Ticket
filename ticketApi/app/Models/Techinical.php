<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class technical extends Model
{
    protected $table = 'technicals';

    protected $fillable = [
        'company_name',
        'trade_name',
        'cnpj_cpf',
        'phone', 
        'cep',
        'address',
        'number',  
        'gender',  
        'availability',  
    ];
}
