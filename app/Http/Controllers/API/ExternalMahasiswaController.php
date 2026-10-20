<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Alumni;
use App\Models\Mahasiswa;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ExternalMahasiswaController extends Controller
{
    /**
     * Helper untuk membersihkan NIM (trim spasi).
     */
    protected function cleanNim(?string $nim): string
    {
        return trim((string) $nim);
    }

    /**
     * Endpoint 1: Batch / Multi Cek Status Disabilitas
     * Menerima daftar array NIM dan mengembalikan status apakah terdaftar di ULD.
     * 
     * Request JSON: { "nims": ["21/123/TK/11", "20/456/EK/22"] }
     */
    public function checkBatchStatus(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'nims'   => 'required|array|min:1|max:500',
            'nims.*' => 'required|string',
        ]);

        $inputNims = array_values(array_unique(array_map([$this, 'cleanNim'], $validated['nims'])));

        // Cari di Mahasiswa Aktif
        $mhsList = Mahasiswa::whereIn('nim', $inputNims)
            ->get(['nim', 'nomor_induk_uld', 'nama', 'ragam_disabilitas'])
            ->keyBy('nim');

        // Cari juga di Alumni jika tidak ditemukan di mahasiswa aktif
        $foundMhsNims = $mhsList->keys()->toArray();
        $remainingNims = array_diff($inputNims, $foundMhsNims);

        $alumniList = collect();
        if (!empty($remainingNims)) {
            $alumniList = Alumni::whereIn('nim', $remainingNims)
                ->get(['nim', 'nomor_induk_uld', 'nama', 'ragam_disabilitas'])
                ->keyBy('nim');
        }

        $results = [];
        foreach ($inputNims as $nim) {
            $isMhs = $mhsList->get($nim);
            $isAlumni = $alumniList->get($nim);
            $record = $isMhs ?: $isAlumni;

            if ($record) {
                $ragam = $record->ragam_disabilitas;
                if (is_string($ragam)) {
                    $ragam = array_filter(array_map('trim', explode(',', $ragam)));
                }

                $results[] = [
                    'nim'             => $nim,
                    'is_disabilitas'  => true,
                    'status_kuliah'   => $isMhs ? 'aktif' : 'alumni',
                    'nomor_induk_uld' => $record->nomor_induk_uld,
                    'ragam_disabilitas' => (array) $ragam,
                ];
            } else {
                $results[] = [
                    'nim'            => $nim,
                    'is_disabilitas' => false,
                ];
            }
        }

        return response()->json([
            'status' => 'success',
            'total'  => count($results),
            'data'   => $results,
        ]);
    }

    /**
     * Endpoint 2: Cek Single Status Disabilitas via Query Param / Path
     * GET /api/v1/external/mahasiswa/check?nim=...
     */
    public function checkSingleStatus(Request $request): JsonResponse
    {
        $nim = $this->cleanNim($request->query('nim'));

        if (empty($nim)) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Parameter nim wajib diisi. Contoh: ?nim=20/461191/EK/23147',
            ], 422);
        }

        $mhs = Mahasiswa::where('nim', $nim)->first();
        $isAlumni = false;

        if (!$mhs) {
            $mhs = Alumni::where('nim', $nim)->first();
            $isAlumni = true;
        }

        if (!$mhs) {
            return response()->json([
                'status' => 'success',
                'data'   => [
                    'nim'            => $nim,
                    'is_disabilitas' => false,
                ],
            ]);
        }

        $ragam = $mhs->ragam_disabilitas;
        if (is_string($ragam)) {
            $ragam = array_filter(array_map('trim', explode(',', $ragam)));
        }

        return response()->json([
            'status' => 'success',
            'data'   => [
                'nim'               => $mhs->nim,
                'is_disabilitas'    => true,
                'status_kuliah'     => $isAlumni ? 'alumni' : 'aktif',
                'nomor_induk_uld'   => $mhs->nomor_induk_uld,
                'ragam_disabilitas' => (array) $ragam,
            ],
        ]);
    }

    /**
     * Endpoint 3a: Detail dengan query param ?nim=...
     * GET /api/v1/external/mahasiswa/detail?nim=...
     */
    public function detailWithQuery(Request $request): JsonResponse
    {
        $nim = $request->query('nim');
        if (empty($nim)) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Parameter query nim wajib disertakan. Contoh: ?nim=20/461191/EK/23147',
            ], 422);
        }

        return $this->detail($request, (string) $nim);
    }

    /**
     * Endpoint 3: Detail Informasi Disabilitas Mahasiswa (Ketika ikon disabilitas diklik)
     * Hanya mengembalikan informasi akademis & akomodasi, tanpa dokumen/rekam medis rahasia.
     * 
     * GET /api/v1/external/mahasiswa/detail/{nim}
     */
    public function detail(Request $request, string $nim): JsonResponse
    {
        $nim = $this->cleanNim(urldecode($nim));

        $mhs = Mahasiswa::where('nim', $nim)->first();
        $statusKuliah = 'aktif';

        if (!$mhs) {
            $mhs = Alumni::where('nim', $nim)->first();
            $statusKuliah = 'alumni';
        }

        if (!$mhs) {
            return response()->json([
                'status'  => 'error',
                'message' => "Data mahasiswa dengan NIM '{$nim}' tidak terdaftar di Unit Layanan Disabilitas (ULD).",
            ], 404);
        }

        // Parse ragam & subragam dengan rapi
        $ragam = $mhs->ragam_disabilitas;
        if (is_string($ragam)) {
            $ragam = array_filter(array_map('trim', explode(',', $ragam)));
        }

        $subragam = $mhs->subragam_disabilitas;
        if (is_string($subragam)) {
            $decoded = json_decode($subragam, true);
            $subragam = is_array($decoded) ? $decoded : $subragam;
        }

        return response()->json([
            'status' => 'success',
            'data'   => [
                'nomor_induk_uld' => $mhs->nomor_induk_uld,
                'nim'             => $mhs->nim,
                'nama'            => $mhs->nama,
                'status_kuliah'   => $statusKuliah,
                'fakultas'        => $mhs->fakultas,
                'prodi'           => $mhs->prodi,
                'pendidikan'      => $mhs->pendidikan,
                'angkatan'        => $mhs->angkatan,
                'disabilitas'     => [
                    'ragam'                  => (array) $ragam,
                    'subragam'               => $subragam,
                    'alat_bantu'             => $mhs->alat_bantu ?: null,
                    'kebutuhan_akomodasi'    => $mhs->akomodasi ?: null,
                    'kebutuhan_pendampingan' => $mhs->pendampingan ?: null,
                ],
            ],
        ]);
    }
}
