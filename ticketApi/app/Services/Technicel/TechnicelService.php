<?php

namespace App\Services\Technicel;

use App\Repositories\Interfaces\Technicel\TechnicelContract;
use Exception;
use Illuminate\Support\Facades\DB;

class TechnicelService
{
    public function __construct(
        protected TechnicelContract $technicelRepository
    ){}

    public function index(string $id)
    {
        return $this->technicelRepository->index($id);
    }

    public function store(array $data)
    {
        return DB::transaction(fn() => $this->technicelRepository->store($data));
    }

    public function update(array $data, string $id)
    {
        return DB::transaction(fn() => $this->technicelRepository->update($data, $id));
    }

    public function show(string $ownerId, string $id)
    {
        $technicel = $this->technicelRepository->findById($ownerId, $id);

        if(!$technicel)
        {
            throw new Exception('Técnico não localizado!', 1);
        }

        return $technicel;
    }

    public function activeOrDisable(string $ownerId, string $id, string $action)
    {
        $technicel = $this->technicelRepository->activeOrDisable($ownerId, $id, $action);
        
        if(!$technicel)
        {
            throw new Exception('Técnico não localizado!', 1);
        }

        return $technicel;
    }

    public function commissionManagement(array $data)
    {
        return DB::transaction(fn() => $this->technicelRepository->commissionManagement($data));
    }

    public function getCommissionByTechnical(string $ownerId, string $id)
    {
        $commission = $this->technicelRepository->getCommissionByTechnical($ownerId, $id);
        
        return $commission;
    }

    public function updateCommissionTechnical(array $data, string $id)
    {
        return DB::transaction(fn() => $this->technicelRepository->updateCommissionTechnical($data, $id));
    }
}