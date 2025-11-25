<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\Owner\OwnerService;
use App\Services\User\UserService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

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
        $user = $this->userService->findByMail($credentials['email']);

        if($user && Hash::check($credentials['password'], $user->password))
        {
            $token = $user->createToken('api-token')->plainTextToken;
            $ownerData = $this->ownerService->findByUserId($user->id);

            return apiSuccess('Login bem sucedido!', [
                'token' => $token,
                'user' => $user,
                'owner_id' => $ownerData->id,
                'owner_data' => $ownerData
            ]);

        } else {
            throw new Exception('Credencias incorretas!');

        }
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return apiSuccess('Logout bem sucedido!');
    }
}
