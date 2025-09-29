<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Clear existing services for a fresh start
        Service::truncate();

        // Sample services as requested
        $services = [
            [
                'name' => 'Deluxe Haircut',
                'slug' => 'deluxe-haircut',
                'category' => 'haircut',
                'description' => 'Premium haircut service with wash, cut, style, and finishing touches. Includes consultation and styling advice.',
                'base_price' => 85.00,
                'durations' => [
                    [
                        'variant' => 'Short Hair',
                        'minutes' => 45,
                        'price' => 75.00
                    ],
                    [
                        'variant' => 'Medium Hair',
                        'minutes' => 60,
                        'price' => 85.00
                    ],
                    [
                        'variant' => 'Long Hair',
                        'minutes' => 75,
                        'price' => 95.00
                    ]
                ],
                'tags' => ['premium', 'consultation', 'styling', 'wash-included'],
                'active' => true,
                'staff_ids' => ['staff_001', 'staff_002', 'staff_003'],
                'addon_ids' => ['addon_deep_condition', 'addon_scalp_massage'],
                'visibility' => 'public',
                'rating' => 4.8,
                'booking_constraints' => [
                    'min_notice_minutes' => 120, // 2 hours minimum notice
                    'max_future_days' => 30 // Can book up to 30 days in advance
                ]
            ],
            [
                'name' => 'Keratin Treatment',
                'slug' => 'keratin-treatment',
                'category' => 'treatment',
                'description' => 'Professional keratin smoothing treatment to reduce frizz and add shine. Long-lasting results for up to 4 months.',
                'base_price' => 280.00,
                'durations' => [
                    [
                        'variant' => 'Express Keratin (Short Hair)',
                        'minutes' => 120,
                        'price' => 250.00
                    ],
                    [
                        'variant' => 'Full Keratin (Medium Hair)',
                        'minutes' => 180,
                        'price' => 280.00
                    ],
                    [
                        'variant' => 'Full Keratin (Long Hair)',
                        'minutes' => 240,
                        'price' => 320.00
                    ]
                ],
                'tags' => ['treatment', 'anti-frizz', 'smoothing', 'long-lasting', 'professional'],
                'active' => true,
                'staff_ids' => ['staff_001', 'staff_004'], // Only certain staff can perform
                'addon_ids' => ['addon_blowdry', 'addon_styling'],
                'visibility' => 'public',
                'rating' => 4.9,
                'booking_constraints' => [
                    'min_notice_minutes' => 1440, // 24 hours minimum notice
                    'max_future_days' => 45 // Can book up to 45 days in advance
                ]
            ],
            [
                'name' => 'Basic Trim',
                'slug' => 'basic-trim',
                'category' => 'haircut',
                'description' => 'Simple trim service to maintain your current style. Quick and affordable.',
                'base_price' => 35.00,
                'durations' => [
                    [
                        'variant' => 'Basic Trim',
                        'minutes' => 30,
                        'price' => 35.00
                    ]
                ],
                'tags' => ['basic', 'trim', 'maintenance', 'quick'],
                'active' => true,
                'staff_ids' => ['staff_001', 'staff_002', 'staff_003', 'staff_005'],
                'addon_ids' => ['addon_wash', 'addon_blowdry'],
                'visibility' => 'public',
                'rating' => 4.5,
                'booking_constraints' => [
                    'min_notice_minutes' => 60, // 1 hour minimum notice
                    'max_future_days' => 14 // Can book up to 2 weeks in advance
                ]
            ],
            [
                'name' => 'Deep Conditioning Treatment',
                'slug' => 'deep-conditioning-treatment',
                'category' => 'treatment',
                'description' => 'Intensive moisturizing treatment for damaged or dry hair. Restores health and shine.',
                'base_price' => 65.00,
                'durations' => [
                    [
                        'variant' => 'Standard Treatment',
                        'minutes' => 45,
                        'price' => 65.00
                    ],
                    [
                        'variant' => 'Intensive Treatment',
                        'minutes' => 60,
                        'price' => 80.00
                    ]
                ],
                'tags' => ['treatment', 'conditioning', 'moisturizing', 'repair'],
                'active' => true,
                'staff_ids' => ['staff_001', 'staff_002', 'staff_004'],
                'addon_ids' => ['addon_scalp_massage', 'addon_styling'],
                'visibility' => 'public',
                'rating' => 4.6,
                'booking_constraints' => [
                    'min_notice_minutes' => 90, // 1.5 hours minimum notice
                    'max_future_days' => 21 // Can book up to 3 weeks in advance
                ]
            ],
            [
                'name' => 'Consultation Service',
                'slug' => 'consultation-service',
                'category' => 'consultation',
                'description' => 'Professional hair consultation to discuss styling options, color choices, and treatment recommendations.',
                'base_price' => 25.00,
                'durations' => [
                    [
                        'variant' => 'Basic Consultation',
                        'minutes' => 20,
                        'price' => 25.00
                    ],
                    [
                        'variant' => 'Extended Consultation',
                        'minutes' => 40,
                        'price' => 45.00
                    ]
                ],
                'tags' => ['consultation', 'advice', 'planning'],
                'active' => true,
                'staff_ids' => ['staff_001', 'staff_002'], // Senior staff only
                'addon_ids' => [],
                'visibility' => 'public',
                'rating' => 4.7,
                'booking_constraints' => [
                    'min_notice_minutes' => 120, // 2 hours minimum notice
                    'max_future_days' => 7 // Can book up to 1 week in advance
                ]
            ],
            [
                'name' => 'Staff Training Service',
                'slug' => 'staff-training-service',
                'category' => 'internal',
                'description' => 'Internal service for staff training and skill development sessions.',
                'base_price' => 0.00,
                'durations' => [
                    [
                        'variant' => 'Training Session',
                        'minutes' => 120,
                        'price' => 0.00
                    ]
                ],
                'tags' => ['training', 'internal', 'development'],
                'active' => true,
                'staff_ids' => ['staff_001'],
                'addon_ids' => [],
                'visibility' => 'internal', // Not visible to public
                'rating' => 5.0,
                'booking_constraints' => [
                    'min_notice_minutes' => 2880, // 48 hours minimum notice
                    'max_future_days' => 90 // Can book up to 3 months in advance
                ]
            ]
        ];

        foreach ($services as $service) {
            Service::create($service);
        }

        $this->command->info('Service seeder completed successfully!');
        $this->command->info('Created ' . count($services) . ' services including:');
        $this->command->info('- Deluxe Haircut (Premium service with multiple variants)');
        $this->command->info('- Keratin Treatment (Professional smoothing treatment)');
        $this->command->info('- Basic Trim (Quick maintenance service)');
        $this->command->info('- Deep Conditioning Treatment (Hair repair service)');
        $this->command->info('- Consultation Service (Professional advice)');
        $this->command->info('- Staff Training Service (Internal service)');
    }
}