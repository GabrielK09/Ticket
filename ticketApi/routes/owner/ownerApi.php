<?php

use App\Http\Controllers\Owner\OwnerController;
use Illuminate\Support\Facades\Route;

Route::prefix('owner')->group(function() {
    Route::controller(OwnerController::class)->group(function() {
        Route::post('/create', 'store');
        Route::put('/update/{id}', 'update');
    });
}); 