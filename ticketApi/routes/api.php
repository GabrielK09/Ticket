<?php

use App\Http\Controllers\Auth\AuthController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function() {
    Route::prefix('auth')->group(function() {
        Route::controller(AuthController::class)->group(function() {
            Route::post('/register', 'register');
            Route::post('/login', 'login');
            Route::post('/logout', 'logout');
            Route::post('/check-exists-mail', 'checkExistEmail');
            
        });
    });

    Route::middleware('auth:sanctum')->group(function() {
        Route::prefix('auth')->group(function() {
            Route::controller(AuthController::class)->group(function() {
                Route::post('/logout', 'logout');
            });
        });

        require_once __DIR__.'/owner/ownerApi.php';
        require_once __DIR__.'/customer/customerApi.php';
        require_once __DIR__.'/ticket/ticketApi.php';
        require_once __DIR__.'/payMentForm/payMentFormApi.php';
        require_once __DIR__.'/user/userApi.php';
        require_once __DIR__.'/technicals/technicalsApi.php';
        require_once __DIR__.'/config/configApi.php';
    });
});