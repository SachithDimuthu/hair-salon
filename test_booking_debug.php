<?php

// Test script to debug BookService time slot functionality
echo "=== BookService Time Slot Test ===\n";

// Change to the project directory
chdir('C:\xampp\htdocs\Salon\luxe-hair-studio');

// Load Laravel application
require_once 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Test the BookService component
echo "1. Testing time slot generation...\n";

use App\Livewire\BookService;
use Carbon\Carbon;

try {
    // Create component instance
    $component = new BookService();
    
    // Test with tomorrow's date
    $testDate = Carbon::tomorrow()->format('Y-m-d');
    echo "   Test date: {$testDate}\n";
    
    // Set booking date
    $component->bookingDate = $testDate;
    
    // Generate time slots
    $component->generateTimeSlots();
    
    // Check results
    echo "   Generated time slots: " . count($component->availableTimeSlots) . "\n";
    
    if (count($component->availableTimeSlots) > 0) {
        echo "   First few slots:\n";
        foreach (array_slice($component->availableTimeSlots, 0, 5) as $slot) {
            echo "     - {$slot['display']} ({$slot['time']})\n";
        }
        
        // Test time slot selection
        $firstSlot = $component->availableTimeSlots[0];
        $component->selectTimeSlot($firstSlot['time']);
        echo "   Selected time: {$component->bookingTime}\n";
        
        // Test validation
        echo "   Can proceed to next step: " . ($component->canProceedToNextStep() ? 'YES' : 'NO') . "\n";
    } else {
        echo "   ERROR: No time slots generated!\n";
    }
    
} catch (Exception $e) {
    echo "   ERROR: " . $e->getMessage() . "\n";
    echo "   Trace: " . $e->getTraceAsString() . "\n";
}

echo "\n=== Test Complete ===\n";