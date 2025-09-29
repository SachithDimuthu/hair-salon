<?php
// Quick MongoDB test script for Luxe Hair Studio
require __DIR__ . '/vendor/autoload.php';
use App\Models\Service;
use App\Models\Deal;

try {
    echo "MongoDB Service count: ";
    echo Service::count() . "\n";
    
    $service = Service::first();
    if ($service) {
        echo "First Service: " . $service->ServiceName . " (Duration: " . $service->Duration . ", Category: " . $service->Category . ")\n";
    } else {
        echo "No services found.\n";
    }

    echo "MongoDB Deal count: ";
    echo Deal::count() . "\n";
    $deal = Deal::first();
    if ($deal) {
        echo "First Deal: " . $deal->DealName . " (Terms: " . $deal->Terms . ", MaxUses: " . $deal->MaxUses . ")\n";
    } else {
        echo "No deals found.\n";
    }

    echo "MongoDB test completed successfully.\n";
} catch (Exception $e) {
    echo "MongoDB test failed: " . $e->getMessage() . "\n";
}
