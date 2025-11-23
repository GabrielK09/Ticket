<?php

namespace App\Services\Owner;

use App\Repositories\Interfaces\Owner\OnwerContract;
use Exception;
use Illuminate\Support\Facades\DB;

class OwnerService 
{
    public function __construct(
        protected OnwerContract $ownerRepository
    ){}

    public function store(array $data)
    {
        return DB::transaction(fn() => $this->ownerRepository->store($data));
    }

    public function update(array $data, string $id)
    {
        return DB::transaction(fn() => $this->ownerRepository->update($data, $id));
        
    }
}