<?php

use App\Http\Controllers\Owner\OwnerController;
use Illuminate\Support\Facades\Route;

Route::prefix('owner')->group(function() {
    Route::controller(OwnerController::class)->group(function() {
        Route::get('/all/{id}', 'index');
        Route::post('/create', 'store');
        Route::put('/update/{id}', 'update');
        Route::get('/check-exists-cnpj-cpf/{cnpjcpf}', 'checkExistsCnpjCpf');
    });
}); 