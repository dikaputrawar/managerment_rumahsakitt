<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DokterController;
use App\Http\Controllers\JadwalDokterController;
use App\Http\Controllers\PasienController;
use App\Http\Controllers\KonsultasiController;
use App\Http\Controllers\RekamMedisController;
use App\Http\Controllers\LaporanController;

Route::apiResource('dokter', DokterController::class);
Route::apiResource('jadwal-dokter', JadwalDokterController::class);
Route::apiResource('pasien', PasienController::class);
Route::apiResource('konsultasi', KonsultasiController::class);
Route::apiResource('rekam-medis', RekamMedisController::class);
Route::apiResource('laporan', LaporanController::class);


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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
