<?php

namespace App\Exceptions;

use App\Exceptions\OwnerExceptions\ExistsCNPJCPF;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    public function render($request, Throwable $e)
    {
        if($e instanceof ValidationException)   
        {
            return response()->json([
                'success' => false,
                'mesage' => 'Erro de validação!',
                'errors' => $e->errors()

            ], 422);
        }

        if($e instanceof AuthenticationException) 
        {
            return response()->json([
                'success' => false,
                'mesage' => 'Usuário não autenticado!',

            ], 401);
        }

        if($e instanceof AuthorizationException)
        {
            return response()->json([
                'success' => false,
                'mesage' => 'Usuário não autorizado!',

            ], 403);
        }

        if($e instanceof ModelNotFoundException)
        {
            return response()->json([
                'success' => false,
                'mesage' => 'Recurso não encontrado!',

            ], 404);
        }

        if($e instanceof NotFoundHttpException)
        {
            return response()->json([
                'success' => false,
                'mesage' => 'Registro não encontrado!',

            ], 404);
        }

        if($e instanceof HttpException)
        {
            return response()->json([
                'success' => false,
                'mesage' => $e->getMessage() ?: 'Erro na requisição!',

            ], $e->getStatusCode()); 
        }

        if($e instanceof ExistsCNPJCPF)
        {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }

        Log::channel('internal-error')->critical('Erro interno', [
            'erro' => $e
            
        ]);

        return response()->json([
            'success' => false,
            'message' => 'Erro interno!'
        ], 500);
    }   
}
