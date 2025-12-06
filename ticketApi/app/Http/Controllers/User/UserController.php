<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Services\User\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct(
        protected UserService $userService
    ){}

    public function show(string $id)
    {
        return apiSuccess('Dados do usuário!', $this->userService->findById($id));
    }
    
    public function update(Request $request)
    {
        $data = $request->validate([
            'user_id' => ['required', 'exists:users,id'],
            'name' => ['sometimes', 'string'],
            'email' => ['sometimes', 'email']

        ], [
            'user_id.required' => 'O identificador do usuário é obrigatório!',
            'user_id.exists' => 'O identificador do usuário é obrigatório!',            
            'name.string' => 'O nome precisa estar em um formato válido!',
            'email.email' => 'O e-mail precisa estar em um formato válido!'
            
        ]);

        return apiSuccess('Dados do usuário alterados com sucesso!', $this->userService->update($data));
    }
}
