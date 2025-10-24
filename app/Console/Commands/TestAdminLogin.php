<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class TestAdminLogin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:admin-login';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test admin login functionality';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Testing admin login...');
        
        // Get the admin user
        $admin = User::where('role', 'admin')->first();
        
        if (!$admin) {
            $this->error('No admin user found!');
            return Command::FAILURE;
        }
        
        $this->info("Found admin user: {$admin->name} ({$admin->email})");
        
        // Try to login
        $credentials = [
            'email' => $admin->email,
            'password' => 'password', // Assuming the password is 'password'
        ];
        
        if (Auth::attempt($credentials)) {
            $this->info("Logged in successfully as {$admin->name}");
            $this->info("User role: {$admin->role}");
            $this->info("Is admin: " . ($admin->isAdmin() ? 'Yes' : 'No'));
            
            return Command::SUCCESS;
        } else {
            $this->error('Login failed!');
            
            // Check if credentials are valid
            $this->info("Checking user credentials...");
            $user = User::where('email', $credentials['email'])->first();
            
            if (!$user) {
                $this->error("User with email {$credentials['email']} not found!");
                return Command::FAILURE;
            }
            
            $this->info("User found: {$user->name}");
            $this->info("Checking password...");
            
            if (Hash::check($credentials['password'], $user->password)) {
                $this->info("Password is correct");
            } else {
                $this->error("Password is incorrect");
            }
            
            return Command::FAILURE;
        }
    }
} 