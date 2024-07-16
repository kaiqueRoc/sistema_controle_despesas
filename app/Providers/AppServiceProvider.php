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
            'App\Http\Services\Auth\Interface\ILogin',
            'App\Http\Services\Auth\LoginService'
        );

        // Repositories

        // User
        $this->app->bind(
            'App\Http\Repositories\Users\Interface\IUserRepository',
            'App\Http\Repositories\Users\UserRepository'
        );

        // Despesa
        $this->app->bind(
            'App\Http\Repositories\Despesas\Interface\IDespesaRepository',
            'App\Http\Repositories\Despesas\DespesaRepository'
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
