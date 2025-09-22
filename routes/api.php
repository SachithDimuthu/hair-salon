<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ServiceController;
use Illuminate\Support\Facades\Route;

// Public API routes with rate limiting
Route::middleware(['throttle:api'])->group(function () {
    Route::get('/services', [ServiceController::class, 'index']);
});

// Authentication routes with stricter rate limiting
Route::middleware(['throttle:auth,5,1'])->group(function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
});

// Protected API routes
Route::middleware(['auth:sanctum', 'throttle:api'])->group(function () {
    // User management
    Route::get('/user', [AuthController::class, 'user']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/logout-all', [AuthController::class, 'logoutAll']);
    
    // Services API (for authenticated users)
    Route::apiResource('services', ServiceController::class)->except(['index']);
    
    // Additional API routes will be added as controllers are created
    // Customer routes, Staff routes, Admin routes will be implemented in future phases
});
