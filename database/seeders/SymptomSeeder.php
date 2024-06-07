<?php

namespace Database\Seeders;

use App\Models\Symptom;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SymptomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $symptoms = [
            ['name' => 'Demam'],
            ['name' => 'Batuk'],
            ['name' => 'Bersin-bersin'],
            ['name' => 'Sakit Tenggorokan'],
            // Tambahkan gejala lainnya di sini
        ];

        foreach ($symptoms as $symptom) {
            Symptom::create($symptom);
        }
    }
}
