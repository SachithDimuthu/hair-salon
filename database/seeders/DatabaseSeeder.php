<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create an admin user
        User::factory()->withPersonalTeam()->create([
            'name' => 'Admin User',
            'email' => 'admin@luxehairstudio.lk',
            'role' => 'admin',
        ]);

        // Create a customer user
        User::factory()->withPersonalTeam()->create([
            'name' => 'Customer User',
            'email' => 'customer@example.com',
            'role' => 'customer',
        ]);

        // Create additional test users
        // User::factory(10)->withPersonalTeam()->create();
    }
}
