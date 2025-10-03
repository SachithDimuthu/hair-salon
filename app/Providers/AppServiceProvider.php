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
        // Temporarily disable HTTPS forcing to prevent redirect loops on Railway
        // Railway handles HTTPS at the proxy level
        /*
        if (config('app.env') === 'production') {
            // Only force HTTPS if not already HTTPS to avoid redirect loops
            if (!request()->isSecure() && !request()->header('X-Forwarded-Proto') === 'https') {
                URL::forceScheme('https');
            }
        }
        */
    }
}
