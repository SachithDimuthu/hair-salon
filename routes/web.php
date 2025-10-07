<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\DashboardController;

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
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Test route for debugging time slots without cache issues
Route::get('/test-time-slots', function () {
    return view('test-time-slots');
})->name('test-time-slots');

// Test route for appointments debugging
Route::get('/test-appointments', function () {
    $appointments = collect(['test' => 'data']);
    return view('appointments.index', compact('appointments'));
})->name('test-appointments');

// Test route for basic Livewire functionality  
Route::get('/test-button', function () {
    return view('components.layout', ['component' => 'test-button']);
})->name('test-button');

// Public pages
Route::get('/services', function () {
    $services = \App\Models\Service::where('active', true)
        ->where('visibility', 'public')
        ->orderBy('name')
        ->get();
    return view('pages.services', compact('services'));
})->name('services');

Route::get('/services/{service}', function (\App\Models\Service $service) {
    // Check if service is visible to public
    if (!$service->active || $service->visibility !== 'public') {
        abort(404);
    }
    
    // Get related services from same category  
    $relatedServices = \App\Models\Service::where('active', true)
        ->where('visibility', 'public')
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
            return view('dashboard.customer-livewire');
        })->name('dashboard');
    });

    // Appointment routes for customers
    Route::prefix('appointments')->name('appointments.')->middleware('role:customer')->group(function () {
        Route::get('/create', function () {
            return view('components.layout', ['component' => 'book-service']);
        })->name('create');
        
        Route::get('/my-appointments', function () {
            $user = Auth::user();
            
            if (!$user) {
                return redirect()->route('login');
            }
            
            try {
                $appointments = \App\Models\Booking::where('customer_id', $user->id)
                    ->orderBy('booking_date', 'desc')
                    ->get();
                    
                // Ensure $appointments is never null
                if ($appointments === null) {
                    $appointments = collect();
                }
                
                return view('appointments.index')->with('appointments', $appointments);
                
            } catch (\Exception $e) {
                Log::error('Error fetching appointments: ' . $e->getMessage());
                $appointments = collect();
                return view('appointments.index')->with('appointments', $appointments);
            }
        })->name('index');
        
        Route::get('/{appointment}', function ($appointment) {
            $user = Auth::user();
            $appointmentData = \App\Models\Booking::where('customer_id', $user->id)
                ->where('id', $appointment)
                ->firstOrFail();
            return view('appointments.show', ['appointment' => $appointmentData]);
        })->name('show');
        
        Route::get('/{appointment}/edit', function ($appointment) {
            $user = Auth::user();
            $appointmentData = \App\Models\Booking::where('customer_id', $user->id)
                ->where('id', $appointment)
                ->firstOrFail();
            return view('appointments.edit', ['appointment' => $appointmentData]);
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
        
        Route::get('/dashboard', [DashboardController::class, 'admin'])->name('dashboard');

        Route::get('/bookings', function () {
            return view('components.layout', ['component' => 'manage-bookings']);
        })->name('bookings.index');

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

// Temporary MongoDB import route (remove after production data is seeded)
if (file_exists(base_path('routes/import.php'))) {
    require base_path('routes/import.php');
}
