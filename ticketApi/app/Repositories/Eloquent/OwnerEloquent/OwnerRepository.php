<?php

namespace App\Repositories\Eloquent\OwnerEloquent;

use App\Models\Config\Customer\CustomerConfig;
use App\Models\Customer;
use App\Repositories\Interfaces\Owner\OnwerContract;

use App\Models\Owner;
use Illuminate\Support\Facades\Log;

class OwnerRepository implements OnwerContract
{
    public function index(string $id)
    {

        return Owner::where('user_id', $id)
                        ->select('id', 'company_name', 'cnpj_cpf')
                        ->get();

    }

    public function store(array $data): Owner
    {
        Log::channel('owners')->debug('Started store - Owners');

        $owner = Owner::create([
            'user_id' => $data['user_id'],
            'company_name' => $data['company_name'],
            'trade_name' => $data['trade_name'],
            'cnpj_cpf' => formatCPFCNPJ($data['cnpj_cpf']),
            'phone' => formatPhone($data['phone']), 
            'cep' => formatCEP($data['cep']),
            'address' => $data['address'],
            'number' => $data['number'],
            'cnae' => $data['cnae'],
            'activity' => $data['activity'],

        ]);

        Customer::create([
            'owner_id' => $owner->id,
            'customer_id' => 1,
            'company_name' => 'Cliente padrão',
            'trade_name' => '',
            'cnpj_cpf' => '',
            'phone' => '', 
            'cep' => '', 
            'address' => '', 
            'number' => '', 
        ]);

        CustomerConfig::create([
            'owner_id' => $owner->id,
            'customer_config_id' => $owner->id,
        ]);

        return $owner;
    }

    public function update(array $data, string $id): Owner
    {
        Log::channel('owners')->debug('Started update - Owners');
        $owner = Owner::findOrFail($id);

        $updated = $owner->update([
            'company_name' => $data['company_name'],
            'trade_name' => $data['trade_name'],
            'cnpj_cpf' => $owner->cnpj_cpf,
            'phone' => formatPhone($data['phone']), 
            'cep' => formatCEP($data['cep']),
            'address' => $data['address'],
            'number' => $data['number'],
            'cnae' => $data['cnae'],
            'activity' => $data['activity'],

        ]);

        if(!$updated) 
        {
            throw new \RuntimeException('Erro ao atualizar o emitente!');
        }

        return $owner->fresh();
    }

    public function findById(string $id): Owner
    {
        return Owner::findOrFail($id);
    }

    public function findByUserId(string $id): Owner
    {
        return Owner::where('user_id', $id)->first();
    }

    public function checkExistsCnpjCpf(string $cnpjCpf): Owner
    {
        return Owner::where('cnpj_cpf', $cnpjCpf)->select('cnpj_cpf')->first();
    }
}