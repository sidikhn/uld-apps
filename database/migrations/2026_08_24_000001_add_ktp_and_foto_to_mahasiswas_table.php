<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('mahasiswas', 'ktp')) {
            Schema::table('mahasiswas', function (Blueprint $table) {
                $table->string('ktp')->nullable();
            });
        }

        if (!Schema::hasColumn('mahasiswas', 'foto')) {
            Schema::table('mahasiswas', function (Blueprint $table) {
                $table->string('foto')->nullable();
            });
        }
    }

    public function down(): void
    {
        foreach (['ktp', 'foto'] as $column) {
            if (Schema::hasColumn('mahasiswas', $column)) {
                Schema::table('mahasiswas', function (Blueprint $table) use ($column) {
                    $table->dropColumn($column);
                });
            }
        }
    }
};