<?php

use App\Http\Controllers\Customer\Config\CustomerConfigController;
use Illuminate\Support\Facades\Route;

Route::prefix('/config')->group(function() {
    Route::prefix('/customer')->group(function() {
        Route::controller(CustomerConfigController::class)->group(function() {
            Route::get('/get-config', 'show');
            Route::put('/update-config', 'update');
        });
        
    });
});