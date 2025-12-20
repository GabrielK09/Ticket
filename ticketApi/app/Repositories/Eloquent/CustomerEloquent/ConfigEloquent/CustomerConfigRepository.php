<?php

namespace App\Repositories\Eloquent\CustomerEloquent\ConfigEloquent;

use App\Models\Config\Customer\CustomerConfig;
use App\Repositories\Interfaces\Customer\Config\CustomerConfigContract;
use Exception;

class CustomerConfigRepository implements CustomerConfigContract
{
    private function getFirstOrCreate(string $ownerId)
    {
        return CustomerConfig::firstOrCreate(
            ['owner_id' => $ownerId],
            [
                'customer_config_id' => $ownerId
            ]
        );
    }

    public function show(string $id)
    {
        return $this->getFirstOrCreate($id);
    }

    public function update(array $data)
    {
        $config = $this->getFirstOrCreate($data['owner_id']);

        $config->fill([
            'default_type' => $data['default_type'],
            'trande_name_null' => $data['trande_name_null'],
            'phone_null' => $data['phone_null'],
            'address_null' => $data['address_null'],
            'number_address_null' => $data['number_address_null'],

        ])->save();

        return $config;
    }
}