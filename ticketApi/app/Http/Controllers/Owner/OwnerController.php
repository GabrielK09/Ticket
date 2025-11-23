<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Http\Requests\Owner\OwnerRequest;
use App\Services\Owner\OwnerService;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class OwnerController extends Controller
{
    public function __construct(
        protected OwnerService $ownerService
    ){}
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(OwnerRequest $request)
    {
        return apiSuccess('Emitente cadastrado com sucesso!', $this->ownerService->store($request->validated()));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
