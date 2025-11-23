<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Owner extends Model
{
    protected $primaryKey = 'id';
    
    protected $table = 'owners';

    protected $fillable = [
        'user_id',
        'company_name',
        'trade_name',
        'cnpj_cpf',
        'phone', 
        'cep',
        'address',
        'number',
        'cnae',
        'activity',
        'active',

    ];
}
