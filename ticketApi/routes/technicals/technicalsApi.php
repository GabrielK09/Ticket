<?php

use App\Http\Controllers\TechnicalsController;
use App\Http\Controllers\User\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('/technicals')->group(function() {
    Route::controller(TechnicalsController::class)->group(function() {
        Route::get('/all/{id}', 'index');
        Route::post('/create', 'store');
        Route::put('/new-status-technical', 'activeOrDisable');
    });
});