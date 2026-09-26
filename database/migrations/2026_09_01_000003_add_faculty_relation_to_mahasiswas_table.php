<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('mahasiswas', function (Blueprint $table) {
            if (!Schema::hasColumn('mahasiswas', 'faculty_id')) {
                $table->foreignId('faculty_id')->nullable()->after('pendidikan')->constrained('faculties')->nullOnDelete();
            }

            if (!Schema::hasColumn('mahasiswas', 'study_program_id')) {
                $table->foreignId('study_program_id')->nullable()->after('faculty_id')->constrained('study_programs')->nullOnDelete();
            }
        });
    }

    public function down(): void
    {
        Schema::table('mahasiswas', function (Blueprint $table) {
            if (Schema::hasColumn('mahasiswas', 'study_program_id')) {
                $table->dropConstrainedForeignId('study_program_id');
            }

            if (Schema::hasColumn('mahasiswas', 'faculty_id')) {
                $table->dropConstrainedForeignId('faculty_id');
            }
        });
    }
};
