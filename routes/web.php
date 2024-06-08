<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DiseaseController;
use App\Http\Controllers\Admin\SymptomController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('login', [AuthController::class, 'doLogin']);
Route::get('/logout', [AuthController::class, 'logout']);

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/', [PageController::class, 'user'])->middleware('auth:admin');

Route::get('/admin', function () {
    return view('admin.index');
})->name('admin.index')->middleware('auth:admin');

Route::prefix('admin')->middleware('auth:admin')->group(function () {
    Route::resource('diseases', DiseaseController::class);
    Route::resource('symptoms', SymptomController::class);
});




