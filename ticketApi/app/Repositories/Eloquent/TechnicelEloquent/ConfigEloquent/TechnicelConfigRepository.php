<?php

namespace App\Repositories\Eloquent\TechnicelEloquent\ConfigEloquent;

use App\Models\Config\Technicel\TechnicelConfig;
use Exception;

class TechnicelConfigRepository
{
    private function getFirstOrCreate(string $ownerId)
    {
        return TechnicelConfig::firstOrCreate(
            ['owner_id' => $ownerId],
            [
                'technicel_config_id' => $ownerId
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
            'trade_name_null' => $data['trade_name_null'],
            'phone_null' => $data['phone_null'],
            'address_null' => $data['address_null'],
            'number_address_null' => $data['number_address_null'],
            'default_commission_type' => $data['default_commission_type'],
            'fixed_commission_value' => $data['fixed_commission_value'],

        ])->save();

        return $config;
    }
}