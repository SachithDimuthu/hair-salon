<?php

return [
    
    /*
    |--------------------------------------------------------------------------
    | Security Configuration
    |--------------------------------------------------------------------------
    |
    | This file contains security-related configuration options for the
    | Luxe Hair Studio application.
    |
    */

    /*
    |--------------------------------------------------------------------------
    | HTTPS Enforcement
    |--------------------------------------------------------------------------
    |
    | When enabled, all HTTP requests will be redirected to HTTPS in production.
    | This should be enabled for all production deployments.
    |
    */

    'force_https' => env('SECURITY_FORCE_HTTPS', true),

    /*
    |--------------------------------------------------------------------------
    | HTTP Strict Transport Security (HSTS)
    |--------------------------------------------------------------------------
    |
    | When enabled, the application will send HSTS headers to prevent
    | man-in-the-middle attacks and protocol downgrade attacks.
    |
    */

    'hsts_enabled' => env('SECURITY_HSTS_ENABLED', true),

    /*
    |--------------------------------------------------------------------------
    | Content Security Policy
    |--------------------------------------------------------------------------
    |
    | When enabled, the application will send CSP headers to prevent
    | XSS attacks and other code injection attacks.
    |
    */

    'content_security_policy' => env('SECURITY_CONTENT_SECURITY_POLICY', true),

    /*
    |--------------------------------------------------------------------------
    | Rate Limiting
    |--------------------------------------------------------------------------
    |
    | Configure rate limiting for different parts of the application.
    |
    */

    'rate_limit_api' => env('RATE_LIMIT_API', 60),
    'rate_limit_web' => env('RATE_LIMIT_WEB', 1000),
    'rate_limit_auth' => env('RATE_LIMIT_AUTH', 5),

    /*
    |--------------------------------------------------------------------------
    | Session Security
    |--------------------------------------------------------------------------
    |
    | Additional session security configurations.
    |
    */

    'session_timeout' => env('SESSION_LIFETIME', 120),
    'session_regenerate' => true,

    /*
    |--------------------------------------------------------------------------
    | API Security
    |--------------------------------------------------------------------------
    |
    | Security settings for API endpoints.
    |
    */

    'api_token_expiry' => 60 * 24, // 24 hours in minutes
    'api_refresh_token_expiry' => 60 * 24 * 7, // 7 days in minutes

    /*
    |--------------------------------------------------------------------------
    | File Upload Security
    |--------------------------------------------------------------------------
    |
    | Security settings for file uploads.
    |
    */

    'allowed_file_types' => [
        'images' => ['jpg', 'jpeg', 'png', 'gif', 'webp'],
        'documents' => ['pdf', 'doc', 'docx'],
    ],

    'max_file_size' => 10 * 1024 * 1024, // 10MB in bytes

    /*
    |--------------------------------------------------------------------------
    | Password Security
    |--------------------------------------------------------------------------
    |
    | Password policy and security settings.
    |
    */

    'password_min_length' => 8,
    'password_require_special' => true,
    'password_require_numbers' => true,
    'password_require_uppercase' => true,

    /*
    |--------------------------------------------------------------------------
    | Security Headers Whitelist
    |--------------------------------------------------------------------------
    |
    | Domains that are allowed for various security policies.
    |
    */

    'trusted_domains' => [
        env('APP_URL'),
        'localhost',
        '127.0.0.1',
    ],

];