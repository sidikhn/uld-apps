<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AsesmenUjian extends Model
{
    use SoftDeletes;
    // protected $fillable = [
    //     'nama', 'semester', 'jenis_kelamin', 'tanggal_lahir', 'nim', 'angkatan',
    //     'pendidikan', 'prodi', 'fakultas', 'nomor_hp', 'beasiswa',
    //     'ragam_disabilitas', 'detail_disabilitas', 'alat_bantu', 'kendala',
    //     'akomodasi', 'pendampingan','surat_keterangan_link', 
    // ];
    protected $fillable = [
    'nama',
    'jenis_kelamin',  
    'tanggal_lahir',  
    'nim',
    'prodi',
    'fakultas',
    'ragam_disabilitas',
    'semester',
    'keperluan_perpanjangan',
    'alat_bantu',
    'preferensi_format',
    'keperluan_pendampingan',
    'penyesuaian_lain',
    'pdf_path',
];

}
