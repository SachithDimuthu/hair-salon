<?php

namespace Database\Factories;

use App\Models\Service;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Service>
 */
class ServiceFactory extends Factory
{
    protected $model = Service::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $services = [
            'Hair Cut & Style' => ['duration' => 60, 'price' => [40, 80]],
            'Hair Color (Full)' => ['duration' => 120, 'price' => [80, 150]],
            'Highlights' => ['duration' => 150, 'price' => [100, 200]],
            'Balayage' => ['duration' => 180, 'price' => [120, 250]],
            'Hair Wash & Blow Dry' => ['duration' => 45, 'price' => [30, 60]],
            'Deep Conditioning Treatment' => ['duration' => 30, 'price' => [25, 50]],
            'Keratin Treatment' => ['duration' => 240, 'price' => [200, 400]],
            'Hair Extensions' => ['duration' => 180, 'price' => [150, 350]],
            'Wedding Hair Styling' => ['duration' => 120, 'price' => [100, 200]],
            'Men\'s Cut & Style' => ['duration' => 45, 'price' => [25, 55]],
            'Beard Trim & Shape' => ['duration' => 30, 'price' => [20, 40]],
            'Eyebrow Shaping' => ['duration' => 20, 'price' => [15, 30]],
            'Facial Treatment' => ['duration' => 75, 'price' => [60, 120]],
            'Manicure' => ['duration' => 45, 'price' => [25, 50]],
            'Pedicure' => ['duration' => 60, 'price' => [35, 70]],
            'Gel Nail Polish' => ['duration' => 30, 'price' => [20, 40]],
            'Nail Art' => ['duration' => 45, 'price' => [30, 60]],
            'Makeup Application' => ['duration' => 60, 'price' => [50, 100]],
        ];

        $serviceName = fake()->randomElement(array_keys($services));
        $serviceData = $services[$serviceName];
        
        return [
            'category_id' => Category::factory(),
            'name' => $serviceName,
            'slug' => Str::slug($serviceName),
            'description' => fake()->paragraph(2),
            'duration_minutes' => $serviceData['duration'],
            'base_price' => fake()->randomFloat(2, $serviceData['price'][0], $serviceData['price'][1]),
            'is_active' => fake()->boolean(90), // 90% active services
            'requires_consultation' => fake()->boolean(20), // 20% require consultation
            'image' => fake()->optional(0.6)->imageUrl(400, 300, 'fashion'),
            'sort_order' => fake()->numberBetween(1, 100),
        ];
    }

    /**
     * Indicate that the service is premium/expensive.
     */
    public function premium(): static
    {
        return $this->state(fn (array $attributes) => [
            'base_price' => fake()->randomFloat(2, 150, 500),
            'duration_minutes' => fake()->numberBetween(120, 300),
            'requires_consultation' => true,
        ]);
    }

    /**
     * Indicate that the service is inactive.
     */
    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => false,
        ]);
    }

    /**
     * Indicate that the service is quick/basic.
     */
    public function quick(): static
    {
        return $this->state(fn (array $attributes) => [
            'duration_minutes' => fake()->numberBetween(15, 45),
            'base_price' => fake()->randomFloat(2, 15, 60),
            'requires_consultation' => false,
        ]);
    }
}