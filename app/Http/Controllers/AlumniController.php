<?php

namespace App\Http\Controllers;

use App\Models\Alumni;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\MahasiswaController;

class AlumniController extends Controller
{
    public function index()
    {
        $alumnis = Alumni::all();
        return view('alumni.index', compact('alumnis'));
    }
    public function bulkDelete(Request $request)
    {
        $ids = explode(",", $request->ids);

        Alumni::whereIn('id', $ids)->delete();

        return redirect()->route('alumni.index')->with('success', 'Data berhasil dihapus.');
    }
    public function create()
    {
        $subragamOptions = MahasiswaController::getExistingSubragams();
        return view('alumni.create_tracer', compact('subragamOptions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'nim' => 'required|string|max:20',
            'ragam_disabilitas' => [
                'required',
                'array',
                'min:1',
            ],
            'ragam_disabilitas.*' => [
                'string',
                'in:Netra,Rungu,Mental,Fisik,Disabilitas Ganda',
            ],
            'alamat_domisili' => 'nullable|string',
            'email_aktif' => 'nullable|email|max:255',
            'url_linkedin' => 'nullable|url|max:255',
            'aktivitas_saat_ini' => 'nullable|in:B1,B2,B3,B4,B5,B6,B7',
            'waktu_mendapatkan_pekerjaan_bulan' => 'nullable|integer|between:-12,12',
            'waktu_mulai_mencari_pekerjaan_bulan' => 'nullable|integer|between:-12,12',
            'cara_mendapatkan_pekerjaan' => 'nullable|array',
            'cara_mendapatkan_pekerjaan.*' => 'string|max:255',
            'cara_mendapatkan_pekerjaan_lainnya' => 'nullable|string',
            'jenis_institusi_pekerjaan' => 'nullable|string|max:255',
            'jenis_institusi_pekerjaan_lainnya' => 'nullable|string',
            'nama_tempat_kerja' => 'nullable|string|max:255',
            'alamat_tempat_kerja' => 'nullable|string',
            'kontak_tempat_kerja' => 'nullable|string|max:255',
            'posisi_pekerjaan' => 'nullable|string|max:255',
            'posisi_pekerjaan_lainnya' => 'nullable|string',
            'lama_bekerja' => 'nullable|string|max:100',
            'kendala_mencari_pekerjaan' => 'nullable|array',
            'kendala_mencari_pekerjaan.*' => 'string|max:255',
            'kendala_mencari_pekerjaan_lainnya' => 'nullable|string',
            'jenjang_studi_lanjut' => 'nullable|string|max:100',
            'nama_prodi_studi_lanjut' => 'nullable|string|max:255',
            'institusi_studi_lanjut' => 'nullable|string|max:255',
            'lokasi_studi_lanjut' => 'nullable|string|max:255',
            'tanggal_mulai_studi_lanjut' => 'nullable|date',
            'tanggal_selesai_studi_lanjut' => 'nullable|date|after_or_equal:tanggal_mulai_studi_lanjut',
        ]);

        $data = $request->all();
        $data['perlu_update'] = true;

        $disability = $this->processDisabilityInput($request);
        $data['ragam_disabilitas'] = $disability['ragam_disabilitas'];
        $data['ragam_pilihan'] = $disability['ragam_pilihan'];
        $data['subragam_disabilitas'] = $disability['subragam_disabilitas'];

        try {
            $alumni = Alumni::create($data);
        } catch (QueryException $e) {

            if ($e->errorInfo[1] == 1062) {
                return redirect()->route('alumni.index')
                    ->with('error', 'Data dengan NIM tersebut sudah tersimpan sebelumnya.');
            }

            throw $e;
        }

        // Upload file jika ada
        if ($request->hasFile('surat_keterangan')) {
            $file = $request->file('surat_keterangan');
            $filename = time() . '_' . $file->getClientOriginalName();

            // simpan ke storage/app/private/surat_keterangan
            $file->storeAs('private/surat_keterangan', $filename);

            // masukkan ke array data
            $data['surat_keterangan'] = $filename;
        }
        // === Generate PDF otomatis ===
        $pdf = Pdf::loadView('alumni.pdf', compact('alumni'));

        $pdfFilename = 'alumni_' . preg_replace('/[\/\\\\]/', '-', $alumni->nim) . '.pdf';
        $pdfPath = 'private/pdf_alumni/' . $pdfFilename;

        // Simpan ke storage/app/private/pdf_mahasiswa
        Storage::put($pdfPath, $pdf->output());

        // Update path pdf ke mahasiswa
        $alumni->update(['pdf_path' => $pdfPath]);

        return redirect()->route('alumni.index')->with('success', 'Data alumni berhasil ditambahkan!');
    }
    public function download($id)
    {
        $alumni = Alumni::findOrFail($id);

        if (!$alumni->surat_keterangan) {
            return redirect()->back()->with('error', 'File tidak tersedia.');
        }

        $filePath = storage_path('app/private/surat_keterangan/' . $alumni->surat_keterangan);

        if (!file_exists($filePath)) {
            return redirect()->back()->with('error', 'File tidak ditemukan.');
        }

        return response()->download($filePath, $alumni->surat_keterangan);
    }
    public function generatePdf($id)
    {
        $alumni = Alumni::findOrFail($id);

        $pdf = Pdf::loadView('alumni.pdf', compact('alumni'));
        
        $filename = 'alumni_' . preg_replace('/[\/\\\\]/', '-', $alumni->nim) . '.pdf';

        return $pdf->download($filename);

    }
    public function downloadPdf($id)
    {
        $alumni = Alumni::findOrFail($id);

        if (!$alumni->pdf_path) {
            return back()->with('error', 'File PDF belum tersedia.');
        }

        $filePath = storage_path('app/' . $alumni->pdf_path);

        if (!file_exists($filePath)) {
            return back()->with('error', 'File tidak ditemukan di server.');
        }

        $filename = 'alumni_' . preg_replace('/[\/\\\\]/', '-', $alumni->nim) . '.pdf';

        return response()->download($filePath, $filename, [
            'Content-Type' => 'application/pdf',
        ]);
    }

    public function edit($id)
    {
        $alumni = Alumni::findOrFail($id);
        $subragamOptions = MahasiswaController::getExistingSubragams();
        return view('alumni.edit_tracer', compact('alumni', 'subragamOptions'));
    }
    public function update(Request $request, $id)
    {
        $alumni = Alumni::findOrFail($id);

        $request->validate([
            'nama' => 'required|string|max:255',
            'nim' => 'required|string|max:20|unique:alumnis,nim,' . $id, // nim boleh sama asal milik dirinya
            'ragam_disabilitas' => [
                'required',
                'array',
                'min:1',
            ],
            'ragam_disabilitas.*' => [
                'string',
                'in:Netra,Rungu,Mental,Fisik,Disabilitas Ganda',
            ],
            'alamat_domisili' => 'nullable|string',
            'email_aktif' => 'nullable|email|max:255',
            'url_linkedin' => 'nullable|url|max:255',
            'aktivitas_saat_ini' => 'nullable|in:B1,B2,B3,B4,B5,B6,B7',
            'waktu_mendapatkan_pekerjaan_bulan' => 'nullable|integer|between:-12,12',
            'waktu_mulai_mencari_pekerjaan_bulan' => 'nullable|integer|between:-12,12',
            'cara_mendapatkan_pekerjaan' => 'nullable|array',
            'cara_mendapatkan_pekerjaan.*' => 'string|max:255',
            'cara_mendapatkan_pekerjaan_lainnya' => 'nullable|string',
            'jenis_institusi_pekerjaan' => 'nullable|string|max:255',
            'jenis_institusi_pekerjaan_lainnya' => 'nullable|string',
            'nama_tempat_kerja' => 'nullable|string|max:255',
            'alamat_tempat_kerja' => 'nullable|string',
            'kontak_tempat_kerja' => 'nullable|string|max:255',
            'posisi_pekerjaan' => 'nullable|string|max:255',
            'posisi_pekerjaan_lainnya' => 'nullable|string',
            'lama_bekerja' => 'nullable|string|max:100',
            'kendala_mencari_pekerjaan' => 'nullable|array',
            'kendala_mencari_pekerjaan.*' => 'string|max:255',
            'kendala_mencari_pekerjaan_lainnya' => 'nullable|string',
            'jenjang_studi_lanjut' => 'nullable|string|max:100',
            'nama_prodi_studi_lanjut' => 'nullable|string|max:255',
            'institusi_studi_lanjut' => 'nullable|string|max:255',
            'lokasi_studi_lanjut' => 'nullable|string|max:255',
            'tanggal_mulai_studi_lanjut' => 'nullable|date',
            'tanggal_selesai_studi_lanjut' => 'nullable|date|after_or_equal:tanggal_mulai_studi_lanjut',
            'surat_keterangan' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
        ]);

        $data = $request->all();
        $data['perlu_update'] = false;

        $disability = $this->processDisabilityInput($request);
        $data['ragam_disabilitas'] = $disability['ragam_disabilitas'];
        $data['ragam_pilihan'] = $disability['ragam_pilihan'];
        $data['subragam_disabilitas'] = $disability['subragam_disabilitas'];

        // Jika ada file baru diupload
        if ($request->hasFile('surat_keterangan')) {
            // Hapus file lama jika ada
            if ($alumni->surat_keterangan && Storage::exists('private/surat_keterangan/' . $alumni->surat_keterangan)) {
                Storage::delete('private/surat_keterangan/' . $alumni->surat_keterangan);
            }

            $file = $request->file('surat_keterangan');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('private/surat_keterangan', $filename);
            $data['surat_keterangan'] = $filename;
        } else {
            unset($data['surat_keterangan']); // jangan timpa kalau kosong
        }

        // Update mahasiswa
        $alumni->update($data);

        // === Regenerate PDF (opsional) ===
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('alumni.pdf', compact('alumni'));
        $pdfFilename = 'alumni_' . preg_replace('/[\/\\\\]/', '-', $alumni->nim) . '.pdf';
        $pdfPath = 'private/pdf_alumni/' . $pdfFilename;

        Storage::put($pdfPath, $pdf->output());
        $alumni->update(['pdf_path' => $pdfPath]);

        return redirect()->route('alumni.index')->with('success', 'Data alumni berhasil diperbarui!');
    }

    /**
     * Memproses pilihan ragam dan subragam disabilitas.
     */
    private function processDisabilityInput(Request $request): array
    {
        $selectedRagam = array_values(
            array_unique(
                array_filter(
                    (array) $request->input('ragam_disabilitas', [])
                )
            )
        );

        $validBase = [
            'Netra',
            'Rungu',
            'Mental',
            'Fisik',
        ];

        $chosenBase = array_values(
            array_intersect($validBase, $selectedRagam)
        );

        /*
         * Jika memilih lebih dari satu ragam,
         * otomatis dianggap sebagai Disabilitas Ganda.
         */
        if (count($chosenBase) > 1) {
            $finalRagam = [
                'Disabilitas Ganda',
            ];
        } elseif (count($chosenBase) === 1) {
            $finalRagam = [
                $chosenBase[0],
            ];
        } else {
            $finalRagam = [
                'Fisik',
            ];
        }

        $subragamInput = (array) $request->input('subragam', []);
        $subragamCustom = (array) $request->input('subragam_custom', []);
        $finalSubragam = [];

        foreach ($chosenBase as $ragam) {
            $chosenVal = trim((string) ($subragamInput[$ragam] ?? ''));

            /*
             * Jika memilih "Tulis Subragam Baru",
             * ambil nilai dari input custom.
             */
            if ($chosenVal === '__custom__' || $chosenVal === 'custom') {
                $chosenVal = trim((string) ($subragamCustom[$ragam] ?? ''));
            } elseif ($chosenVal === '' && !empty($subragamCustom[$ragam])) {
                $chosenVal = trim((string) $subragamCustom[$ragam]);
            }

            if ($chosenVal !== '') {
                $finalSubragam[$ragam] = $chosenVal;
            }
        }

        return [
            'ragam_disabilitas' => $finalRagam,
            'ragam_pilihan' => $chosenBase,
            'subragam_disabilitas' => $finalSubragam,
        ];
    }

    public function show($id)
    {
        $alumni = Alumni::findOrFail($id);
        return view('alumni.show', compact('alumni'));
    }
}
