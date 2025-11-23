<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Techinical extends Model
{
    protected $table = 'techinicals';

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
