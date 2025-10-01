<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ErrorHandling
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {
            return $next($request);
        } catch (\Exception $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'error' => 'Something went wrong. Please try again.',
                    'message' => app()->environment('local') ? $e->getMessage() : 'Internal server error'
                ], 500);
            }

            // For web requests, show a user-friendly error page
            if ($e instanceof \Illuminate\Database\Eloquent\ModelNotFoundException) {
                return response()->view('errors.404', [], 404);
            }

            if ($e instanceof \Symfony\Component\HttpKernel\Exception\NotFoundHttpException) {
                return response()->view('errors.404', [], 404);
            }

            // Log the error for debugging
            \Log::error('Application error', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
                'url' => $request->fullUrl(),
                'user_agent' => $request->userAgent(),
                'ip' => $request->ip()
            ]);

            return response()->view('errors.500', [], 500);
        }
    }
}