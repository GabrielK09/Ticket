<?php

namespace App\Models\Config\Technicel;

use Illuminate\Database\Eloquent\Model;

class TechnicelConfig extends Model
{
    protected $table = 'technicel_configs';

    protected $primaryKey = 'technicel_config_id';

    protected $fillable = [
        'technicel_config_id',
        'owner_id',
        'default_type',
        'trade_name_null',
        'phone_null',
        'address_null',
        'number_address_null',
        'default_commission_type',
        'fixed_commission_value',
        
    ];
}
