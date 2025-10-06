<?php
/**
 * Seed Railway MongoDB Database
 * Run this locally to populate Railway MongoDB with services
 */

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "🚀 Connecting to Railway MongoDB...\n";
echo "=====================================\n\n";

// Railway MongoDB connection (internal network won't work from local)
// We need to use MONGO_PUBLIC_URL or MONGO_URL instead

echo "⚠️  Note: You need to use MONGO_PUBLIC_URL to connect from outside Railway\n\n";

echo "Please go to your Railway MongoDB service and find:\n";
echo "- MONGO_PUBLIC_URL (or MONGO_URL)\n\n";

echo "Then run this command instead:\n";
echo "php artisan tinker\n\n";

echo "And paste this code:\n";
echo "=====================================\n";
echo "
// Your services data
\$services = [
    ['name' => 'Deluxe Haircut', 'slug' => 'deluxe-haircut', 'category' => 'Hair', 'description' => 'Premium haircut service with styling', 'price' => 1500, 'duration' => 60, 'active' => true, 'visibility' => 'public', 'image' => 'images/Services/Haircut.jpg'],
    ['name' => 'Keratin Treatment', 'slug' => 'keratin-treatment', 'category' => 'Hair Care', 'description' => 'Professional keratin treatment', 'price' => 8500, 'duration' => 180, 'active' => true, 'visibility' => 'public', 'image' => 'images/Services/Hair_care.jpg'],
    ['name' => 'Basic Trim', 'slug' => 'basic-trim', 'category' => 'Hair', 'description' => 'Quick hair trimming', 'price' => 800, 'duration' => 30, 'active' => true, 'visibility' => 'public', 'image' => 'images/Services/Haircut.jpg'],
    ['name' => 'Hair Coloring', 'slug' => 'hair-coloring', 'category' => 'Hair', 'description' => 'Professional hair coloring', 'price' => 5500, 'duration' => 120, 'active' => true, 'visibility' => 'public', 'image' => 'images/Services/Hair_coloring.jpg'],
    ['name' => 'Bridal Package', 'slug' => 'bridal-package', 'category' => 'Special', 'description' => 'Complete bridal beauty package', 'price' => 25000, 'duration' => 240, 'active' => true, 'visibility' => 'public', 'image' => 'images/Services/Bridal.jpg'],
    ['name' => 'Basic Facial', 'slug' => 'basic-facial', 'category' => 'Facial', 'description' => 'Refreshing facial treatment', 'price' => 2500, 'duration' => 60, 'active' => true, 'visibility' => 'public', 'image' => 'images/Services/Basic_Facial.jpg'],
    ['name' => 'Eyebrow Shaping', 'slug' => 'eyebrow-shaping', 'category' => 'Beauty', 'description' => 'Professional eyebrow shaping', 'price' => 500, 'duration' => 20, 'active' => true, 'visibility' => 'public', 'image' => 'images/Services/Eyebrow_shaping.jpg'],
    ['name' => 'Eyelash Extensions', 'slug' => 'eyelash-extensions', 'category' => 'Beauty', 'description' => 'Premium eyelash extensions', 'price' => 3500, 'duration' => 90, 'active' => true, 'visibility' => 'public', 'image' => 'images/Services/Eyelashes_extensions.jpg'],
    ['name' => 'Makeup Service', 'slug' => 'makeup-service', 'category' => 'Beauty', 'description' => 'Professional makeup application', 'price' => 3000, 'duration' => 60, 'active' => true, 'visibility' => 'public', 'image' => 'images/Services/Makeup.jpg'],
    ['name' => 'Manicure', 'slug' => 'manicure', 'category' => 'Nails', 'description' => 'Complete manicure service', 'price' => 1200, 'duration' => 45, 'active' => true, 'visibility' => 'public', 'image' => 'images/Services/Manicure.jpg'],
    ['name' => 'Pedicure', 'slug' => 'pedicure', 'category' => 'Nails', 'description' => 'Relaxing pedicure treatment', 'price' => 1500, 'duration' => 60, 'active' => true, 'visibility' => 'public', 'image' => 'images/Services/Pedicure.jpg'],
    ['name' => 'Hair Spa', 'slug' => 'hair-spa', 'category' => 'Hair Care', 'description' => 'Luxurious hair spa treatment', 'price' => 4500, 'duration' => 90, 'active' => true, 'visibility' => 'public', 'image' => 'images/Services/Hair_spa.jpg'],
    ['name' => 'Full Body Waxing', 'slug' => 'full-body-waxing', 'category' => 'Waxing', 'description' => 'Complete body waxing', 'price' => 5500, 'duration' => 120, 'active' => true, 'visibility' => 'public', 'image' => 'images/Services/Full_body_waxing.jpg'],
    ['name' => 'Groom Package', 'slug' => 'groom-package', 'category' => 'Special', 'description' => 'Complete grooming for grooms', 'price' => 18000, 'duration' => 180, 'active' => true, 'visibility' => 'public', 'image' => 'images/Services/Groom.jpg'],
];

// Copy existing local services to get all 37
\$localServices = DB::connection('mongodb')->table('services')->get()->toArray();

echo 'Found ' . count(\$localServices) . ' services in local MongoDB';
echo 'Seeding to Railway MongoDB...';

foreach (\$localServices as \$service) {
    App\Models\Service::create((array)\$service);
    echo '.';
}

echo 'Done! Seeded ' . count(\$localServices) . ' services';
";
