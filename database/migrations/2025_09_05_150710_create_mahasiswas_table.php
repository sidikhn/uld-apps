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
        Schema::create('mahasiswas', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('jenis_kelamin');
            $table->date('tanggal_lahir')->nullable();
            $table->string('nim')->unique();
            $table->string('prodi')->nullable();
            $table->string('fakultas');
            $table->string('pendidikan');
            $table->string('angkatan');
            $table->string('nomor_hp')->nullable();
            $table->string('beasiswa')->nullable();
            $table->string('ragam_disabilitas');
            $table->string('surat_keterangan_link');
            $table->string('surat_keterangan')->nullable();
            $table->text('detail_disabilitas')->nullable();
            $table->text('alat_bantu')->nullable();
            $table->text('kendala')->nullable();
            $table->text('akomodasi')->nullable();
            $table->text('pendampingan')->nullable();
            $table->string('pdf_path')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mahasiswas');
    }
};