<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Mahasiswa extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'nama',
        'jenis_kelamin',
        'tanggal_lahir',
        'nim',
        'angkatan',
        'tahun_asesmen',
        'pendidikan',
        'faculty_id',
        'study_program_id',
        'prodi',
        'fakultas',
        'nomor_hp',
        'beasiswa',
        'ragam_disabilitas',
        'ragam_pilihan',
        'subragam_disabilitas',
        'surat_keterangan',
        'ktp',
        'foto',
        'surat_keterangan_link',
        'detail_disabilitas',
        'alat_bantu',
        'kendala',
        'akomodasi',
        'pendampingan',
        'pdf_path',
    ];
    protected $casts = [
        'ragam_disabilitas' => 'array',
        'ragam_pilihan' => 'array',
        'subragam_disabilitas' => 'array',
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

    public function faculty()
    {
        return $this->belongsTo(Faculty::class);
    }

    public function studyProgram()
    {
        return $this->belongsTo(StudyProgram::class);
    }
}
