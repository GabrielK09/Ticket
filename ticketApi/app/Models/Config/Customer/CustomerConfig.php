<?php

namespace App\Models\Config\Customer;

use Illuminate\Database\Eloquent\Model;

class CustomerConfig extends Model
{
    protected $table = 'customer_configs';

    protected $primaryKey = 'customer_config_id';

    protected $fillable = [
        'owner_id',
        'customer_config_id',
        'default_type',
        'trade_name_null',
        'phone_null',
        'address_null',
        'number_address_null',
        
    ];
}
