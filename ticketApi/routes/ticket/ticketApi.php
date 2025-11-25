<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Ticket\TicketController;

Route::prefix('ticket')->group(function() {
    Route::controller(TicketController::class)->group(function(){ 
        Route::get('/all/{paginate}', 'index');
        Route::post('/create', 'store');
        Route::put('/update/{id}', 'update');
        Route::put('/finish', 'finishTicket');
        Route::get('/show/{id}/{code}', 'show');
    });
});