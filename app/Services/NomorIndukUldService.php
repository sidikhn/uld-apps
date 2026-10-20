<?php

namespace App\Services;

use App\Models\Alumni;
use App\Models\Mahasiswa;

class NomorIndukUldService
{
    /**
     * Generate Nomor Induk ULD berikutnya untuk tahun yang ditentukan.
     * Format: ULD/{YYYY}/{000001}
     */
    public static function generateNext(?string $year = null): string
    {
        $year = $year ?: date('Y');
        $prefix = "ULD/{$year}/";

        // Ambil semua nomor induk ULD pada tahun terkait dari kedua tabel
        $mhsUld = Mahasiswa::withTrashed()
            ->where('nomor_induk_uld', 'like', "{$prefix}%")
            ->pluck('nomor_induk_uld')
            ->toArray();

        $alumniUld = Alumni::withTrashed()
            ->where('nomor_induk_uld', 'like', "{$prefix}%")
            ->pluck('nomor_induk_uld')
            ->toArray();

        $allUld = array_unique(array_merge($mhsUld, $alumniUld));

        $maxNumber = 0;
        foreach ($allUld as $uld) {
            $parts = explode('/', trim($uld));
            if (count($parts) === 3 && is_numeric($parts[2])) {
                $num = (int) $parts[2];
                if ($num > $maxNumber) {
                    $maxNumber = $num;
                }
            }
        }

        $nextNumber = $maxNumber + 1;
        return $prefix . sprintf('%06d', $nextNumber);
    }

    /**
     * Validasi format Nomor Induk ULD.
     */
    public static function isValid(?string $uld): bool
    {
        if (empty($uld)) {
            return false;
        }

        return (bool) preg_match('/^ULD\/\d{4}\/\d{6}$/', trim($uld));
    }
}
