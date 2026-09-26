<?php

namespace App\Http\Controllers;

use App\Models\AsesmenUjian;
use App\Models\Mahasiswa;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\QueryException;


class AsesmenUjianController extends Controller
{
    public function index(Request $request)
    {
        $asesmen_ujians = AsesmenUjian::all();

        // Ambil nilai semester dari request (kalau ada)
        $semester = $request->input('semester');
        // Query data
        $query = AsesmenUjian::query();
        if (!empty($semester)) {
            $query->where('semester', $semester);
        }
        $data = $query->latest()->paginate(10);

        return view('ujian.index', compact( 'data', 'semester'));
    }

    public function create()
    {
        $mahasiswas = Mahasiswa::select('id', 'nama', 'jenis_kelamin', 'tanggal_lahir', 'nim', 'prodi', 'fakultas', 'ragam_disabilitas')->get();
        return view('ujian.create',compact('mahasiswas'));
    }
    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'nama' => 'required|string|max:255',
            'nim' => 'required|string|max:20',
        ]);

        $data = $request->all();

        try {
            $asesmen_ujian = AsesmenUjian::create($data);
        } catch (QueryException $e) {

            if ($e->errorInfo[1] == 1062) {
                return redirect()->route('ujian.index')
                    ->with('error', 'Data dengan NIM tersebut sudah tersimpan sebelumnya.');
            }

            throw $e;
        }

        // Generate PDF
        $pdf = Pdf::loadView('ujian.pdf', compact('asesmen_ujian'));

        $pdfFilename = 'asesmen_ujian_' . preg_replace('/[\/\\\\]/', '-', $asesmen_ujian->nim) . '.pdf';
        $pdfPath = 'private/pdf_asesmen_ujian/' . $pdfFilename;

        Storage::put($pdfPath, $pdf->output());

        $asesmen_ujian->update(['pdf_path' => $pdfPath]);

        return redirect()->route('ujian.index')
            ->with('success', 'Data asesmen ujian mahasiswa berhasil ditambahkan!');
    }

    public function download($id)
    {
        $asesmen_ujian = AsesmenUjian::findOrFail($id);

        if (!$asesmen_ujian->surat_keterangan) {
            return redirect()->back()->with('error', 'File tidak tersedia.');
        }

        $filePath = storage_path('app/private/surat_keterangan/' . $asesmen_ujian->surat_keterangan);

        if (!file_exists($filePath)) {
            return redirect()->back()->with('error', 'File tidak ditemukan.');
        }

        return response()->download($filePath, $asesmen_ujian->surat_keterangan);
    }
    public function generatePdf($id)
    {
        $asesmen_ujian = AsesmenUjian::findOrFail($id);

        $pdf = Pdf::loadView('ujian.pdf', compact('asesmen_ujian'));
        
        $filename = 'asesmen_ujian_' . preg_replace('/[\/\\\\]/', '-', $asesmen_ujian->nim) . '.pdf';

        return $pdf->download($filename);

    }
    public function downloadPdf($id)
    {
        $asesmen_ujian = AsesmenUjian::findOrFail($id);

        if (!$asesmen_ujian->pdf_path) {
            return back()->with('error', 'File PDF belum tersedia.');
        }

        $filePath = storage_path('app/' . $asesmen_ujian->pdf_path);

        if (!file_exists($filePath)) {
            return back()->with('error', 'File tidak ditemukan di server.');
        }

        $filename = 'asesmen_ujian_' . preg_replace('/[\/\\\\]/', '-', $asesmen_ujian->nim) . '.pdf';

        return response()->download($filePath, $filename, [
            'Content-Type' => 'application/pdf',
        ]);
    }
    public function bulkDelete(Request $request)
    {
        $ids = explode(",", $request->ids);

        AsesmenUjian::whereIn('id', $ids)->delete();

        return redirect()->route('ujian.index')->with('success', 'Data berhasil dihapus.');
    }

    public function edit($id)
    {
        $asesmen_ujian = AsesmenUjian::findOrFail($id);
        return view('ujian.edit', compact('asesmen_ujian'));
    }
    public function update(Request $request, $id)
    {
        $asesmen_ujian = AsesmenUjian::findOrFail($id);

        $request->validate([
            'nama' => 'required|string|max:255',
            'nim' => 'required|string|max:20|unique:asesmen_ujians,nim,' . $id,
        ]);

        $data = $request->all();

        // Update data di database
        $asesmen_ujian->update($data);

        // ✅ Refresh data dari database supaya variabel ini punya nilai terbaru
        $asesmen_ujian->refresh();

        // 🔁 Regenerate PDF baru
        $pdf = Pdf::loadView('ujian.pdf', compact('asesmen_ujian'));
        $pdfFilename = 'asesmen_ujian_' . preg_replace('/[\/\\\\]/', '-', $asesmen_ujian->nim) . '.pdf';
        $pdfPath = 'private/pdf_asesmen_ujian/' . $pdfFilename;

        // Hapus PDF lama (opsional, supaya tidak menumpuk)
        if ($asesmen_ujian->pdf_path && Storage::exists($asesmen_ujian->pdf_path)) {
            Storage::delete($asesmen_ujian->pdf_path);
        }

        // Simpan PDF baru
        Storage::put($pdfPath, $pdf->output());

        // Update path PDF
        $asesmen_ujian->update(['pdf_path' => $pdfPath]);

        return redirect()->route('ujian.index')->with('success', 'Data asesmen ujian berhasil diperbarui!');
    }


    public function show($id)
    {
        $asesmen_ujian = AsesmenUjian::findOrFail($id);
        return view('ujian.show', compact('asesmen_ujian'));
    }
    
}
