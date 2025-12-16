<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\Owner\OwnerService;
use App\Services\User\UserService;
use Exception;
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
        $startLogin = microtime(true);

        $credentials = $request->only('email', 'password');
        $user = $this->userService->findByMailForAuth($credentials['email']);

        if($user && Hash::check($credentials['password'], $user->password))
        {
            $token = $user->createToken('api-token')->plainTextToken;

            $endLogin = microtime(true);

            $executionTime = ($startLogin - $endLogin) / 60;

            Log::debug("Tempo de execução do login: {$executionTime}", );

            return response()->json([
                'message' => 'Login bem sucedido!',
                'success' => true,
                'token' => $token,
                'user' => $user
                
            ], 200);

        } else {
            throw new Exception('Credencias incorretas!');

        };
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return apiSuccess('Logout bem sucedido!');
    }
}
