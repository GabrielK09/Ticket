<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Customer\CustomerRequest;
use App\Services\Customer\CustomerService;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function __construct(
        protected CustomerService $customerService
    ){}

    /**
     * Display a listing of the resource.
     */
    public function index(string $id)
    {
        return apiSuccess('Retornando todos os clientes!', $this->customerService->index($id));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CustomerRequest $request)
    {
        return apiSuccess('Cliente cadastrado com sucesso!', $this->customerService->store($request->validated()));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $ownerId, string $id)
    {
        return apiSuccess('Dados do cliente selecionado', $this->customerService->show($ownerId, $id));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CustomerRequest $request, string $id)
    {
        if($id === 1) throw new \Illuminate\Validation\ValidationException('O cliente padrão não pode ser alterado');
        return apiSuccess('Cliente alterado com sucesso!', $this->customerService->update($request->validated(), $id));   
    }

    public function activeOrDisable(Request $request)
    {
        $data = $request->validate([
            'owner_id' => 'required|exists:owners,id',
            'customer_id' => 'required|exists:customers,customer_id',
            'action' => 'required|string'
        ], [
            'owner_id.required' => 'O identificador do proprietário é obrigatório!',
            'owner_id.exists' => 'O identificador do proprietário é obrigatório!',

            'customer_id.required' => 'O identificador do cliente é obrigatório!',
            'customer_id.exists' => 'O identificador do cliente é obrigatório!',
            
            'action.required' => 'A ação da operação é obrigatório!',
            'action.string' => 'A ação da operação é precisa estar em um formato válido!',

        ]);

        $message = $data['action'] === 'active' ? 'ativado' : 'desativado';

        return apiSuccess("Cliente {$message} com sucesso!", $this->customerService->activeOrDisable($data['owner_id'], $data['customer_id'], $data['action']));
    }
}
