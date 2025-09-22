<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Customer;
use App\Models\Staff;
use App\Models\Service;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminCrudTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function admin_can_view_customers_list()
    {
        /** @var User $admin */
        $admin = User::factory()->create(['role' => 'admin']);
        Customer::factory()->count(5)->create();

        $response = $this->actingAs($admin)->get('/admin/customers');

        $response->assertStatus(200);
        $response->assertViewHas('customers');
    }

    /** @test */
    public function admin_can_create_customers()
    {
        /** @var User $admin */
        $admin = User::factory()->create(['role' => 'admin']);

        $customerData = [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john.doe@example.com',
            'phone' => '123-456-7890',
            'date_of_birth' => '1990-01-01',
            'gender' => 'male',
            'address' => '123 Main St',
            'city' => 'Anytown',
            'postal_code' => '12345',
        ];

        $response = $this->actingAs($admin)
            ->post('/admin/customers', $customerData);

        $response->assertRedirect();
        $this->assertDatabaseHas('customers', [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john.doe@example.com',
        ]);
    }

    /** @test */
    public function admin_can_update_customers()
    {
        /** @var User $admin */
        $admin = User::factory()->create(['role' => 'admin']);
        $customer = Customer::factory()->create();

        $updateData = [
            'first_name' => 'Updated Name',
            'last_name' => $customer->last_name,
            'email' => $customer->email,
            'phone' => $customer->phone,
            'date_of_birth' => $customer->date_of_birth->format('Y-m-d'),
            'gender' => $customer->gender,
            'address' => $customer->address,
            'city' => $customer->city,
            'postal_code' => $customer->postal_code,
        ];

        $response = $this->actingAs($admin)
            ->put("/admin/customers/{$customer->id}", $updateData);

        $response->assertRedirect();
        $this->assertDatabaseHas('customers', [
            'id' => $customer->id,
            'first_name' => 'Updated Name',
        ]);
    }

    /** @test */
    public function admin_can_delete_customers()
    {
        /** @var User $admin */
        $admin = User::factory()->create(['role' => 'admin']);
        $customer = Customer::factory()->create();

        $response = $this->actingAs($admin)
            ->delete("/admin/customers/{$customer->id}");

        $response->assertRedirect();
        $this->assertDatabaseMissing('customers', [
            'id' => $customer->id,
        ]);
    }

    /** @test */
    public function admin_can_manage_staff()
    {
        /** @var User $admin */
        $admin = User::factory()->create(['role' => 'admin']);

        // View staff list
        $response = $this->actingAs($admin)->get('/admin/staff');
        $response->assertStatus(200);

        // Create staff
        $staffData = [
            'employee_id' => 'EMP001',
            'first_name' => 'Jane',
            'last_name' => 'Smith',
            'email' => 'jane.smith@example.com',
            'phone' => '123-456-7890',
            'hire_date' => '2024-01-01',
            'position' => 'stylist',
            'specializations' => ['Hair Cutting', 'Hair Coloring'],
            'hourly_rate' => 25.00,
            'commission_rate' => 0.15,
        ];

        $response = $this->actingAs($admin)
            ->post('/admin/staff', $staffData);

        $response->assertRedirect();
        $this->assertDatabaseHas('staff', [
            'employee_id' => 'EMP001',
            'first_name' => 'Jane',
            'last_name' => 'Smith',
        ]);
    }

    /** @test */
    public function admin_can_manage_services()
    {
        /** @var User $admin */
        $admin = User::factory()->create(['role' => 'admin']);
        $category = Category::factory()->create();

        // View services list
        $response = $this->actingAs($admin)->get('/admin/services');
        $response->assertStatus(200);

        // Create service
        $serviceData = [
            'category_id' => $category->id,
            'name' => 'Premium Hair Cut',
            'description' => 'Professional hair cutting service',
            'duration_minutes' => 60,
            'base_price' => 50.00,
            'requires_consultation' => false,
        ];

        $response = $this->actingAs($admin)
            ->post('/admin/services', $serviceData);

        $response->assertRedirect();
        $this->assertDatabaseHas('services', [
            'name' => 'Premium Hair Cut',
            'base_price' => 50.00,
        ]);

        // Update service
        $service = Service::where('name', 'Premium Hair Cut')->first();
        $updateData = array_merge($serviceData, [
            'base_price' => 60.00,
        ]);

        $response = $this->actingAs($admin)
            ->put("/admin/services/{$service->id}", $updateData);

        $response->assertRedirect();
        $this->assertDatabaseHas('services', [
            'id' => $service->id,
            'base_price' => 60.00,
        ]);
    }

    /** @test */
    public function staff_cannot_access_admin_functions()
    {
        /** @var User $staff */
        $staff = User::factory()->create(['role' => 'staff']);

        $response = $this->actingAs($staff)->get('/admin/customers');
        $response->assertStatus(403);

        $response = $this->actingAs($staff)->get('/admin/staff');
        $response->assertStatus(403);

        $response = $this->actingAs($staff)->post('/admin/customers', []);
        $response->assertStatus(403);
    }

    /** @test */
    public function customers_cannot_access_admin_functions()
    {
        /** @var User $customer */
        $customer = User::factory()->create(['role' => 'customer']);

        $response = $this->actingAs($customer)->get('/admin/customers');
        $response->assertStatus(403);

        $response = $this->actingAs($customer)->get('/admin/staff');
        $response->assertStatus(403);

        $response = $this->actingAs($customer)->get('/admin/services');
        $response->assertStatus(403);
    }

    /** @test */
    public function admin_can_view_dashboard_with_analytics()
    {
        /** @var User $admin */
        $admin = User::factory()->create(['role' => 'admin']);

        // Create some test data
        Customer::factory()->count(10)->create();
        Staff::factory()->count(5)->create();
        Service::factory()->count(20)->create();

        $response = $this->actingAs($admin)->get('/admin/dashboard');

        $response->assertStatus(200);
        $response->assertViewHas(['totalCustomers', 'totalStaff', 'totalServices']);
    }

    /** @test */
    public function admin_crud_operations_require_validation()
    {
        /** @var User $admin */
        $admin = User::factory()->create(['role' => 'admin']);

        // Test customer validation
        $response = $this->actingAs($admin)
            ->post('/admin/customers', [
                'first_name' => '',
                'email' => 'invalid-email',
            ]);

        $response->assertSessionHasErrors(['first_name', 'email']);

        // Test staff validation
        $response = $this->actingAs($admin)
            ->post('/admin/staff', [
                'employee_id' => '',
                'position' => 'invalid-position',
                'hourly_rate' => 'not-a-number',
            ]);

        $response->assertSessionHasErrors(['employee_id', 'position', 'hourly_rate']);

        // Test service validation
        $response = $this->actingAs($admin)
            ->post('/admin/services', [
                'name' => '',
                'duration_minutes' => 'invalid',
                'base_price' => -10,
            ]);

        $response->assertSessionHasErrors(['name', 'duration_minutes', 'base_price']);
    }
}