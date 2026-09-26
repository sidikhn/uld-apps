<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        foreach (['alumnis', 'tendiks'] as $tableName) {
            if (Schema::hasColumn($tableName, 'surat_keterangan_link')) {
                Schema::table($tableName, function (Blueprint $table) use ($tableName) {
                    $table->string('surat_keterangan_link')->nullable()->change();
                });
            }
        }
    }

    public function down(): void
    {
        foreach (['alumnis', 'tendiks'] as $tableName) {
            if (Schema::hasColumn($tableName, 'surat_keterangan_link')) {
                Schema::table($tableName, function (Blueprint $table) use ($tableName) {
                    $table->string('surat_keterangan_link')->nullable(false)->change();
                });
            }
        }
    }
};