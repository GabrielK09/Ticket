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
        $credentials = $request->only('email', 'password');
        $user = $this->userService->findByMailForAuth($credentials['email']);

        if($user && Hash::check($credentials['password'], $user->password))
        {
            $token = $user->createToken('api-token')->plainTextToken;

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

    public function forgotPassword()
    {

    }

    public function checkExistEmail(Request $request)
    {
        $data = $request->only('email');

        $email = $this->userService->checkExistEmail($data['email']);
        
        if($email)
        {    
            throw new Exception('E-mail já cadastrado!');

        } else {
            return;
        };
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return apiSuccess('Logout bem sucedido!');
    }
}
