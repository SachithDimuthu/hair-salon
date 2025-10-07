<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Models\Service;
use App\Models\Deal;

// Temporary import endpoint - DELETE AFTER USE!
Route::get('/import-mongodb-data-temp-{token}', function ($token) {
    // Security: Use a secret token
    if ($token !== env('IMPORT_TOKEN', 'delete-me-after-import-2024')) {
        abort(403, 'Invalid token');
    }

    $exitCode = Artisan::call('mongodb:import');
    $output = Artisan::output();

    $servicesCount = Service::count();
    $dealsCount = Deal::count();

    return response()->json([
        'success' => $exitCode === 0,
        'imported' => [
            'services' => $servicesCount,
            'deals' => $dealsCount,
        ],
        'exitCode' => $exitCode,
        'output' => trim($output),
        'message' => $exitCode === 0
            ? "✅ Successfully imported {$servicesCount} services and {$dealsCount} deals!"
            : '❌ Import command reported errors',
    ]);
});
