<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\DokterController;
use App\Http\Controllers\Api\JadwalDokterController;
use App\Http\Controllers\Api\PasienController;
use App\Http\Controllers\Api\KonsultasiController;
use App\Http\Controllers\Api\RekamMedisController;
use App\Http\Controllers\Api\LaporanController;
use App\Http\Controllers\Api\UserController;    

Route::apiResource('user', UserController::class);
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
