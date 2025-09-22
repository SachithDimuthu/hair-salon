<?php

namespace Tests\Unit;

use App\Models\Service;
use App\Models\Category;
use App\Models\Staff;
use App\Models\Appointment;
use App\Models\AppointmentService;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ServiceTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_belongs_to_a_category()
    {
        $category = Category::factory()->create();
        $service = Service::factory()->create(['category_id' => $category->id]);

        $this->assertInstanceOf(Category::class, $service->category);
        $this->assertEquals($category->id, $service->category->id);
    }

    /** @test */
    public function it_can_have_many_staff_members()
    {
        $service = Service::factory()->create();
        $staff = Staff::factory()->count(3)->create();

        // Attach staff to service (assuming pivot table exists)
        foreach ($staff as $staffMember) {
            $service->staff()->attach($staffMember->id, ['price_override' => $service->base_price + 10]);
        }

        $this->assertCount(3, $service->staff);
        $this->assertInstanceOf(Staff::class, $service->staff->first());
    }

    /** @test */
    public function it_can_calculate_total_revenue()
    {
        $service = Service::factory()->create(['base_price' => 100.00]);
        
        // Create appointments with this service
        $appointment1 = Appointment::factory()->create(['total_amount' => 100.00]);
        $appointment2 = Appointment::factory()->create(['total_amount' => 120.00]);
        $appointment3 = Appointment::factory()->create(['total_amount' => 90.00]);

        // Create appointment services linking appointments to the service
        AppointmentService::create([
            'appointment_id' => $appointment1->id,
            'service_id' => $service->id,
            'price' => 100.00,
            'quantity' => 1
        ]);

        AppointmentService::create([
            'appointment_id' => $appointment2->id,
            'service_id' => $service->id,
            'price' => 120.00,
            'quantity' => 1
        ]);

        AppointmentService::create([
            'appointment_id' => $appointment3->id,
            'service_id' => $service->id,
            'price' => 90.00,
            'quantity' => 1
        ]);

        $totalRevenue = $service->appointmentServices()->sum('price');

        $this->assertEquals(310.00, $totalRevenue);
    }

    /** @test */
    public function it_can_find_most_popular_services()
    {
        $service1 = Service::factory()->create(['name' => 'Hair Cut']);
        $service2 = Service::factory()->create(['name' => 'Hair Color']);
        $service3 = Service::factory()->create(['name' => 'Highlights']);

        // Create appointment services for popularity testing
        AppointmentService::factory()->count(5)->create(['service_id' => $service1->id]);
        AppointmentService::factory()->count(8)->create(['service_id' => $service2->id]);
        AppointmentService::factory()->count(3)->create(['service_id' => $service3->id]);

        // Get services ordered by appointment count
        $popularServices = Service::select('services.*')
            ->leftJoin('appointment_services', 'services.id', '=', 'appointment_services.service_id')
            ->selectRaw('COUNT(appointment_services.id) as appointment_count')
            ->groupBy('services.id')
            ->orderByDesc('appointment_count')
            ->get();

        $this->assertEquals($service2->id, $popularServices->first()->id);
        $this->assertEquals(8, $popularServices->first()->appointment_count);
    }

    /** @test */
    public function it_scopes_active_services()
    {
        Service::factory()->count(3)->create(['is_active' => true]);
        Service::factory()->count(2)->create(['is_active' => false]);

        $activeServices = Service::where('is_active', true)->get();

        $this->assertCount(3, $activeServices);
        $this->assertTrue($activeServices->every(fn($service) => $service->is_active));
    }

    /** @test */
    public function it_can_check_if_consultation_required()
    {
        $consultationService = Service::factory()->create(['requires_consultation' => true]);
        $regularService = Service::factory()->create(['requires_consultation' => false]);

        $this->assertTrue($consultationService->requires_consultation);
        $this->assertFalse($regularService->requires_consultation);
    }

    /** @test */
    public function it_formats_duration_in_minutes()
    {
        $service = Service::factory()->create(['duration_minutes' => 90]);

        $this->assertEquals(90, $service->duration_minutes);
        
        // Test duration formatting (1 hour 30 minutes)
        $hours = intdiv($service->duration_minutes, 60);
        $minutes = $service->duration_minutes % 60;
        
        $this->assertEquals(1, $hours);
        $this->assertEquals(30, $minutes);
    }

    /** @test */
    public function it_can_filter_services_by_price_range()
    {
        Service::factory()->create(['base_price' => 25.00]);
        Service::factory()->create(['base_price' => 75.00]);
        Service::factory()->create(['base_price' => 150.00]);
        Service::factory()->create(['base_price' => 300.00]);

        $affordableServices = Service::where('base_price', '<=', 100.00)->get();
        $premiumServices = Service::where('base_price', '>', 200.00)->get();

        $this->assertCount(2, $affordableServices);
        $this->assertCount(1, $premiumServices);
    }

    /** @test */
    public function it_can_filter_services_by_duration()
    {
        Service::factory()->create(['duration_minutes' => 30]);
        Service::factory()->create(['duration_minutes' => 60]);
        Service::factory()->create(['duration_minutes' => 120]);
        Service::factory()->create(['duration_minutes' => 180]);

        $quickServices = Service::where('duration_minutes', '<=', 60)->get();
        $longServices = Service::where('duration_minutes', '>', 120)->get();

        $this->assertCount(2, $quickServices);
        $this->assertCount(1, $longServices);
    }

    /** @test */
    public function premium_factory_state_creates_expensive_service()
    {
        $premiumService = Service::factory()->premium()->create();

        $this->assertGreaterThanOrEqual(150, $premiumService->base_price);
        $this->assertGreaterThanOrEqual(120, $premiumService->duration_minutes);
        $this->assertTrue($premiumService->requires_consultation);
    }

    /** @test */
    public function quick_factory_state_creates_short_affordable_service()
    {
        $quickService = Service::factory()->quick()->create();

        $this->assertLessThanOrEqual(45, $quickService->duration_minutes);
        $this->assertLessThanOrEqual(60, $quickService->base_price);
        $this->assertFalse($quickService->requires_consultation);
    }

    /** @test */
    public function it_can_calculate_average_service_price_by_category()
    {
        $category = Category::factory()->create();
        
        Service::factory()->count(3)->create([
            'category_id' => $category->id,
            'base_price' => 100.00
        ]);

        Service::factory()->count(2)->create([
            'category_id' => $category->id,
            'base_price' => 50.00
        ]);

        $averagePrice = Service::where('category_id', $category->id)->avg('base_price');

        $this->assertEquals(80.00, $averagePrice); // (300 + 100) / 5
    }

    /** @test */
    public function it_generates_slug_from_name()
    {
        $service = Service::factory()->create(['name' => 'Hair Cut & Style']);

        $this->assertEquals('hair-cut-style', $service->slug);
    }
}