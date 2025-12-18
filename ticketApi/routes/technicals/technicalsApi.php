<?php

use App\Http\Controllers\Technicel\TechnicalsController;
use Illuminate\Support\Facades\Route;

Route::prefix('/technicel')->group(function() {
    Route::controller(TechnicalsController::class)->group(function() {
        Route::get('/all/{id}', 'index');
        Route::post('/create', 'store');
        Route::put('/new-status-technical', 'activeOrDisable');

        Route::get('/get/{id}/commission', 'getCommissionByTechnical');
        Route::put('/update/{id}/commission', 'updateCommissionTechnical');

        Route::post('/create/commission', 'commissionManagement');

    });
});