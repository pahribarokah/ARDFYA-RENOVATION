<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Message;
use App\Models\Inquiry;
use App\Notifications\NewMessageNotification;
use App\Notifications\InquiryStatusNotification;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NotificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get some users
        $customers = User::where('role', 'customer')->take(3)->get();
        $admin = User::where('role', 'admin')->first();

        if ($customers->isEmpty() || !$admin) {
            $this->command->info('No users found. Please run UserSeeder first.');
            return;
        }

        // Create some test notifications for customers
        foreach ($customers as $customer) {
            // Create a fake message notification
            $fakeMessage = new Message([
                'id' => rand(1000, 9999),
                'user_id' => $admin->id,
                'message' => 'Halo! Terima kasih telah menghubungi kami. Tim kami akan segera memproses permintaan Anda.',
                'is_from_admin' => true,
                'created_at' => now()->subMinutes(rand(5, 60))
            ]);
            $fakeMessage->user = $admin;

            // Send message notification
            $customer->notify(new NewMessageNotification($fakeMessage, 'inquiry', 'Konsultasi Renovasi Rumah'));

            // Create inquiry status notification if customer has inquiries
            $inquiry = $customer->inquiries()->first();
            if ($inquiry) {
                $customer->notify(new InquiryStatusNotification($inquiry, 'new', 'contacted'));
            }
        }

        // Create some notifications for admin
        if ($admin) {
            foreach ($customers->take(2) as $customer) {
                $fakeMessage = new Message([
                    'id' => rand(1000, 9999),
                    'user_id' => $customer->id,
                    'message' => 'Selamat pagi, saya ingin bertanya tentang layanan renovasi kamar mandi.',
                    'is_from_admin' => false,
                    'created_at' => now()->subMinutes(rand(10, 120))
                ]);
                $fakeMessage->user = $customer;

                $admin->notify(new NewMessageNotification($fakeMessage, 'inquiry', 'Inquiry dari ' . $customer->name));
            }
        }

        $this->command->info('Test notifications created successfully!');
    }
}
