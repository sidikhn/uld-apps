<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('alumnis', function (Blueprint $table) {
            // Mengubah tipe kolom menjadi TEXT
            $table->text('kendala')->nullable()->change();
            $table->text('detail_disabilitas')->nullable()->change();
            $table->text('akomodasi')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('alumnis', function (Blueprint $table) {
            $table->string('kendala')->nullable()->change();
            $table->string('detail_disabilitas')->nullable()->change();
            $table->string('akomodasi')->nullable()->change();
        });
    }
};