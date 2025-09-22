<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Customer;
use App\Models\Staff;
use App\Models\Appointment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RoleBasedAccessTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function admin_can_access_all_admin_routes()
    {
        /** @var User $admin */
        $admin = User::factory()->create(['role' => 'admin']);

        $adminRoutes = [
            '/admin/dashboard',
            '/admin/customers',
            '/admin/staff',
            '/admin/services',
            '/admin/appointments',
            '/admin/reports',
        ];

        foreach ($adminRoutes as $route) {
            $response = $this->actingAs($admin)->get($route);
            $response->assertStatus(200, "Admin should be able to access {$route}");
        }
    }

    /** @test */
    public function staff_can_access_staff_routes_only()
    {
        /** @var User $staff */
        $staff = User::factory()->create(['role' => 'staff']);

        // Routes staff should access
        $allowedRoutes = [
            '/dashboard',
            '/staff/appointments',
            '/staff/schedule',
            '/profile/show',
        ];

        foreach ($allowedRoutes as $route) {
            $response = $this->actingAs($staff)->get($route);
            $this->assertNotEquals(403, $response->getStatusCode(), 
                "Staff should be able to access {$route}");
        }

        // Routes staff should NOT access
        $forbiddenRoutes = [
            '/admin/customers',
            '/admin/staff',
            '/admin/services',
            '/admin/reports',
        ];

        foreach ($forbiddenRoutes as $route) {
            $response = $this->actingAs($staff)->get($route);
            $response->assertStatus(403, "Staff should NOT be able to access {$route}");
        }
    }

    /** @test */
    public function customers_can_access_customer_routes_only()
    {
        /** @var User $customer */
        $customer = User::factory()->create(['role' => 'customer']);

        // Routes customers should access
        $allowedRoutes = [
            '/dashboard',
            '/appointments',
            '/appointments/book',
            '/profile/show',
        ];

        foreach ($allowedRoutes as $route) {
            $response = $this->actingAs($customer)->get($route);
            $this->assertNotEquals(403, $response->getStatusCode(), 
                "Customer should be able to access {$route}");
        }

        // Routes customers should NOT access
        $forbiddenRoutes = [
            '/admin/customers',
            '/admin/staff',
            '/admin/services',
            '/admin/reports',
            '/staff/appointments',
            '/staff/schedule',
        ];

        foreach ($forbiddenRoutes as $route) {
            $response = $this->actingAs($customer)->get($route);
            $response->assertStatus(403, "Customer should NOT be able to access {$route}");
        }
    }

    /** @test */
    public function staff_can_only_manage_their_own_appointments()
    {
        /** @var User $staffUser1 */
        $staffUser1 = User::factory()->create(['role' => 'staff']);
        $staff1 = Staff::factory()->create(['user_id' => $staffUser1->id]);

        /** @var User $staffUser2 */
        $staffUser2 = User::factory()->create(['role' => 'staff']);
        $staff2 = Staff::factory()->create(['user_id' => $staffUser2->id]);

        $appointment1 = Appointment::factory()->create(['staff_id' => $staff1->id]);
        $appointment2 = Appointment::factory()->create(['staff_id' => $staff2->id]);

        // Staff1 should be able to update their own appointment
        $response = $this->actingAs($staffUser1)
            ->patch("/staff/appointments/{$appointment1->id}", [
                'status' => 'completed'
            ]);
        $response->assertRedirect();

        // Staff1 should NOT be able to update Staff2's appointment
        $response = $this->actingAs($staffUser1)
            ->patch("/staff/appointments/{$appointment2->id}", [
                'status' => 'completed'
            ]);
        $response->assertStatus(403);
    }

    /** @test */
    public function customers_can_only_manage_their_own_appointments()
    {
        /** @var User $customerUser1 */
        $customerUser1 = User::factory()->create(['role' => 'customer']);
        $customer1 = Customer::factory()->create(['user_id' => $customerUser1->id]);

        /** @var User $customerUser2 */
        $customerUser2 = User::factory()->create(['role' => 'customer']);
        $customer2 = Customer::factory()->create(['user_id' => $customerUser2->id]);

        $appointment1 = Appointment::factory()->create(['customer_id' => $customer1->id]);
        $appointment2 = Appointment::factory()->create(['customer_id' => $customer2->id]);

        // Customer1 should be able to cancel their own appointment
        $response = $this->actingAs($customerUser1)
            ->patch("/appointments/{$appointment1->id}/cancel", [
                'cancellation_reason' => 'Personal reason'
            ]);
        $this->assertNotEquals(403, $response->getStatusCode());

        // Customer1 should NOT be able to cancel Customer2's appointment
        $response = $this->actingAs($customerUser1)
            ->patch("/appointments/{$appointment2->id}/cancel", [
                'cancellation_reason' => 'Personal reason'
            ]);
        $response->assertStatus(403);
    }

    /** @test */
    public function admin_can_manage_any_appointment()
    {
        /** @var User $admin */
        $admin = User::factory()->create(['role' => 'admin']);
        
        $customer = Customer::factory()->create();
        $staff = Staff::factory()->create();
        $appointment = Appointment::factory()->create([
            'customer_id' => $customer->id,
            'staff_id' => $staff->id,
        ]);

        // Admin should be able to update any appointment
        $response = $this->actingAs($admin)
            ->patch("/admin/appointments/{$appointment->id}", [
                'status' => 'completed'
            ]);
        $response->assertRedirect();
        
        $this->assertDatabaseHas('appointments', [
            'id' => $appointment->id,
            'status' => 'completed',
        ]);
    }

    /** @test */
    public function middleware_protects_role_specific_routes()
    {
        /** @var User $customer */
        $customer = User::factory()->create(['role' => 'customer']);

        // Test that middleware is working for admin routes
        $response = $this->actingAs($customer)
            ->post('/admin/customers', [
                'first_name' => 'Test',
                'last_name' => 'User',
                'email' => 'test@example.com',
            ]);

        $response->assertStatus(403);
        $this->assertDatabaseMissing('customers', [
            'email' => 'test@example.com',
        ]);
    }

    /** @test */
    public function users_redirected_to_appropriate_dashboard_after_login()
    {
        // Test admin redirect
        /** @var User $admin */
        $admin = User::factory()->create([
            'role' => 'admin',
            'password' => bcrypt('password'),
        ]);

        $response = $this->post('/login', [
            'email' => $admin->email,
            'password' => 'password',
        ]);

        $response->assertRedirect('/dashboard');
        
        // Logout and test staff redirect
        $this->post('/logout');
        
        /** @var User $staff */
        $staff = User::factory()->create([
            'role' => 'staff',
            'password' => bcrypt('password'),
        ]);

        $response = $this->post('/login', [
            'email' => $staff->email,
            'password' => 'password',
        ]);

        $response->assertRedirect('/dashboard');

        // Logout and test customer redirect
        $this->post('/logout');
        
        /** @var User $customer */
        $customer = User::factory()->create([
            'role' => 'customer',
            'password' => bcrypt('password'),
        ]);

        $response = $this->post('/login', [
            'email' => $customer->email,
            'password' => 'password',
        ]);

        $response->assertRedirect('/dashboard');
    }

    /** @test */
    public function unauthorized_access_returns_proper_error()
    {
        /** @var User $customer */
        $customer = User::factory()->create(['role' => 'customer']);

        $response = $this->actingAs($customer)->get('/admin/customers');
        
        $response->assertStatus(403);
        $response->assertSee('403'); // Should show 403 error page
    }
}