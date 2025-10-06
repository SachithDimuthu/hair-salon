<?php

use Illuminate\Support\Facades\Route;
use App\Models\Service;
use App\Models\Deal;

// Temporary import endpoint - DELETE AFTER USE!
Route::get('/import-mongodb-data-temp-{token}', function ($token) {
    // Security: Use a secret token
    if ($token !== env('IMPORT_TOKEN', 'delete-me-after-import-2024')) {
        abort(403, 'Invalid token');
    }

    $results = [
        'services' => 0,
        'deals' => 0,
        'errors' => []
    ];

    // Import Services
    try {
        $servicesFile = base_path('mongodb_services_export.json');
        if (file_exists($servicesFile)) {
            $servicesJson = file_get_contents($servicesFile);
            $services = json_decode($servicesJson, true);
            
            Service::truncate();
            
            foreach ($services as $service) {
                Service::create($service);
                $results['services']++;
            }
        } else {
            $results['errors'][] = 'Services file not found';
        }
    } catch (\Exception $e) {
        $results['errors'][] = 'Services import error: ' . $e->getMessage();
    }

    // Import Deals
    try {
        $dealsFile = base_path('mongodb_deals_export.json');
        if (file_exists($dealsFile)) {
            $dealsJson = file_get_contents($dealsFile);
            $deals = json_decode($dealsJson, true);
            
            Deal::truncate();
            
            foreach ($deals as $deal) {
                Deal::create($deal);
                $results['deals']++;
            }
        } else {
            $results['errors'][] = 'Deals file not found';
        }
    } catch (\Exception $e) {
        $results['errors'][] = 'Deals import error: ' . $e->getMessage();
    }

    return response()->json([
        'success' => count($results['errors']) === 0,
        'imported' => [
            'services' => $results['services'],
            'deals' => $results['deals']
        ],
        'errors' => $results['errors'],
        'message' => count($results['errors']) === 0 
            ? "✅ Successfully imported {$results['services']} services and {$results['deals']} deals!"
            : '❌ Import completed with errors'
    ]);
});
