<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            'Sembako & Beras',
            'Mie & Makanan Instan',
            'Minuman & Es',
            'Makanan Ringan & Camilan',
            'Bumbu & Bahan Dapur',
            'Susu & Olahan',
            'Perlengkapan Mandi & Cuci',
            'Obat & Kesehatan',
            'Rokok & Korek',
            'Lain-lain',
        ];

        foreach ($categories as $category) {
            Category::updateOrCreate(
                ['name' => $category] // Mencegah duplikasi data jika seeder dijalankan ulang
            );
        }
    }
}
