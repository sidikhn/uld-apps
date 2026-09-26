<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // database/migrations/xxxx_xx_xx_create_alumnis_table.php
public function up()
    {
        Schema::create('alumnis', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('jenis_kelamin')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->string('nim')->unique();
            $table->string('angkatan')->nullable();
            $table->string('pendidikan')->nullable();
            $table->string('prodi')->nullable();
            $table->string('fakultas')->nullable();
            $table->string('nomor_hp')->nullable();
            $table->string('beasiswa')->nullable();
            $table->string('ragam_disabilitas')->nullable();
            $table->string('surat_keterangan_link');
            $table->text('detail_disabilitas')->nullable();
            $table->string('alat_bantu')->nullable();
            $table->string('kendala')->nullable();
            $table->string('akomodasi')->nullable();
            $table->string('pendampingan')->nullable();
            $table->string('pdf_path')->nullable();
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alumnis');
    }
};
