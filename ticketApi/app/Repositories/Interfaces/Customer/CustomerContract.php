<?php

namespace App\Repositories\Interfaces\Customer;

use App\Repositories\Interfaces\BaseApiContract;

interface CustomerContract 
{
    public function index(string $id, int $paginate);
    public function findById(string $ownerId, string $customerId);
    public function store(array $data);
    public function update(array $data, string $customerId);
    public function activeOrDisable(string $ownerId, string $id, string $action);
}
