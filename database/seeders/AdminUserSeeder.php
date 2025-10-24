<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin ARDFYA 3',
            'email' => 'admin3@ardfya.com',
            'password' => Hash::make('admin123'),
            'phone' => '081234567890',
            'address' => 'Jl. Admin ARDFYA No. 123',
            'role' => 'admin',
        ]);
    }
} 