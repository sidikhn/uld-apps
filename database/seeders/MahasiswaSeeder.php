<?php

namespace Database\Seeders;

use App\Models\Faculty;
use App\Models\Mahasiswa;
use App\Models\StudyProgram;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MahasiswaSeeder extends Seeder
{
    public function run(): void
    {
        $filePath = base_path('SHARE SIDIK_KEPERLUAN AUDIENSI DTI_DATA TERBARUU.xlsx - Aktif.csv');
        if (!file_exists($filePath)) {
            $filePath = database_path('seeders/datamahasiswa.csv');
        }

        if (!file_exists($filePath)) {
            $this->command->error("❌ File CSV data mahasiswa tidak ditemukan!");
            return;
        }

        $facultyMap = [
            'Biologi' => 'Fakultas Biologi',
            'Ekonomika dan Bisnis' => 'Fakultas Ekonomi dan Bisnis',
            'Filsafat' => 'Fakultas Filsafat',
            'Geografi' => 'Fakultas Geografi',
            'Hukum' => 'Fakultas Hukum',
            'Ilmu Budaya' => 'Fakultas Ilmu Budaya',
            'Ilmu Sosial dan Politik' => 'Fakultas Ilmu Sosial dan Ilmu Politik',
            'Kedokteran Gigi' => 'Fakultas Kedokteran Gigi',
            'Kedokteran Kesehatan Masyarakat dan Keperawatan' => 'Fakultas Kedokteran, Kesehatan Masyarakat, dan Keperawatan',
            'Kehutanan' => 'Fakultas Kehutanan',
            'Matemetika dan Ilmu Pengetahuan Alam' => 'Fakultas Matematika dan Ilmu Pengetahuan Alam',
            'Pertanian' => 'Fakultas Pertanian',
            'Peternakan' => 'Fakultas Peternakan',
            'Psikologi' => 'Fakultas Psikologi',
            'S1 Sosiologi' => 'Fakultas Ilmu Sosial dan Ilmu Politik',
            'Sekolah Pascasarjana' => 'Sekolah Pascasarjana',
            'Sekolah Vokasi' => 'Sekolah Vokasi',
            'Teknik' => 'Fakultas Teknik',
            'Teknologi Pertanian' => 'Fakultas Teknologi Pertanian',
        ];

        $prodiAlias = [
            'Magister Ekonomi Pembangunan' => 'Magister Ekonomika Pembangunan',
            'Bahasa dan Sastra Prancis' => 'Sastra Perancis',
            'Magister Ilmu Pemerintahan' => 'Magister Politik dan Pemerintahan',
            'Magister Administrasi Publik' => 'Magister Ilmu Administrasi Publik',
            'Magister Sistem Teknik Transportasi' => 'Magister Sistem dan Teknik Transportasi',
            'Bahasa, Sastra, dan Budaya Jawa' => 'Sastra Jawa',
            'Magister Kepemimpinan dan Inovasi Kebijakan' => 'Magister Kepemimpindan dan Inovasi Kebijakan',
            'Magister Kesehatan Masyarakat' => 'Magister Ilmu Kesehatan Masyarakat',
            'Pembangunan dan Komunikasi Pembangunan' => 'Magister Penyuluhan dan Komunikasi Pembangunan',
            'Magister Ilmu Sejarah' => 'Magister Sejarah',
            'Doktor Ilmu Teknik Pertanian' => 'Doktor Ilmu Teknik Pertanian',
            'Rekam Medis' => 'Pengelolaan Arsip dan Rekaman Informasi',
        ];

        $handle = fopen($filePath, 'r');
        if (!$handle) {
            $this->command->error("❌ Gagal membuka file CSV!");
            return;
        }

        // Header lines check
        $line1 = fgetcsv($handle);
        // If line 1 is title "Mahasiswa Disabilitas Aktif", read line 2 as column header
        if ($line1 && stripos($line1[0] ?? '', 'Mahasiswa Disabilitas Aktif') !== false) {
            fgetcsv($handle);
        }

        $count = 0;
        $updated = 0;

        DB::beginTransaction();
        try {
            while (($row = fgetcsv($handle)) !== false) {
                if (count($row) < 12) {
                    continue;
                }

                $tahunAsesmen = trim($row[1] ?? '');
                $nama = trim($row[2] ?? '');
                $fakStr = trim($row[3] ?? '');
                $prodiStr = trim($row[4] ?? '');
                $jenisRaw = trim($row[5] ?? '');
                $subragamRaw = trim($row[6] ?? '');
                $alatBantu = trim($row[7] ?? '');
                $jenjang = trim($row[8] ?? '');
                $angkatan = trim($row[9] ?? '');
                $jk = trim($row[10] ?? '');
                $nim = trim($row[11] ?? '');
                $kondisi = trim($row[12] ?? '');
                $kesulitan = trim($row[13] ?? '');
                $kebutuhan = trim($row[14] ?? '');

                if (empty($nama) || empty($nim)) {
                    continue;
                }

                // Faculty lookup
                $officialFacName = $facultyMap[$fakStr] ?? $fakStr;
                $faculty = Faculty::where('name', $officialFacName)->first();
                if (!$faculty) {
                    $faculty = Faculty::where('name', 'LIKE', '%' . $fakStr . '%')->first();
                }

                // Study Program lookup
                $targetProdi = $prodiAlias[$prodiStr] ?? $prodiStr;
                $studyProgram = null;
                if ($faculty) {
                    $studyProgram = StudyProgram::where('faculty_id', $faculty->id)
                        ->where('name', $targetProdi)
                        ->first();

                    if (!$studyProgram) {
                        $studyProgram = StudyProgram::where('faculty_id', $faculty->id)
                            ->where('name', 'LIKE', '%' . $prodiStr . '%')
                            ->first();
                    }

                    if (!$studyProgram && !empty($prodiStr)) {
                        $studyProgram = StudyProgram::create([
                            'faculty_id' => $faculty->id,
                            'name' => $prodiStr,
                        ]);
                    }
                }

                // Disability classification
                $ragamFinal = [];
                $ragamPilihan = [];
                $subragamFinal = [];

                if (stripos($jenisRaw, 'Ganda') !== false) {
                    $ragamFinal = ['Disabilitas Ganda'];
                    $ragamPilihan = ['Fisik', 'Rungu'];
                    $subragamFinal = [
                        'Fisik' => 'Fisik (Cerebral Palsy)',
                        'Rungu' => 'Hard of Hearing'
                    ];
                } elseif (stripos($jenisRaw, 'Auditory') !== false || stripos($jenisRaw, 'Rungu') !== false) {
                    $ragamFinal = ['Rungu'];
                    $ragamPilihan = ['Rungu'];
                    $subragamFinal = ['Rungu' => $subragamRaw ?: 'Rungu'];
                } elseif (stripos($jenisRaw, 'Netra') !== false) {
                    $ragamFinal = ['Netra'];
                    $ragamPilihan = ['Netra'];
                    $subragamFinal = ['Netra' => $subragamRaw ?: 'Netra'];
                } elseif (stripos($jenisRaw, 'Mental') !== false) {
                    $ragamFinal = ['Mental'];
                    $ragamPilihan = ['Mental'];
                    $subragamFinal = ['Mental' => $subragamRaw ?: 'Mental'];
                } else {
                    $ragamFinal = ['Fisik'];
                    $ragamPilihan = ['Fisik'];
                    $subragamFinal = ['Fisik' => $subragamRaw ?: 'Fisik'];
                }

                $mahasiswaData = [
                    'nama'                 => $nama,
                    'nim'                  => $nim,
                    'jenis_kelamin'        => $jk ?: null,
                    'angkatan'             => $angkatan,
                    'pendidikan'           => $jenjang,
                    'tahun_asesmen'        => $tahunAsesmen ?: $angkatan,
                    'fakultas'             => $faculty ? $faculty->name : $fakStr,
                    'prodi'                => $studyProgram ? $studyProgram->name : $prodiStr,
                    'faculty_id'           => $faculty?->id,
                    'study_program_id'     => $studyProgram?->id,
                    'ragam_disabilitas'    => $ragamFinal,
                    'ragam_pilihan'        => $ragamPilihan,
                    'subragam_disabilitas' => $subragamFinal,
                    'detail_disabilitas'   => $kondisi ?: null,
                    'alat_bantu'           => $alatBantu ?: null,
                    'kendala'              => $kesulitan ?: null,
                    'akomodasi'            => $kebutuhan ?: null,
                ];

                $existing = Mahasiswa::withTrashed()->where('nim', $nim)->first();
                if ($existing) {
                    if ($existing->trashed()) {
                        $existing->restore();
                    }
                    $existing->update($mahasiswaData);
                    $updated++;
                } else {
                    Mahasiswa::create($mahasiswaData);
                    $count++;
                }
            }

            DB::commit();
            fclose($handle);

            $this->command->info("✅ Berhasil mengimpor {$count} data mahasiswa baru (diperbarui: {$updated})!");
        } catch (\Throwable $e) {
            DB::rollBack();
            fclose($handle);
            $this->command->error("❌ Terjadi kesalahan saat impor data: " . $e->getMessage());
            throw $e;
        }
    }
}