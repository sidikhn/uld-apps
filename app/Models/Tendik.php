<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tendik extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'nama', 'jenis_kelamin', 'tanggal_lahir', 'alamat', 'no_ktp', 'email', 'no_hp',
        'nip_nika', 'jenis_pegawai', 'kategori_pegawai', 'unit_kerja', 'ktp',
        'surat_keterangan',
        'pangkat_golongan', 'ragam_disabilitas', 'detail_disabilitas',
        'alat_bantu', 'kendala', 'akomodasi', 'pendampingan', 'pdf_path',
        'surat_keterangan_link',
    ];

    protected $casts = [
        'ragam_disabilitas' => 'array',
        'tanggal_lahir' => 'date:Y-m-d',
    ];
}
