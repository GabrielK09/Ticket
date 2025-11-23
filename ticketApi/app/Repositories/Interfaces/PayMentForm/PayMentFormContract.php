<?php

namespace App\Repositories\Interfaces\PayMentForm;

use App\Repositories\Interfaces\BaseApiContract;

interface PayMentFormContract extends BaseApiContract
{
    public function findById(string $ownerId, string $payMentId);
}
