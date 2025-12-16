<?php

namespace App\Http\Controllers\Technicel;

use App\Http\Controllers\Controller;
use App\Http\Requests\Technicel\TechnicelRequest;
use App\Services\Technicel\TechnicelService;
use Illuminate\Http\Request;

class TechnicalsController extends Controller
{
    public function __construct(
        protected TechnicelService $technicelService
    ){}

    private function messageByGender(string $gender, string $method): string {        
        $operation = match($method) {
            'POST' => 'cadastrado',
            'PUT' => 'alterado',
            default => '__'
        };

        $message = match ($gender) {
            'F' => "Técnica {$operation} com sucesso!",
            'M' => "Técnico {$operation} com sucesso!",
            default => "Técnic {$operation} com sucesso!"
        };
        
        return $message;
    }

    private function returnNameByGender(string $gender): string 
    {
        $name = match($gender) {
            'F' => "Técnica",
            'M' => "Técnico",
            default => "Técnic"
        };

        return $name;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(string $id)
    {
        return apiSuccess('Retornando todos os técnicos!', $this->technicelService->index($id));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TechnicelRequest $request)
    {    
        return apiSuccess($this->messageByGender($request->validated()['gender'], 'POST'), $this->technicelService->store($request->validated()));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $ownerId, string $id): object
    {
        return apiSuccess('', $this->technicelService->show($ownerId, $id));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TechnicelRequest $request, string $id)
    {
        return apiSuccess($this->messageByGender($request->validated()['gender'], 'POST'), $this->technicelService->update($request->validated(), $id));   
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

            'technical_id.required' => 'O identificador do técnico é obrigatório!',
            'technical_id.exists' => 'O identificador do técnico é obrigatório!',
            
            'action.required' => 'A ação da operação é obrigatório!',
            'action.string' => 'A ação da operação é precisa estar em um formato válido!',

        ]);

        $actionMessage = $data['action'] === 'active' ? 'ativado' : 'desativado';
        $technicel = $this->show($data['owner_id'], $data['technical_id']);
        
        return apiSuccess($this->returnNameByGender($technicel->gender) . "{$actionMessage} com sucesso!", $this->technicelService->activeOrDisable($data['owner_id'], $data['technical_id'], $data['action']));
    }
}
