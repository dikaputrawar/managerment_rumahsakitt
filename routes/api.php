<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\{
    DokterController,
    JadwalDokterController,
    PasienController,
    KonsultasiController,
    RekamMedisController,
    LaporanController,
    UserController,
    InventoryController,
    PaymentController,
    PoliController,
    PengambilanObatController,
    AntreanController,
    PendaftaranController,
    AuthController
};

// Route publik
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

// Route yang butuh auth:sanctum
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::apiResource('user', UserController::class);
    Route::apiResource('poli', PoliController::class);
    Route::apiResource('dokter', DokterController::class);
    Route::apiResource('jadwal-dokter', JadwalDokterController::class);
    Route::apiResource('pasien', PasienController::class);
    Route::apiResource('konsultasi', KonsultasiController::class);
    Route::apiResource('rekam-medis', RekamMedisController::class);
    Route::apiResource('laporan', LaporanController::class);
    Route::apiResource('inventory', InventoryController::class);
    Route::apiResource('payments', PaymentController::class);
    Route::apiResource('pengambilan-obat', PengambilanObatController::class);
    Route::apiResource('pendaftaran', PendaftaranController::class);
    Route::apiResource('antrean', AntreanController::class);
});
