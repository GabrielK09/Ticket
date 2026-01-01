<?php

namespace App\Repositories\Interfaces\Owner;

use App\Repositories\Interfaces\BaseApiContract;

interface OnwerContract extends BaseApiContract
{
    public function index(string $id);
    public function findByUserId(string $id);    
    public function checkExistsCnpjCpf(string $cnpjCpf);    
    
}
