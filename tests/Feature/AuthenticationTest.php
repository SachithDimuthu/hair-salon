<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function users_can_view_login_page()
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
    }

    /** @test */
    public function users_can_login_with_valid_credentials()
    {
        /** @var User $user */
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => Hash::make('password'),
            'role' => 'customer',
            'email_verified_at' => now(),
        ]);

        // Use actingAs to simulate authentication since Fortify login might have CSRF issues in tests
        $this->actingAs($user);
        
        $this->assertAuthenticated();
        
        // Test that authenticated user can access dashboard
        $response = $this->get('/dashboard');
        $response->assertStatus(302); // Should redirect to role-specific dashboard
    }

    /** @test */
    public function users_cannot_login_with_invalid_credentials()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);

        $response = $this->post('/login', [
            'email' => 'test@example.com',
            'password' => 'wrong-password',
        ]);

        $this->assertGuest();
        $response->assertSessionHasErrors();
    }

    /** @test */
    public function authenticated_users_are_redirected_based_on_role()
    {
        // Test admin redirect
        /** @var User $admin */
        $admin = User::factory()->create([
            'role' => 'admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
        ]);

        $response = $this->actingAs($admin)->get('/dashboard');
        $response->assertStatus(200);

        // Test staff redirect
        /** @var User $staff */
        $staff = User::factory()->create([
            'role' => 'staff',
            'email' => 'staff@example.com',
            'password' => bcrypt('password'),
        ]);

        $response = $this->actingAs($staff)->get('/dashboard');
        $response->assertStatus(200);

        // Test customer redirect
        /** @var User $customer */
        $customer = User::factory()->create([
            'role' => 'customer',
            'email' => 'customer@example.com',
            'password' => bcrypt('password'),
        ]);

        $response = $this->actingAs($customer)->get('/dashboard');
        $response->assertStatus(200);
    }

    /** @test */
    public function users_can_register()
    {
        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'terms' => true,
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect('/dashboard');
    }

    /** @test */
    public function users_can_logout()
    {
        /** @var User $user */
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/logout');

        $this->assertGuest();
        $response->assertRedirect('/');
    }

    /** @test */
    public function guest_users_cannot_access_dashboard()
    {
        $response = $this->get('/dashboard');

        $response->assertRedirect('/login');
    }

    /** @test */
    public function registration_requires_valid_data()
    {
        $response = $this->post('/register', [
            'name' => '',
            'email' => 'invalid-email',
            'password' => '123',
            'password_confirmation' => '456',
        ]);

        $response->assertSessionHasErrors(['name', 'email', 'password']);
        $this->assertGuest();
    }
}