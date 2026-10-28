<?php

namespace App\Http\Controllers;

use App\Models\Alumni;
use App\Models\Mahasiswa;
use App\Models\Tendik;
use App\Services\NomorIndukUldService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Component\HttpFoundation\StreamedResponse;
use ZipArchive;

class CsvController extends Controller
{
    private const CONFIG = [
        'mahasiswa' => [
            'model' => Mahasiswa::class,
            'title' => 'Mahasiswa Disabilitas',
            'pdf_view' => 'mahasiswa.pdf',
            'columns' => [
                'nomor_induk_uld' => 'Nomor Induk ULD',
                'status' => 'Status',
                'nama' => 'Nama Mahasiswa',
                'jenis_kelamin' => 'Jenis Kelamin',
                'tanggal_lahir' => 'Tanggal Lahir',
                'nim' => 'NIM',
                'angkatan' => 'Angkatan',
                'tahun_asesmen' => 'Tahun Asesmen',
                'pendidikan' => 'Jenjang Pendidikan',
                'fakultas' => 'Fakultas',
                'prodi' => 'Program Studi',
                'nomor_hp' => 'Nomor HP/WA',
                'beasiswa' => 'Beasiswa',
                'ragam_disabilitas' => 'Ragam Disabilitas',
                'subragam_disabilitas' => 'Subragam Disabilitas',
                'detail_disabilitas' => 'Detail / Diagnosis Disabilitas',
                'alat_bantu' => 'Alat Bantu',
                'kendala' => 'Hambatan / Kendala Belajar',
                'akomodasi' => 'Kebutuhan Akomodasi',
                'pendampingan' => 'Kebutuhan Pendampingan',
            ],
            'fields' => ['nomor_induk_uld', 'status', 'nama', 'jenis_kelamin', 'tanggal_lahir', 'nim', 'angkatan', 'tahun_asesmen', 'pendidikan', 'faculty_id', 'study_program_id', 'nomor_hp', 'ragam_disabilitas', 'subragam_disabilitas', 'beasiswa'],
        ],
        'alumni' => [
            'model' => Alumni::class,
            'title' => 'Alumni Disabilitas',
            'pdf_view' => 'alumni.pdf',
            'columns' => [
                'nomor_induk_uld' => 'Nomor Induk ULD',
                'status' => 'Status',
                'nama' => 'Nama Alumni',
                'jenis_kelamin' => 'Jenis Kelamin',
                'tanggal_lahir' => 'Tanggal Lahir',
                'nim' => 'NIM',
                'angkatan' => 'Angkatan',
                'pendidikan' => 'Jenjang Pendidikan',
                'fakultas' => 'Fakultas',
                'prodi' => 'Program Studi',
                'nomor_hp' => 'Nomor HP/WA',
                'alamat_domisili' => 'Alamat Domisili',
                'email_aktif' => 'Email Aktif',
                'url_linkedin' => 'LinkedIn / Portfolio',
                'beasiswa' => 'Beasiswa Semasa Kuliah',
                'ragam_disabilitas' => 'Ragam Disabilitas',
                'subragam_disabilitas' => 'Subragam Disabilitas',
                'detail_disabilitas' => 'Detail Disabilitas',
                'alat_bantu' => 'Alat Bantu',
                'kendala' => 'Hambatan / Kendala',
                'akomodasi' => 'Kebutuhan Akomodasi',
                'pendampingan' => 'Kebutuhan Pendampingan',
                'aktivitas_saat_ini' => 'Aktivitas Saat Ini',
                'waktu_mulai_mencari_pekerjaan_bulan' => 'Mulai Mencari Kerja (Bulan)',
                'waktu_mendapatkan_pekerjaan_bulan' => 'Waktu Mendapatkan Kerja (Bulan)',
                'cara_mendapatkan_pekerjaan' => 'Cara Mendapatkan Pekerjaan',
                'jenis_institusi_pekerjaan' => 'Jenis Institusi Tempat Kerja',
                'nama_tempat_kerja' => 'Nama Tempat Kerja / Perusahaan',
                'posisi_pekerjaan' => 'Posisi / Jabatan',
                'lama_bekerja' => 'Lama Bekerja',
                'alamat_tempat_kerja' => 'Alamat Tempat Kerja',
                'kontak_tempat_kerja' => 'Kontak Tempat Kerja',
                'kendala_mencari_pekerjaan' => 'Kendala Mencari Pekerjaan',
                'jenjang_studi_lanjut' => 'Jenjang Studi Lanjut',
                'institusi_studi_lanjut' => 'Institusi / Kampus Studi Lanjut',
                'nama_prodi_studi_lanjut' => 'Program Studi Studi Lanjut',
                'lokasi_studi_lanjut' => 'Lokasi Studi Lanjut',
                'tanggal_mulai_studi_lanjut' => 'Mulai Studi Lanjut',
                'tanggal_selesai_studi_lanjut' => 'Selesai Studi Lanjut',
            ],
            'fields' => ['nomor_induk_uld', 'status', 'nama', 'nim', 'alamat_domisili', 'email_aktif', 'nomor_hp', 'url_linkedin', 'ragam_disabilitas', 'aktivitas_saat_ini', 'waktu_mendapatkan_pekerjaan_bulan', 'waktu_mulai_mencari_pekerjaan_bulan', 'cara_mendapatkan_pekerjaan', 'jenis_institusi_pekerjaan', 'nama_tempat_kerja', 'alamat_tempat_kerja', 'kontak_tempat_kerja', 'posisi_pekerjaan', 'lama_bekerja', 'kendala_mencari_pekerjaan', 'jenjang_studi_lanjut', 'nama_prodi_studi_lanjut', 'institusi_studi_lanjut', 'lokasi_studi_lanjut', 'tanggal_mulai_studi_lanjut', 'tanggal_selesai_studi_lanjut'],
        ],
        'tendik' => [
            'model' => Tendik::class,
            'title' => 'Dosen & Tenaga Kependidikan',
            'columns' => [
                'nama' => 'Nama Lengkap',
                'jenis_kelamin' => 'Jenis Kelamin',
                'tanggal_lahir' => 'Tanggal Lahir',
                'no_ktp' => 'No KTP / NIK',
                'email' => 'Email',
                'no_hp' => 'Nomor HP/WA',
                'alamat' => 'Alamat',
                'nip_nika' => 'NIP / NIKA',
                'jenis_pegawai' => 'Jenis Pegawai',
                'kategori_pegawai' => 'Kategori Pegawai',
                'unit_kerja' => 'Unit Kerja / Fakultas',
                'pangkat_golongan' => 'Pangkat / Golongan',
                'ragam_disabilitas' => 'Ragam Disabilitas',
                'detail_disabilitas' => 'Detail Disabilitas',
                'alat_bantu' => 'Alat Bantu',
                'kendala' => 'Kendala Kerja',
                'akomodasi' => 'Kebutuhan Akomodasi',
                'pendampingan' => 'Kebutuhan Pendampingan',
            ],
            'fields' => ['nama', 'tanggal_lahir', 'alamat', 'no_ktp', 'email', 'no_hp', 'nip_nika', 'jenis_pegawai', 'kategori_pegawai', 'unit_kerja', 'pangkat_golongan', 'ragam_disabilitas', 'detail_disabilitas', 'alat_bantu', 'kendala', 'akomodasi', 'pendampingan'],
        ],
    ];

    /**
     * Ekspor Data Lengkap ke Excel (.xlsx) dengan nama Fakultas/Prodi, data asesmen, styling profesional.
     */
    public function export(string $type): StreamedResponse
    {
        $config = $this->config($type);
        $columns = $config['columns'] ?? array_combine($config['fields'], array_map(fn($f) => ucwords(str_replace('_', ' ', $f)), $config['fields']));
        $model = $config['model'];
        $title = $config['title'] ?? ucfirst($type);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle(substr($title, 0, 31));

        $headerLabels = array_values($columns);
        $keys = array_keys($columns);

        // Baris Header
        $sheet->fromArray([$headerLabels], null, 'A1');

        $totalCols = count($headerLabels);
        $lastCol = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($totalCols);
        $headerRange = "A1:{$lastCol}1";

        $sheet->getStyle($headerRange)->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
                'size' => 10,
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '1B4E71'],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
                'wrapText' => true,
            ],
        ]);
        $sheet->getRowDimension(1)->setRowHeight(30);

        // Ambil data dengan eager loading relasi jika mahasiswa
        $query = $model::query();
        if ($type === 'mahasiswa') {
            $query->with(['faculty', 'studyProgram']);
        }
        $items = $query->latest()->get();

        $rows = [];
        foreach ($items as $item) {
            $row = [];
            foreach ($keys as $key) {
                $val = '';
                if ($key === 'fakultas') {
                    $val = $item->faculty?->name ?? $item->fakultas ?? '';
                } elseif ($key === 'prodi') {
                    $val = $item->studyProgram?->name ?? $item->prodi ?? '';
                } elseif ($key === 'subragam_disabilitas') {
                    $val = method_exists($item, 'getSubragamFormattedAttribute') ? $item->subragam_formatted : '';
                    if ($val === '-') {
                        $val = '';
                    }
                } elseif ($key === 'ragam_disabilitas') {
                    $raw = $item->ragam_disabilitas;
                    $val = is_array($raw) ? implode(', ', array_filter(array_map('trim', $raw))) : (string)($raw ?? '');
                } else {
                    $raw = $item->{$key} ?? null;
                    if (is_array($raw)) {
                        $val = implode(', ', array_filter(array_map('trim', $raw)));
                    } else {
                        $val = (string)($raw ?? '');
                    }
                }
                $row[] = $val;
            }
            $rows[] = $row;
        }

        if (!empty($rows)) {
            $sheet->fromArray($rows, null, 'A2');
            $lastRow = count($rows) + 1;

            $sheet->getStyle("A1:{$lastCol}{$lastRow}")->applyFromArray([
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['rgb' => 'CBD5E1'],
                    ],
                ],
            ]);

            $sheet->getStyle("A2:{$lastCol}{$lastRow}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        }

        // Auto size columns dengan batas wajar
        foreach (range(1, $totalCols) as $colIndex) {
            $colLetter = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIndex);
            $sheet->getColumnDimension($colLetter)->setAutoSize(true);
        }

        $filename = 'Data_Lengkap_' . str_replace(' ', '_', $title) . '_' . date('Y-m-d') . '.xlsx';

        return response()->streamDownload(function () use ($spreadsheet) {
            $writer = new Xlsx($spreadsheet);
            $writer->save('php://output');
        }, $filename, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Cache-Control' => 'max-age=0',
        ]);
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
