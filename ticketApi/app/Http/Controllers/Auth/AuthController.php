<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\Owner\OwnerService;
use App\Services\User\UserService;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function __construct(
        protected UserService $userService,
        protected OwnerService $ownerService
    ){}

    public function register(Request $request)
    {
        return apiSuccess('Usuário cadastrado com sucesso!', $this->userService->store($request->only('name', 'email', 'password')));
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        $user = $this->userService->getUserForAuthOrFail($credentials['email']);

        if(!Hash::check($credentials['password'], $user->password))
        {
            throw ValidationException::withMessages([
                'email' => ['Credenciais incorretas.'],

            ]);
        };

        $token = $user->createToken('api-token')->plainTextToken;

        return response()->json([
            'message' => 'Login bem sucedido!',
            'success' => true,
            'token' => $token,
            'user' => $user
            
        ], 200);
    }

    public function forgotPassword()
    {

    }

    public function checkExistEmail(Request $request)
    {
        $email = (string) $request->input('email');

        if($this->userService->emailExists($email))
        {   
            throw ValidationException::withMessages([
                'email' => ['E-mail já cadastrado!']
            ]);
        }

        return response()->noContent();
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return apiSuccess('Logout bem sucedido!');
    }
}
