<?php

namespace Database\Seeders;

use App\Models\Alumni;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AlumniSeeder extends Seeder
{
    public function run(): void
    {
        $filePath = base_path('SHARE SIDIK_KEPERLUAN AUDIENSI DTI_DATA TERBARUU.xlsx - Alumni.csv');
        if (!file_exists($filePath)) {
            $filePath = database_path('seeders/dataalumni.csv');
        }

        if (!file_exists($filePath)) {
            $this->command->error("❌ File CSV data alumni tidak ditemukan!");
            return;
        }

        $handle = fopen($filePath, 'r');
        if (!$handle) {
            $this->command->error("❌ Gagal membuka file CSV alumni!");
            return;
        }

        // Baca baris header
        $line1 = fgetcsv($handle);
        if ($line1 && stripos($line1[0] ?? '', 'Mahasiswa Disabilitas Aktif') !== false) {
            fgetcsv($handle); // Lewati baris header kolom
        }

        $updated = 0;
        $created = 0;

        DB::beginTransaction();
        try {
            while (($row = fgetcsv($handle)) !== false) {
                if (count($row) < 11 || empty($row[1])) {
                    continue;
                }

                $nama         = trim($row[1] ?? '');
                $fakultas     = trim($row[2] ?? '');
                $prodi        = trim($row[3] ?? '');
                $jenisRaw     = trim($row[4] ?? '');
                $subragamRaw  = trim($row[5] ?? '');
                $alatBantuRaw = trim($row[6] ?? '');
                $jenjang      = trim($row[7] ?? '');
                $angkatan     = trim($row[8] ?? '');
                $jk           = trim($row[9] ?? '');
                $nim          = trim($row[10] ?? '');
                $catatan      = isset($row[11]) ? trim($row[11]) : '';

                if (empty($nama) || empty($nim)) {
                    continue;
                }

                // Normalisasi Ragam & Subragam Disabilitas
                $ragamFinal    = [];
                $ragamPilihan  = [];
                $subragamFinal = [];

                if (stripos($jenisRaw, 'Ganda') !== false) {
                    $ragamFinal   = ['Disabilitas Ganda'];
                    $ragamPilihan = ['Fisik', 'Rungu'];
                    $subragamFinal = [
                        'Fisik' => 'Fisik',
                        'Rungu' => $subragamRaw ?: 'Rungu',
                    ];
                } elseif (stripos($jenisRaw, 'Netra') !== false) {
                    $ragamFinal    = ['Netra'];
                    $ragamPilihan  = ['Netra'];
                    $subragamFinal = ['Netra' => $subragamRaw ?: 'Netra'];
                } elseif (stripos($jenisRaw, 'Mental') !== false) {
                    $ragamFinal    = ['Mental'];
                    $ragamPilihan  = ['Mental'];
                    $subragamFinal = ['Mental' => $subragamRaw ?: 'Mental'];
                } elseif (stripos($jenisRaw, 'Rungu') !== false || stripos($jenisRaw, 'Tuli') !== false) {
                    $ragamFinal    = ['Rungu'];
                    $ragamPilihan  = ['Rungu'];
                    $subragamFinal = ['Rungu' => $subragamRaw ?: 'Rungu'];
                } else {
                    $ragamFinal    = ['Fisik'];
                    $ragamPilihan  = ['Fisik'];
                    $subragamFinal = ['Fisik' => $subragamRaw ?: 'Fisik'];
                }

                // Normalisasi Alat Bantu
                $alatBantu = null;
                if ($alatBantuRaw !== '' && $alatBantuRaw !== '-') {
                    $alatBantu = $alatBantuRaw;
                }

                // Cari data alumni berdasarkan NIM (atau nama jika NIM generik)
                $alumni = Alumni::withTrashed()->where('nim', $nim)->first();
                if (!$alumni && !empty($nama)) {
                    $alumni = Alumni::withTrashed()->where('nama', $nama)->first();
                }

                if ($alumni) {
                    if ($alumni->trashed()) {
                        $alumni->restore();
                    }

                    $updateData = [];

                    // Selalu perbarui ragam & subragam disabilitas jika di CSV tersedia
                    if (!empty($ragamFinal)) {
                        $updateData['ragam_disabilitas']    = $ragamFinal;
                        $updateData['ragam_pilihan']        = $ragamPilihan;
                        $updateData['subragam_disabilitas'] = $subragamFinal;
                    }

                    // Perbarui alat bantu jika di CSV memiliki nilai nyata, atau jika di DB masih kosong
                    if ($alatBantu !== null) {
                        $updateData['alat_bantu'] = $alatBantu;
                    } elseif (empty($alumni->alat_bantu)) {
                        $updateData['alat_bantu'] = null;
                    }

                    // Lengkapi data identitas jika sebelumnya kosong
                    if (empty($alumni->fakultas) && !empty($fakultas)) {
                        $updateData['fakultas'] = $fakultas;
                    }
                    if (empty($alumni->prodi) && !empty($prodi)) {
                        $updateData['prodi'] = $prodi;
                    }
                    if (empty($alumni->pendidikan) && !empty($jenjang)) {
                        $updateData['pendidikan'] = $jenjang;
                    }
                    if (empty($alumni->angkatan) && !empty($angkatan)) {
                        $updateData['angkatan'] = $angkatan;
                    }
                    if (empty($alumni->jenis_kelamin) && !empty($jk)) {
                        $updateData['jenis_kelamin'] = $jk;
                    }

                    // Jika ada catatan status (misal "Meninggal Dunia", "Mengundurkan diri")
                    if (!empty($catatan) && empty($alumni->detail_disabilitas)) {
                        $updateData['detail_disabilitas'] = $catatan;
                    }

                    $alumni->update($updateData);
                    $updated++;
                } else {
                    Alumni::create([
                        'nama'                 => $nama,
                        'nim'                  => $nim,
                        'fakultas'             => $fakultas,
                        'prodi'                => $prodi,
                        'pendidikan'           => $jenjang,
                        'angkatan'             => $angkatan,
                        'jenis_kelamin'        => $jk ?: null,
                        'ragam_disabilitas'    => $ragamFinal,
                        'ragam_pilihan'        => $ragamPilihan,
                        'subragam_disabilitas' => $subragamFinal,
                        'alat_bantu'           => $alatBantu,
                        'detail_disabilitas'   => $catatan ?: null,
                        'perlu_update'         => true,
                    ]);
                    $created++;
                }
            }

            DB::commit();
            fclose($handle);

            $this->command->info("✅ Berhasil memproses data alumni! Diperbarui: {$updated}, Dibuat baru: {$created}");
        } catch (\Throwable $e) {
            DB::rollBack();
            fclose($handle);
            $this->command->error("❌ Gagal memproses data alumni: " . $e->getMessage());
            throw $e;
        }
    }
}
