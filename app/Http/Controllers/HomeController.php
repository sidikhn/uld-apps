<?php

namespace App\Http\Controllers;

use App\Models\Alumni;
use App\Models\Mahasiswa;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        /*
        |--------------------------------------------------------------------------
        | STATISTIK UTAMA
        |--------------------------------------------------------------------------
        */

        $totalMahasiswa = Mahasiswa::count();
        $totalAlumni = Alumni::count();


        /*
        |--------------------------------------------------------------------------
        | AMBIL SELURUH DATA MAHASISWA
        |--------------------------------------------------------------------------
        |
        | ragam_disabilitas disimpan sebagai JSON oleh MahasiswaController.
        | Karena itu kita olah di PHP agar hasilnya konsisten.
        |
        */

        $mahasiswas = Mahasiswa::select(
            'id',
            'fakultas',
            'tahun_asesmen',
            'ragam_disabilitas'
        )->get();


        /*
        |--------------------------------------------------------------------------
        | HITUNG RAGAM DISABILITAS
        |--------------------------------------------------------------------------
        */

        $jumlahDisabilitas = [
            'Netra' => 0,
            'Rungu' => 0,
            'Mental' => 0,
            'Fisik' => 0,
            'Disabilitas Ganda' => 0,
            'Lainnya' => 0,
        ];

        foreach ($mahasiswas as $mahasiswa) {

            $ragam = $mahasiswa->ragam_disabilitas;

            /*
             * Jika Model Mahasiswa sudah memiliki cast array,
             * Laravel akan otomatis memberikan array.
             *
             * Jika belum, kita decode JSON secara manual.
             */
            if (is_string($ragam)) {
                $ragam = json_decode($ragam, true);
            }

            if (!is_array($ragam)) {
                $ragam = [];
            }

            /*
             * Pastikan setiap nilai berbentuk string.
             */
            $ragam = array_map(function ($item) {
                return strtolower(trim((string) $item));
            }, $ragam);

            /*
             * Kalau ada lebih dari satu ragam dasar,
             * MahasiswaController sebenarnya menyimpannya
             * sebagai "Disabilitas Ganda".
             */
            if (in_array('disabilitas ganda', $ragam, true)) {
                $jumlahDisabilitas['Disabilitas Ganda']++;
            } elseif (in_array('netra', $ragam, true)) {
                $jumlahDisabilitas['Netra']++;
            } elseif (in_array('rungu', $ragam, true)) {
                $jumlahDisabilitas['Rungu']++;
            } elseif (in_array('mental', $ragam, true)) {
                $jumlahDisabilitas['Mental']++;
            } elseif (in_array('fisik', $ragam, true)) {
                $jumlahDisabilitas['Fisik']++;
            } else {
                $jumlahDisabilitas['Lainnya']++;
            }
        }


        /*
        |--------------------------------------------------------------------------
        | BUAT COLLECTION UNTUK CHART
        |--------------------------------------------------------------------------
        */

        $disabilitasData = collect($jumlahDisabilitas)
            ->filter(function ($jumlah, $jenis) {

                /*
                 * "Lainnya" tidak perlu ditampilkan kalau memang
                 * tidak ada data lainnya.
                 */
                if ($jenis === 'Lainnya' && $jumlah === 0) {
                    return false;
                }

                return $jumlah > 0;
            })
            ->map(function ($jumlah, $jenis) {
                return (object) [
                    'ragam_disabilitas' => $jenis,
                    'jumlah' => (int) $jumlah,
                ];
            })
            ->values();


        /*
        |--------------------------------------------------------------------------
        | TOTAL JENIS DISABILITAS
        |--------------------------------------------------------------------------
        */

        $totalJenis = $disabilitasData->count();


        /*
        |--------------------------------------------------------------------------
        | DATA FAKULTAS
        |--------------------------------------------------------------------------
        */

        $dataFakultas = Mahasiswa::query()
            ->select(
                DB::raw("
                    COALESCE(
                        NULLIF(TRIM(fakultas), ''),
                        'Belum Diisi'
                    ) AS fakultas
                "),
                DB::raw('COUNT(*) AS jumlah')
            )
            ->groupBy(
                DB::raw("
                    COALESCE(
                        NULLIF(TRIM(fakultas), ''),
                        'Belum Diisi'
                    )
                ")
            )
            ->orderByDesc('jumlah')
            ->get()
            ->map(function ($item) {
                return (object) [
                    'fakultas' => $item->fakultas ?: 'Belum Diisi',
                    'jumlah' => (int) ($item->jumlah ?? 0),
                ];
            });


        /*
        |--------------------------------------------------------------------------
        | TOTAL FAKULTAS
        |--------------------------------------------------------------------------
        */

        $totalFakultas = Mahasiswa::query()
            ->whereNotNull('fakultas')
            ->whereRaw("TRIM(fakultas) != ''")
            ->distinct()
            ->count('fakultas');


        /*
        |--------------------------------------------------------------------------
        | DATA MAHASISWA PER TAHUN ASESMEN
        |--------------------------------------------------------------------------
        */

        $tahunData = Mahasiswa::query()
            ->select(
                'tahun_asesmen',
                DB::raw('COUNT(*) AS jumlah')
            )
            ->whereNotNull('tahun_asesmen')
            ->whereRaw("TRIM(CAST(tahun_asesmen AS CHAR)) != ''")
            ->groupBy('tahun_asesmen')
            ->orderBy('tahun_asesmen')
            ->get()
            ->map(function ($item) {
                return (object) [
                    'tahun_asesmen' => $item->tahun_asesmen ?: 'Tidak diketahui',
                    'jumlah' => (int) ($item->jumlah ?? 0),
                ];
            });


        /*
        |--------------------------------------------------------------------------
        | STACKED BAR: RAGAM DISABILITAS PER TAHUN
        |--------------------------------------------------------------------------
        */

        $jenisData = collect();

        $tahunGroups = $mahasiswas
            ->filter(function ($mahasiswa) {
                return !empty($mahasiswa->tahun_asesmen);
            })
            ->groupBy('tahun_asesmen');


        foreach ($tahunGroups as $tahun => $records) {

            $data = [
                'tahun_asesmen' => $tahun,
                'netra' => 0,
                'rungu' => 0,
                'mental' => 0,
                'fisik' => 0,
                'ganda' => 0,
            ];

            foreach ($records as $mahasiswa) {

                $ragam = $mahasiswa->ragam_disabilitas;

                if (is_string($ragam)) {
                    $ragam = json_decode($ragam, true);
                }

                if (!is_array($ragam)) {
                    $ragam = [];
                }

                $ragam = array_map(function ($item) {
                    return strtolower(trim((string) $item));
                }, $ragam);


                if (in_array('disabilitas ganda', $ragam, true)) {

                    $data['ganda']++;

                } elseif (in_array('netra', $ragam, true)) {

                    $data['netra']++;

                } elseif (in_array('rungu', $ragam, true)) {

                    $data['rungu']++;

                } elseif (in_array('mental', $ragam, true)) {

                    $data['mental']++;

                } elseif (in_array('fisik', $ragam, true)) {

                    $data['fisik']++;
                }
            }

            $jenisData->push((object) $data);
        }


        /*
        |--------------------------------------------------------------------------
        | DATA $DISABILITAS
        |--------------------------------------------------------------------------
        |
        | Tetap dikirim karena kemungkinan masih digunakan oleh Blade.
        |
        */

        $disabilitas = collect();

        foreach ($jumlahDisabilitas as $jenis => $jumlah) {
            $disabilitas->put(
                strtolower($jenis),
                (int) $jumlah
            );
        }


        /*
        |--------------------------------------------------------------------------
        | KIRIM KE DASHBOARD
        |--------------------------------------------------------------------------
        */

        return view('home', [
            'totalMahasiswa' => (int) $totalMahasiswa,
            'totalJenis' => (int) $totalJenis,
            'totalAlumni' => (int) $totalAlumni,
            'totalFakultas' => (int) $totalFakultas,

            'dataFakultas' => $dataFakultas,
            'tahunData' => $tahunData,
            'jenisData' => $jenisData,
            'disabilitasData' => $disabilitasData,
            'disabilitas' => $disabilitas,
        ]);
    }
}
