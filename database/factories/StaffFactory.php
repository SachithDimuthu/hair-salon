<?php

namespace Database\Factories;

use App\Models\Staff;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Staff>
 */
class StaffFactory extends Factory
{
    protected $model = Staff::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Valid positions according to the database enum
        $positions = ['stylist', 'colorist', 'manager', 'receptionist', 'assistant'];
        $specializations = [
            'Hair Cutting', 'Hair Coloring', 'Hair Styling', 'Highlights', 'Balayage', 
            'Keratin Treatments', 'Wedding Styling', 'Men\'s Cuts', 'Beard Trimming',
            'Extensions', 'Perms', 'Straightening'
        ];
        
        $firstName = fake()->firstName();
        $lastName = fake()->lastName();
        
        return [
            'user_id' => User::factory(),
            'employee_id' => 'EMP' . fake()->unique()->numberBetween(1000, 9999),
            'first_name' => $firstName,
            'last_name' => $lastName,
            'email' => fake()->unique()->safeEmail(),
            'phone' => fake()->phoneNumber(),
            'hire_date' => fake()->dateTimeBetween('-5 years', 'now')->format('Y-m-d'),
            'position' => fake()->randomElement($positions),
            'specializations' => fake()->randomElements($specializations, fake()->numberBetween(2, 5)),
            'hourly_rate' => fake()->randomFloat(2, 15, 50),
            'commission_rate' => fake()->randomFloat(2, 0.05, 0.30),
            'is_active' => fake()->boolean(95), // 95% active staff
            'bio' => fake()->optional(0.7)->paragraph(3),
            'profile_image' => fake()->optional(0.5)->imageUrl(400, 400, 'people'),
        ];
    }

    /**
     * Indicate that the staff member is a senior stylist.
     */
    public function senior(): static
    {
        return $this->state(fn (array $attributes) => [
            'position' => fake()->randomElement(['stylist', 'colorist', 'manager']),
            'hourly_rate' => fake()->randomFloat(2, 35, 75),
            'commission_rate' => fake()->randomFloat(2, 0.20, 0.40),
            'hire_date' => fake()->dateTimeBetween('-10 years', '-2 years')->format('Y-m-d'),
        ]);
    }

    /**
     * Indicate that the staff member is inactive.
     */
    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => false,
        ]);
    }

    /**
     * Indicate that the staff member is a manager.
     */
    public function manager(): static
    {
        return $this->state(fn (array $attributes) => [
            'position' => 'manager',
            'hourly_rate' => fake()->randomFloat(2, 40, 80),
            'commission_rate' => fake()->randomFloat(2, 0.15, 0.35),
            'specializations' => [
                'Team Management', 'Customer Service', 'Scheduling', 
                'Inventory Management', 'Staff Training'
            ],
        ]);
    }
}