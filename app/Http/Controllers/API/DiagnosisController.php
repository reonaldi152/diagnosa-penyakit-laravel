<?php

namespace App\Http\Controllers\API;

use App\Models\Disease;
use App\Models\Symptom;
use Illuminate\Http\Request;
use App\Models\DiagnosisHistory;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DiagnosisController extends Controller
{
    public function getSymptoms()
    {
        try {
            $symptoms = Symptom::all();
    
            if ($symptoms->isEmpty()) {
                return ResponseFormatter::error(null, "Data gejala tidak ditemukan", 404);
            }
    
            return ResponseFormatter::success($symptoms, "Berhasil mendapatkan data");
        } catch (\Exception $e) {
            return ResponseFormatter::error(null, "Terjadi kesalahan saat mengambil data: " . $e->getMessage(), 500);
        }
    }
    

    public function diagnose(Request $request)
{
    try {
        // Validasi input
        $request->validate([
            'symptoms' => 'required|array',
            'symptoms.*' => 'required|integer',
        ]);

        $symptomIds = $request->input('symptoms');

        // Ambil semua penyakit beserta gejalanya
        $diseases = Disease::with('symptoms')->get();
        $results = [];

        // Hitung kesesuaian gejala untuk setiap penyakit
        foreach ($diseases as $disease) {
            $matchingSymptomsCount = $disease->symptoms()->whereIn('symptom_id', $symptomIds)->count();
            $totalSymptomsCount = $disease->symptoms()->count();

            if ($matchingSymptomsCount > 0) {
                $score = ($matchingSymptomsCount / $totalSymptomsCount) * 100;
                $results[] = [
                    'disease' => $disease,
                    'matching_symptoms' => $matchingSymptomsCount,
                    'total_symptoms' => $totalSymptomsCount,
                    'score' => $score
                ];
            }
        }

        // Urutkan hasil berdasarkan skor kesesuaian tertinggi
        usort($results, function($a, $b) {
            return $b['score'] <=> $a['score'];
        });

        // Ambil ID penyakit dari hasil diagnosis
        $diseaseIds = array_map(function($result) {
            return $result['disease']->id;
        }, $results);
        // dd($diseaseIds);

        // Simpan riwayat diagnosis
        // DiagnosisHistory::create([
        //     'user_id' => Auth::id(),
        //     'symptoms' => json_encode($symptomIds),
        //     'diseases' => json_encode($diseaseIds),
        // ]);

        // Kembalikan hasil dalam format JSON
        return ResponseFormatter::success($results, "Berhasil mendapatkan data");
    } catch (\Exception $e) {
        // Tangani kesalahan dan kembalikan pesan kesalahan
        return ResponseFormatter::error(null, "Terjadi kesalahan saat mendiagnosis: " . $e->getMessage(), 500);
    }
}

    

    public function history()
    {
        // $histories = DiagnosisHistory::with(['user'])->where('user_id', Auth::id())->get()->map(function ($history) {
        //     // dd($history);
        //     return [
        //         'id' => $history->id,
        //         'user' => $history->user,
        //         'symptoms' => $history->symptom_details,
        //         'diseases' => $history->disease_details,
        //         'created_at' => $history->created_at,
        //         'updated_at' => $history->updated_at,
        //     ];
        // });

        // // dd($histories);

        // // return response()->json([
        // //     'histories' => $histories
        // // ]);
        // return ResponseFormatter::success([
        //         'histories' => $histories
        //     ], "Berhasil mendapatkan data");




        try {
            // Ambil ID pengguna yang terautentikasi
            $userId = Auth::id();
            
            // Ambil riwayat diagnosis berdasarkan ID pengguna yang terautentikasi
            $history = DiagnosisHistory::with('user')
                ->where('user_id', $userId)
                ->get()
                ->map(function($record) {
                    // Decode symptoms dan diseases dari JSON menjadi array
                    $record->symptoms = json_decode($record->symptoms, true);
                    $record->diseases = json_decode($record->diseases, true);
    
                    // Ambil data lengkap dari symptoms dan diseases berdasarkan ID
                    $record->symptoms_data = Symptom::whereIn('id', $record->symptoms)->get();
                    $record->diseases_data = Disease::whereIn('id', $record->diseases)->get();
    
                    return $record;
                });
    
            return ResponseFormatter::success($history, "Berhasil mendapatkan riwayat diagnosis");
        } catch (\Exception $e) {
            return ResponseFormatter::error(null, "Terjadi kesalahan saat mengambil riwayat diagnosis: " . $e->getMessage(), 500);
        }

    }
}
