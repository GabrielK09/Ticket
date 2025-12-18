<?php

namespace App\Repositories\Interfaces\Technicel;

use App\Repositories\Interfaces\BaseApiContract;

interface TechnicelContract
{
    public function index(string $id);
    public function store(array $data);
    public function update(array $data, string $technicelId);
    public function activeOrDisable(string $ownerId, string $id, string $action);
    public function findById(string $ownerId, string $technicelId);
    public function commissionManagement(array $data);
    public function getCommissionByTechnical(string $id);
    public function updateCommissionTechnical(array $data, string $id);

}