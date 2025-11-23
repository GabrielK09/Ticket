<?php

namespace App\Services\Customer;

use App\Repositories\Interfaces\Customer\CustomerContract;
use Illuminate\Support\Facades\DB;

class CustomerService 
{
    public function __construct(
        protected CustomerContract $customerRepository
    ){}

    public function store(array $data)
    {
        return DB::transaction(fn() => $this->customerRepository->store($data));
    }
}