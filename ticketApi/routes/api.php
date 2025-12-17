<?php

use App\Http\Controllers\Auth\AuthController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function() {
    Route::prefix('auth')->group(function() {
        Route::controller(AuthController::class)->group(function() {
            Route::post('/register', 'register');
            Route::post('/login', 'login');
            Route::post('/logout', 'logout');
            Route::post('/check-exists-mail', 'checkExistEmail');
            
        });
    });

    Route::middleware('auth:sanctum')->group(function() {
        Route::prefix('auth')->group(function() {
            Route::controller(AuthController::class)->group(function() {
                Route::post('/logout', 'logout');
            });
        });

        require_once __DIR__.'/owner/ownerApi.php';
        // Route::prefix('owner')->group(function() {
        //     Route::controller(OwnerController::class)->group(function() {
        //         Route::post('/create', 'store');
        //         Route::put('/update/{id}', 'update');
        //     });
        // }); 

        require_once __DIR__.'/customer/customerApi.php';
        // Route::prefix('customer')->group(function() {
        //     Route::controller(CustomerController::class)->group(function() {
        //         Route::get('/all/{paginate}', 'index');
        //         Route::post('/create', 'store');
        //         Route::put('/update/{id}', 'update');
        //         Route::put('/{owner_id}/{id}/{action}', 'activeOrDisable');
        //     });
        // }); 

        require_once __DIR__.'/ticket/ticketApi.php';
        // Route::prefix('ticket')->group(function() {
        //     Route::controller(TicketController::class)->group(function(){ 
        //         Route::get('/all/{paginate}', 'index');
        //         Route::post('/create', 'store');
        //         Route::put('/update/{id}', 'update');
        //         Route::put('/finish', 'finishTicket');
        //         Route::get('/show/{id}/{code}', 'show');
        //     });
        // });

        require_once __DIR__.'/payMentForm/payMentFormApi.php';
        // Route::prefix('pay-ment-form')->group(function() {
        //     Route::controller(PayMentFormController::class)->group(function() {
        //         Route::get('/all', 'index');
        //         Route::post('/create', 'store');
        //         Route::put('/update/{id}', 'update');
        //     });
        // });

        require_once __DIR__.'/user/userApi.php';
        require_once __DIR__.'/technicals/technicalsApi.php';
    });
});