<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TechnicalsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function activeOrDisable(Request $request)
    {
        $data = $request->validate([
            'owner_id' => 'required|exists:owners,id',
            'technical_id' => 'required|exists:technicals,technical_id',
            'action' => 'required|string'
        ], [
            'owner_id.required' => 'O identificador do proprietário é obrigatório!',
            'owner_id.exists' => 'O identificador do proprietário é obrigatório!',

            'technical_id.required' => 'O identificador do cliente é obrigatório!',
            'technical_id.exists' => 'O identificador do cliente é obrigatório!',
            
            'action.required' => 'A ação da operação é obrigatório!',
            'action.string' => 'A ação da operação é precisa estar em um formato válido!',

        ]);

        $message = $data['action'] === 'active' ? 'ativado' : 'desativado';

        return apiSuccess("Cliente {$message} com sucesso!", $this->customerService->activeOrDisable($data['owner_id'], $data['technical_id'], $data['action']));
    }
}
