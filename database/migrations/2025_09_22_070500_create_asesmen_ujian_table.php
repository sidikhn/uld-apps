<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('asesmen_ujians', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('semester')->nullable();
            $table->string('jenis_kelamin')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->string('nim')->unique();
            $table->string('prodi')->nullable();
            $table->string('fakultas')->nullable();
            $table->string('ragam_disabilitas')->nullable();
            // $table->string('surat_keterangan_link');
            $table->text('keperluan_perpanjangan')->nullable();
            $table->text('pdf_path')->nullable();
            $table->string('alat_bantu')->nullable();
            $table->string('preferensi_format')->nullable();
            $table->string('keperluan_pendampingan')->nullable();
            $table->string('penyesuaian_lain')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asesmen_ujian');
    }
};
