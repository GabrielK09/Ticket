<?php

namespace App\Services\Technicel\Config;

use App\Repositories\Interfaces\Technicel\Config\TechnicelConfigContract;
use Illuminate\Support\Facades\DB;

class TechnicelConfigService
{
    public function __construct(
        protected TechnicelConfigContract $technicelConfigRepository
    ){}

    public function show(string $id)
    {
        return $this->technicelConfigRepository->show($id);

    }

    public function update(array $data)
    {
        return DB::transaction(fn() => $this->technicelConfigRepository->update($data));
    }
}