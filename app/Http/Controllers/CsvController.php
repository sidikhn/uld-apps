<?php

namespace App\Http\Controllers;

use App\Models\Alumni;
use App\Models\Mahasiswa;
use App\Models\Tendik;
use App\Services\NomorIndukUldService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;
use ZipArchive;

class CsvController extends Controller
{
    private const CONFIG = [
        'mahasiswa' => [
            'model' => Mahasiswa::class,
            'title' => 'Mahasiswa Aktif',
            'pdf_view' => 'mahasiswa.pdf',
            'fields' => ['nomor_induk_uld', 'nama', 'jenis_kelamin', 'tanggal_lahir', 'nim', 'angkatan', 'tahun_asesmen', 'pendidikan', 'faculty_id', 'study_program_id', 'nomor_hp', 'ragam_disabilitas', 'subragam_disabilitas', 'beasiswa'],
        ],
        'alumni' => [
            'model' => Alumni::class,
            'title' => 'Alumni Disabilitas',
            'pdf_view' => 'alumni.pdf',
            'fields' => ['nomor_induk_uld', 'nama', 'nim', 'alamat_domisili', 'email_aktif', 'nomor_hp', 'url_linkedin', 'ragam_disabilitas', 'aktivitas_saat_ini', 'waktu_mendapatkan_pekerjaan_bulan', 'waktu_mulai_mencari_pekerjaan_bulan', 'cara_mendapatkan_pekerjaan', 'jenis_institusi_pekerjaan', 'nama_tempat_kerja', 'alamat_tempat_kerja', 'kontak_tempat_kerja', 'posisi_pekerjaan', 'lama_bekerja', 'kendala_mencari_pekerjaan', 'jenjang_studi_lanjut', 'nama_prodi_studi_lanjut', 'institusi_studi_lanjut', 'lokasi_studi_lanjut', 'tanggal_mulai_studi_lanjut', 'tanggal_selesai_studi_lanjut'],
        ],
        'tendik' => [
            'model' => Tendik::class,
            'title' => 'Dosen & Tendik',
            'fields' => ['nama', 'tanggal_lahir', 'alamat', 'no_ktp', 'email', 'no_hp', 'nip_nika', 'jenis_pegawai', 'kategori_pegawai', 'unit_kerja', 'pangkat_golongan', 'ragam_disabilitas', 'detail_disabilitas', 'alat_bantu', 'kendala', 'akomodasi', 'pendampingan'],
        ],
    ];

    /**
     * Ekspor Data ke CSV.
     */
    public function export(string $type): StreamedResponse
    {
        $config = $this->config($type);
        $fields = $config['fields'];
        $model = $config['model'];

        return response()->streamDownload(function () use ($fields, $model) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, $fields);
            $model::query()->latest()->chunk(500, function ($items) use ($handle, $fields) {
                foreach ($items as $item) {
                    fputcsv($handle, array_map(fn ($field) => $this->csvValue($item->{$field}), $fields));
                }
            });
            fclose($handle);
        }, $type . '-data-' . date('Y-m-d') . '.csv', ['Content-Type' => 'text/csv; charset=UTF-8']);
    }

    /**
     * Ekspor Rekapitulasi Data Lengkap ke Dokumen PDF Resmi Landscape yang Rapi.
     */
    public function exportPdf(string $type)
    {
        $config = $this->config($type);
        $model = $config['model'];
        $title = $config['title'] ?? ucfirst($type);

        $items = $model::query()->orderBy('nama', 'asc')->get();

        $pdf = Pdf::loadView('reports.rekap_data_pdf', [
            'items' => $items,
            'title' => $title,
            'type'  => $type,
        ]);

        $pdf->setPaper('a4', 'landscape');

        $filename = 'Rekap_Data_' . str_replace(' ', '_', $title) . '_' . date('Y-m-d') . '.pdf';

        return $pdf->download($filename);
    }

    /**
     * Unduh Seluruh Berkas PDF Asesmen Individu dalam 1 Arsip ZIP.
     */
    public function downloadAllPdf(string $type)
    {
        $config = $this->config($type);
        $model = $config['model'];
        $title = $config['title'] ?? ucfirst($type);
        $pdfView = $config['pdf_view'] ?? ($type . '.pdf');

        $items = $model::query()->get();

        if ($items->isEmpty()) {
            return back()->with('error', 'Tidak ada data untuk diunduh berkas PDF-nya.');
        }

        // Buat temporary file zip
        $zipFileName = 'Semua_Berkas_PDF_' . str_replace(' ', '_', $title) . '_' . date('Y-m-d_His') . '.zip';
        $zipFilePath = storage_path('app/' . $zipFileName);

        $zip = new ZipArchive();
        if ($zip->open($zipFilePath, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) {
            return back()->with('error', 'Gagal membuat file ZIP di server.');
        }

        // Generate / kumpulkan setiap PDF asesmen mahasiswa
        foreach ($items as $item) {
            $nimClean = preg_replace('/[\/\\\\]/', '-', $item->nim);
            $namaClean = preg_replace('/[^a-zA-Z0-9_\-]/', '_', substr($item->nama, 0, 30));
            $pdfEntryName = "{$nimClean}_{$namaClean}.pdf";

            // Cek apakah sudah pernah tersimpan di disk
            $pdfContent = null;
            if ($item->pdf_path && Storage::disk('local')->exists($item->pdf_path)) {
                $pdfContent = Storage::disk('local')->get($item->pdf_path);
            } else {
                // Generate on-the-fly jika belum ada
                try {
                    $pdf = Pdf::loadView($pdfView, [$type => $item]);
                    $pdfContent = $pdf->output();

                    // Simpan ke storage jika mau
                    $pdfPath = "private/pdf_{$type}/" . $type . "_{$nimClean}.pdf";
                    Storage::disk('local')->put($pdfPath, $pdfContent);
                    $item->update(['pdf_path' => $pdfPath]);
                } catch (\Throwable $e) {
                    continue;
                }
            }

            if ($pdfContent) {
                $zip->addFromString($pdfEntryName, $pdfContent);
            }
        }

        $zip->close();

        return response()->download($zipFilePath)->deleteFileAfterSend(true);
    }

    public function template(string $type): StreamedResponse
    {
        $fields = $this->config($type)['fields'];
        return response()->streamDownload(function () use ($fields) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, $fields);
            fclose($handle);
        }, $type . '-template.csv', ['Content-Type' => 'text/csv; charset=UTF-8']);
    }

    public function import(Request $request, string $type)
    {
        $config = $this->config($type);
        $request->validate(['file' => ['required', 'file', 'mimes:csv,txt', 'max:10240']]);
        $handle = fopen($request->file('file')->getRealPath(), 'r');
        $headers = fgetcsv($handle);
        $fields = array_values(array_intersect($config['fields'], array_map('trim', $headers ?: [])));
        abort_if(!$fields, 422, 'Header CSV tidak sesuai template.');
        $count = 0;
        while (($row = fgetcsv($handle)) !== false) {
            if (count(array_filter($row, fn ($value) => trim((string) $value) !== '')) === 0) continue;
            $data = [];
            foreach ($headers as $index => $header) {
                if (in_array($header, $fields, true)) $data[$header] = $row[$index] ?? null;
            }
            foreach (['ragam_disabilitas', 'cara_mendapatkan_pekerjaan', 'kendala_mencari_pekerjaan'] as $field) {
                if (isset($data[$field]) && is_string($data[$field]) && str_starts_with(trim($data[$field]), '[')) {
                    $data[$field] = json_decode($data[$field], true) ?: [];
                }
            }
            if (in_array($type, ['mahasiswa', 'alumni']) && empty($data['nomor_induk_uld'])) {
                $year = $data['tahun_asesmen'] ?? ($data['angkatan'] ?? date('Y'));
                $data['nomor_induk_uld'] = NomorIndukUldService::generateNext((string) $year);
            }
            $config['model']::create($data);
            $count++;
        }
        fclose($handle);
        return back()->with('success', $count . ' data berhasil diimpor.');
    }

    private function config(string $type): array
    {
        abort_unless(isset(self::CONFIG[$type]), 404);
        return self::CONFIG[$type];
    }

    private function csvValue(mixed $value): string
    {
        return is_array($value) ? json_encode($value, JSON_UNESCAPED_UNICODE) : (string) ($value ?? '');
    }
}
