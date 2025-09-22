<?php

namespace Database\Factories;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Customer>
 */
class CustomerFactory extends Factory
{
    protected $model = Customer::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $gender = fake()->randomElement(['male', 'female', 'other']);
        $firstName = fake()->firstName($gender === 'other' ? null : $gender);
        $lastName = fake()->lastName();
        
        return [
            'user_id' => User::factory(),
            'first_name' => $firstName,
            'last_name' => $lastName,
            'email' => fake()->unique()->safeEmail(),
            'phone' => fake()->phoneNumber(),
            'date_of_birth' => fake()->dateTimeBetween('-70 years', '-18 years')->format('Y-m-d'),
            'gender' => $gender,
            'address' => fake()->streetAddress(),
            'city' => fake()->city(),
            'postal_code' => fake()->postcode(),
            'emergency_contact_name' => fake()->name(),
            'emergency_contact_phone' => fake()->phoneNumber(),
            'notes' => fake()->optional(0.3)->paragraph(2),
            'is_active' => fake()->boolean(90), // 90% active customers
            'last_visit_at' => fake()->optional(0.8)->dateTimeBetween('-6 months', 'now'),
            'total_visits' => fake()->numberBetween(0, 50),
            'total_spent' => fake()->randomFloat(2, 0, 5000),
        ];
    }

    /**
     * Indicate that the customer is a VIP (spent > $1000).
     */
    public function vip(): static
    {
        return $this->state(fn (array $attributes) => [
            'total_spent' => fake()->randomFloat(2, 1000, 10000),
            'total_visits' => fake()->numberBetween(10, 100),
        ]);
    }

    /**
     * Indicate that the customer is inactive.
     */
    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => false,
        ]);
    }

    /**
     * Indicate that the customer is a new customer with no visits.
     */
    public function newCustomer(): static
    {
        return $this->state(fn (array $attributes) => [
            'last_visit_at' => null,
            'total_visits' => 0,
            'total_spent' => 0,
        ]);
    }
}