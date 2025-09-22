<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    protected $model = Order::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $subtotal = fake()->randomFloat(2, 50, 500);
        $taxAmount = $subtotal * 0.1; // 10% tax
        $discountAmount = fake()->boolean(30) ? fake()->randomFloat(2, 5, 50) : 0;
        $totalAmount = $subtotal + $taxAmount - $discountAmount;

        return [
            'customer_id' => Customer::factory(),
            'staff_id' => null, // Staff can be nullable according to migration
            'order_number' => 'ORD-' . fake()->unique()->numberBetween(10000, 99999),
            'subtotal' => $subtotal,
            'tax_amount' => $taxAmount,
            'discount_amount' => $discountAmount,
            'total_amount' => $totalAmount,
            'payment_method' => fake()->randomElement(['cash', 'card', 'online', 'gift_card']),
            'payment_status' => fake()->randomElement(['pending', 'paid', 'refunded', 'cancelled']),
            'status' => fake()->randomElement(['pending', 'processing', 'completed', 'cancelled']),
            'notes' => fake()->optional(0.3)->sentence(),
        ];
    }

    /**
     * Indicate that the order is completed.
     */
    public function completed(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'completed',
            'payment_status' => 'paid',
        ]);
    }
}