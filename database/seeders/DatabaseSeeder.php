<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // Create base admin user
        if (!User::where('email', 'admin@ardfya.com')->exists()) {
            User::create([
                'name' => 'Administrator',
                'email' => 'admin@ardfya.com',
                'password' => Hash::make('password'),
                'phone' => '08123456789',
                'address' => 'Jl. Admin No. 1',
                'role' => 'admin',
            ]);
        }

        // Create regular user
        User::create([
            'name' => 'User',
            'email' => 'user@example.com',
            'password' => Hash::make('password'),
            'phone' => '08987654321',
            'address' => 'Jl. User No. 1',
            'role' => 'customer',
        ]);

        // Run seeders
        $this->call([
            ServicesSeeder::class,
            DemoDataSeeder::class, // Add comprehensive demo data
            AdminSeeder::class,
        ]);
    }
}
