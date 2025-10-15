<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ServiceController;
use App\Http\Controllers\Api\DealController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Http\Request;
use App\Models\Service;
use App\Models\Deal;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

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

// API Health Check - Test route to verify API is working
Route::get('/', function () {
    return response()->json([
        'message' => 'API is working!',
        'timestamp' => now(),
        'version' => '1.0',
        'endpoints' => [
            'auth' => '/api/login, /api/register',
            'services' => '/api/services',
            'deals' => '/api/deals',
        ],
    ]);
});

// Test protected route - Verify authentication is working
Route::middleware('auth:sanctum')->get('/test', function (Request $request) {
    return response()->json([
        'message' => 'Authenticated successfully!',
        'user' => $request->user(),
    ]);
});

Route::middleware('throttle:5,1')->get('/debug/import-mongodb', function () {
    $exitCode = Artisan::call('mongodb:import');
    $output = Artisan::output();

    return response()->json([
        'success' => $exitCode === 0,
        'services' => Service::count(),
        'deals' => Deal::count(),
        'exitCode' => $exitCode,
        'output' => trim($output),
    ]);
});

// Public API routes (with standard rate limiting)
Route::middleware(['throttle:api'])->group(function () {
    
    // Public service catalog (no authentication required)
    Route::get('/services', [ServiceController::class, 'index'])
        ->name('api.services.index');
    
    // Public active services with caching (optional caching layer)
    Route::get('/services/public', [ServiceController::class, 'publicServices'])
        ->name('api.services.public');
    
    // Public deal listings (no authentication required)
    Route::get('/deals', [DealController::class, 'index'])
        ->name('api.deals.index');
    
    // Public active deals with caching
    Route::get('/deals/public', [DealController::class, 'publicDeals'])
        ->name('api.deals.public');
    
    // Check deal availability
    Route::get('/deals/{id}/availability', [DealController::class, 'checkAvailability'])
        ->name('api.deals.availability');
    
});

// Debug endpoint to test database and auth setup
Route::get('/debug/auth-status', function () {
    try {
        $checks = [
            'app_key_set' => config('app.key') !== null && config('app.key') !== '',
            'database_connection' => 'unknown',
            'users_table_exists' => false,
            'users_count' => 0,
            'sanctum_config' => config('sanctum.guard') !== null,
        ];

        // Test database connection
        try {
            DB::connection()->getPdo();
            $checks['database_connection'] = 'SUCCESS';
            
            // Check if users table exists
            if (Schema::hasTable('users')) {
                $checks['users_table_exists'] = true;
                $checks['users_count'] = DB::table('users')->count();
            }
        } catch (\Exception $e) {
            $checks['database_connection'] = 'FAILED: ' . $e->getMessage();
        }

        return response()->json([
            'status' => 'Auth Debug Info',
            'checks' => $checks,
            'env' => config('app.env'),
            'url' => config('app.url'),
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString(),
        ], 500);
    }
})->name('api.debug.auth');

// Authentication API routes (with stricter rate limiting)
Route::middleware(['throttle:auth'])->group(function () {
    
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

    // Deals API (full CRUD for authenticated users)
    Route::apiResource('deals', DealController::class)
        ->except(['index']) // index is public
        ->names([
            'show' => 'api.deals.show',
            'store' => 'api.deals.store',
            'update' => 'api.deals.update',
            'destroy' => 'api.deals.destroy',
        ]);

    // TODO: Future auth enhancement - wrap mutating routes with sanctum middleware
    // These routes (store, update, destroy) should be wrapped with auth:sanctum middleware
    // when proper authentication system is fully implemented
    
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
