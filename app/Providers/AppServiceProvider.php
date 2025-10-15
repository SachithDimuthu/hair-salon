<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;

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
        // Configure API rate limiters
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });

        RateLimiter::for('auth', function (Request $request) {
            return Limit::perMinute(5)->by($request->ip());
        });

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
