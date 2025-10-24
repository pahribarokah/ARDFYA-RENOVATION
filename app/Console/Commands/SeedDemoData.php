<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class SeedDemoData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'seed:demo';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Seeds the database with demo data for ARDFYA renovation service';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting to seed demo data...');
        
        $this->info('Seeding demo data...');
        Artisan::call('db:seed', ['--class' => 'Database\Seeders\DemoDataSeeder']);
        
        $this->info('Demo data seeded successfully!');
        $this->info('You can now log in with:');
        $this->info('Admin: admin@ardfya.com / password123');
        $this->info('Customers: customer1@example.com, customer2@example.com, customer3@example.com / password123');
        
        return Command::SUCCESS;
    }
} 