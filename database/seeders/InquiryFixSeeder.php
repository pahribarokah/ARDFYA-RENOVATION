<?php

namespace Database\Seeders;

use App\Models\Inquiry;
use App\Models\Service;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class InquiryFixSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Log::info('Mulai proses perbaikan data inquiry');
        
        DB::beginTransaction();
        
        try {
            // 1. Pastikan ada service aktif tersedia
            $serviceCount = Service::where('is_active', true)->count();
            Log::info('Jumlah layanan aktif', ['count' => $serviceCount]);
            
            if ($serviceCount == 0) {
                Log::info('Membuat layanan aktif baru');
                Service::create([
                    'name' => 'Desain Interior',
                    'description' => 'Layanan desain interior untuk rumah dan apartemen',
                    'is_active' => true,
                ]);
            }
            
            // 2. Pastikan semua inquiry memiliki user_id
            $inquiriesWithoutUser = Inquiry::whereNull('user_id')->get();
            $fixedCount = 0;
            
            foreach ($inquiriesWithoutUser as $inquiry) {
                // Cek jika inquiry memiliki email
                if (!$inquiry->email) {
                    Log::warning('Inquiry tanpa email', ['id' => $inquiry->id]);
                    continue;
                }
                
                // Cari user dengan email yang sama atau buat baru
                $user = User::where('email', $inquiry->email)->first();
                
                if (!$user) {
                    $user = User::create([
                        'name' => $inquiry->name,
                        'email' => $inquiry->email,
                        'password' => bcrypt('password123'),
                        'role' => 'customer',
                    ]);
                    
                    Log::info('User baru dibuat', [
                        'user_id' => $user->id,
                        'email' => $user->email
                    ]);
                }
                
                // Update inquiry dengan user_id
                $inquiry->user_id = $user->id;
                $inquiry->save();
                $fixedCount++;
                
                Log::info('Inquiry diperbarui dengan user_id', [
                    'inquiry_id' => $inquiry->id,
                    'user_id' => $user->id
                ]);
            }
            
            Log::info('Inquiry yang diperbarui dengan user_id', ['count' => $fixedCount]);
            
            // 3. Pastikan semua inquiry memiliki tanggal mulai dan fleksibilitas jadwal
            $inquiriesWithMissingFields = Inquiry::whereNull('start_date')
                ->orWhereNull('schedule_flexibility')
                ->get();
            
            $fixedDateCount = 0;
            
            foreach ($inquiriesWithMissingFields as $inquiry) {
                $changed = false;
                
                if (!$inquiry->start_date) {
                    $inquiry->start_date = now()->addDays(7);
                    $changed = true;
                }
                
                if (!$inquiry->schedule_flexibility) {
                    $inquiry->schedule_flexibility = 'flexible';
                    $changed = true;
                }
                
                if ($changed) {
                    $inquiry->save();
                    $fixedDateCount++;
                    
                    Log::info('Inquiry diperbarui dengan data tanggal', [
                        'inquiry_id' => $inquiry->id
                    ]);
                }
            }
            
            Log::info('Inquiry yang diperbarui dengan tanggal', ['count' => $fixedDateCount]);
            
            // 4. Jika belum ada data inquiry sama sekali, buat contoh
            $totalInquiries = Inquiry::count();
            Log::info('Total inquiry', ['count' => $totalInquiries]);
            
            if ($totalInquiries == 0) {
                Log::info('Membuat inquiry contoh baru');
                
                // Dapatkan atau buat user customer
                $customer = User::where('role', 'customer')->first();
                if (!$customer) {
                    $customer = User::create([
                        'name' => 'Pelanggan Demo',
                        'email' => 'pelanggan@example.com',
                        'password' => bcrypt('password123'),
                        'role' => 'customer',
                    ]);
                }
                
                // Dapatkan service pertama
                $service = Service::where('is_active', true)->first();
                
                // Buat inquiry demo
                Inquiry::create([
                    'user_id' => $customer->id,
                    'service_id' => $service->id,
                    'name' => 'Pelanggan Demo',
                    'email' => 'pelanggan@example.com',
                    'phone' => '081234567890',
                    'property_type' => 'rumah',
                    'address' => 'Jl. Contoh No. 123, Jakarta',
                    'area_size' => 100,
                    'current_condition' => 'Butuh renovasi',
                    'description' => 'Saya ingin merenovasi ruang tamu',
                    'budget' => 15000000,
                    'start_date' => now()->addDays(7),
                    'schedule_flexibility' => 'flexible',
                    'status' => 'new',
                ]);
                
                Log::info('Inquiry contoh berhasil dibuat');
            }
            
            DB::commit();
            Log::info('Proses perbaikan data inquiry selesai');
            
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error dalam proses perbaikan data inquiry', [
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
            throw $e;
        }
    }
} 