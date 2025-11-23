<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            \App\Repositories\Interfaces\Owner\OnwerContract::class,
            \App\Repositories\Eloquent\OwnerEloquent\OwnerRepository::class
            
        );

        $this->app->bind(
            \App\Repositories\Interfaces\Customer\CustomerContract::class,
            \App\Repositories\Eloquent\CustomerEloquent\CustomerRepository::class
        );

        $this->app->bind(
            \App\Repositories\Interfaces\Ticket\TicketContract::class,
            \App\Repositories\Eloquent\TicketEloquent\TicketRepository::class
        );

        $this->app->bind(
            \App\Repositories\Interfaces\PayMentForm\PayMentFormContract::class,
            \App\Repositories\Eloquent\PayMentEloquent\PayMentRepository::class
        );

        $this->app->bind(
            \App\Repositories\Interfaces\CashRegister\CashRegisterContract::class,
            \App\Repositories\Eloquent\CashRegisterEloquent\CashRegisterRepository::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
