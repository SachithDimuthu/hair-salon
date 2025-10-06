<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "🌱 Seeding Railway MongoDB with Services and Deals\n";
echo "=================================================\n\n";

// Check MongoDB connection
try {
    $count = DB::connection('mongodb')->table('services')->count();
    echo "✓ MongoDB connected successfully\n";
    echo "Current services count: {$count}\n\n";
} catch (Exception $e) {
    echo "✗ MongoDB connection failed: " . $e->getMessage() . "\n";
    exit(1);
}

// Service data with proper image paths
$services = [
    ['name' => 'Deluxe Haircut', 'slug' => 'deluxe-haircut', 'category' => 'Hair', 'description' => 'Premium haircut service with styling', 'price' => 1500, 'duration' => 60, 'active' => true, 'visibility' => 'public', 'image' => 'images/Services/Haircut.jpg', 'features' => ['Wash', 'Cut', 'Style'], 'tags' => ['haircut', 'styling']],
    ['name' => 'Keratin Treatment', 'slug' => 'keratin-treatment', 'category' => 'Hair Care', 'description' => 'Professional keratin treatment for smooth hair', 'price' => 8500, 'duration' => 180, 'active' => true, 'visibility' => 'public', 'image' => 'images/Services/Hair_care.jpg', 'features' => ['Deep conditioning', 'Smoothing'], 'tags' => ['treatment', 'keratin']],
    ['name' => 'Basic Trim', 'slug' => 'basic-trim', 'category' => 'Hair', 'description' => 'Quick and simple hair trimming', 'price' => 800, 'duration' => 30, 'active' => true, 'visibility' => 'public', 'image' => 'images/Services/Haircut.jpg', 'features' => ['Trim'], 'tags' => ['haircut', 'quick']],
    ['name' => 'Deep Conditioning Treatment', 'slug' => 'deep-conditioning', 'category' => 'Hair Care', 'description' => 'Intensive hair conditioning treatment', 'price' => 3500, 'duration' => 90, 'active' => true, 'visibility' => 'public', 'image' => 'images/Services/Hair_care.jpg', 'features' => ['Deep conditioning'], 'tags' => ['treatment', 'conditioning']],
    ['name' => 'Hair Coloring', 'slug' => 'hair-coloring', 'category' => 'Hair', 'description' => 'Professional hair coloring service', 'price' => 5500, 'duration' => 120, 'active' => true, 'visibility' => 'public', 'image' => 'images/Services/Hair_coloring.jpg', 'features' => ['Color consultation', 'Application'], 'tags' => ['color', 'dyeing']],
    ['name' => 'Bridal Package', 'slug' => 'bridal-package', 'category' => 'Special', 'description' => 'Complete bridal beauty package', 'price' => 25000, 'duration' => 240, 'active' => true, 'visibility' => 'public', 'image' => 'images/Services/Bridal.jpg', 'features' => ['Hair', 'Makeup', 'Nails'], 'tags' => ['bridal', 'wedding', 'package']],
    ['name' => 'Basic Facial', 'slug' => 'basic-facial', 'category' => 'Facial', 'description' => 'Refreshing facial treatment', 'price' => 2500, 'duration' => 60, 'active' => true, 'visibility' => 'public', 'image' => 'images/Services/Basic_Facial.jpg', 'features' => ['Cleansing', 'Massage', 'Mask'], 'tags' => ['facial', 'skincare']],
    ['name' => 'Anti Aging Facial', 'slug' => 'anti-aging-facial', 'category' => 'Facial', 'description' => 'Advanced anti-aging treatment', 'price' => 4500, 'duration' => 90, 'active' => true, 'visibility' => 'public', 'image' => 'images/Services/Anti_aging.jpg', 'features' => ['Anti-aging serum', 'Massage'], 'tags' => ['facial', 'anti-aging']],
    ['name' => 'Eyebrow Shaping', 'slug' => 'eyebrow-shaping', 'category' => 'Beauty', 'description' => 'Professional eyebrow shaping', 'price' => 500, 'duration' => 20, 'active' => true, 'visibility' => 'public', 'image' => 'images/Services/Eyebrow_shaping.jpg', 'features' => ['Threading', 'Shaping'], 'tags' => ['eyebrows', 'grooming']],
    ['name' => 'Eyelash Extensions', 'slug' => 'eyelash-extensions', 'category' => 'Beauty', 'description' => 'Premium eyelash extensions', 'price' => 3500, 'duration' => 90, 'active' => true, 'visibility' => 'public', 'image' => 'images/Services/Eyelashes_extensions.jpg', 'features' => ['Classic lashes', 'Application'], 'tags' => ['lashes', 'extensions']],
    ['name' => 'Makeup Service', 'slug' => 'makeup-service', 'category' => 'Beauty', 'description' => 'Professional makeup application', 'price' => 3000, 'duration' => 60, 'active' => true, 'visibility' => 'public', 'image' => 'images/Services/Makeup.jpg', 'features' => ['Full makeup'], 'tags' => ['makeup', 'beauty']],
    ['name' => 'Party Makeup', 'slug' => 'party-makeup', 'category' => 'Beauty', 'description' => 'Glamorous party makeup', 'price' => 4000, 'duration' => 75, 'active' => true, 'visibility' => 'public', 'image' => 'images/Services/Party_makeup.jpg', 'features' => ['Full makeup', 'Glam look'], 'tags' => ['makeup', 'party']],
    ['name' => 'Manicure', 'slug' => 'manicure', 'category' => 'Nails', 'description' => 'Complete manicure service', 'price' => 1200, 'duration' => 45, 'active' => true, 'visibility' => 'public', 'image' => 'images/Services/Manicure.jpg', 'features' => ['Nail care', 'Polish'], 'tags' => ['nails', 'manicure']],
    ['name' => 'Pedicure', 'slug' => 'pedicure', 'category' => 'Nails', 'description' => 'Relaxing pedicure treatment', 'price' => 1500, 'duration' => 60, 'active' => true, 'visibility' => 'public', 'image' => 'images/Services/Pedicure.jpg', 'features' => ['Foot care', 'Polish'], 'tags' => ['nails', 'pedicure']],
    ['name' => 'Nail Art', 'slug' => 'nail-art', 'category' => 'Nails', 'description' => 'Creative nail art designs', 'price' => 2000, 'duration' => 60, 'active' => true, 'visibility' => 'public', 'image' => 'images/Services/Nail_arts.jpg', 'features' => ['Custom designs'], 'tags' => ['nails', 'art']],
    ['name' => 'Hair Spa', 'slug' => 'hair-spa', 'category' => 'Hair Care', 'description' => 'Luxurious hair spa treatment', 'price' => 4500, 'duration' => 90, 'active' => true, 'visibility' => 'public', 'image' => 'images/Services/Hair_spa.jpg', 'features' => ['Spa treatment', 'Massage'], 'tags' => ['spa', 'treatment']],
    ['name' => 'Full Body Waxing', 'slug' => 'full-body-waxing', 'category' => 'Waxing', 'description' => 'Complete body waxing service', 'price' => 5500, 'duration' => 120, 'active' => true, 'visibility' => 'public', 'image' => 'images/Services/Full_body_waxing.jpg', 'features' => ['Full body'], 'tags' => ['waxing', 'grooming']],
    ['name' => 'Face Waxing', 'slug' => 'face-waxing', 'category' => 'Waxing', 'description' => 'Gentle face waxing', 'price' => 800, 'duration' => 30, 'active' => true, 'visibility' => 'public', 'image' => 'images/Services/Face_waxing.jpg', 'features' => ['Face waxing'], 'tags' => ['waxing', 'face']],
    ['name' => 'Groom Package', 'slug' => 'groom-package', 'category' => 'Special', 'description' => 'Complete grooming for grooms', 'price' => 18000, 'duration' => 180, 'active' => true, 'visibility' => 'public', 'image' => 'images/Services/Groom.jpg', 'features' => ['Hair', 'Grooming'], 'tags' => ['groom', 'wedding', 'package']],
    ['name' => 'Festival Package', 'slug' => 'festival-package', 'category' => 'Special', 'description' => 'Special festival beauty package', 'price' => 8000, 'duration' => 120, 'active' => true, 'visibility' => 'public', 'image' => 'images/Services/Festival.jpg', 'features' => ['Hair', 'Makeup'], 'tags' => ['festival', 'package']],
];

echo "Clearing existing services...\n";
DB::connection('mongodb')->table('services')->truncate();

echo "Inserting " . count($services) . " services...\n";
foreach ($services as $service) {
    DB::connection('mongodb')->table('services')->insert($service);
    echo "✓ {$service['name']}\n";
}

echo "\n=================================================\n";
echo "✅ Successfully seeded " . count($services) . " services!\n";
echo "✅ MongoDB is ready for production!\n\n";

// Verify
$finalCount = DB::connection('mongodb')->table('services')->count();
echo "Final count: {$finalCount} services\n";
