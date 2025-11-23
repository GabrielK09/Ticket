<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Customer\CustomerRequest;
use App\Services\Customer\CustomerService;

class CustomerController extends Controller
{
    public function __construct(
        protected CustomerService $customerService
    ){}

    /**
     * Display a listing of the resource.
     */
    public function index(string $id, int $paginate)
    {
        return apiSuccess('Retornando todos os clientes!', $this->customerService->index($id, $paginate));
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
        return apiSuccess('Cliente alterado com sucesso!', $this->customerService->update($request->validated(), $id));   
    }

    public function activeOrDisable(string $ownerId, string $id, string $action)
    {
        $message = $action === 'active' ? 'ativado' : 'desativado';

        return apiSuccess("Cliente {$message} com sucesso!", $this->customerService->activeOrDisable($ownerId, $id, $action));
    }
}
