<?php

namespace Tests\Unit;

use App\Models\Appointment;
use App\Models\Customer;
use App\Models\Staff;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Carbon\Carbon;

class AppointmentTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_detect_overlapping_appointments()
    {
        $staff = Staff::factory()->create();
        $date = now()->addDays(5)->format('Y-m-d');

        // Create an existing appointment
        $existingAppointment = Appointment::factory()->create([
            'staff_id' => $staff->id,
            'appointment_date' => $date,
            'start_time' => '10:00:00',
            'end_time' => '11:00:00',
            'status' => 'scheduled'
        ]);

        // Create a new appointment to test overlap detection
        $newAppointment = new Appointment();

        // Test overlapping cases
        $this->assertTrue($newAppointment->isOverlapping($date, '09:30:00', '10:30:00', $staff->id));
        $this->assertTrue($newAppointment->isOverlapping($date, '10:30:00', '11:30:00', $staff->id));
        $this->assertTrue($newAppointment->isOverlapping($date, '09:30:00', '11:30:00', $staff->id));
        $this->assertTrue($newAppointment->isOverlapping($date, '10:15:00', '10:45:00', $staff->id));

        // Test non-overlapping cases
        $this->assertFalse($newAppointment->isOverlapping($date, '08:00:00', '09:00:00', $staff->id));
        $this->assertFalse($newAppointment->isOverlapping($date, '12:00:00', '13:00:00', $staff->id));
    }

    /** @test */
    public function it_ignores_cancelled_appointments_when_checking_overlaps()
    {
        $staff = Staff::factory()->create();
        $date = now()->addDays(5)->format('Y-m-d');

        // Create a cancelled appointment
        $cancelledAppointment = Appointment::factory()->create([
            'staff_id' => $staff->id,
            'appointment_date' => $date,
            'start_time' => '10:00:00',
            'end_time' => '11:00:00',
            'status' => 'cancelled'
        ]);

        // Should not detect overlap with cancelled appointment
        $this->assertFalse($cancelledAppointment->isOverlapping($date, '10:30:00', '11:30:00', $staff->id));
    }

    /** @test */
    public function it_can_calculate_appointment_duration()
    {
        $appointment = Appointment::factory()->create([
            'start_time' => '10:00:00',
            'end_time' => '11:30:00'
        ]);

        $duration = $appointment->calculateDuration();

        $this->assertEquals(90, $duration); // 90 minutes
    }

    /** @test */
    public function it_can_update_status_properly()
    {
        $appointment = Appointment::factory()->create(['status' => 'scheduled']);

        $appointment->update(['status' => 'completed']);

        $this->assertEquals('completed', $appointment->fresh()->status);
    }

    /** @test */
    public function it_belongs_to_customer_and_staff()
    {
        $customer = Customer::factory()->create();
        $staff = Staff::factory()->create();
        
        $appointment = Appointment::factory()->create([
            'customer_id' => $customer->id,
            'staff_id' => $staff->id
        ]);

        $this->assertInstanceOf(Customer::class, $appointment->customer);
        $this->assertInstanceOf(Staff::class, $appointment->staff);
        $this->assertEquals($customer->id, $appointment->customer->id);
        $this->assertEquals($staff->id, $appointment->staff->id);
    }

    /** @test */
    public function it_scopes_upcoming_appointments()
    {
        // Create upcoming appointments
        Appointment::factory()->count(3)->create([
            'appointment_date' => now()->addDays(5)->format('Y-m-d'),
            'status' => 'scheduled'
        ]);

        // Create past appointments
        Appointment::factory()->count(2)->create([
            'appointment_date' => now()->subDays(5)->format('Y-m-d'),
            'status' => 'completed'
        ]);

        // Create cancelled upcoming appointments (should not be included)
        Appointment::factory()->count(1)->create([
            'appointment_date' => now()->addDays(3)->format('Y-m-d'),
            'status' => 'cancelled'
        ]);

        $upcomingAppointments = Appointment::upcoming()->get();

        $this->assertCount(3, $upcomingAppointments);
    }

    /** @test */
    public function it_scopes_completed_appointments()
    {
        Appointment::factory()->count(4)->create(['status' => 'completed']);
        Appointment::factory()->count(2)->create(['status' => 'scheduled']);
        Appointment::factory()->count(1)->create(['status' => 'cancelled']);

        $completedAppointments = Appointment::completed()->get();

        $this->assertCount(4, $completedAppointments);
        $this->assertTrue($completedAppointments->every(fn($apt) => $apt->status === 'completed'));
    }

    /** @test */
    public function it_scopes_todays_appointments()
    {
        // Create today's appointments
        Appointment::factory()->count(3)->create([
            'appointment_date' => now()->format('Y-m-d')
        ]);

        // Create appointments for other days
        Appointment::factory()->count(2)->create([
            'appointment_date' => now()->addDays(1)->format('Y-m-d')
        ]);

        $todaysAppointments = Appointment::today()->get();

        $this->assertCount(3, $todaysAppointments);
    }

    /** @test */
    public function it_handles_cancellation_properly()
    {
        $appointment = Appointment::factory()->create([
            'status' => 'scheduled',
            'cancellation_reason' => null,
            'cancelled_at' => null
        ]);

        $cancellationReason = 'Customer request';
        $appointment->update([
            'status' => 'cancelled',
            'cancellation_reason' => $cancellationReason,
            'cancelled_at' => now()
        ]);

        $freshAppointment = $appointment->fresh();
        $this->assertEquals('cancelled', $freshAppointment->status);
        $this->assertEquals($cancellationReason, $freshAppointment->cancellation_reason);
        $this->assertNotNull($freshAppointment->cancelled_at);
    }

    /** @test */
    public function upcoming_factory_state_creates_future_appointment()
    {
        $upcomingAppointment = Appointment::factory()->upcoming()->create();

        $this->assertGreaterThanOrEqual(now()->format('Y-m-d'), $upcomingAppointment->appointment_date);
        $this->assertContains($upcomingAppointment->status, ['scheduled', 'confirmed']);
        $this->assertContains($upcomingAppointment->payment_status, ['pending', 'partial']);
    }

    /** @test */
    public function completed_factory_state_creates_past_completed_appointment()
    {
        $completedAppointment = Appointment::factory()->completed()->create();

        $this->assertLessThan(now()->format('Y-m-d'), $completedAppointment->appointment_date);
        $this->assertEquals('completed', $completedAppointment->status);
        $this->assertEquals('paid', $completedAppointment->payment_status);
    }

    /** @test */
    public function cancelled_factory_state_creates_cancelled_appointment()
    {
        $cancelledAppointment = Appointment::factory()->cancelled()->create();

        $this->assertEquals('cancelled', $cancelledAppointment->status);
        $this->assertNotNull($cancelledAppointment->cancellation_reason);
        $this->assertNotNull($cancelledAppointment->cancelled_at);
    }

    /** @test */
    public function it_prevents_double_booking_same_staff()
    {
        $staff = Staff::factory()->create();
        $date = now()->addDays(5)->format('Y-m-d');

        // Create first appointment
        Appointment::factory()->create([
            'staff_id' => $staff->id,
            'appointment_date' => $date,
            'start_time' => '10:00:00',
            'end_time' => '11:00:00',
            'status' => 'scheduled'
        ]);

        // Try to create overlapping appointment
        $overlappingAppointment = new Appointment([
            'staff_id' => $staff->id,
            'appointment_date' => $date,
            'start_time' => '10:30:00',
            'end_time' => '11:30:00'
        ]);

        $hasOverlap = $overlappingAppointment->isOverlapping($date, '10:30:00', '11:30:00', $staff->id);

        $this->assertTrue($hasOverlap);
    }
}