<?php

namespace App\Repositories\Interfaces\Owner;

use App\Repositories\Interfaces\BaseApiContract;

interface OnwerContract extends BaseApiContract
{
    public function findByUserId(string $id);    
}
