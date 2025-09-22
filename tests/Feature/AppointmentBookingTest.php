<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Customer;
use App\Models\Staff;
use App\Models\Service;
use App\Models\Appointment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AppointmentBookingTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function customers_can_view_booking_page()
    {
        /** @var User $customerUser */
        $customerUser = User::factory()->create(['role' => 'customer']);
        $customer = Customer::factory()->create(['user_id' => $customerUser->id]);

        $response = $this->actingAs($customerUser)->get('/appointments/book');

        $response->assertStatus(200);
    }

    /** @test */
    public function customers_can_book_appointments()
    {
        /** @var User $customerUser */
        $customerUser = User::factory()->create(['role' => 'customer']);
        $customer = Customer::factory()->create(['user_id' => $customerUser->id]);
        $staff = Staff::factory()->create();
        $service = Service::factory()->create();

        $appointmentData = [
            'staff_id' => $staff->id,
            'service_id' => $service->id,
            'appointment_date' => now()->addDays(7)->format('Y-m-d'),
            'start_time' => '10:00',
            'notes' => 'First time appointment',
        ];

        $response = $this->actingAs($customerUser)
            ->post('/appointments', $appointmentData);

        $response->assertRedirect();
        $this->assertDatabaseHas('appointments', [
            'customer_id' => $customer->id,
            'staff_id' => $staff->id,
            'appointment_date' => $appointmentData['appointment_date'],
            'start_time' => $appointmentData['start_time'] . ':00',
            'status' => 'scheduled',
        ]);
    }

    /** @test */
    public function appointments_require_valid_data()
    {
        /** @var User $customerUser */
        $customerUser = User::factory()->create(['role' => 'customer']);
        $customer = Customer::factory()->create(['user_id' => $customerUser->id]);

        $response = $this->actingAs($customerUser)
            ->post('/appointments', [
                'staff_id' => 999, // Non-existent staff
                'service_id' => 999, // Non-existent service
                'appointment_date' => 'invalid-date',
                'start_time' => 'invalid-time',
            ]);

        $response->assertSessionHasErrors(['staff_id', 'service_id', 'appointment_date', 'start_time']);
    }

    /** @test */
    public function customers_cannot_book_past_appointments()
    {
        /** @var User $customerUser */
        $customerUser = User::factory()->create(['role' => 'customer']);
        $customer = Customer::factory()->create(['user_id' => $customerUser->id]);
        $staff = Staff::factory()->create();
        $service = Service::factory()->create();

        $appointmentData = [
            'staff_id' => $staff->id,
            'service_id' => $service->id,
            'appointment_date' => now()->subDays(1)->format('Y-m-d'), // Past date
            'start_time' => '10:00',
        ];

        $response = $this->actingAs($customerUser)
            ->post('/appointments', $appointmentData);

        $response->assertSessionHasErrors(['appointment_date']);
    }

    /** @test */
    public function customers_can_view_their_appointments()
    {
        /** @var User $customerUser */
        $customerUser = User::factory()->create(['role' => 'customer']);
        $customer = Customer::factory()->create(['user_id' => $customerUser->id]);
        
        // Create appointments for this customer
        Appointment::factory()->count(3)->create(['customer_id' => $customer->id]);
        
        // Create appointments for other customers
        Appointment::factory()->count(2)->create();

        $response = $this->actingAs($customerUser)->get('/appointments');

        $response->assertStatus(200);
        // Should only see their own appointments (3)
        $response->assertViewHas('appointments', function ($appointments) {
            return $appointments->count() === 3;
        });
    }

    /** @test */
    public function customers_can_cancel_their_upcoming_appointments()
    {
        /** @var User $customerUser */
        $customerUser = User::factory()->create(['role' => 'customer']);
        $customer = Customer::factory()->create(['user_id' => $customerUser->id]);
        
        $appointment = Appointment::factory()->create([
            'customer_id' => $customer->id,
            'appointment_date' => now()->addDays(5)->format('Y-m-d'),
            'status' => 'scheduled',
        ]);

        $response = $this->actingAs($customerUser)
            ->patch("/appointments/{$appointment->id}/cancel", [
                'cancellation_reason' => 'Schedule conflict'
            ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('appointments', [
            'id' => $appointment->id,
            'status' => 'cancelled',
            'cancellation_reason' => 'Schedule conflict',
        ]);
    }

    /** @test */
    public function customers_cannot_cancel_past_appointments()
    {
        /** @var User $customerUser */
        $customerUser = User::factory()->create(['role' => 'customer']);
        $customer = Customer::factory()->create(['user_id' => $customerUser->id]);
        
        $appointment = Appointment::factory()->create([
            'customer_id' => $customer->id,
            'appointment_date' => now()->subDays(1)->format('Y-m-d'),
            'status' => 'completed',
        ]);

        $response = $this->actingAs($customerUser)
            ->patch("/appointments/{$appointment->id}/cancel");

        $response->assertStatus(403);
    }

    /** @test */
    public function staff_can_view_their_appointments()
    {
        /** @var User $staffUser */
        $staffUser = User::factory()->create(['role' => 'staff']);
        $staff = Staff::factory()->create(['user_id' => $staffUser->id]);
        
        // Create appointments for this staff member
        Appointment::factory()->count(4)->create(['staff_id' => $staff->id]);
        
        // Create appointments for other staff
        Appointment::factory()->count(2)->create();

        $response = $this->actingAs($staffUser)->get('/staff/appointments');

        $response->assertStatus(200);
        // Should only see their own appointments (4)
        $response->assertViewHas('appointments', function ($appointments) {
            return $appointments->count() === 4;
        });
    }

    /** @test */
    public function staff_can_update_appointment_status()
    {
        /** @var User $staffUser */
        $staffUser = User::factory()->create(['role' => 'staff']);
        $staff = Staff::factory()->create(['user_id' => $staffUser->id]);
        
        $appointment = Appointment::factory()->create([
            'staff_id' => $staff->id,
            'status' => 'scheduled',
        ]);

        $response = $this->actingAs($staffUser)
            ->patch("/staff/appointments/{$appointment->id}", [
                'status' => 'completed'
            ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('appointments', [
            'id' => $appointment->id,
            'status' => 'completed',
        ]);
    }

    /** @test */
    public function guests_cannot_access_booking_features()
    {
        $response = $this->get('/appointments/book');
        $response->assertRedirect('/login');

        $response = $this->post('/appointments', []);
        $response->assertRedirect('/login');

        $response = $this->get('/appointments');
        $response->assertRedirect('/login');
    }
}