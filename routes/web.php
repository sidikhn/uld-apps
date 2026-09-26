<?php

use App\Http\Controllers\AdminAccountController;
use App\Http\Controllers\AlumniController;
use App\Http\Controllers\AsesmenUjianController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\tendikController;
use App\Http\Controllers\TrashController;
use App\Http\Controllers\CsvController;
use App\Models\Alumni;
use App\Models\AsesmenUjian;

Route::get('/', [LoginController::class, 'showLoginForm'])->name('login');  
Route::post('/', [LoginController::class, 'login']);  

Route::get('/api/study-programs', [MahasiswaController::class, 'studyPrograms'])
    ->name('api.studyPrograms');

Route::middleware(['auth', 'view-only'])->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('dashboard');
    Route::get('/admin', [AdminAccountController::class, 'index'])
        ->middleware('superadmin')->name('admin.index');
    Route::post('/admin', [AdminAccountController::class, 'store'])
        ->middleware('superadmin')->name('admin.store');
    Route::get('/sampah', [TrashController::class, 'index'])->name('trash.index');
    Route::post('/sampah/{type}/{id}/restore', [TrashController::class, 'restore'])->name('trash.restore');
    
    Route::get('/mahasiswa/create', [MahasiswaController::class, 'create'])->name('mahasiswa.create');
    Route::get('/mahasiswa/export', [CsvController::class, 'export'])->defaults('type', 'mahasiswa')->name('mahasiswa.export');
    Route::get('/mahasiswa/template', [CsvController::class, 'template'])->defaults('type', 'mahasiswa')->name('mahasiswa.template');
    Route::post('/mahasiswa/import', [CsvController::class, 'import'])->defaults('type', 'mahasiswa')->name('mahasiswa.import');
    Route::post('/mahasiswa', [MahasiswaController::class, 'store'])->name('mahasiswa.store');
    Route::get('/mahasiswa', [MahasiswaController::class, 'index'])->name('mahasiswa.index');
    
    // Route::get('/mahasiswa/{id}/download', [MahasiswaController::class, 'download'])->name('mahasiswa.download');
    // Route::get('/mahasiswa/{id}/download', [MahasiswaController::class, 'download'])
    //     ->middleware('auth') // biar aman, hanya user login
    //     ->name('mahasiswa.download');

    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    
    Route::get('/mahasiswa/{id}/pdf', [MahasiswaController::class, 'generatePdf'])
        ->name('mahasiswa.pdf');
    Route::get('/mahasiswa/{id}/pdf/download', [MahasiswaController::class, 'downloadPdf'])
        // ->middleware('auth') // opsional, biar aman hanya user login
        ->name('mahasiswa.downloadPdf');
    
    // Form edit
    Route::get('/mahasiswa/{id}/edit', [MahasiswaController::class, 'edit'])->name('mahasiswa.edit');
    
    // Proses update and delete
    Route::put('/mahasiswa/{id}', [MahasiswaController::class, 'update'])->name('mahasiswa.update');
    Route::delete('/mahasiswa/bulk-delete', [MahasiswaController::class, 'bulkDelete'])
    ->name('mahasiswa.bulkDelete');   
    Route::get('/mahasiswa/{id}', [MahasiswaController::class, 'show'])->name('mahasiswa.show');
    Route::get('/mahasiswa/{id}/document/{document}', [MahasiswaController::class, 'document'])
        ->name('mahasiswa.document');
    
    // make alumni
    Route::post('/mahasiswa/alumni', [MahasiswaController::class, 'jadikanAlumni'])
    ->name('mahasiswa.jadikanAlumni');
    
    // ROUTE ALUMNI
    // Tambahkan ini
    Route::get('/alumni', [AlumniController::class, 'index'])->name('alumni.index');
    Route::get('/alumni/create', [AlumniController::class, 'create'])->name('alumni.create');
    Route::get('/alumni/export', [CsvController::class, 'export'])->defaults('type', 'alumni')->name('alumni.export');
    Route::get('/alumni/template', [CsvController::class, 'template'])->defaults('type', 'alumni')->name('alumni.template');
    Route::post('/alumni/import', [CsvController::class, 'import'])->defaults('type', 'alumni')->name('alumni.import');
    Route::post('/alumni', [AlumniController::class, 'store'])->name('alumni.store');
    Route::delete('/alumni/bulk-delete', [AlumniController::class, 'bulkDelete'])
        ->name('alumni.bulkDelete');
        Route::get('/alumni/{id}/pdf', [AlumniController::class, 'generatePdf'])
        ->name('alumni.pdf');
    Route::get('/alumni/{id}/pdf/download', [AlumniController::class, 'downloadPdf'])
    // ->middleware('auth') // opsional, biar aman hanya user login
        ->name('alumni.downloadPdf');
    
    // Form edit
    Route::get('/alumni/{id}/edit', [AlumniController::class, 'edit'])->name('alumni.edit');
    
    // Proses update and delete
    Route::put('/alumni/{id}', [AlumniController::class, 'update'])->name('alumni.update');
    Route::get('/alumni/{id}', [AlumniController::class, 'show'])->name('alumni.show');
    
    // ROUTE ASESMEN UJIAN
    Route::get('/asesmen-ujian', [AsesmenUjianController::class, 'index'])->name('ujian.index');
    Route::get('/asesmen-ujian/create', [AsesmenUjianController::class, 'create'])->name('ujian.create');
    Route::post('/asesmen-ujian', [AsesmenUjianController::class, 'store'])->name('ujian.store');
    Route::get('/asesmen-ujian/{id}/pdf', [AsesmenUjianController::class, 'generatePdf'])
    ->name('asesmen_ujian.pdf');
    Route::get('/asesmen-ujian/{id}/pdf/download', [AsesmenUjianController::class, 'downloadPdf'])
    // ->middleware('auth') // opsional, biar aman hanya user login
    ->name('asesmen_ujian.downloadPdf');
    // Proses update and delete
    Route::put('/asesmen-ujian/{id}', [AsesmenUjianController::class, 'update'])->name('ujian.update');
    Route::get('/asesmen-ujian/{id}', [AsesmenUjianController::class, 'show'])->name('ujian.show');
    Route::delete('/asesmen-ujian/bulk-delete', [AsesmenUjianController::class, 'bulkDelete'])
        ->name('ujian.bulkDelete');
    // Form edit
    Route::get('/asesmen-ujian/{id}/edit', [AsesmenUjianController::class, 'edit'])->name('ujian.edit');
    
    // ROUTE TENDIK DOSEN
    Route::get('/dosen-tendik', [tendikController::class, 'index'])->name('tendik.index');
    Route::get('/dosen-tendik/create', [tendikController::class, 'create'])->name('tendik.create');
    Route::get('/dosen-tendik/export', [CsvController::class, 'export'])->defaults('type', 'tendik')->name('tendik.export');
    Route::get('/dosen-tendik/template', [CsvController::class, 'template'])->defaults('type', 'tendik')->name('tendik.template');
    Route::post('/dosen-tendik/import', [CsvController::class, 'import'])->defaults('type', 'tendik')->name('tendik.import');
    Route::post('/dosen-tendik', [tendikController::class, 'store'])->name('tendik.store');
    Route::get('/dosen-tendik/{id}/pdf', [tendikController::class, 'generatePdf'])
    ->name('tendik.pdf');
    Route::get('/dosen-tendik/{id}/pdf/download', [tendikController::class, 'downloadPdf'])
    // ->middleware('auth') // opsional, biar aman hanya user login
    ->name('tendik.downloadPdf');
    // Proses update and delete
    Route::put('/dosen-tendik/{id}', [tendikController::class, 'update'])->name('tendik.update');
    Route::get('/dosen-tendik/{id}', [tendikController::class, 'show'])->name('tendik.show');
    Route::get('/dosen-tendik/{id}/document/{document}', [tendikController::class, 'document'])->name('tendik.document');
    Route::delete('/dosen-tendik/bulk-delete', [tendikController::class, 'bulkDelete'])
        ->name('tendik.bulkDelete');
    // Form edit
    Route::get('/dosen-tendik/{id}/edit', [tendikController::class, 'edit'])->name('tendik.edit');
    Route::get('/tendik/{id}/edit', [tendikController::class, 'edit'])->name('tendik.edit.legacy');
    
});
