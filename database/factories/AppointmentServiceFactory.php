<?php

namespace Database\Factories;

use App\Models\AppointmentService;
use App\Models\Appointment;
use App\Models\Service;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AppointmentService>
 */
class AppointmentServiceFactory extends Factory
{
    protected $model = AppointmentService::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'appointment_id' => Appointment::factory(),
            'service_id' => Service::factory(),
            'price' => fake()->randomFloat(2, 20, 300),
            'quantity' => fake()->numberBetween(1, 3),
            'notes' => fake()->optional(0.3)->sentence(),
        ];
    }
}