<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Customer\CustomerController;
use App\Http\Controllers\Owner\OwnerController;
use App\Http\Controllers\PayMentForm\PayMentFormController;
use App\Http\Controllers\Ticket\TicketController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function() {
    Route::prefix('auth')->group(function() {
        Route::controller(AuthController::class)->group(function() {
            Route::post('/register', 'register');
            Route::post('/login', 'login');
            Route::post('/logout', 'logout');
        });
    });

    Route::middleware('auth:sanctum')->group(function() {
        Route::prefix('auth')->group(function() {
            Route::controller(AuthController::class)->group(function() {
                Route::post('/logout', 'logout');
            });
        });

        Route::prefix('owner')->group(function() {
            Route::controller(OwnerController::class)->group(function() {
                Route::post('/create', 'store');
                Route::put('/update/{id}', 'update');
            });
        }); 

        Route::prefix('customer')->group(function() {
            Route::controller(CustomerController::class)->group(function() {
                Route::post('/create', 'store');
                Route::put('/update/{id}', 'update');
            });
        }); 

        Route::prefix('ticket')->group(function() {
            Route::controller(TicketController::class)->group(function(){ 
                Route::post('/create', 'store');
                Route::put('/update/{id}', 'update');
                Route::put('/finish', 'finishTicket');
                Route::get('/show/{id}/{code}', 'show');

            });
        });

        Route::prefix('pay-ment-form')->group(function() {
            Route::controller(PayMentFormController::class)->group(function() {
                Route::post('/create', 'store');
                Route::put('/update/{id}', 'update');

            });
        });
    });
});