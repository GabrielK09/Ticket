<?php

namespace App\Services\PayMent;

use App\Repositories\Interfaces\PayMentForm\PayMentFormContract;
use Illuminate\Support\Facades\DB;

class PayMentService
{
    public function __construct(
        protected PayMentFormContract $payMentRepository
    ){}

    public function store(array $data)
    {
        return DB::transaction(fn() => $this->payMentRepository->store($data));

    }

    public function update(array $data, string $id)
    {
        return DB::transaction(fn() => $this->payMentRepository->update($data, $id));
    }
}