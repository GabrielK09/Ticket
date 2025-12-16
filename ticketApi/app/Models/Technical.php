<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Technical extends Model
{
    protected $table = 'technicals';

    protected $primaryKey = 'technical_id';

    protected $fillable = [
        'technical_id',
        'owner_id',
        'company_name',
        'trade_name',
        'cnpj_cpf',
        'phone', 
        'cep',
        'address',
        'number',  
        'gender',  
        'availability',  
        'active',  
    ];
}
