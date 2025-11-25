<?php

use App\Http\Controllers\PayMentForm\PayMentFormController;
use Illuminate\Support\Facades\Route;

Route::prefix('pay-ment-form')->group(function() {
    Route::controller(PayMentFormController::class)->group(function() {
        Route::get('/all', 'index');
        Route::post('/create', 'store');
        Route::put('/update/{id}', 'update');
    });
});