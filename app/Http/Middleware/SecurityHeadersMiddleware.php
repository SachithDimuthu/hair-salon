<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityHeadersMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Force HTTPS in production
        if (config('app.env') === 'production' && !$request->secure()) {
            return redirect()->secure($request->getRequestUri(), 301);
        }

        // Security headers
        $this->addSecurityHeaders($response);

        return $response;
    }

    /**
     * Add security headers to the response
     */
    private function addSecurityHeaders(Response $response): void
    {
        // HTTP Strict Transport Security (HSTS)
        if (config('security.hsts_enabled', true)) {
            $response->headers->set('Strict-Transport-Security', 'max-age=31536000; includeSubDomains; preload');
        }

        // Content Security Policy
        if (config('security.content_security_policy', true)) {
            $csp = $this->buildContentSecurityPolicy();
            $response->headers->set('Content-Security-Policy', $csp);
        }

        // X-Frame-Options (Clickjacking protection)
        $response->headers->set('X-Frame-Options', 'DENY');

        // X-Content-Type-Options (MIME sniffing protection)
        $response->headers->set('X-Content-Type-Options', 'nosniff');

        // X-XSS-Protection
        $response->headers->set('X-XSS-Protection', '1; mode=block');

        // Referrer Policy
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');

        // Permissions Policy (Feature Policy)
        $response->headers->set('Permissions-Policy', 
            'camera=(), microphone=(), geolocation=(self), payment=(self)'
        );

        // Remove server identification
        $response->headers->remove('Server');
        $response->headers->remove('X-Powered-By');

        // Add custom security identifier
        $response->headers->set('X-Content-Type-Options', 'nosniff');
    }

    /**
     * Build Content Security Policy header
     */
    private function buildContentSecurityPolicy(): string
    {
        $appUrl = config('app.url');
        $allowedDomains = [
            parse_url($appUrl, PHP_URL_HOST),
            'localhost',
            '127.0.0.1'
        ];

        $policies = [
            "default-src 'self'",
            "script-src 'self' 'unsafe-inline' 'unsafe-eval' https://cdn.jsdelivr.net https://unpkg.com",
            "style-src 'self' 'unsafe-inline' https://fonts.googleapis.com https://fonts.bunny.net https://cdn.jsdelivr.net",
            "font-src 'self' https://fonts.gstatic.com https://fonts.bunny.net",
            "img-src 'self' data: https: blob:",
            "connect-src 'self' https:",
            "frame-src 'none'",
            "object-src 'none'",
            "base-uri 'self'",
            "form-action 'self'",
        ];

        return implode('; ', $policies);
    }
}