<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        foreach (['alumnis', 'tendiks'] as $tableName) {
            if (Schema::hasColumn($tableName, 'surat_keterangan_link')) {
                DB::statement("ALTER TABLE `{$tableName}` MODIFY `surat_keterangan_link` VARCHAR(255) NULL");
            }
        }
    }

    public function down(): void
    {
        foreach (['alumnis', 'tendiks'] as $tableName) {
            if (Schema::hasColumn($tableName, 'surat_keterangan_link')) {
                DB::statement("ALTER TABLE `{$tableName}` MODIFY `surat_keterangan_link` VARCHAR(255) NOT NULL");
            }
        }
    }
};
