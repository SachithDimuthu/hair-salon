<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Service;
use App\Models\Deal;

class MongoDBSeeder extends Seeder
{
    /**
     * Run the database seeds for MongoDB collections.
     */
    public function run(): void
    {
        // Clear existing MongoDB data
        Service::truncate();
        Deal::truncate();

        // Create Services in MongoDB
        $services = [
            [
                'ServiceName' => 'Premium Haircut & Styling',
                'Description' => 'Professional haircut with personalized styling consultation, wash, cut, and blow-dry using premium products.',
                'Price' => 75.00,
                'Visibility' => true,
                'Duration' => 90,
                'Category' => 'Hair Services',
                'ServicePhoto' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'ServiceName' => 'Hair Coloring & Highlights',
                'Description' => 'Complete hair coloring service including consultation, color application, and professional styling.',
                'Price' => 120.00,
                'Visibility' => true,
                'Duration' => 180,
                'Category' => 'Hair Services',
                'ServicePhoto' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'ServiceName' => 'Luxury Facial Treatment',
                'Description' => 'Rejuvenating facial treatment with deep cleansing, exfoliation, and hydrating mask for all skin types.',
                'Price' => 95.00,
                'Visibility' => true,
                'Duration' => 75,
                'Category' => 'Spa Services',
                'ServicePhoto' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'ServiceName' => 'Manicure & Pedicure',
                'Description' => 'Complete nail care service including cuticle care, shaping, buffing, and polish application.',
                'Price' => 65.00,
                'Visibility' => true,
                'Duration' => 60,
                'Category' => 'Nail Services',
                'ServicePhoto' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'ServiceName' => 'Relaxation Massage',
                'Description' => 'Full-body relaxation massage using aromatic oils and therapeutic techniques for stress relief.',
                'Price' => 110.00,
                'Visibility' => true,
                'Duration' => 90,
                'Category' => 'Spa Services',
                'ServicePhoto' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        $createdServices = [];
        foreach ($services as $service) {
            $createdService = Service::create($service);
            $createdServices[] = $createdService;
            echo "Created service: " . $service['ServiceName'] . " (ID: " . $createdService->_id . ")\n";
        }

        // Create Deals in MongoDB
        $deals = [
            [
                'DealName' => 'New Client Welcome Special',
                'Description' => 'First-time clients receive 25% off any hair service. Perfect introduction to our premium salon experience.',
                'DiscountPercentage' => 25.00,
                'StartDate' => now()->subDays(7),
                'EndDate' => now()->addMonths(3),
                'IsActive' => true,
                'ServiceID' => $createdServices[0]->_id, // Premium Haircut
                'Terms' => 'Valid for new clients only. Cannot be combined with other offers.',
                'MaxUses' => 100,
                'CurrentUses' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'DealName' => 'Student Spa Package',
                'Description' => 'Students save 20% on all spa services with valid student ID. Includes facial treatments and massages.',
                'DiscountPercentage' => 20.00,
                'StartDate' => now()->subDays(14),
                'EndDate' => now()->addMonths(6),
                'IsActive' => true,
                'ServiceID' => $createdServices[2]->_id, // Luxury Facial
                'Terms' => 'Valid student ID required. Available Monday-Thursday only.',
                'MaxUses' => null, // Unlimited uses
                'CurrentUses' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'DealName' => 'Holiday Color Special',
                'Description' => 'Get ready for the holidays with 30% off hair coloring and highlighting services.',
                'DiscountPercentage' => 30.00,
                'StartDate' => now()->addDays(30),
                'EndDate' => now()->addDays(90),
                'IsActive' => true,
                'ServiceID' => $createdServices[1]->_id, // Hair Coloring
                'Terms' => 'Advance booking required. Limited time offer.',
                'MaxUses' => 50,
                'CurrentUses' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($deals as $deal) {
            $createdDeal = Deal::create($deal);
            echo "Created deal: " . $deal['DealName'] . " (ID: " . $createdDeal->_id . ")\n";
        }

        echo "\nMongoDB seeding completed successfully!\n";
        echo "Created " . count($services) . " services and " . count($deals) . " deals in MongoDB.\n";
    }
}