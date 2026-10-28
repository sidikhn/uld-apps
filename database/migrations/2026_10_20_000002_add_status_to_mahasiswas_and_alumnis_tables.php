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
        Schema::table('mahasiswas', function (Blueprint $table) {
            if (!Schema::hasColumn('mahasiswas', 'status')) {
                // Status mahasiswa: aktif, cuti, meninggal, mengundurkan_diri
                $table->string('status')->default('aktif')->after('nomor_induk_uld');
            }
        });

        Schema::table('alumnis', function (Blueprint $table) {
            if (!Schema::hasColumn('alumnis', 'status')) {
                // Status alumni: lulus (default), meninggal
                $table->string('status')->default('lulus')->after('nomor_induk_uld');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mahasiswas', function (Blueprint $table) {
            if (Schema::hasColumn('mahasiswas', 'status')) {
                $table->dropColumn('status');
            }
        });

        Schema::table('alumnis', function (Blueprint $table) {
            if (Schema::hasColumn('alumnis', 'status')) {
                $table->dropColumn('status');
            }
        });
    }
};
