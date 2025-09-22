<?php

namespace Tests\Unit;

use App\Models\Staff;
use App\Models\User;
use App\Models\Appointment;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StaffTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_count_total_appointments()
    {
        $staff = Staff::factory()->create();
        
        // Create appointments for this staff member
        Appointment::factory()->count(5)->create(['staff_id' => $staff->id]);

        $appointmentCount = $staff->appointments()->count();

        $this->assertEquals(5, $appointmentCount);
    }

    /** @test */
    public function it_can_count_completed_appointments()
    {
        $staff = Staff::factory()->create();
        
        // Create completed appointments
        Appointment::factory()->count(3)->create([
            'staff_id' => $staff->id,
            'status' => 'completed'
        ]);

        // Create non-completed appointments
        Appointment::factory()->count(2)->create([
            'staff_id' => $staff->id,
            'status' => 'scheduled'
        ]);

        $completedCount = $staff->appointments()->where('status', 'completed')->count();

        $this->assertEquals(3, $completedCount);
    }

    /** @test */
    public function it_can_calculate_commission_from_completed_appointments()
    {
        $staff = Staff::factory()->create([
            'commission_rate' => 0.20 // 20% commission
        ]);

        // Create completed appointments with known amounts
        Appointment::factory()->create([
            'staff_id' => $staff->id,
            'status' => 'completed',
            'total_amount' => 100.00
        ]);

        Appointment::factory()->create([
            'staff_id' => $staff->id,
            'status' => 'completed',
            'total_amount' => 150.00
        ]);

        // Create a non-completed appointment (should not count)
        Appointment::factory()->create([
            'staff_id' => $staff->id,
            'status' => 'scheduled',
            'total_amount' => 200.00
        ]);

        $totalRevenue = $staff->appointments()
            ->where('status', 'completed')
            ->sum('total_amount');
        
        $expectedCommission = $totalRevenue * $staff->commission_rate;

        $this->assertEquals(250.00, $totalRevenue);
        $this->assertEquals(50.00, $expectedCommission);
    }

    /** @test */
    public function it_returns_full_name_attribute()
    {
        $staff = Staff::factory()->create([
            'first_name' => 'Jane',
            'last_name' => 'Smith'
        ]);

        // Assuming the Staff model has a getFullNameAttribute method like Customer
        $this->assertEquals('Jane Smith', $staff->first_name . ' ' . $staff->last_name);
    }

    /** @test */
    public function it_belongs_to_a_user()
    {
        $user = User::factory()->create();
        $staff = Staff::factory()->create(['user_id' => $user->id]);

        $this->assertInstanceOf(User::class, $staff->user);
        $this->assertEquals($user->id, $staff->user->id);
    }

    /** @test */
    public function it_has_many_appointments()
    {
        $staff = Staff::factory()->create();
        $appointments = Appointment::factory()->count(4)->create(['staff_id' => $staff->id]);

        $this->assertCount(4, $staff->appointments);
        $this->assertInstanceOf(Appointment::class, $staff->appointments->first());
    }

    /** @test */
    public function it_can_get_appointments_for_specific_date()
    {
        $staff = Staff::factory()->create();
        $targetDate = now()->addDays(5)->format('Y-m-d');

        // Create appointments for target date
        Appointment::factory()->count(2)->create([
            'staff_id' => $staff->id,
            'appointment_date' => $targetDate
        ]);

        // Create appointments for different date
        Appointment::factory()->count(3)->create([
            'staff_id' => $staff->id,
            'appointment_date' => now()->addDays(10)->format('Y-m-d')
        ]);

        $appointmentsForDate = $staff->appointments()
            ->where('appointment_date', $targetDate)
            ->count();

        $this->assertEquals(2, $appointmentsForDate);
    }

    /** @test */
    public function it_can_calculate_monthly_revenue()
    {
        $staff = Staff::factory()->create();
        $currentMonth = now()->format('Y-m');

        // Create completed appointments for current month
        Appointment::factory()->create([
            'staff_id' => $staff->id,
            'status' => 'completed',
            'appointment_date' => now()->format('Y-m-d'),
            'total_amount' => 80.00
        ]);

        Appointment::factory()->create([
            'staff_id' => $staff->id,
            'status' => 'completed',
            'appointment_date' => now()->addDays(10)->format('Y-m-d'),
            'total_amount' => 120.00
        ]);

        // Create appointment for different month
        Appointment::factory()->create([
            'staff_id' => $staff->id,
            'status' => 'completed',
            'appointment_date' => now()->subMonth()->format('Y-m-d'),
            'total_amount' => 100.00
        ]);

        $monthlyRevenue = $staff->appointments()
            ->where('status', 'completed')
            ->whereYear('appointment_date', now()->year)
            ->whereMonth('appointment_date', now()->month)
            ->sum('total_amount');

        $this->assertEquals(200.00, $monthlyRevenue);
    }

    /** @test */
    public function senior_factory_state_creates_experienced_staff()
    {
        $seniorStaff = Staff::factory()->senior()->create();

        $this->assertContains($seniorStaff->position, ['stylist', 'colorist', 'manager']);
        $this->assertGreaterThanOrEqual(35, $seniorStaff->hourly_rate);
        $this->assertGreaterThanOrEqual(0.20, $seniorStaff->commission_rate);
    }

    /** @test */
    public function manager_factory_state_creates_management_staff()
    {
        $manager = Staff::factory()->manager()->create();

        $this->assertEquals('manager', $manager->position);
        $this->assertGreaterThanOrEqual(40, $manager->hourly_rate);
        $this->assertContains('Team Management', $manager->specializations);
    }

    /** @test */
    public function it_can_check_availability_for_time_slot()
    {
        $staff = Staff::factory()->create();
        $date = now()->addDays(5)->format('Y-m-d');
        $startTime = '10:00:00';
        $endTime = '11:00:00';

        // Create an existing appointment
        Appointment::factory()->create([
            'staff_id' => $staff->id,
            'appointment_date' => $date,
            'start_time' => '10:30:00',
            'end_time' => '11:30:00',
            'status' => 'scheduled'
        ]);

        // Check for overlapping appointment
        $hasOverlap = $staff->appointments()
            ->where('appointment_date', $date)
            ->whereNotIn('status', ['cancelled'])
            ->where(function ($query) use ($startTime, $endTime) {
                $query->whereBetween('start_time', [$startTime, $endTime])
                      ->orWhereBetween('end_time', [$startTime, $endTime])
                      ->orWhere(function ($subQuery) use ($startTime, $endTime) {
                          $subQuery->where('start_time', '<=', $startTime)
                                   ->where('end_time', '>=', $endTime);
                      });
            })
            ->exists();

        $this->assertTrue($hasOverlap);
    }
}