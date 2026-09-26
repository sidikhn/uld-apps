<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('alumnis', function (Blueprint $table) {
            $table->text('ragam_disabilitas')->nullable()->change();
            $table->string('surat_keterangan_link')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('alumnis', function (Blueprint $table) {
            $table->string('ragam_disabilitas')->nullable()->change();
            $table->string('surat_keterangan_link')->nullable(false)->change();
        });
    }
};
