<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\DiagnosisController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
   
});

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/diagnose', [DiagnosisController::class, 'diagnose']);
    Route::get('/diagnosis-history', [DiagnosisController::class, 'history']);
});

Route::get('/symptoms', [DiagnosisController::class, 'getSymptoms']);
// Route::post('/diagnose', [DiagnosisController::class, 'diagnose']);
