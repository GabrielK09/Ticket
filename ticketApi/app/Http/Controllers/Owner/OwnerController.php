<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Http\Requests\Owner\OwnerRequest;
use App\Services\Owner\OwnerService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;

class OwnerController extends Controller
{
    public function __construct(
        protected OwnerService $ownerService
    ){}

    public function index(string $id)
    {
        return apiSuccess('Retornando todos as empresas do usuário', $this->ownerService->index($id));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(OwnerRequest $request)
    {
        return apiSuccess('Emitente cadastrado com sucesso!', $this->ownerService->store($request->validated()));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(OwnerRequest $request, string $id)
    {
        try {
            return apiSuccess('Emitente editado com sucesso!', $this->ownerService->update($request->validated(), $id));

        } catch (ModelNotFoundException $e) {
            return apiError('Emitente não encontrado!', 404);

        } catch (\Throwable $e) {
            return apiError('Erro ao atualizar emitente: ' . $e->getMessage(), 500);
            
        }
    }

    public function show(string $id)
    {
        return apiSuccess('Emitente localizado com sucesso!', $this->ownerService->show($id));
    }
}
