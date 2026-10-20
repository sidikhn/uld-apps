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
            if (!Schema::hasColumn('mahasiswas', 'nomor_induk_uld')) {
                $table->string('nomor_induk_uld', 50)->nullable()->after('id')->index();
            }
        });

        Schema::table('alumnis', function (Blueprint $table) {
            if (!Schema::hasColumn('alumnis', 'nomor_induk_uld')) {
                $table->string('nomor_induk_uld', 50)->nullable()->after('id')->index();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mahasiswas', function (Blueprint $table) {
            if (Schema::hasColumn('mahasiswas', 'nomor_induk_uld')) {
                $table->dropIndex(['nomor_induk_uld']);
                $table->dropColumn('nomor_induk_uld');
            }
        });

        Schema::table('alumnis', function (Blueprint $table) {
            if (Schema::hasColumn('alumnis', 'nomor_induk_uld')) {
                $table->dropIndex(['nomor_induk_uld']);
                $table->dropColumn('nomor_induk_uld');
            }
        });
    }
};
