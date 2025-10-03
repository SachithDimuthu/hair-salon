<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class SimpleServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Clear existing services for a fresh start
        Service::truncate();

        // Simple services that match the MySQL table structure
        $services = [
            [
                'ServiceName' => 'Deluxe Haircut',
                'Description' => 'Premium haircut service with wash, cut, style, and finishing touches.',
                'Price' => 85.00,
                'Visibility' => true,
                'ServicePhoto' => null,
            ],
            [
                'ServiceName' => 'Hair Coloring',
                'Description' => 'Professional hair coloring and highlighting services.',
                'Price' => 120.00,
                'Visibility' => true,
                'ServicePhoto' => null,
            ],
            [
                'ServiceName' => 'Deep Conditioning Treatment',
                'Description' => 'Intensive hair treatment to restore moisture and shine.',
                'Price' => 65.00,
                'Visibility' => true,
                'ServicePhoto' => null,
            ],
            [
                'ServiceName' => 'Hair Styling',
                'Description' => 'Professional hair styling for special events and occasions.',
                'Price' => 55.00,
                'Visibility' => true,
                'ServicePhoto' => null,
            ],
            [
                'ServiceName' => 'Beard Trim',
                'Description' => 'Professional beard trimming and shaping service.',
                'Price' => 35.00,
                'Visibility' => true,
                'ServicePhoto' => null,
            ],
            [
                'ServiceName' => 'Facial Treatment',
                'Description' => 'Relaxing facial treatment with cleansing and moisturizing.',
                'Price' => 75.00,
                'Visibility' => true,
                'ServicePhoto' => null,
            ],
        ];

        foreach ($services as $service) {
            Service::create($service);
        }

        echo "\nSimple service seeding completed!\n";
        echo "Created " . count($services) . " services in MySQL database.\n";
    }
}