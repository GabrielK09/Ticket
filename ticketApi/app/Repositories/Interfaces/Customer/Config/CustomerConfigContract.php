<?php

namespace App\Repositories\Interfaces\Customer\Config;

interface CustomerConfigContract
{
    public function show(string $id);
    public function update(array $data);
}
