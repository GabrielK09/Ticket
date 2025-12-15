<?php

namespace App\Repositories\Eloquent\CustomerEloquent;

use App\Models\Customer;
use App\Repositories\Interfaces\Customer\CustomerContract;
use Exception;
use Illuminate\Support\Facades\Log;

class CustomerRepository implements CustomerContract
{
    public function index(string $id)
    {
        return Customer::where('owner_id', $id)->get();
        
    }

    public function store(array $data)
    {
        Log::channel('customers')->debug('Started store - Customers');

        $maxId = Customer::where('owner_id', $data['owner_id'])->max('customer_id');

        return Customer::create([
            'owner_id' => $data['owner_id'],
            'customer_id' => $maxId ? $maxId + 1 : 1,
            'company_name' => $data['company_name'],
            'trade_name' => $data['trade_name'],
            'cnpj_cpf' => formatCPFCNPJ($data['cnpj_cpf']),
            'phone' => formatPhone($data['phone']), 
            'cep' => formatCEP($data['cep']),
            'address' => $data['address'],
            'number' => $data['number'],
        ]);
    }

    public function update(array $data, string $customerId)
    {
        if($customerId === 1)
        {
            throw new Exception('O cliente padrão não pode ser alterado');
        };

        Log::channel('customers')->debug('Started update - Customers');
        $customer = $this->findById($data['owner_id'], $customerId);

        $updated = $customer->update([
            'company_name' => $data['company_name'],
            'trade_name' => $data['trade_name'],
            'cnpj_cpf' => $customer->cnpj_cpf,
            'phone' => formatPhone($data['phone']), 
            'cep' => formatCEP($data['cep']),
            'address' => $data['address'],
            'number' => $data['number']

        ]);

        if(!$updated) 
        {
            throw new \RuntimeException('Erro ao atualizar o cliente!');
        }

        return $customer->fresh();
    }

    public function findById(string $ownerId, string $customerId)
    {
        return Customer::where('owner_id', $ownerId)
                        ->where('customer_id', $customerId)
                        ->first();
    }

    public function activeOrDisable(string $ownerId, string $id, string $action)
    {
        $customer = $this->findById($ownerId, $id);

        $action === 'active' ? $customer->update(['active' => 1]) : $customer->update(['active' => 0]);

        return $customer->fresh();
    }
}