<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Customer\CustomerController;

Route::prefix('customer')->group(function() {
    Route::controller(CustomerController::class)->group(function() {
        Route::get('/all/{id}', 'index');
        Route::post('/create', 'store');
        Route::get('/{ownerId}/customer-data/{id}', 'show');
        Route::put('/update/{customerId}', 'update');
        Route::put('/new-status-customer', 'activeOrDisable');
    });
}); 