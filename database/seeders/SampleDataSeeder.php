<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Customer;
use App\Models\Service;
use App\Models\Deal;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class SampleDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Services
        $services = [
            [
                'ServiceName' => 'Haircut & Styling',
                'Description' => 'Professional haircut with personalized styling to suit your face shape and lifestyle.',
                'Price' => 65.00,
                'Visibility' => true,
            ],
            [
                'ServiceName' => 'Hair Coloring',
                'Description' => 'Premium hair coloring service with high-quality products for vibrant, long-lasting results.',
                'Price' => 120.00,
                'Visibility' => true,
            ],
            [
                'ServiceName' => 'Deep Conditioning Treatment',
                'Description' => 'Intensive hair treatment to restore moisture, shine, and strength to damaged hair.',
                'Price' => 45.00,
                'Visibility' => true,
            ],
            [
                'ServiceName' => 'Blow Dry & Style',
                'Description' => 'Professional blow dry service with styling for any occasion.',
                'Price' => 35.00,
                'Visibility' => true,
            ],
            [
                'ServiceName' => 'Highlights & Lowlights',
                'Description' => 'Expert highlighting techniques to add dimension and depth to your hair.',
                'Price' => 150.00,
                'Visibility' => true,
            ],
        ];

        foreach ($services as $service) {
            Service::create($service);
        }

        // Create Customers
        $customers = [
            [
                'CustomerName' => 'Emily Johnson',
                'Email' => 'emily.johnson@email.com',
                'Password' => Hash::make('password123'),
                'PhoneNumber' => '555-0101',
            ],
            [
                'CustomerName' => 'Michael Chen',
                'Email' => 'michael.chen@email.com',
                'Password' => Hash::make('password123'),
                'PhoneNumber' => '555-0102',
            ],
            [
                'CustomerName' => 'Sarah Williams',
                'Email' => 'sarah.williams@email.com',
                'Password' => Hash::make('password123'),
                'PhoneNumber' => '555-0103',
            ],
            [
                'CustomerName' => 'David Rodriguez',
                'Email' => 'david.rodriguez@email.com',
                'Password' => Hash::make('password123'),
                'PhoneNumber' => '555-0104',
            ],
            [
                'CustomerName' => 'Jessica Brown',
                'Email' => 'jessica.brown@email.com',
                'Password' => Hash::make('password123'),
                'PhoneNumber' => '555-0105',
            ],
        ];

        foreach ($customers as $customer) {
            Customer::create($customer);
        }

        // Create Admins
        $admins = [
            [
                'AdminName' => 'Admin User',
                'Email' => 'admin@luxehair.com',
                'Password' => Hash::make('admin123'),
                'Role' => 'admin',
                'ContactNumber' => '555-9001',
            ],
            [
                'AdminName' => 'Manager Sarah',
                'Email' => 'manager@luxehair.com',
                'Password' => Hash::make('manager123'),
                'Role' => 'manager',
                'ContactNumber' => '555-9002',
            ],
        ];

        foreach ($admins as $admin) {
            Admin::create($admin);
        }

        // Create Deals
        $deals = [
            [
                'DealName' => 'New Client Special',
                'Description' => 'First-time clients get 20% off any service!',
                'DiscountPercentage' => 20.00,
                'StartDate' => Carbon::now()->format('Y-m-d'),
                'EndDate' => Carbon::now()->addDays(60)->format('Y-m-d'),
                'IsActive' => true,
                'ServiceID' => 1, // Haircut & Styling
            ],
            [
                'DealName' => 'Color Package Deal',
                'Description' => 'Save 15% when you book coloring with highlights!',
                'DiscountPercentage' => 15.00,
                'StartDate' => Carbon::now()->format('Y-m-d'),
                'EndDate' => Carbon::now()->addDays(45)->format('Y-m-d'),
                'IsActive' => true,
                'ServiceID' => 2, // Hair Coloring
            ],
            [
                'DealName' => 'Treatment Tuesday',
                'Description' => 'Every Tuesday, get 25% off deep conditioning treatments!',
                'DiscountPercentage' => 25.00,
                'StartDate' => Carbon::now()->format('Y-m-d'),
                'EndDate' => Carbon::now()->addDays(90)->format('Y-m-d'),
                'IsActive' => true,
                'ServiceID' => 3, // Deep Conditioning Treatment
            ],
        ];

        foreach ($deals as $deal) {
            Deal::create($deal);
        }

        // Create some sample bookings (customer-service relationships)
        $customer1 = Customer::find(1);
        $customer2 = Customer::find(2);
        $customer3 = Customer::find(3);

        if ($customer1) {
            $customer1->services()->attach(1, [
                'BookedAt' => Carbon::now()->addDays(3)->format('Y-m-d H:i:s'),
                'Status' => 'booked'
            ]);
        }

        if ($customer2) {
            $customer2->services()->attach(2, [
                'BookedAt' => Carbon::now()->addDays(5)->format('Y-m-d H:i:s'),
                'Status' => 'booked'
            ]);
        }

        if ($customer3) {
            $customer3->services()->attach(1, [
                'BookedAt' => Carbon::now()->subDays(2)->format('Y-m-d H:i:s'),
                'Status' => 'completed'
            ]);
        }

        // Create admin relationship data
        $admin1 = Admin::find(1); // Super Admin
        $admin2 = Admin::find(2); // Manager

        if ($admin1) {
            // Super admin manages all customers, services, and deals
            $admin1->customers()->attach([1, 2, 3, 4, 5]);
            $admin1->services()->attach([1, 2, 3, 4, 5]);
            $admin1->deals()->attach([1, 2, 3]);
        }

        if ($admin2) {
            // Manager manages subset of customers, services, and deals
            $admin2->customers()->attach([1, 2, 3]);
            $admin2->services()->attach([1, 2, 3]);
            $admin2->deals()->attach([1, 2]);
        }
    }
}
