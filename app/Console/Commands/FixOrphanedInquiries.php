<?php

namespace App\Console\Commands;

use App\Models\Inquiry;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class FixOrphanedInquiries extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fix:inquiries';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fix orphaned inquiries by associating them with customer accounts based on email';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting orphaned inquiry fix process...');
        
        // Find all inquiries without user_id
        $orphanedInquiries = Inquiry::whereNull('user_id')->get();
        $count = $orphanedInquiries->count();
        
        $this->info("Found {$count} orphaned inquiries");
        
        if ($count === 0) {
            $this->info('No orphaned inquiries to fix. Exiting.');
            return Command::SUCCESS;
        }
        
        $bar = $this->output->createProgressBar($count);
        $bar->start();
        
        $fixedCount = 0;
        $createdUsers = 0;
        
        DB::beginTransaction();
        
        try {
            foreach ($orphanedInquiries as $inquiry) {
                if (empty($inquiry->email)) {
                    $this->warn("Inquiry ID {$inquiry->id} has no email, skipping");
                    $bar->advance();
                    continue;
                }
                
                // Look for a user with this email
                $user = User::where('email', $inquiry->email)->first();
                
                if (!$user) {
                    // Create a new user account
                    $user = User::create([
                        'name' => $inquiry->name,
                        'email' => $inquiry->email,
                        'password' => bcrypt('password123'), // Temporary password
                        'phone' => $inquiry->phone,
                        'address' => $inquiry->address,
                        'role' => 'customer',
                    ]);
                    
                    $createdUsers++;
                    
                    Log::info('Created new user for orphaned inquiry', [
                        'user_id' => $user->id,
                        'email' => $user->email,
                        'inquiry_id' => $inquiry->id
                    ]);
                }
                
                // Associate the inquiry with the user
                $inquiry->user_id = $user->id;
                $inquiry->save();
                
                $fixedCount++;
                $bar->advance();
            }
            
            DB::commit();
            $bar->finish();
            
            $this->newLine(2);
            $this->info("Fixed {$fixedCount} orphaned inquiries");
            $this->info("Created {$createdUsers} new user accounts");
            
            return Command::SUCCESS;
            
        } catch (\Exception $e) {
            DB::rollBack();
            
            $this->newLine(2);
            $this->error("Error fixing orphaned inquiries: {$e->getMessage()}");
            
            Log::error('Error fixing orphaned inquiries', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return Command::FAILURE;
        }
    }
} 