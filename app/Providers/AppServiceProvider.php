<?php

namespace App\Providers;

use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // One place that defines "a strong enough password" for the whole app.
        Password::defaults(function () {
            return $this->app->isProduction()
                ? Password::min(12)->letters()->mixedCase()->numbers()->symbols()->uncompromised()
                : Password::min(8)->letters()->numbers();
        });

        // Never send a password over plain HTTP in production.
        if ($this->app->isProduction()) {
            URL::forceScheme('https');
        }
    }
}
