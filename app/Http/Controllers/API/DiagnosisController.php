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
            $request->validate([
                'symptoms' => 'required|array',
                'symptoms.*' => 'required|integer',
            ]);
    
            $symptomIds = $request->input('symptoms');
    
            $diseases = Disease::with('symptoms')->get();
            $results = [];
    
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
    
            usort($results, function($a, $b) {
                return $b['score'] <=> $a['score'];
            });
    
            DiagnosisHistory::create([
                'user_id' => Auth::id(),
                'symptoms' => json_encode($symptomIds),
                'diseases' => json_encode(array_column($results, 'disease.id')),
            ]);
    
            return ResponseFormatter::success($results, "Berhasil mendapatkan data");
        } catch (\Exception $e) {
            return ResponseFormatter::error(null, "Terjadi kesalahan saat mendiagnosis: " . $e->getMessage(), 500);
        }
    }
    

    public function history()
    {
        $histories = DiagnosisHistory::with(['user'])->where('user_id', Auth::id())->get()->map(function ($history) {
            return [
                'id' => $history->id,
                'user' => $history->user,
                'symptoms' => $history->symptom_details,
                'diseases' => $history->disease_details,
                'created_at' => $history->created_at,
                'updated_at' => $history->updated_at,
            ];
        });

        // return response()->json([
        //     'histories' => $histories
        // ]);
        return ResponseFormatter::success([
                'histories' => $histories
            ], "Berhasil mendapatkan data");

    }
}
