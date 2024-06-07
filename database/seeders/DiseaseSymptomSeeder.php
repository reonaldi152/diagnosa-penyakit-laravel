<?php

namespace Database\Seeders;

use App\Models\Disease;
use App\Models\Symptom;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DiseaseSymptomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // // Ambil gejala berdasarkan nama
        // $demam = Symptom::where('name', 'Demam')->first();
        // $batuk = Symptom::where('name', 'Batuk')->first();
        // $bersin = Symptom::where('name', 'Bersin-bersin')->first();
        // $sakitTenggorokan = Symptom::where('name', 'Sakit Tenggorokan')->first();

        // // Influenza mempunyai gejala Demam, Batuk, Bersin-bersin
        // $influenza = Disease::where('name', 'Influenza')->first();
        // $influenza->symptoms()->attach([$demam->id, $batuk->id, $bersin->id]);

        // // Common Cold mempunyai gejala Batuk, Sakit Tenggorokan
        // $commonCold = Disease::where('name', 'Common Cold')->first();
        // $commonCold->symptoms()->attach([$batuk->id, $sakitTenggorokan->id]);

        // $diseases = [
        //     ['name' => 'Influenza', 'description' => 'Infeksi virus yang menyerang sistem pernapasan'],
        //     ['name' => 'Common Cold', 'description' => 'Infeksi virus yang menyerang saluran pernapasan bagian atas'],
        //     // Tambahkan penyakit lainnya di sini
        // ];

        // foreach ($diseases as $disease) {
        //     Disease::create($disease);
        // }


        // Ambil gejala berdasarkan nama
        $demam = Symptom::where('name', 'Demam')->first();
        $batuk = Symptom::where('name', 'Batuk')->first();
        $bersin = Symptom::where('name', 'Bersin-bersin')->first();
        $sakitTenggorokan = Symptom::where('name', 'Sakit Tenggorokan')->first();

        // Pastikan gejala ditemukan
        if (!$demam || !$batuk || !$bersin || !$sakitTenggorokan) {
            throw new \Exception('Gejala tidak ditemukan');
        }

        // Influenza mempunyai gejala Demam, Batuk, Bersin-bersin
        $influenza = Disease::where('name', 'Influenza')->first();
        if ($influenza) {
            $influenza->symptoms()->attach([$demam->id, $batuk->id, $bersin->id]);
        }

        // Common Cold mempunyai gejala Batuk, Sakit Tenggorokan
        $commonCold = Disease::where('name', 'Common Cold')->first();
        if ($commonCold) {
            $commonCold->symptoms()->attach([$batuk->id, $sakitTenggorokan->id]);
        }
    }
}
