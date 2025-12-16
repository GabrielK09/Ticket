<?php

namespace App\Repositories\Eloquent\TechnicelEloquent;

use App\Models\Technical;
use App\Repositories\Interfaces\Technicel\TechnicelContract;
use Exception;

class TechnicelRepository implements TechnicelContract
{
    public function index(string $id)
    {
        return Technical::where('owner_id', $id)->get();
        
    }

    public function store(array $data)
    {
        $maxId = Technical::where('owner_id', $data['owner_id'])->max('technical_id');

        return Technical::create([
            'owner_id' => $data['owner_id'],
            'technical_id' => $maxId ? $maxId + 1 : 1,
            'company_name' => $data['company_name'],
            'trade_name' => $data['trade_name'],
            'cnpj_cpf' => formatCPFCNPJ($data['cnpj_cpf']),
            'phone' => formatPhone($data['phone']), 
            'cep' => formatCEP($data['cep']),
            'address' => $data['address'],
            'number' => $data['number'],
            'gender' => $data['gender'],
        ]);
    }

    public function update(array $data, string $technicelId)
    {
        if($technicelId === 1)
        {
            throw new Exception('O cliente padrão não pode ser alterado');
        };

        $technicel = $this->findById($data['owner_id'], $technicelId);

        $updated = $technicel->update([
            'company_name' => $data['company_name'],
            'trade_name' => $data['trade_name'],
            'cnpj_cpf' => $technicel->cnpj_cpf,
            'phone' => formatPhone($data['phone']), 
            'cep' => formatCEP($data['cep']),
            'address' => $data['address'],
            'number' => $data['number']

        ]);

        if(!$updated) 
        {
            throw new \RuntimeException('Erro ao atualizar o cliente!');
        }

        return $technicel->fresh();
    }

    public function findById(string $ownerId, string $technicelId)
    {
        return Technical::where('owner_id', $ownerId)
                        ->where('technical_id', $technicelId)
                        ->first();
    }

    public function activeOrDisable(string $ownerId, string $id, string $action)
    {
        $technicel = $this->findById($ownerId, $id);

        $action === 'active' ? $technicel->update(['active' => 1]) : $technicel->update(['active' => 0]);

        return $technicel->fresh();
    }
}