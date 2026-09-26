<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MahasiswaApiController extends Controller
{
    // List semua mahasiswa yang punya PDF
    public function index()
    {
        $data = Mahasiswa::whereNotNull('pdf_path')
            ->get(['id', 'nama', 'nim', 'pdf_path']);

        return response()->json([
            'status' => 'success',
            'count' => $data->count(),
            'data' => $data
        ]);
    }

    // Detail mahasiswa per id
    public function show($id)
    {
        $mhs = Mahasiswa::findOrFail($id);

        return response()->json([
            'status' => 'success',
            'data' => $mhs
        ]);
    }

    // Download file PDF dari private storage
    public function download($id)
    {
        $mhs = Mahasiswa::findOrFail($id);

        if (!$mhs->pdf_path || !Storage::exists($mhs->pdf_path)) {
            return response()->json([
                'status' => 'error',
                'message' => 'File tidak ditemukan'
            ], 404);
        }

        $filename = 'mahasiswa_' . preg_replace('/[\/\\\\]/', '-', $mhs->nim) . '.pdf';

        return Storage::download($mhs->pdf_path, $filename, [
            'Content-Type' => 'application/pdf'
        ]);
    }
}
