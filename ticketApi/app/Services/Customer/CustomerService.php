<?php

namespace App\Services\Customer;

use App\Repositories\Interfaces\Customer\CustomerContract;
use Exception;
use Illuminate\Support\Facades\DB;

class CustomerService 
{
    public function __construct(
        protected CustomerContract $customerRepository
    ){}

    public function index(string $id, int $paginate)
    {
        return $this->customerRepository->index($id, $paginate);
    }

    public function store(array $data)
    {
        return DB::transaction(fn() => $this->customerRepository->store($data));
    }

    public function update(array $data, string $id)
    {
        return DB::transaction(fn() => $this->customerRepository->update($data, $id));
    }

    public function show(string $ownerId, string $id)
    {
        $customer = $this->customerRepository->findById($ownerId, $id);

        if(!$customer)
        {
            throw new Exception('Cliente não localizado!', 1);
        }

        return $customer;
    }

    public function activeOrDisable(string $ownerId, string $id, string $action)
    {
        $customer = $this->customerRepository->activeOrDisable($ownerId, $id, $action);
        
        if(!$customer)
        {
            throw new Exception('Cliente não localizado!', 1);
        }

        return $customer;
    }
}