<?php

use App\Http\Controllers\User\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('/user')->group(function() {
    Route::controller(UserController::class)->group(function() {
        Route::get('/find/{id}', 'show');
        Route::put('/update/{id}', 'update');
        
    });
});