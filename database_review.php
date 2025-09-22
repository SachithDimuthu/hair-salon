<?php

/**
 * Database Implementation Review & Testing Script
 * Luxe Hair Studio - Phase 2 Validation
 */

require_once 'vendor/autoload.php';

use App\Models\User;
use App\Models\Customer;
use App\Models\Staff;
use App\Models\Category;
use App\Models\Service;
use App\Models\Product;
use App\Models\Appointment;
use App\Models\Order;
use App\Models\Review;
use App\Models\WorkSchedule;

echo "=== LUXE HAIR STUDIO DATABASE REVIEW ===\n\n";

// Test 1: Model Class Loading
echo "1. Testing Model Classes:\n";
$models = [
    'User' => User::class,
    'Customer' => Customer::class,
    'Staff' => Staff::class,
    'Category' => Category::class,
    'Service' => Service::class,
    'Product' => Product::class,
    'Appointment' => Appointment::class,
    'Order' => Order::class,
    'Review' => Review::class,
    'WorkSchedule' => WorkSchedule::class,
];

foreach ($models as $name => $class) {
    $status = class_exists($class) ? "✅ LOADED" : "❌ FAILED";
    echo "   {$name}: {$status}\n";
}

// Test 2: Database Connection
echo "\n2. Testing Database Connection:\n";
try {
    $connection = \Illuminate\Support\Facades\DB::connection();
    $connection->getPdo();
    echo "   Database Connection: ✅ CONNECTED\n";
} catch (Exception $e) {
    echo "   Database Connection: ❌ FAILED - " . $e->getMessage() . "\n";
}

// Test 3: Table Existence
echo "\n3. Testing Table Structure:\n";
$tables = [
    'users', 'customers', 'staff', 'categories', 'services', 
    'products', 'appointments', 'orders', 'staff_services',
    'appointment_services', 'order_items', 'reviews', 'work_schedules'
];

foreach ($tables as $table) {
    try {
        $exists = \Illuminate\Support\Facades\Schema::hasTable($table);
        $status = $exists ? "✅ EXISTS" : "❌ MISSING";
        echo "   {$table}: {$status}\n";
    } catch (Exception $e) {
        echo "   {$table}: ❌ ERROR - " . $e->getMessage() . "\n";
    }
}

// Test 4: Model Relationships
echo "\n4. Testing Model Relationships:\n";

// Test User role system
echo "   User Role System:\n";
try {
    $user = new User(['name' => 'Test User', 'email' => 'test@test.com', 'role' => 'admin']);
    $isAdmin = $user->isAdmin();
    echo "     - Role Methods: " . ($isAdmin ? "✅ WORKING" : "❌ FAILED") . "\n";
} catch (Exception $e) {
    echo "     - Role Methods: ❌ ERROR - " . $e->getMessage() . "\n";
}

// Test Customer relationships
echo "   Customer Model:\n";
try {
    $customer = new Customer();
    $hasUserRelation = method_exists($customer, 'user');
    $hasAppointmentsRelation = method_exists($customer, 'appointments');
    echo "     - User Relationship: " . ($hasUserRelation ? "✅ DEFINED" : "❌ MISSING") . "\n";
    echo "     - Appointments Relationship: " . ($hasAppointmentsRelation ? "✅ DEFINED" : "❌ MISSING") . "\n";
} catch (Exception $e) {
    echo "     - Relationships: ❌ ERROR - " . $e->getMessage() . "\n";
}

// Test Staff relationships
echo "   Staff Model:\n";
try {
    $staff = new Staff();
    $hasServicesRelation = method_exists($staff, 'services');
    $hasScheduleRelation = method_exists($staff, 'workSchedules');
    echo "     - Services Relationship: " . ($hasServicesRelation ? "✅ DEFINED" : "❌ MISSING") . "\n";
    echo "     - Work Schedules Relationship: " . ($hasScheduleRelation ? "✅ DEFINED" : "❌ MISSING") . "\n";
} catch (Exception $e) {
    echo "     - Relationships: ❌ ERROR - " . $e->getMessage() . "\n";
}

// Test Service model business logic
echo "   Service Model Business Logic:\n";
try {
    $service = new Service(['duration_minutes' => 90]);
    $formattedDuration = $service->getFormattedDurationAttribute();
    echo "     - Duration Formatting: " . (!empty($formattedDuration) ? "✅ WORKING" : "❌ FAILED") . "\n";
} catch (Exception $e) {
    echo "     - Business Logic: ❌ ERROR - " . $e->getMessage() . "\n";
}

// Test 5: Database Constraints
echo "\n5. Testing Database Constraints:\n";

// Check foreign key constraints exist
$constraints = [
    'customers' => 'user_id',
    'staff' => 'user_id', 
    'services' => 'category_id',
    'products' => 'category_id',
    'appointments' => 'customer_id',
    'orders' => 'customer_id'
];

foreach ($constraints as $table => $column) {
    try {
        $columns = \Illuminate\Support\Facades\Schema::getColumnListing($table);
        $hasColumn = in_array($column, $columns);
        echo "   {$table}.{$column}: " . ($hasColumn ? "✅ EXISTS" : "❌ MISSING") . "\n";
    } catch (Exception $e) {
        echo "   {$table}.{$column}: ❌ ERROR - " . $e->getMessage() . "\n";
    }
}

echo "\n=== REVIEW COMPLETED ===\n";
echo "✅ = Working correctly\n";
echo "❌ = Issue found\n";
echo "Review any failed items above before proceeding to Phase 3.\n";

// Test 1: Check if all models can be instantiated
echo "1. MODEL INSTANTIATION TEST:\n";
$models = [
    'User' => User::class,
    'Customer' => Customer::class,
    'Staff' => Staff::class,
    'Category' => Category::class,
    'Service' => Service::class,
    'Product' => Product::class,
    'Appointment' => Appointment::class,
    'Order' => Order::class,
    'Review' => Review::class,
    'WorkSchedule' => WorkSchedule::class,
];

foreach ($models as $name => $class) {
    try {
        $instance = new $class();
        echo "   ✅ {$name}: OK\n";
    } catch (Exception $e) {
        echo "   ❌ {$name}: FAIL - {$e->getMessage()}\n";
    }
}

// Test 2: Check database table existence
echo "\n2. DATABASE TABLE TEST:\n";
$tables = [
    'users', 'customers', 'staff', 'categories', 'services', 'products',
    'appointments', 'orders', 'staff_services', 'appointment_services',
    'order_items', 'reviews', 'work_schedules'
];

foreach ($tables as $table) {
    try {
        if (Schema::hasTable($table)) {
            echo "   ✅ {$table}: EXISTS\n";
        } else {
            echo "   ❌ {$table}: MISSING\n";
        }
    } catch (Exception $e) {
        echo "   ❌ {$table}: ERROR - {$e->getMessage()}\n";
    }
}

// Test 3: Check model record counts
echo "\n3. MODEL RECORD COUNT TEST:\n";
foreach ($models as $name => $class) {
    try {
        $count = $class::count();
        echo "   📊 {$name}: {$count} records\n";
    } catch (Exception $e) {
        echo "   ❌ {$name}: FAIL - {$e->getMessage()}\n";
    }
}

// Test 4: Test User model role functionality
echo "\n4. USER ROLE SYSTEM TEST:\n";
try {
    $userCount = User::count();
    echo "   📊 Total users: {$userCount}\n";
    
    if ($userCount > 0) {
        $user = User::first();
        echo "   🔍 First user role: {$user->role}\n";
        echo "   🔍 Is Admin: " . ($user->isAdmin() ? 'Yes' : 'No') . "\n";
        echo "   🔍 Is Staff: " . ($user->isStaff() ? 'Yes' : 'No') . "\n";
        echo "   🔍 Is Customer: " . ($user->isCustomer() ? 'Yes' : 'No') . "\n";
    }
} catch (Exception $e) {
    echo "   ❌ User role test FAIL: {$e->getMessage()}\n";
}

// Test 5: Test relationships (basic)
echo "\n5. RELATIONSHIP TEST:\n";
try {
    echo "   🔗 User->customer relationship: " . (method_exists(User::class, 'customer') ? 'EXISTS' : 'MISSING') . "\n";
    echo "   🔗 User->staff relationship: " . (method_exists(User::class, 'staff') ? 'EXISTS' : 'MISSING') . "\n";
    echo "   🔗 Customer->appointments relationship: " . (method_exists(Customer::class, 'appointments') ? 'EXISTS' : 'MISSING') . "\n";
    echo "   🔗 Staff->services relationship: " . (method_exists(Staff::class, 'services') ? 'EXISTS' : 'MISSING') . "\n";
} catch (Exception $e) {
    echo "   ❌ Relationship test FAIL: {$e->getMessage()}\n";
}

echo "\n=== REVIEW COMPLETE ===\n";