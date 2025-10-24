<?php

namespace Database\Seeders;

use App\Models\Contract;
use App\Models\Inquiry;
use App\Models\Message;
use App\Models\Project;
use App\Models\Service;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class DemoDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user if not exists
        $admin = User::where('email', 'admin@ardfya.com')->first();
        if (!$admin) {
            $admin = User::create([
                'name' => 'Administrator',
                'email' => 'admin@ardfya.com',
                'password' => Hash::make('password123'),
                'phone' => '08123456789',
                'address' => 'Jl. Admin No. 1, Jakarta',
                'role' => 'admin',
            ]);
        }

        // Create services if not exists
        if (Service::count() === 0) {
            $services = [
                [
                    'name' => 'Renovasi Rumah',
                    'description' => 'Layanan renovasi rumah mencakup perubahan struktur, desain, dan perbaikan pada bangunan rumah Anda.',
                    'icon' => 'fas fa-home',
                    'is_active' => true,
                    'slug' => 'renovasi-rumah',
                ],
                [
                    'name' => 'Desain Interior',
                    'description' => 'Layanan desain interior untuk menciptakan ruangan yang indah, fungsional dan sesuai dengan gaya hidup Anda.',
                    'icon' => 'fas fa-drafting-compass',
                    'is_active' => true,
                    'slug' => 'desain-interior',
                ],
                [
                    'name' => 'Perbaikan Rumah',
                    'description' => 'Layanan perbaikan untuk masalah di rumah Anda seperti kebocoran, kerusakan dinding, lantai, atau plafon.',
                    'icon' => 'fas fa-tools',
                    'is_active' => true,
                    'slug' => 'perbaikan-rumah',
                ],
            ];

            foreach ($services as $serviceData) {
                Service::create($serviceData);
            }
        }

        // Create 3 customer users if they don't exist
        $customers = [];
        $customerEmails = ['customer1@example.com', 'customer2@example.com', 'customer3@example.com'];
        
        foreach ($customerEmails as $index => $email) {
            $customer = User::where('email', $email)->first();
            if (!$customer) {
                $customer = User::create([
                    'name' => 'Customer ' . ($index + 1),
                    'email' => $email,
                    'password' => Hash::make('password123'),
                    'phone' => '08' . rand(1000000000, 9999999999),
                    'address' => 'Jl. Customer No. ' . ($index + 1) . ', Jakarta',
                    'role' => 'customer',
                ]);
            }
            $customers[] = $customer;
        }

        // Create inquiries for each customer
        $services = Service::all();
        
        // Statuses to cycle through
        $statuses = ['new', 'contacted', 'in_progress', 'completed', 'cancelled'];
        $propertyTypes = ['rumah', 'apartemen', 'ruko', 'kantor', 'lainnya'];
        
        foreach ($customers as $index => $customer) {
            // Check if customer already has inquiries
            if ($customer->inquiries()->count() === 0) {
                // Create 2 inquiries per customer
                for ($i = 0; $i < 2; $i++) {
                    $service = $services[rand(0, count($services) - 1)];
                    $status = $statuses[rand(0, count($statuses) - 1)];
                    $propertyType = $propertyTypes[rand(0, count($propertyTypes) - 1)];
                    
                    $inquiry = new Inquiry();
                    $inquiry->user_id = $customer->id;
                    $inquiry->service_id = $service->id;
                    $inquiry->name = $customer->name;
                    $inquiry->email = $customer->email;
                    $inquiry->phone = $customer->phone;
                    $inquiry->property_type = $propertyType;
                    $inquiry->address = $customer->address;
                    $inquiry->area_size = rand(50, 500);
                    $inquiry->budget = rand(10, 100) * 1000000;
                    $inquiry->description = 'Permintaan renovasi untuk ' . $propertyType . ' saya. Butuh bantuan profesional.';
                    $inquiry->status = $status;
                    $inquiry->start_date = now()->addDays(rand(7, 30));
                    $inquiry->schedule_flexibility = ['strict', 'moderate', 'flexible'][rand(0, 2)];
                    $inquiry->current_condition = 'Kondisi ' . $propertyType . ' saat ini memerlukan perbaikan.';
                    
                    // Add admin notes for contacted or in progress inquiries
                    if (in_array($status, ['contacted', 'in_progress', 'completed'])) {
                        $inquiry->admin_notes = 'Telah dihubungi pada ' . now()->subDays(rand(1, 10))->format('d/m/Y');
                    }
                    
                    $inquiry->created_at = now()->subDays(rand(1, 60));
                    $inquiry->updated_at = now()->subDays(rand(0, 30));
                    $inquiry->save();
                    
                    // Add some messages to inquiries
                    if (in_array($status, ['contacted', 'in_progress'])) {
                        Message::create([
                            'inquiry_id' => $inquiry->id,
                            'user_id' => $admin->id,
                            'message' => 'Terima kasih atas permintaan Anda. Kami akan meninjau dan menghubungi Anda segera.',
                            'is_from_admin' => true,
                            'is_read' => true,
                            'created_at' => $inquiry->created_at->addDays(1),
                        ]);
                        
                        Message::create([
                            'inquiry_id' => $inquiry->id,
                            'user_id' => $customer->id,
                            'message' => 'Terima kasih. Saya menunggu kabar selanjutnya.',
                            'is_from_admin' => false,
                            'is_read' => $status === 'in_progress',
                            'created_at' => $inquiry->created_at->addDays(2),
                        ]);
                    }
                    
                    // Create project for in_progress or completed inquiries
                    if (in_array($status, ['in_progress', 'completed'])) {
                        $projectStatus = $status === 'in_progress' ? 'in_progress' : 'completed';
                        
                        $project = Project::create([
                            'user_id' => $customer->id,
                            'service_id' => $service->id,
                            'inquiry_id' => $inquiry->id,
                            'name' => 'Proyek ' . $service->name . ' - ' . $customer->name,
                            'description' => 'Proyek ' . $service->name . ' untuk ' . $propertyType . ' milik ' . $customer->name,
                            'status' => $projectStatus,
                            'start_date' => $inquiry->created_at->addDays(7),
                            'end_date' => $status === 'completed' ? $inquiry->created_at->addDays(37) : null,
                            'address' => $inquiry->address,
                            'total_cost' => $inquiry->budget * 1.1, // 10% markup
                            'category' => $propertyType,
                            'is_featured' => $status === 'completed',
                            'progress_percentage' => $status === 'completed' ? 100 : rand(10, 90),
                        ]);
                        
                        // Create contract for projects
                        if ($projectStatus === 'completed' || rand(0, 1) === 1) {
                            $paymentStatus = $projectStatus === 'completed' ? 'paid' : ['pending', 'partial'][rand(0, 1)];
                            
                            Contract::create([
                                'project_id' => $project->id,
                                'user_id' => $customer->id,
                                'start_date' => $project->start_date,
                                'end_date' => $project->end_date,
                                'amount' => $project->total_cost,
                                'payment_status' => $paymentStatus,
                                'notes' => 'Kontrak untuk proyek ' . $project->name,
                            ]);
                        }
                    }
                }
            }
        }
    }
} 