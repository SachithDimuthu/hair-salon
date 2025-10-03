<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;

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
        // Force HTTPS in production with proper proxy detection
        if (config('app.env') === 'production') {
            // Trust Railway's proxy headers
            $this->app['request']->server->set('HTTPS', 'on');
            URL::forceScheme('https');
        }
    }
}
