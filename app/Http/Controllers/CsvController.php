<?php

namespace App\Http\Controllers;

use App\Models\Alumni;
use App\Models\Mahasiswa;
use App\Models\Tendik;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class CsvController extends Controller
{
    private const CONFIG = [
        'mahasiswa' => [
            'model' => Mahasiswa::class,
            'fields' => ['nama', 'jenis_kelamin', 'tanggal_lahir', 'nim', 'angkatan', 'tahun_asesmen', 'pendidikan', 'faculty_id', 'study_program_id', 'nomor_hp', 'ragam_disabilitas', 'subragam_disabilitas', 'beasiswa'],
        ],
        'alumni' => [
            'model' => Alumni::class,
            'fields' => ['nama', 'nim', 'alamat_domisili', 'email_aktif', 'nomor_hp', 'url_linkedin', 'ragam_disabilitas', 'aktivitas_saat_ini', 'waktu_mendapatkan_pekerjaan_bulan', 'waktu_mulai_mencari_pekerjaan_bulan', 'cara_mendapatkan_pekerjaan', 'jenis_institusi_pekerjaan', 'nama_tempat_kerja', 'alamat_tempat_kerja', 'kontak_tempat_kerja', 'posisi_pekerjaan', 'lama_bekerja', 'kendala_mencari_pekerjaan', 'jenjang_studi_lanjut', 'nama_prodi_studi_lanjut', 'institusi_studi_lanjut', 'lokasi_studi_lanjut', 'tanggal_mulai_studi_lanjut', 'tanggal_selesai_studi_lanjut'],
        ],
        'tendik' => [
            'model' => Tendik::class,
            'fields' => ['nama', 'tanggal_lahir', 'alamat', 'no_ktp', 'email', 'no_hp', 'nip_nika', 'jenis_pegawai', 'kategori_pegawai', 'unit_kerja', 'pangkat_golongan', 'ragam_disabilitas', 'detail_disabilitas', 'alat_bantu', 'kendala', 'akomodasi', 'pendampingan'],
        ],
    ];

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
        }, $type . '-data.csv', ['Content-Type' => 'text/csv; charset=UTF-8']);
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
