<?php

use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\CustomerController as AdminCustomerController;
use App\Http\Controllers\Admin\ServiceController as AdminServiceController;
use App\Http\Controllers\Admin\StaffController as AdminStaffController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/services', [HomeController::class, 'services'])->name('services');
Route::get('/staff', [HomeController::class, 'staff'])->name('staff');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
Route::get('/about', [HomeController::class, 'about'])->name('about');

// Authenticated routes
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    
    // Main dashboard - redirects to role-specific dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Role-specific dashboards
    Route::get('/admin/dashboard', [DashboardController::class, 'admin'])
        ->middleware('admin')
        ->name('admin.dashboard');
    
    Route::get('/staff/dashboard', [DashboardController::class, 'staff'])
        ->middleware('staff')
        ->name('staff.dashboard');
    
    Route::get('/customer/dashboard', [DashboardController::class, 'customer'])
        ->middleware('role:customer')
        ->name('customer.dashboard');

    // Admin routes
    Route::middleware('admin')->prefix('admin')->name('admin.')->group(function () {
        Route::resource('staff', AdminStaffController::class);
        Route::resource('customers', AdminCustomerController::class);
        Route::resource('services', AdminServiceController::class);
        Route::patch('services/{service}/toggle-status', [AdminServiceController::class, 'toggleStatus'])
            ->name('services.toggleStatus');
    });

    // Customer routes
    Route::middleware('role:customer')->group(function () {
        Route::resource('appointments', AppointmentController::class)->except(['index', 'show']);
        Route::get('/appointments', [AppointmentController::class, 'index'])->name('appointments.index');
        Route::get('/appointments/{appointment}', [AppointmentController::class, 'show'])->name('appointments.show');
    });

    // Staff routes (accessible by both staff and admin)
    Route::middleware('staff')->prefix('staff')->name('staff.')->group(function () {
        // Staff-specific appointment management
        Route::get('/appointments', [AppointmentController::class, 'staffIndex'])->name('appointments.index');
        Route::get('/appointments/{appointment}', [AppointmentController::class, 'staffShow'])->name('appointments.show');
        Route::put('/appointments/{appointment}', [AppointmentController::class, 'staffUpdate'])->name('appointments.update');
    });
});
