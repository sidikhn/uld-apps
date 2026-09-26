<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Ubah dari Schema::table menjadi Schema::create
        Schema::create('tendiks', function (Blueprint $table) {
            $table->id();
            
            // Identitas Utama
            $table->string('nama');
            $table->string('jenis_kelamin');
            $table->date('tanggal_lahir');
            $table->string('no_ktp', 32);
            $table->string('email');
            $table->string('no_hp', 30);
            $table->text('alamat');
            $table->string('nip_nika', 50)->unique();
            $table->string('jenis_pegawai');
            $table->string('kategori_pegawai');
            $table->string('unit_kerja');
            $table->string('pangkat_golongan')->nullable();

            // Disabilitas & Kebutuhan
            $table->text('ragam_disabilitas');
            $table->text('detail_disabilitas');
            $table->text('alat_bantu')->nullable();
            $table->text('kendala');
            $table->text('akomodasi');
            $table->text('pendampingan')->nullable();

            // Dokumen Pendukung & PDF Output
            $table->string('ktp')->nullable();
            $table->string('surat_keterangan')->nullable();
            $table->string('pdf_path')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tendiks');
    }
};