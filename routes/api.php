<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ServiceController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
| API routes should only contain:
| - Routes that return JSON responses
| - Authentication APIs (login, register, logout)
| - CRUD APIs with proper resource controllers
| - Rate limiting and auth:sanctum middleware
|
*/

// Public API routes (with standard rate limiting)
Route::middleware(['throttle:api'])->group(function () {
    
    // Public service catalog (no authentication required)
    Route::get('/services', [ServiceController::class, 'index'])
        ->name('api.services.index');
    
    // Public active services with caching (optional caching layer)
    Route::get('/services/public', [ServiceController::class, 'publicServices'])
        ->name('api.services.public');
    
    // Public deal listings (no authentication required)
    // Route::get('/deals', [DealController::class, 'index'])
    //     ->name('api.deals.index');
    
});

// Authentication API routes (with stricter rate limiting)
Route::middleware(['throttle:auth,5,1'])->group(function () {
    
    Route::post('/login', [AuthController::class, 'login'])
        ->name('api.auth.login');
    
    Route::post('/register', [AuthController::class, 'register'])
        ->name('api.auth.register');
    
    // Demo token generation for testing (remove in production)
    Route::get('/demo-token', [AuthController::class, 'demoToken'])
        ->name('api.auth.demo-token');
    
});

// Protected API routes (requires authentication)
Route::middleware(['auth:sanctum', 'throttle:api'])->group(function () {
    
    // User management
    Route::get('/user', [AuthController::class, 'user'])
        ->name('api.auth.user');
    
    Route::post('/logout', [AuthController::class, 'logout'])
        ->name('api.auth.logout');
    
    Route::post('/logout-all', [AuthController::class, 'logoutAll'])
        ->name('api.auth.logout-all');
    
    // Services API (full CRUD for authenticated users)
    Route::apiResource('services', ServiceController::class)
        ->except(['index']) // index is public
        ->names([
            'show' => 'api.services.show',
            'store' => 'api.services.store',
            'update' => 'api.services.update',
            'destroy' => 'api.services.destroy',
        ]);

    // Additional service routes
    Route::get('/services/stats/aggregate', [ServiceController::class, 'aggregateStats'])
        ->name('api.services.aggregate-stats');

    // TODO: Future auth enhancement - wrap mutating routes with sanctum middleware
    // These routes (store, update, destroy) should be wrapped with auth:sanctum middleware
    // when proper authentication system is fully implemented
    
    // Deals API (full CRUD for authenticated users)
    // Route::apiResource('deals', DealController::class)
    //     ->except(['index']) // index is public
    //     ->names([
    //         'show' => 'api.deals.show',
    //         'store' => 'api.deals.store',
    //         'update' => 'api.deals.update',
    //         'destroy' => 'api.deals.destroy',
    //     ]);
    
    // Customer management API (admin/staff only)
    // Route::middleware(['role:admin,staff'])->group(function () {
    //     Route::apiResource('customers', CustomerController::class)
    //         ->names([
    //             'index' => 'api.customers.index',
    //             'show' => 'api.customers.show',
    //             'store' => 'api.customers.store',
    //             'update' => 'api.customers.update',
    //             'destroy' => 'api.customers.destroy',
    //         ]);
    // });
    
    // Staff management API (admin only)
    // Route::middleware(['role:admin'])->group(function () {
    //     Route::apiResource('staff', StaffController::class)
    //         ->names([
    //             'index' => 'api.staff.index',
    //             'show' => 'api.staff.show',
    //             'store' => 'api.staff.store',
    //             'update' => 'api.staff.update',
    //             'destroy' => 'api.staff.destroy',
    //         ]);
    // });
    
    // Booking management API
    // Route::apiResource('bookings', BookingController::class)
    //     ->names([
    //         'index' => 'api.bookings.index',
    //         'show' => 'api.bookings.show',
    //         'store' => 'api.bookings.store',
    //         'update' => 'api.bookings.update',
    //         'destroy' => 'api.bookings.destroy',
    //     ]);
    
    // Admin dashboard statistics API
    // Route::prefix('admin')->name('api.admin.')->group(function () {
    //     Route::get('/dashboard-stats', [AdminController::class, 'dashboardStats'])
    //         ->name('dashboard-stats');
    //     Route::get('/revenue-analytics', [AdminController::class, 'revenueAnalytics'])
    //         ->name('revenue-analytics');
    // });
    
});
