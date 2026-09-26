<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Alumni extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'nama', 'jenis_kelamin', 'tanggal_lahir', 'nim', 'angkatan',
        'pendidikan', 'prodi', 'fakultas', 'nomor_hp', 'beasiswa',
        'ragam_disabilitas', 'ragam_pilihan', 'subragam_disabilitas',
        'detail_disabilitas', 'alat_bantu', 'kendala',
        'akomodasi', 'pendampingan', 'pdf_path', 'surat_keterangan_link',
        'alamat_domisili', 'email_aktif', 'url_linkedin', 'aktivitas_saat_ini',
        'waktu_mendapatkan_pekerjaan_bulan', 'waktu_mulai_mencari_pekerjaan_bulan',
        'cara_mendapatkan_pekerjaan', 'cara_mendapatkan_pekerjaan_lainnya',
        'jenis_institusi_pekerjaan', 'jenis_institusi_pekerjaan_lainnya',
        'nama_tempat_kerja', 'alamat_tempat_kerja', 'kontak_tempat_kerja',
        'posisi_pekerjaan', 'posisi_pekerjaan_lainnya', 'lama_bekerja',
        'kendala_mencari_pekerjaan', 'kendala_mencari_pekerjaan_lainnya',
        'jenjang_studi_lanjut', 'nama_prodi_studi_lanjut', 'institusi_studi_lanjut',
        'lokasi_studi_lanjut', 'tanggal_mulai_studi_lanjut', 'tanggal_selesai_studi_lanjut',
        'perlu_update',
    ];

    protected $casts = [
        'ragam_disabilitas' => 'array',
        'ragam_pilihan' => 'array',
        'subragam_disabilitas' => 'array',
        'cara_mendapatkan_pekerjaan' => 'array',
        'kendala_mencari_pekerjaan' => 'array',
        'perlu_update' => 'boolean',
    ];

    public function getSubragamFormattedAttribute(): string
    {
        $sub = $this->subragam_disabilitas;
        if (empty($sub)) {
            return '-';
        }
        if (is_string($sub)) {
            $decoded = json_decode($sub, true);
            if (is_array($decoded)) {
                $sub = $decoded;
            } else {
                return $sub;
            }
        }
        if (is_array($sub)) {
            $parts = [];
            foreach ($sub as $k => $v) {
                if (!empty($v)) {
                    $parts[] = is_numeric($k) ? $v : "$k: $v";
                }
            }
            return count($parts) > 0 ? implode(', ', $parts) : '-';
        }
        return '-';
    }
}
