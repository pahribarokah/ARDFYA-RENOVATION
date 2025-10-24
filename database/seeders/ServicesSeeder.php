<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ServicesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $services = [
            [
                'name' => 'Renovasi Rumah',
                'description' => 'Layanan renovasi rumah yang mencakup perubahan struktur, desain, dan perbaikan pada bangunan rumah Anda. Kami menawarkan solusi renovasi yang komprehensif untuk meningkatkan nilai dan fungsi rumah Anda.',
                'icon' => 'fas fa-home',
                'is_active' => true
            ],
            [
                'name' => 'Perbaikan Rumah',
                'description' => 'Layanan perbaikan untuk masalah di rumah Anda seperti kebocoran, kerusakan dinding, lantai, plafon, atau instalasi listrik dan air. Teknisi berpengalaman kami siap menyelesaikan masalah rumah Anda dengan cepat dan profesional.',
                'icon' => 'fas fa-tools',
                'is_active' => true
            ],
            [
                'name' => 'Desain Interior',
                'description' => 'Layanan desain interior untuk menciptakan ruangan yang indah, fungsional dan sesuai dengan gaya hidup Anda. Tim desainer kami akan membantu mewujudkan ruangan impian Anda dengan desain yang estetis dan praktis.',
                'icon' => 'fas fa-drafting-compass',
                'is_active' => true
            ],
        ];

        foreach ($services as $service) {
            Service::create($service);
        }
    }
}
