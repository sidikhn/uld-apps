<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('mahasiswas', function (Blueprint $table) {
            // Tambahkan kolom ktp jika belum ada
            if (!Schema::hasColumn('mahasiswas', 'ktp')) {
                $table->string('ktp')->nullable()->after('nomor_hp');
            }
            
            // Tambahkan kolom foto jika belum ada
            if (!Schema::hasColumn('mahasiswas', 'foto')) {
                $table->string('foto')->nullable()->after('ktp');
            }

            // Hapus kolom link lama jika memang ada
            if (Schema::hasColumn('mahasiswas', 'surat_keterangan_link')) {
                $table->dropColumn('surat_keterangan_link');
            }
        });
    }

    public function down(): void
    {
        Schema::table('mahasiswas', function (Blueprint $table) {
            if (Schema::hasColumn('mahasiswas', 'ktp')) {
                $table->dropColumn('ktp');
            }
            if (Schema::hasColumn('mahasiswas', 'foto')) {
                $table->dropColumn('foto');
            }
            
            if (!Schema::hasColumn('mahasiswas', 'surat_keterangan_link')) {
                $table->string('surat_keterangan_link')->nullable();
            }
        });
    }
};