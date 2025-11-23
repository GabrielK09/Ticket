<?php

namespace App\Repositories\Interfaces\Customer;

use App\Repositories\Interfaces\BaseApiContract;

interface CustomerContract extends BaseApiContract
{
    public function findById(string $ownerId, string $customerId);
}
