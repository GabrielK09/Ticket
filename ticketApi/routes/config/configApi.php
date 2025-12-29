<?php

use App\Http\Controllers\Customer\Config\CustomerConfigController;
use App\Http\Controllers\Technicel\Config\TechnicelConfigController;
use Illuminate\Support\Facades\Route;

Route::prefix('/config')->group(function() {
    Route::prefix('/customer')->group(function() {
        Route::controller(CustomerConfigController::class)->group(function() {
            Route::get('/get-config/{id}', 'show');
            Route::put('/update-config', 'update');
        });
    });

    Route::prefix('/technicel')->group(function() {
        Route::controller(TechnicelConfigController::class)->group(function() {
            Route::get('/get-config/{id}', 'show');
            Route::put('/update-config', 'update');
        });
    });
});