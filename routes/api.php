<?php

use App\Http\Controllers\API\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\MahasiswaApiController;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

// Route::post("register", [AuthController::class, "register"]);

// butuh token sanctum
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/mahasiswa', [MahasiswaApiController::class, 'index']);
    Route::get('/mahasiswa/{id}', [MahasiswaApiController::class, 'show']);
    Route::get('/mahasiswa/{id}/download', [MahasiswaApiController::class, 'download']);
});

Route::post('/login', [AuthController::class, 'login']);