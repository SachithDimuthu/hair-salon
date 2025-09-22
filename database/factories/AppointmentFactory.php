<?php

namespace Database\Factories;

use App\Models\Appointment;
use App\Models\Customer;
use App\Models\Staff;
use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Appointment>
 */
class AppointmentFactory extends Factory
{
    protected $model = Appointment::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $appointmentDate = fake()->dateTimeBetween('-2 months', '+2 months');
        $startHour = fake()->numberBetween(9, 17); // Business hours: 9 AM to 5 PM
        $startMinutes = fake()->randomElement([0, 15, 30, 45]); // 15-minute intervals
        $startTime = sprintf('%02d:%02d:00', $startHour, $startMinutes);
        
        // Duration between 30 minutes to 3 hours
        $durationMinutes = fake()->randomElement([30, 45, 60, 90, 120, 150, 180]);
        $endTime = Carbon::parse($startTime)->addMinutes($durationMinutes)->format('H:i:s');
        
        $totalAmount = fake()->randomFloat(2, 25, 300);
        $depositAmount = fake()->randomFloat(2, 0, $totalAmount * 0.5);
        
        return [
            'customer_id' => Customer::factory(),
            'staff_id' => Staff::factory(),
            'appointment_date' => $appointmentDate->format('Y-m-d'),
            'start_time' => $startTime,
            'end_time' => $endTime,
            'status' => fake()->randomElement(['scheduled', 'confirmed', 'completed', 'cancelled']),
            'total_amount' => $totalAmount,
            'deposit_amount' => $depositAmount,
            'payment_status' => fake()->randomElement(['pending', 'partial', 'paid', 'refunded']),
            'notes' => fake()->optional(0.4)->paragraph(1),
            'cancellation_reason' => null,
            'cancelled_at' => null,
        ];
    }

    /**
     * Indicate that the appointment is scheduled for the future.
     */
    public function upcoming(): static
    {
        return $this->state(fn (array $attributes) => [
            'appointment_date' => fake()->dateTimeBetween('now', '+2 months')->format('Y-m-d'),
            'status' => fake()->randomElement(['scheduled', 'confirmed']),
            'payment_status' => fake()->randomElement(['pending', 'partial']),
        ]);
    }

    /**
     * Indicate that the appointment is completed.
     */
    public function completed(): static
    {
        return $this->state(fn (array $attributes) => [
            'appointment_date' => fake()->dateTimeBetween('-2 months', '-1 day')->format('Y-m-d'),
            'status' => 'completed',
            'payment_status' => 'paid',
            'cancelled_at' => null,
        ]);
    }

    /**
     * Indicate that the appointment is cancelled.
     */
    public function cancelled(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'cancelled',
            'payment_status' => fake()->randomElement(['pending', 'refunded']),
            'cancellation_reason' => fake()->randomElement([
                'Customer request',
                'Staff unavailable',
                'Emergency',
                'Illness',
                'Weather conditions',
                'Double booking'
            ]),
            'cancelled_at' => fake()->dateTimeBetween('-1 month', 'now'),
        ]);
    }

    /**
     * Indicate that the appointment is for today.
     */
    public function today(): static
    {
        return $this->state(fn (array $attributes) => [
            'appointment_date' => now()->format('Y-m-d'),
            'status' => fake()->randomElement(['scheduled', 'confirmed', 'in_progress']),
        ]);
    }

    /**
     * Indicate that the appointment has a no-show status.
     */
    public function noShow(): static
    {
        return $this->state(fn (array $attributes) => [
            'appointment_date' => fake()->dateTimeBetween('-1 month', '-1 day')->format('Y-m-d'),
            'status' => 'no_show',
            'payment_status' => 'pending',
        ]);
    }
}