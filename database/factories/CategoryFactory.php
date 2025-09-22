<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    protected $model = Category::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $categories = [
            'Hair Services' => 'Professional hair cutting, styling, and coloring services',
            'Nail Services' => 'Manicure, pedicure, and nail art treatments',
            'Facial Treatments' => 'Skincare and facial beauty treatments',
            'Massage Therapy' => 'Relaxing and therapeutic massage services',
            'Wedding Services' => 'Special occasion hair and makeup',
            'Men\'s Grooming' => 'Specialized services for men',
            'Color Treatments' => 'Hair coloring and highlighting services',
            'Hair Treatments' => 'Deep conditioning and hair repair treatments',
        ];

        $categoryName = fake()->randomElement(array_keys($categories));
        
        return [
            'name' => $categoryName,
            'slug' => Str::slug($categoryName),
            'description' => $categories[$categoryName],
            'type' => fake()->randomElement(['service', 'product']),
            'is_active' => fake()->boolean(90),
            'sort_order' => fake()->numberBetween(1, 50),
        ];
    }

    /**
     * Indicate that the category is for services.
     */
    public function service(): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => 'service',
        ]);
    }

    /**
     * Indicate that the category is for products.
     */
    public function product(): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => 'product',
        ]);
    }
}