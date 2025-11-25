<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Customer\CustomerController;

Route::prefix('customer')->group(function() {
    Route::controller(CustomerController::class)->group(function() {
        Route::get('/all/{paginate}', 'index');
        Route::post('/create', 'store');
        Route::put('/update/{id}', 'update');
        Route::put('/{owner_id}/{id}/{action}', 'activeOrDisable');
    });
}); 