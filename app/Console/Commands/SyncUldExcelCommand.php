<?php

namespace App\Console\Commands;

use App\Models\Alumni;
use App\Models\Mahasiswa;
use App\Services\NomorIndukUldService;
use Illuminate\Console\Command;
use ZipArchive;

class SyncUldExcelCommand extends Command
{
    protected $signature = 'uld:sync-excel {--file= : Path ke file excel}';
    protected $description = 'Sinkronisasi Nomor Induk ULD dari file Excel ke database Mahasiswa dan Alumni';

    public function handle()
    {
        $file = $this->option('file') ?: base_path('dataexcel/SHARE SIDIK_KEPERLUAN AUDIENSI DTI_DATA TERBARUU.xlsx');

        if (!file_exists($file)) {
            $this->error("File tidak ditemukan: {$file}");
            return 1;
        }

        $this->info("Membaca file excel: {$file}");

        $zip = new ZipArchive();
        if ($zip->open($file) !== true) {
            $this->error("Gagal membuka file Excel sebagai zip archive.");
            return 1;
        }

        $stringsXml = simplexml_load_string($zip->getFromName('xl/sharedStrings.xml'));
        $strings = [];
        foreach ($stringsXml->si as $val) {
            $strings[] = (string)($val->t ?? ($val->r ? $val->r->t : ''));
        }

        $aktifData = $this->getSheetRows($zip, 'xl/worksheets/sheet1.xml', $strings);
        $alumniData = $this->getSheetRows($zip, 'xl/worksheets/sheet2.xml', $strings);
        $zip->close();

        $this->info("Menyinkronkan data Mahasiswa Aktif...");
        $mhsUpdated = $this->syncAktif($aktifData);
        $this->info("Mahasiswa Aktif disinkronkan: {$mhsUpdated} baris.");

        $this->info("Menyinkronkan data Alumni...");
        $alumniUpdated = $this->syncAlumni($alumniData);
        $this->info("Alumni disinkronkan: {$alumniUpdated} baris.");

        // Backfill data lain yang masih belum punya Nomor Induk ULD
        $this->info("Memeriksa sisa data yang belum memiliki Nomor Induk ULD...");
        $backfillMhs = 0;
        foreach (Mahasiswa::whereNull('nomor_induk_uld')->orWhere('nomor_induk_uld', '')->get() as $mhs) {
            $year = $mhs->tahun_asesmen ?: ($mhs->angkatan ?: date('Y'));
            $mhs->update(['nomor_induk_uld' => NomorIndukUldService::generateNext((string) $year)]);
            $backfillMhs++;
        }

        $backfillAlumni = 0;
        foreach (Alumni::whereNull('nomor_induk_uld')->orWhere('nomor_induk_uld', '')->get() as $alumni) {
            $year = $alumni->angkatan ?: date('Y');
            $alumni->update(['nomor_induk_uld' => NomorIndukUldService::generateNext((string) $year)]);
            $backfillAlumni++;
        }

        $this->info("Selesai! Backfill Mahasiswa: {$backfillMhs}, Backfill Alumni: {$backfillAlumni}.");
        return 0;
    }

    private function getSheetRows(ZipArchive $zip, string $path, array $strings): array
    {
        $content = $zip->getFromName($path);
        if (!$content) return [];

        $sheetXml = simplexml_load_string($content);
        $rows = $sheetXml->sheetData->row;
        $data = [];
        foreach ($rows as $row) {
            $cols = [];
            foreach ($row->c as $c) {
                $v = (string)$c->v;
                $cols[] = ((string)$c['t'] === 's') ? ($strings[(int)$v] ?? '') : $v;
            }
            $data[] = $cols;
        }
        return $data;
    }

    private function cleanNim(?string $nim): string
    {
        return preg_replace('/[^0-9a-zA-Z]/', '', (string)$nim);
    }

    private function syncAktif(array $rows): int
    {
        if (count($rows) < 2) return 0;
        $headers = $rows[1] ?? [];
        $uldIdx = 5;
        $nimIdx = 12;
        $namaIdx = 2;

        foreach ($headers as $idx => $header) {
            $h = trim($header);
            if (strcasecmp($h, 'Nomor Induk ULD') === 0) $uldIdx = $idx;
            if (strcasecmp($h, 'NIM') === 0) $nimIdx = $idx;
            if (strcasecmp($h, 'Nama Lengkap') === 0) $namaIdx = $idx;
        }

        $count = 0;
        for ($i = 2; $i < count($rows); $i++) {
            $uld = trim($rows[$i][$uldIdx] ?? '');
            $nim = trim($rows[$i][$nimIdx] ?? '');
            $nama = trim($rows[$i][$namaIdx] ?? '');

            if (!$uld) continue;

            $mhs = null;
            if ($nim) {
                $mhs = Mahasiswa::where('nim', $nim)->first();
                if (!$mhs) {
                    $clean = $this->cleanNim($nim);
                    $mhs = Mahasiswa::whereRaw("REPLACE(REPLACE(REPLACE(nim, '/', ''), ' ', ''), '-', '') = ?", [$clean])->first();
                }
            }
            if (!$mhs && $nama) {
                $mhs = Mahasiswa::where('nama', $nama)->first();
                if (!$mhs) {
                    $mhs = Mahasiswa::where('nama', 'like', "%{$nama}%")->first();
                }
            }

            if ($mhs) {
                $mhs->update(['nomor_induk_uld' => $uld]);
                $count++;
            }
        }
        return $count;
    }

    private function syncAlumni(array $rows): int
    {
        if (count($rows) < 2) return 0;
        $headers = $rows[1] ?? [];
        $uldIdx = 4;
        $nimIdx = 11;
        $namaIdx = 1;

        foreach ($headers as $idx => $header) {
            $h = trim($header);
            if (strcasecmp($h, 'Nomor Induk ULD') === 0) $uldIdx = $idx;
            if (strcasecmp($h, 'NIM') === 0) $nimIdx = $idx;
            if (strcasecmp($h, 'Nama Lengkap') === 0) $namaIdx = $idx;
        }

        $count = 0;
        for ($i = 2; $i < count($rows); $i++) {
            $uld = trim($rows[$i][$uldIdx] ?? '');
            $nim = trim($rows[$i][$nimIdx] ?? '');
            $nama = trim($rows[$i][$namaIdx] ?? '');

            if (!$uld) continue;

            $alumni = null;
            if ($nim) {
                $clean = $this->cleanNim($nim);
                $alumni = Alumni::whereRaw("REPLACE(REPLACE(nim, '/', ''), ' ', '') = ?", [$clean])->first();
            }
            if (!$alumni && $nama) {
                $alumni = Alumni::where('nama', 'like', "%{$nama}%")->first();
            }

            if ($alumni) {
                $alumni->update(['nomor_induk_uld' => $uld]);
                $count++;
            }
        }
        return $count;
    }
}
