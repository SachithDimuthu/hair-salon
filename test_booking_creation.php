<?php

require_once 'vendor/autoload.php';

use App\Models\Booking;
use App\Models\Service;
use Illuminate\Foundation\Application;

// Bootstrap Laravel application
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

try {
    // Get the first service
    $service = Service::first();
    
    if (!$service) {
        echo "No services found. Please create a service first.\n";
        exit(1);
    }
    
    // Create test bookings
    $bookings = [
        [
            'customer_first_name' => 'John',
            'customer_last_name' => 'Smith',
            'customer_email' => 'john.smith@example.com',
            'customer_phone' => '555-0101',
            'service_id' => $service->_id,
            'service_name' => $service->name,
            'service_price' => $service->base_price,
            'booking_date' => today()->format('Y-m-d'),
            'booking_time' => '10:00',
            'duration_minutes' => $service->durations[0]['minutes'],
            'total_price' => $service->base_price,
            'status' => 'pending'
        ],
        [
            'customer_first_name' => 'Sarah',
            'customer_last_name' => 'Johnson',
            'customer_email' => 'sarah.johnson@example.com',
            'customer_phone' => '555-0102',
            'service_id' => $service->_id,
            'service_name' => $service->name,
            'service_price' => $service->base_price,
            'booking_date' => today()->format('Y-m-d'),
            'booking_time' => '14:00',
            'duration_minutes' => $service->durations[0]['minutes'],
            'total_price' => $service->base_price,
            'status' => 'confirmed'
        ],
        [
            'customer_first_name' => 'Mike',
            'customer_last_name' => 'Brown',
            'customer_email' => 'mike.brown@example.com',
            'customer_phone' => '555-0103',
            'service_id' => $service->_id,
            'service_name' => $service->name,
            'service_price' => $service->base_price,
            'booking_date' => today()->subDays(1)->format('Y-m-d'),
            'booking_time' => '11:00',
            'duration_minutes' => $service->durations[0]['minutes'],
            'total_price' => $service->base_price,
            'status' => 'completed'
        ]
    ];
    
    foreach ($bookings as $bookingData) {
        $booking = Booking::create($bookingData);
        echo "Created booking #{$booking->id} for {$booking->customer_first_name} {$booking->customer_last_name}\n";
    }
    
    echo "\nTest bookings created successfully!\n";
    echo "Total bookings in database: " . Booking::count() . "\n";
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "Stack trace: " . $e->getTraceAsString() . "\n";
}