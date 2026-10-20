<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\ExternalMahasiswaController;
use App\Http\Controllers\API\MahasiswaApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// butuh token sanctum
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/mahasiswa', [MahasiswaApiController::class, 'index']);
    Route::get('/mahasiswa/{id}', [MahasiswaApiController::class, 'show']);
    Route::get('/mahasiswa/{id}/download', [MahasiswaApiController::class, 'download']);
});

Route::post('/login', [AuthController::class, 'login']);

/*
|--------------------------------------------------------------------------
| External Academic Integration API (Protected by API Key)
|--------------------------------------------------------------------------
| Digunakan oleh sistem akademik luar untuk mengecek status disabilitas
| dan melihat detail kebutuhan akomodasi mahasiswa.
*/
Route::prefix('v1/external')
    ->middleware(['verify.external.api'])
    ->group(function () {
        // Cek status batch (daftar NIM dalam array)
        Route::post('/mahasiswa/check-batch', [ExternalMahasiswaController::class, 'checkBatchStatus']);

        // Cek status single NIM
        Route::get('/mahasiswa/check', [ExternalMahasiswaController::class, 'checkSingleStatus']);

        // Detail informasi disabilitas & akomodasi (saat icon diklik)
        // Gunakan parameter query ?nim= atau path dengan regex encode
        Route::get('/mahasiswa/detail', [ExternalMahasiswaController::class, 'detailWithQuery']);
        Route::get('/mahasiswa/detail/{nim}', [ExternalMahasiswaController::class, 'detail'])->where('nim', '.*');
    });