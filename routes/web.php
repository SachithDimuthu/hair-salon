<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
| Web routes should only contain:
| - Routes that return Blade views
| - Routes used for Livewire components
| - Browser-based application routes
|
*/

// Public web routes
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Test route for debugging time slots without cache issues
Route::get('/test-time-slots', function () {
    return view('test-time-slots');
})->name('test-time-slots');

// Test route for basic Livewire functionality  
Route::get('/test-button', function () {
    return view('components.layout', ['component' => 'test-button']);
})->name('test-button');

// Public pages
Route::get('/services', function () {
    $services = \App\Models\Service::where('visibility', true)->orderBy('category')->get();
    return view('pages.services', compact('services'));
})->name('services');

Route::get('/services/{service}', function (\App\Models\Service $service) {
    // Check if service is visible to public
    if (!$service->visibility) {
        abort(404);
    }
    
    // Get related services from same category
    $relatedServices = \App\Models\Service::where('visibility', true)
        ->where('category', $service->category)
        ->where('_id', '!=', $service->_id)
        ->limit(3)
        ->get();
    
    return view('pages.service-detail', compact('service', 'relatedServices'));
})->name('service.show');

Route::get('/about', function () {
    return view('pages.about');
})->name('about');

Route::get('/contact', function () {
    return view('pages.contact');
})->name('contact');

// Public Livewire component routes
Route::get('/book-service', function () {
    return view('components.layout', ['component' => 'book-service']);
})->name('book-service');

// Authenticated web routes (requires login)
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {

    // Main dashboard - role-based redirection
    Route::get('/dashboard', function () {
        $user = Auth::user();
        
        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        } elseif ($user->isCustomer()) {
            return redirect()->route('customer.dashboard');
        }
        
        // Default fallback
        return view('components.layout', ['component' => 'dashboard']);
    })->name('dashboard');

    // Customer dashboard routes
    Route::prefix('customer')->name('customer.')->middleware('role:customer')->group(function () {
        Route::get('/dashboard', function () {
            $user = Auth::user();
            
            // Calculate customer statistics (using dummy data for now)
            $stats = [
                'total_appointments' => 0,
                'upcoming_appointments' => 0,
                'total_orders' => 0,
                'total_spent' => 0.00,
            ];
            
            // Create empty collections for appointments and orders
            $upcomingAppointments = collect();
            $recentOrders = collect();
            
            return view('dashboard.customer', compact('stats', 'upcomingAppointments', 'recentOrders'));
        })->name('dashboard');
    });

    // Appointment routes for customers
    Route::prefix('appointments')->name('appointments.')->middleware('role:customer')->group(function () {
        Route::get('/create', function () {
            return view('components.layout', ['component' => 'book-service']);
        })->name('create');
        
        Route::get('/my-appointments', function () {
            return view('appointments.index');
        })->name('index');
        
        Route::get('/{appointment}', function ($appointment) {
            return view('appointments.show', compact('appointment'));
        })->name('show');
        
        Route::get('/{appointment}/edit', function ($appointment) {
            return view('appointments.edit', compact('appointment'));
        })->name('edit');
    });

    // Customer order routes
    Route::prefix('orders')->name('orders.')->middleware('role:customer')->group(function () {
        Route::get('/', function () {
            return view('orders.index');
        })->name('index');
    });

    // Customer loyalty routes
    Route::prefix('loyalty')->name('loyalty.')->middleware('role:customer')->group(function () {
        Route::get('/', function () {
            return view('loyalty.index');
        })->name('index');
    });

    // Admin web interface routes (Livewire components)
    Route::prefix('admin')->name('admin.')->middleware('admin')->group(function () {
        
        Route::get('/dashboard', function () {
            return view('components.layout', ['component' => 'dashboard']);
        })->name('dashboard');

        Route::get('/bookings', function () {
            return view('components.layout', ['component' => 'manage-bookings']);
        })->name('bookings');

        Route::get('/customers', function () {
            return view('components.layout', ['component' => 'manage-customers']);
        })->name('customers');

        Route::get('/services', function () {
            return view('components.layout', ['component' => 'manage-services']);
        })->name('services');

        Route::get('/deals', function () {
            return view('components.layout', ['component' => 'manage-deals']);
        })->name('deals');

    });});
