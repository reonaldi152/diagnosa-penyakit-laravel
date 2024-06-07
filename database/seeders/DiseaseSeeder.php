<?php

namespace Database\Seeders;

use App\Models\Disease;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DiseaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $diseases = [
            [
                'name' => 'Influenza', 
                'description' => 'Infeksi virus yang menyerang sistem pernapasan',
                'additional_symptoms' => ['Kelelahan', 'Nyeri otot', 'Menggigil'],
            ],
            [
                'name' => 'Common Cold',
                'description' => 'Infeksi virus yang menyerang saluran pernapasan bagian atas',
                'additional_symptoms' => ['Kelelahan', 'Nyeri otot', 'Menggigil'],
            ],
            // Tambahkan penyakit lainnya di sini
        ];

        foreach ($diseases as $disease) {
            Disease::create($disease);
        }
    }
}
