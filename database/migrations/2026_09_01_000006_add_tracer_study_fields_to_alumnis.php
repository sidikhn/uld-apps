<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('alumnis', function (Blueprint $table) {
            $table->text('alamat_domisili')->nullable();
            $table->string('email_aktif')->nullable();
            $table->string('url_linkedin')->nullable();
            $table->string('aktivitas_saat_ini')->nullable();
            $table->integer('waktu_mendapatkan_pekerjaan_bulan')->nullable();
            $table->integer('waktu_mulai_mencari_pekerjaan_bulan')->nullable();
            $table->json('cara_mendapatkan_pekerjaan')->nullable();
            $table->text('cara_mendapatkan_pekerjaan_lainnya')->nullable();
            $table->string('jenis_institusi_pekerjaan')->nullable();
            $table->text('jenis_institusi_pekerjaan_lainnya')->nullable();
            $table->string('nama_tempat_kerja')->nullable();
            $table->text('alamat_tempat_kerja')->nullable();
            $table->string('kontak_tempat_kerja')->nullable();
            $table->string('posisi_pekerjaan')->nullable();
            $table->text('posisi_pekerjaan_lainnya')->nullable();
            $table->string('lama_bekerja')->nullable();
            $table->json('kendala_mencari_pekerjaan')->nullable();
            $table->text('kendala_mencari_pekerjaan_lainnya')->nullable();
            $table->string('jenjang_studi_lanjut')->nullable();
            $table->string('nama_prodi_studi_lanjut')->nullable();
            $table->string('institusi_studi_lanjut')->nullable();
            $table->string('lokasi_studi_lanjut')->nullable();
            $table->date('tanggal_mulai_studi_lanjut')->nullable();
            $table->date('tanggal_selesai_studi_lanjut')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('alumnis', function (Blueprint $table) {
            $table->dropColumn([
                'alamat_domisili', 'email_aktif', 'url_linkedin', 'aktivitas_saat_ini',
                'waktu_mendapatkan_pekerjaan_bulan', 'waktu_mulai_mencari_pekerjaan_bulan',
                'cara_mendapatkan_pekerjaan', 'cara_mendapatkan_pekerjaan_lainnya',
                'jenis_institusi_pekerjaan', 'jenis_institusi_pekerjaan_lainnya',
                'nama_tempat_kerja', 'alamat_tempat_kerja', 'kontak_tempat_kerja',
                'posisi_pekerjaan', 'posisi_pekerjaan_lainnya', 'lama_bekerja',
                'kendala_mencari_pekerjaan', 'kendala_mencari_pekerjaan_lainnya',
                'jenjang_studi_lanjut', 'nama_prodi_studi_lanjut', 'institusi_studi_lanjut',
                'lokasi_studi_lanjut', 'tanggal_mulai_studi_lanjut', 'tanggal_selesai_studi_lanjut',
            ]);
        });
    }
};
