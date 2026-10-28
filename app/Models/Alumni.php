<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Alumni extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'nomor_induk_uld', 'status', 'nama', 'jenis_kelamin', 'tanggal_lahir', 'nim', 'angkatan',
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

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($alumni) {
            // Jika status secara manual disetel ke meninggal atau mengundurkan_diri, pertahankan status tersebut
            if (in_array($alumni->status, ['meninggal', 'mengundurkan_diri'])) {
                return;
            }

            // Otomatisasi status berdasarkan data aktivitas / studi lanjut / bekerja
            $activity = strtoupper(trim((string) $alumni->aktivitas_saat_ini));

            if ($activity === 'B7' || !empty($alumni->jenjang_studi_lanjut) || !empty($alumni->nama_prodi_studi_lanjut) || !empty($alumni->institusi_studi_lanjut)) {
                $alumni->status = 'lulus_studi_lanjut';
            } elseif (in_array($activity, ['B1', 'B3']) || !empty($alumni->nama_tempat_kerja) || !empty($alumni->posisi_pekerjaan)) {
                $alumni->status = 'lulus_bekerja';
            } elseif (in_array($activity, ['B2', 'B4', 'B5'])) {
                $alumni->status = 'lulus_mencari_kerja';
            } elseif (empty($alumni->status)) {
                $alumni->status = 'lulus';
            }
        });
    }

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

    public function mahasiswaAktif()
    {
        return $this->hasOne(Mahasiswa::class, 'nomor_induk_uld', 'nomor_induk_uld');
    }

    /**
     * Mengambil riwayat kelulusan jenjang lain dari alumni yang sama (berdasarkan nomor_induk_uld).
     */
    public function alumniLain()
    {
        return $this->hasMany(Alumni::class, 'nomor_induk_uld', 'nomor_induk_uld')
            ->where('id', '!=', $this->id)
            ->orderBy('created_at', 'asc');
    }
}
