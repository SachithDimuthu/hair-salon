<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Service;

class MongoDBServicesSeeder extends Seeder
{
    /**
     * Seed the MongoDB services collection for production
     */
    public function run(): void
    {
        echo "\n";
        echo "===========================================\n";
        echo "🌱 STARTING MongoDB Services Seeder\n";
        echo "===========================================\n";
        echo "Environment: " . app()->environment() . "\n";
        echo "Database: " . config('database.connections.mongodb.database') . "\n";
        echo "Host: " . config('database.connections.mongodb.host') . "\n";
        echo "Port: " . config('database.connections.mongodb.port') . "\n";
        echo "Username: " . (config('database.connections.mongodb.username') ? '***SET***' : 'NOT SET') . "\n";
        echo "Password: " . (config('database.connections.mongodb.password') ? '***SET***' : 'NOT SET') . "\n";
        
        // Check if DSN is set (Railway uses DSN connection string)
        $dsn = config('database.connections.mongodb.dsn');
        if ($dsn) {
            echo "DSN: " . (substr($dsn, 0, 20) . '...') . "\n";
        }
        echo "-------------------------------------------\n";
        
        try {
        $services = [
            ['name' => 'Deluxe Haircut', 'slug' => 'deluxe-haircut', 'category' => 'Hair', 'description' => 'Premium haircut service with expert styling and consultation', 'price' => 1500, 'duration' => 60, 'active' => true, 'visibility' => 'public', 'image' => 'images/Services/Haircut.jpg', 'features' => ['Wash', 'Cut', 'Style'], 'tags' => ['haircut', 'styling']],
            
            ['name' => 'Keratin Treatment', 'slug' => 'keratin-treatment', 'category' => 'Hair Care', 'description' => 'Professional keratin treatment for smooth, frizz-free hair', 'price' => 8500, 'duration' => 180, 'active' => true, 'visibility' => 'public', 'image' => 'images/Services/Hair_care.jpg', 'features' => ['Deep conditioning', 'Smoothing', 'Shine'], 'tags' => ['treatment', 'keratin', 'smoothing']],
            
            ['name' => 'Basic Trim', 'slug' => 'basic-trim', 'category' => 'Hair', 'description' => 'Quick and simple hair trimming service', 'price' => 800, 'duration' => 30, 'active' => true, 'visibility' => 'public', 'image' => 'images/Services/Haircut.jpg', 'features' => ['Trim'], 'tags' => ['haircut', 'quick', 'trim']],
            
            ['name' => 'Deep Conditioning Treatment', 'slug' => 'deep-conditioning', 'category' => 'Hair Care', 'description' => 'Intensive deep conditioning treatment for damaged hair', 'price' => 3500, 'duration' => 90, 'active' => true, 'visibility' => 'public', 'image' => 'images/Services/Hair_care.jpg', 'features' => ['Deep conditioning', 'Repair'], 'tags' => ['treatment', 'conditioning', 'repair']],
            
            ['name' => 'Hair Coloring', 'slug' => 'hair-coloring', 'category' => 'Hair', 'description' => 'Professional hair coloring with premium products', 'price' => 5500, 'duration' => 120, 'active' => true, 'visibility' => 'public', 'image' => 'images/Services/Hair_coloring.jpg', 'features' => ['Color consultation', 'Application', 'After-care'], 'tags' => ['color', 'dyeing', 'highlights']],
            
            ['name' => 'Bridal Package', 'slug' => 'bridal-package', 'category' => 'Special', 'description' => 'Complete bridal beauty package including hair, makeup, and nails', 'price' => 25000, 'duration' => 240, 'active' => true, 'visibility' => 'public', 'image' => 'images/Services/Bridal.jpg', 'features' => ['Hair styling', 'Makeup', 'Nails', 'Trial session'], 'tags' => ['bridal', 'wedding', 'package', 'special']],
            
            ['name' => 'Basic Facial', 'slug' => 'basic-facial', 'category' => 'Facial', 'description' => 'Refreshing basic facial treatment for all skin types', 'price' => 2500, 'duration' => 60, 'active' => true, 'visibility' => 'public', 'image' => 'images/Services/Basic_Facial.jpg', 'features' => ['Cleansing', 'Exfoliation', 'Massage', 'Mask'], 'tags' => ['facial', 'skincare', 'cleansing']],
            
            ['name' => 'Anti-Aging Facial', 'slug' => 'anti-aging-facial', 'category' => 'Facial', 'description' => 'Advanced anti-aging facial treatment with premium serums', 'price' => 4500, 'duration' => 90, 'active' => true, 'visibility' => 'public', 'image' => 'images/Services/Anti_aging.jpg', 'features' => ['Anti-aging serum', 'Collagen boost', 'Massage'], 'tags' => ['facial', 'anti-aging', 'premium']],
            
            ['name' => 'Eyebrow Shaping', 'slug' => 'eyebrow-shaping', 'category' => 'Beauty', 'description' => 'Professional eyebrow threading and shaping', 'price' => 500, 'duration' => 20, 'active' => true, 'visibility' => 'public', 'image' => 'images/Services/Eyebrow_shaping.jpg', 'features' => ['Threading', 'Shaping', 'Tinting'], 'tags' => ['eyebrows', 'grooming', 'threading']],
            
            ['name' => 'Eyelash Extensions', 'slug' => 'eyelash-extensions', 'category' => 'Beauty', 'description' => 'Premium eyelash extensions for dramatic or natural looks', 'price' => 3500, 'duration' => 90, 'active' => true, 'visibility' => 'public', 'image' => 'images/Services/Eyelashes_extensions.jpg', 'features' => ['Classic lashes', 'Volume lashes', 'Application'], 'tags' => ['lashes', 'extensions', 'beauty']],
            
            ['name' => 'Makeup Service', 'slug' => 'makeup-service', 'category' => 'Beauty', 'description' => 'Professional makeup application for any occasion', 'price' => 3000, 'duration' => 60, 'active' => true, 'visibility' => 'public', 'image' => 'images/Services/Makeup.jpg', 'features' => ['Full makeup', 'Consultation'], 'tags' => ['makeup', 'beauty', 'glam']],
            
            ['name' => 'Party Makeup', 'slug' => 'party-makeup', 'category' => 'Beauty', 'description' => 'Glamorous party makeup with long-lasting finish', 'price' => 4000, 'duration' => 75, 'active' => true, 'visibility' => 'public', 'image' => 'images/Services/Party_makeup.jpg', 'features' => ['Full makeup', 'Glam look', 'Touch-ups'], 'tags' => ['makeup', 'party', 'glam']],
            
            ['name' => 'Manicure', 'slug' => 'manicure', 'category' => 'Nails', 'description' => 'Complete manicure service with nail care and polish', 'price' => 1200, 'duration' => 45, 'active' => true, 'visibility' => 'public', 'image' => 'images/Services/Manicure.jpg', 'features' => ['Nail care', 'Polish', 'Hand massage'], 'tags' => ['nails', 'manicure', 'polish']],
            
            ['name' => 'Pedicure', 'slug' => 'pedicure', 'category' => 'Nails', 'description' => 'Relaxing pedicure treatment with foot care', 'price' => 1500, 'duration' => 60, 'active' => true, 'visibility' => 'public', 'image' => 'images/Services/Pedicure.jpg', 'features' => ['Foot care', 'Polish', 'Foot massage'], 'tags' => ['nails', 'pedicure', 'foot-care']],
            
            ['name' => 'Nail Art', 'slug' => 'nail-art', 'category' => 'Nails', 'description' => 'Creative nail art designs with premium products', 'price' => 2000, 'duration' => 60, 'active' => true, 'visibility' => 'public', 'image' => 'images/Services/Nail_arts.jpg', 'features' => ['Custom designs', 'Gel polish', 'Decorations'], 'tags' => ['nails', 'art', 'design']],
            
            ['name' => 'Hair Spa', 'slug' => 'hair-spa', 'category' => 'Hair Care', 'description' => 'Luxurious hair spa treatment with deep conditioning', 'price' => 4500, 'duration' => 90, 'active' => true, 'visibility' => 'public', 'image' => 'images/Services/Hair_spa.jpg', 'features' => ['Spa treatment', 'Head massage', 'Conditioning'], 'tags' => ['spa', 'treatment', 'luxury']],
            
            ['name' => 'Full Body Waxing', 'slug' => 'full-body-waxing', 'category' => 'Waxing', 'description' => 'Complete body waxing service with premium wax', 'price' => 5500, 'duration' => 120, 'active' => true, 'visibility' => 'public', 'image' => 'images/Services/Full_body_waxing.jpg', 'features' => ['Full body', 'Premium wax', 'After-care'], 'tags' => ['waxing', 'grooming', 'body']],
            
            ['name' => 'Face Waxing', 'slug' => 'face-waxing', 'category' => 'Waxing', 'description' => 'Gentle face waxing with sensitive skin formula', 'price' => 800, 'duration' => 30, 'active' => true, 'visibility' => 'public', 'image' => 'images/Services/Face_waxing.jpg', 'features' => ['Face waxing', 'Sensitive formula'], 'tags' => ['waxing', 'face', 'gentle']],
            
            ['name' => 'Groom Package', 'slug' => 'groom-package', 'category' => 'Special', 'description' => 'Complete grooming package for grooms', 'price' => 18000, 'duration' => 180, 'active' => true, 'visibility' => 'public', 'image' => 'images/Services/Groom.jpg', 'features' => ['Hair', 'Beard grooming', 'Facial'], 'tags' => ['groom', 'wedding', 'package', 'men']],
            
            ['name' => 'Festival Package', 'slug' => 'festival-package', 'category' => 'Special', 'description' => 'Special festival beauty package with hair and makeup', 'price' => 8000, 'duration' => 120, 'active' => true, 'visibility' => 'public', 'image' => 'images/Services/Festival.jpg', 'features' => ['Hair styling', 'Makeup', 'Accessories'], 'tags' => ['festival', 'package', 'celebration']],
        ];

        echo "Clearing existing services...\n";
        Service::truncate();
        
        echo "Inserting " . count($services) . " services...\n";
        
        // Insert all services using the model
        foreach ($services as $service) {
            Service::create($service);
        }
        
        $count = Service::count();
        echo "-------------------------------------------\n";
        echo "✅ Successfully seeded {$count} services to MongoDB!\n";
        echo "===========================================\n\n";
        
        } catch (\Exception $e) {
            echo "-------------------------------------------\n";
            echo "❌ ERROR SEEDING MongoDB\n";
            echo "Error: " . $e->getMessage() . "\n";
            echo "File: " . $e->getFile() . ":" . $e->getLine() . "\n";
            echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
            echo "===========================================\n\n";
            throw $e;
        }
    }
}
