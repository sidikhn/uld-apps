<?php

namespace App\Http\Controllers;

use App\Models\Tendik;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class tendikController extends Controller
{
    public function index(Request $request)
    {
        $query = Tendik::query();

        if ($request->filled('jenis_pegawai')) {
            $query->where('jenis_pegawai', $request->string('jenis_pegawai')->toString());
        }

        if ($request->filled('kategori_pegawai')) {
            $query->where('kategori_pegawai', $request->string('kategori_pegawai')->toString());
        }

        if ($request->filled('unit_kerja')) {
            $query->where('unit_kerja', 'like', '%' . $request->string('unit_kerja')->toString() . '%');
        }

        $tendiks = $query->latest()->get();
        return view('dosen_tendik.index', compact('tendiks'));
    }

    public function bulkDelete(Request $request)
    {
        $ids = explode(",", $request->ids);
        Tendik::whereIn('id', $ids)->delete();

        return redirect()->route('tendik.index')->with('success', 'Data berhasil dihapus.');
    }

    public function create()
    {
        return view('dosen_tendik.create_clean');
    }

    private function rules(?int $id = null): array
    {
        return [
            'nama' => ['required', 'string', 'max:255'],
            'jenis_kelamin' => ['required', 'in:Laki-laki,Perempuan'], // <-- Tambahkan baris ini
            'tanggal_lahir' => ['required', 'date'],
            'alamat' => ['required', 'string', 'max:255'],
            'no_ktp' => ['required', 'string', 'max:32'],
            'email' => ['required', 'email', 'max:255'],
            'no_hp' => ['required', 'string', 'max:30'],
            'ktp' => [$id ? 'nullable' : 'required', 'file', 'mimes:pdf,jpg,jpeg,png,gif,webp,bmp', 'max:51200'],
            'surat_keterangan' => [$id ? 'nullable' : 'required', 'file', 'mimes:pdf,jpg,jpeg,png,gif,webp,bmp', 'max:51200'],
            'nip_nika' => ['required', 'string', 'max:50', 'unique:tendiks,nip_nika,' . $id],
            'jenis_pegawai' => ['required', 'in:PNS,Pegawai tetap UGM,Pegawai kontrak'],
            'kategori_pegawai' => ['required', 'in:Dosen,Tenaga kependidikan'],
            'unit_kerja' => ['required', 'string', 'max:255'],
            'pangkat_golongan' => ['nullable', 'string', 'max:500'],
            'ragam_disabilitas' => ['required', 'array', 'min:1'],
            'ragam_disabilitas.*' => ['in:Fisik,Sensorik,Mental,Intelektual,Psikososial,Lainnya'],
            'detail_disabilitas' => ['required', 'string'],
            'alat_bantu' => ['nullable', 'string'],
            'kendala' => ['nullable', 'string'],
            'akomodasi' => ['nullable', 'string'],
            'pendampingan' => ['nullable', 'string'],
        ];
    }

    private function validatedData(Request $request, ?int $id = null): array
    {
        $data = $request->validate($this->rules($id));
        $data['ragam_disabilitas'] = json_encode($data['ragam_disabilitas']);
        return $data;
    }

    public function store(Request $request)
    {
        $data = $this->validatedData($request);
        $this->storeDocuments($request, $data);
        $tendik = Tendik::create($data);
        $this->writePdf($tendik);

        return redirect()->route('tendik.index')->with('success', 'Data dosen/tendik berhasil ditambahkan.');
    }

    public function download($id)
    {
        $tendik = Tendik::findOrFail($id);

        if (!$tendik->surat_keterangan) {
            return redirect()->back()->with('error', 'File tidak tersedia.');
        }

        $filePath = storage_path('app/private/tendik/' . $tendik->surat_keterangan);

        if (!file_exists($filePath)) {
            return redirect()->back()->with('error', 'File tidak ditemukan.');
        }

        return response()->download($filePath, $tendik->surat_keterangan);
    }

    public function generatePdf($id)
    {
        $tendik = Tendik::findOrFail($id);
        $pdf = Pdf::loadView('dosen_tendik.pdf', compact('tendik'));
        $filename = 'tendik_' . preg_replace('/[\/\\\\]/', '-', $tendik->nip_nika) . '.pdf';

        return $pdf->download($filename);
    }

    public function downloadPdf($id)
    {
        $tendik = Tendik::findOrFail($id);

        if (!$tendik->pdf_path) {
            return back()->with('error', 'File PDF belum tersedia.');
        }

        $filePath = storage_path('app/' . $tendik->pdf_path);

        if (!file_exists($filePath)) {
            return back()->with('error', 'File tidak ditemukan di server.');
        }

        $filename = 'tendik_' . preg_replace('/[\/\\\\]/', '-', $tendik->nip_nika) . '.pdf';

        return response()->download($filePath, $filename, [
            'Content-Type' => 'application/pdf',
        ]);
    }

    public function edit($id)
    {
        $tendik = Tendik::findOrFail($id);
        return view('dosen_tendik.edit_clean', compact('tendik'));
    }

    public function update(Request $request, $id)
    {
        $tendik = Tendik::findOrFail($id);

        $data = $this->validatedData($request, (int) $id);
        $this->storeDocuments($request, $data, $tendik);
        $tendik->update($data);

        $this->writePdf($tendik);

        return redirect()->route('tendik.index')->with('success', 'Data tendik berhasil diperbarui!');
    }

    public function show($id)
    {
        $tendik = Tendik::findOrFail($id);
        return view('dosen_tendik.show', compact('tendik'));
    }

    public function document($id, string $document)
    {
        abort_unless(in_array($document, ['ktp', 'surat_keterangan'], true), 404);
        $tendik = Tendik::findOrFail($id);
        abort_unless($tendik->{$document}, 404);
        $path = storage_path('app/private/tendik/' . $tendik->{$document});
        abort_unless(is_file($path), 404);

        return response()->file($path);
    }

    private function writePdf(Tendik $tendik): void
    {
        $pdf = Pdf::loadView('dosen_tendik.pdf', compact('tendik'));
        $filename = 'tendik_' . preg_replace('/[\/\\\\]/', '-', $tendik->nip_nika) . '.pdf';
        $path = 'private/pdf_tendik/' . $filename;
        Storage::put($path, $pdf->output());
        $tendik->update(['pdf_path' => $path]);
    }

    private function storeDocuments(Request $request, array &$data, ?Tendik $tendik = null): void
    {
        foreach (['ktp', 'surat_keterangan'] as $document) {
            if ($request->hasFile($document)) {
                if ($tendik && $tendik->{$document}) {
                    Storage::delete('private/tendik/' . $tendik->{$document});
                }

                $file = $request->file($document);
                $filename = time() . '_' . $document . '_' . $file->hashName();
                $file->storeAs('private/tendik', $filename);
                $data[$document] = $filename;
            } else {
                if ($tendik) {
                    unset($data[$document]);
                }
            }
        }
    }
}