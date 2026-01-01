<?php

namespace App\Services\Owner;

use App\Exceptions\OwnerExceptions\ExistsCNPJCPF;
use App\Repositories\Interfaces\Owner\OnwerContract;
use Exception;
use Illuminate\Support\Facades\DB;

class OwnerService 
{
    public function __construct(
        protected OnwerContract $ownerRepository
    ){}

    public function index(string $id)
    {
        return $this->ownerRepository->index($id);
    }

    public function store(array $data)
    {
        return DB::transaction(fn() => $this->ownerRepository->store($data));
    }

    public function update(array $data, string $id)
    {
        return DB::transaction(fn() => $this->ownerRepository->update($data, $id));
        
    }

    public function show(string $id)
    {
        $owner = $this->ownerRepository->findById($id);

        if(!$owner)
        {
            throw new Exception('Erro ao atualizar o emitente!');
        }

        return $owner;
    }

    public function findByUserId(string $id)
    {
        $owner = $this->ownerRepository->findByUserId($id);

        if(!$owner)
        {
            throw new Exception('Erro ao atualizar o emitente!');
        }

        return $owner;
    }

    public function checkExistsCnpjCpf(string $cnpjCpf)
    {
        if($this->ownerRepository->checkExistsCnpjCpf($cnpjCpf) === $cnpjCpf)
        {
            throw new ExistsCNPJCPF('Esse CNPJ/CPF já está cadastrado!');
        }

        return;
    }
}