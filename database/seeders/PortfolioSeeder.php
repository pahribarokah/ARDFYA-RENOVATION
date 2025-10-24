<?php

namespace Database\Seeders;

use App\Models\Portfolio;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PortfolioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $portfolios = [
            [
                'title' => 'Renovasi Rumah Modern Minimalis',
                'description' => 'Proyek renovasi rumah dengan konsep modern minimalis yang mengutamakan fungsi dan estetika. Menggunakan material berkualitas tinggi dengan desain yang clean dan elegan.',
                'category' => 'renovasi',
                'client_name' => 'Bapak Andi Wijaya',
                'location' => 'Jakarta Selatan',
                'completion_date' => '2024-03-15',
                'project_value' => 150000000,
                'is_featured' => true,
                'is_active' => true,
                'ordering' => 1,
            ],
            [
                'title' => 'Pembangunan Villa Tropis',
                'description' => 'Pembangunan villa dengan konsep tropis yang menyatu dengan alam. Menggunakan material alami seperti kayu dan batu alam untuk menciptakan suasana yang hangat dan nyaman.',
                'category' => 'pembangunan',
                'client_name' => 'Ibu Sarah Putri',
                'location' => 'Bogor',
                'completion_date' => '2024-05-20',
                'project_value' => 500000000,
                'is_featured' => true,
                'is_active' => true,
                'ordering' => 2,
            ],
            [
                'title' => 'Desain Interior Apartemen',
                'description' => 'Desain interior apartemen dengan konsep Scandinavian yang mengutamakan kenyamanan dan fungsionalitas. Menggunakan warna-warna netral dan furniture multifungsi.',
                'category' => 'interior',
                'client_name' => 'Bapak Rudi Hartono',
                'location' => 'Jakarta Pusat',
                'completion_date' => '2024-02-10',
                'project_value' => 75000000,
                'is_featured' => false,
                'is_active' => true,
                'ordering' => 3,
            ],
            [
                'title' => 'Renovasi Kantor Modern',
                'description' => 'Renovasi kantor dengan konsep modern dan profesional. Menciptakan ruang kerja yang produktif dengan desain yang inspiring dan fasilitas yang lengkap.',
                'category' => 'komersial',
                'client_name' => 'PT. Maju Bersama',
                'location' => 'Jakarta Barat',
                'completion_date' => '2024-04-30',
                'project_value' => 300000000,
                'is_featured' => false,
                'is_active' => true,
                'ordering' => 4,
            ],
            [
                'title' => 'Landscape Taman Rumah',
                'description' => 'Desain dan pembuatan taman rumah dengan konsep natural yang menyegarkan. Menggunakan tanaman lokal dan sistem irigasi yang efisien.',
                'category' => 'landscape',
                'client_name' => 'Ibu Maya Sari',
                'location' => 'Depok',
                'completion_date' => '2024-01-25',
                'project_value' => 50000000,
                'is_featured' => false,
                'is_active' => true,
                'ordering' => 5,
            ],
        ];

        foreach ($portfolios as $portfolio) {
            Portfolio::create($portfolio);
        }
    }
}
