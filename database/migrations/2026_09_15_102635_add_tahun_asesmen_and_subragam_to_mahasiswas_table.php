<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('mahasiswas', function (Blueprint $table) {
            $table->string('tahun_asesmen', 10)->nullable()->after('angkatan');
            $table->text('ragam_pilihan')->nullable()->after('ragam_disabilitas');
            $table->text('subragam_disabilitas')->nullable()->after('ragam_pilihan');
        });

        // Migrasi dan normalisasi data lama jika ada
        $records = DB::table('mahasiswas')->get();
        foreach ($records as $r) {
            $tahunAsesmen = $r->tahun_asesmen ?: ($r->angkatan ?: date('Y', strtotime($r->created_at ?? 'now')));
            $ragamRaw = (string) $r->ragam_disabilitas;
            $text = strtolower($r->detail_disabilitas ?? '');

            $finalRagam = ['Fisik'];
            $ragamPilihan = ['Fisik'];
            $subragam = [];

            if (str_contains($ragamRaw, 'Sensorik')) {
                if (str_contains($text, 'netra') || str_contains($text, 'vision') || str_contains($text, 'blind')) {
                    $finalRagam = ['Netra'];
                    $ragamPilihan = ['Netra'];
                    $subragam = ['Netra' => str_contains($text, 'low vision') ? 'Low Vision' : 'Buta Total (Totally Blind)'];
                } else {
                    $finalRagam = ['Rungu'];
                    $ragamPilihan = ['Rungu'];
                    $subragam = ['Rungu' => 'Tuli (Deaf)'];
                }
            } elseif (str_contains($ragamRaw, 'Fisik')) {
                $finalRagam = ['Fisik'];
                $ragamPilihan = ['Fisik'];
                $subragam = ['Fisik' => 'Paraplegia'];
            } elseif (str_contains($ragamRaw, 'Mental')) {
                $finalRagam = ['Mental'];
                $ragamPilihan = ['Mental'];
                $subragam = ['Mental' => 'Bipolar'];
            } elseif (str_contains($ragamRaw, 'Ganda')) {
                $finalRagam = ['Disabilitas Ganda'];
                $ragamPilihan = ['Fisik', 'Mental'];
                $subragam = ['Fisik' => 'Paraplegia'];
            } elseif (str_contains($ragamRaw, 'Netra')) {
                $finalRagam = ['Netra'];
                $ragamPilihan = ['Netra'];
                $subragam = ['Netra' => 'Low Vision'];
            } elseif (str_contains($ragamRaw, 'Rungu')) {
                $finalRagam = ['Rungu'];
                $ragamPilihan = ['Rungu'];
                $subragam = ['Rungu' => 'Tuli (Deaf)'];
            }

            DB::table('mahasiswas')->where('id', $r->id)->update([
                'tahun_asesmen' => $tahunAsesmen,
                'ragam_disabilitas' => json_encode($finalRagam, JSON_UNESCAPED_UNICODE),
                'ragam_pilihan' => json_encode($ragamPilihan, JSON_UNESCAPED_UNICODE),
                'subragam_disabilitas' => json_encode($subragam, JSON_UNESCAPED_UNICODE),
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mahasiswas', function (Blueprint $table) {
            $table->dropColumn(['tahun_asesmen', 'ragam_pilihan', 'subragam_disabilitas']);
        });
    }
};
