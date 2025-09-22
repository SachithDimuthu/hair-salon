<?php

namespace Tests\Unit;

use App\Models\Customer;
use App\Models\User;
use App\Models\Appointment;
use App\Models\Order;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CustomerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_calculate_loyalty_points_based_on_total_spent()
    {
        $customer = Customer::factory()->create([
            'total_spent' => 500.00
        ]);

        // Assuming loyalty points = total_spent / 10
        $expectedPoints = 50;
        $this->assertEquals($expectedPoints, floor($customer->total_spent / 10));
    }

    /** @test */
    public function it_identifies_vip_customers_with_over_1000_spent()
    {
        $vipCustomer = Customer::factory()->create([
            'total_spent' => 1500.00
        ]);

        $regularCustomer = Customer::factory()->create([
            'total_spent' => 500.00
        ]);

        $this->assertTrue($vipCustomer->total_spent > 1000);
        $this->assertFalse($regularCustomer->total_spent > 1000);
    }

    /** @test */
    public function it_returns_full_name_attribute()
    {
        $customer = Customer::factory()->create([
            'first_name' => 'John',
            'last_name' => 'Doe'
        ]);

        $this->assertEquals('John Doe', $customer->full_name);
    }

    /** @test */
    public function it_can_check_if_customer_has_upcoming_appointments()
    {
        $customer = Customer::factory()->create();
        
        // Create an upcoming appointment
        Appointment::factory()->create([
            'customer_id' => $customer->id,
            'appointment_date' => now()->addDays(5)->format('Y-m-d'),
            'status' => 'scheduled'
        ]);

        $this->assertTrue($customer->hasUpcomingAppointments());
    }

    /** @test */
    public function it_returns_false_when_no_upcoming_appointments()
    {
        $customer = Customer::factory()->create();
        
        // Create a past appointment
        Appointment::factory()->create([
            'customer_id' => $customer->id,
            'appointment_date' => now()->subDays(5)->format('Y-m-d'),
            'status' => 'completed'
        ]);

        $this->assertFalse($customer->hasUpcomingAppointments());
    }

    /** @test */
    public function it_scopes_active_customers()
    {
        Customer::factory()->count(3)->create(['is_active' => true]);
        Customer::factory()->count(2)->create(['is_active' => false]);

        $activeCustomers = Customer::active()->get();

        $this->assertCount(3, $activeCustomers);
        $this->assertTrue($activeCustomers->every(fn($customer) => $customer->is_active));
    }

    /** @test */
    public function it_can_update_visit_statistics()
    {
        $customer = Customer::factory()->create([
            'total_visits' => 0,
            'total_spent' => 0,
            'last_visit_at' => null
        ]);

        // Create completed appointments
        $appointment1 = Appointment::factory()->create([
            'customer_id' => $customer->id,
            'status' => 'completed',
            'appointment_date' => now()->subDays(10)->format('Y-m-d')
        ]);

        $appointment2 = Appointment::factory()->create([
            'customer_id' => $customer->id,
            'status' => 'completed',
            'appointment_date' => now()->subDays(5)->format('Y-m-d')
        ]);

        // Create completed orders
        Order::factory()->create([
            'customer_id' => $customer->id,
            'status' => 'completed',
            'total_amount' => 100.00
        ]);

        Order::factory()->create([
            'customer_id' => $customer->id,
            'status' => 'completed',
            'total_amount' => 150.00
        ]);

        $customer->updateVisitStats();
        $customer = $customer->fresh();

        $this->assertEquals(2, $customer->total_visits);
        $this->assertEquals(250.00, $customer->total_spent);
        $this->assertEquals($appointment2->appointment_date, $customer->last_visit_at);
    }

    /** @test */
    public function it_belongs_to_a_user()
    {
        $user = User::factory()->create();
        $customer = Customer::factory()->create(['user_id' => $user->id]);

        $this->assertInstanceOf(User::class, $customer->user);
        $this->assertEquals($user->id, $customer->user->id);
    }

    /** @test */
    public function it_has_many_appointments()
    {
        $customer = Customer::factory()->create();
        $appointments = Appointment::factory()->count(3)->create(['customer_id' => $customer->id]);

        $this->assertCount(3, $customer->appointments);
        $this->assertInstanceOf(Appointment::class, $customer->appointments->first());
    }

    /** @test */
    public function vip_factory_state_creates_customer_with_high_spending()
    {
        $vipCustomer = Customer::factory()->vip()->create();

        $this->assertGreaterThan(1000, $vipCustomer->total_spent);
        $this->assertGreaterThanOrEqual(10, $vipCustomer->total_visits);
    }

    /** @test */
    public function new_customer_factory_state_creates_customer_with_no_history()
    {
        $newCustomer = Customer::factory()->newCustomer()->create();

        $this->assertEquals(0, $newCustomer->total_visits);
        $this->assertEquals(0, $newCustomer->total_spent);
        $this->assertNull($newCustomer->last_visit_at);
    }
}