<?php

namespace App\Services\Customer\Config;

use App\Repositories\Interfaces\Customer\Config\CustomerConfigContract;
use Illuminate\Support\Facades\DB;

class CustomerConfigService 
{
    public function __construct(
        protected CustomerConfigContract $customerConfigRepository
    ){}


    public function show(string $id)
    {
        $config = $this->customerConfigRepository->show($id);

        return $config;

    }

    public function update(array $data)
    {
        return DB::transaction(fn() => $this->customerConfigRepository->update($data));
    }
}