<?php

namespace App\Http\Controllers;

use App\Models\Alumni;
use App\Models\Faculty;
use App\Models\Mahasiswa;
use App\Models\StudyProgram;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class MahasiswaController extends Controller
{
    public static function getExistingSubragams(): array
    {
        $base = [
            'Netra' => [
                'Netra Total',
                'Netra Parsial',
                'Low Vision',
            ],

            'Rungu' => [
                'Tuli Parsial',
                'Tuli Total',
                'Hard of Hearing',
            ],

            'Mental' => [
                'Bipolar',
                'Autis',
                'ADHD',
                'Depresi',
                'Skizofrenia',
            ],

            'Fisik' => [
                'Fisik Bawah (Kaki)',
                'Fisik Atas (Tangan)',
                'Fisik (Motorik)',
            ],
        ];

        $records = Mahasiswa::whereNotNull('subragam_disabilitas')
            ->pluck('subragam_disabilitas')
            ->concat(
                Alumni::whereNotNull('subragam_disabilitas')->pluck('subragam_disabilitas')
            );

        foreach ($records as $row) {

            if (is_array($row)) {
                $data = $row;
            } else {
                $data = json_decode((string) $row, true);
            }

            if (!is_array($data)) {
                continue;
            }

            foreach ($data as $ragam => $sub) {

                $ragamKey = ucfirst(
                    strtolower(
                        trim((string) $ragam)
                    )
                );

                $subVal = trim((string) $sub);

                if (
                    $subVal !== '' &&
                    isset($base[$ragamKey]) &&
                    !in_array($subVal, $base[$ragamKey], true)
                ) {
                    $base[$ragamKey][] = $subVal;
                }
            }
        }

        return $base;
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
                'Disabilitas Ganda'
            ];

        } elseif (count($chosenBase) === 1) {

            $finalRagam = [
                $chosenBase[0]
            ];

        } else {

            $finalRagam = [
                'Fisik'
            ];
        }

        $subragamInput = (array) $request->input(
            'subragam',
            []
        );

        $subragamCustom = (array) $request->input(
            'subragam_custom',
            []
        );

        $finalSubragam = [];

        foreach ($chosenBase as $ragam) {

            $chosenVal = trim(
                (string) ($subragamInput[$ragam] ?? '')
            );

            /*
             * Jika memilih "Tulis Subragam Baru",
             * ambil nilai dari input custom.
             */
            if (
                $chosenVal === '__custom__' ||
                $chosenVal === 'custom'
            ) {
                $chosenVal = trim(
                    (string) ($subragamCustom[$ragam] ?? '')
                );

            } elseif (
                $chosenVal === '' &&
                !empty($subragamCustom[$ragam])
            ) {
                $chosenVal = trim(
                    (string) $subragamCustom[$ragam]
                );
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

    /**
     * Form tambah mahasiswa.
     */
    public function create()
    {
        $faculties = Faculty::orderBy('name')->get();

        $subragamOptions = self::getExistingSubragams();

        return view('mahasiswa.create', [
            'faculties' => $faculties,
            'mahasiswa' => null,
            'subragamOptions' => $subragamOptions,
        ]);
    }

    /**
     * Mengambil program studi berdasarkan fakultas.
     */
    public function studyPrograms(Request $request)
    {
        $facultyId = $request->query('faculty_id');

        if (!$facultyId || !is_numeric($facultyId)) {
            return response()->json([]);
        }

        if (!Faculty::whereKey($facultyId)->exists()) {
            return response()->json([]);
        }

        $programs = StudyProgram::query()
            ->where('faculty_id', (int) $facultyId)
            ->orderBy('name')
            ->select('id', 'name')
            ->get();

        return response()->json($programs);
    }

    /**
     * Menyimpan mahasiswa baru.
     */
    public function store(Request $request)
    {
        $request->validate([

            'nama' => 'required|string|max:255',

            'nim' => [
                'required',
                'string',
                'max:20',
                'unique:mahasiswas,nim',
            ],

            'tahun_asesmen' => 'required|string|max:10',

            'faculty_id' => [
                'required',
                'exists:faculties,id',
            ],

            'study_program_id' => [
                'nullable',
                'exists:study_programs,id',

                function ($attribute, $value, $fail) use ($request) {

                    if (!$request->faculty_id || !$value) {
                        return;
                    }

                    $studyProgram = StudyProgram::find($value);

                    if (
                        !$studyProgram ||
                        (int) $studyProgram->faculty_id !==
                        (int) $request->faculty_id
                    ) {
                        $fail(
                            'Program studi harus sesuai dengan fakultas yang dipilih.'
                        );
                    }
                },
            ],

            'ktp' => [
                'nullable',
                'file',
                'mimes:pdf,jpg,jpeg,png,gif,webp,bmp',
                'max:51200',
            ],

            'foto' => [
                'nullable',
                'image',
                'max:51200',
            ],

            'surat_keterangan' => [
                'nullable',
                'file',
                'mimes:pdf,jpg,jpeg,png,gif,webp,bmp',
                'max:51200',
            ],

            'ragam_disabilitas' => [
                'required',
                'array',
                'min:1',
            ],

            'ragam_disabilitas.*' => [
                'string',
                'in:Netra,Rungu,Mental,Fisik,Disabilitas Ganda',
            ],
        ]);

        $data = $request->except([
            'ktp',
            'foto',
            'surat_keterangan',
        ]);

        $faculty = Faculty::find(
            $request->faculty_id
        );

        $studyProgram = StudyProgram::find(
            $request->study_program_id
        );

        $data['fakultas'] = $faculty
            ? $faculty->name
            : $request->fakultas;

        $data['prodi'] = $studyProgram
            ? $studyProgram->name
            : $request->prodi;

        $data['tahun_asesmen'] =
            $request->input('tahun_asesmen')
            ?: ($request->input('angkatan') ?: date('Y'));

        /*
         * Proses ragam dan subragam.
         */
        $disability = $this->processDisabilityInput($request);

        $data['ragam_disabilitas'] =
            $disability['ragam_disabilitas'];

        $data['ragam_pilihan'] =
            $disability['ragam_pilihan'];

        $data['subragam_disabilitas'] =
            $disability['subragam_disabilitas'];

        /*
         * Upload dokumen.
         *
         * Input:
         * ktp
         * foto
         * surat_keterangan
         *
         * Database:
         * ktp
         * foto
         * surat_keterangan_link
         */
        $this->handleDocumentUploads(
            $request,
            $data
        );

        DB::transaction(function () use (&$mahasiswa, $data) {

            $mahasiswa = Mahasiswa::create($data);

            /*
             * Generate PDF otomatis.
             */
            $pdf = Pdf::loadView(
                'mahasiswa.pdf',
                compact('mahasiswa')
            );

            $pdfFilename =
                'mahasiswa_' .
                preg_replace(
                    '/[\/\\\\]/',
                    '-',
                    $mahasiswa->nim
                ) .
                '.pdf';

            $pdfPath =
                'private/pdf_mahasiswa/' .
                $pdfFilename;

            Storage::disk('local')->put(
                $pdfPath,
                $pdf->output()
            );

            $mahasiswa->update([
                'pdf_path' => $pdfPath,
            ]);
        });

        return redirect()
            ->route('mahasiswa.index')
            ->with(
                'success',
                'Data mahasiswa berhasil ditambahkan!'
            );
    }

    /**
     * Menangani upload KTP, foto, dan surat keterangan.
     */
    private function handleDocumentUploads(
        Request $request,
        array &$data,
        ?Mahasiswa $mahasiswa = null
    ): void {

        $documents = [
            'ktp',
            'foto',
            'surat_keterangan',
        ];

        foreach ($documents as $document) {

            if (!$request->hasFile($document)) {
                continue;
            }

            $file = $request->file($document);

            if (!$file || !$file->isValid()) {
                continue;
            }

            $filename =
                time() .
                '_' .
                $document .
                '_' .
                $file->getClientOriginalName();

            /*
             * Jika update dan ada file lama,
             * hapus file lama terlebih dahulu.
             */
            if ($mahasiswa) {

                $databaseField =
                    $document === 'surat_keterangan'
                        ? 'surat_keterangan_link'
                        : $document;

                $oldFilename =
                    $mahasiswa->{$databaseField};

                if ($oldFilename) {

                    $oldPath =
                        'mahasiswa/' .
                        $oldFilename;

                    if (
                        Storage::disk('local')
                            ->exists($oldPath)
                    ) {
                        Storage::disk('local')
                            ->delete($oldPath);
                    }
                }
            }

            Storage::disk('local')->putFileAs(
                'mahasiswa',
                $file,
                $filename
            );

            /*
             * Mapping nama input → nama kolom database.
             */
            if ($document === 'surat_keterangan') {

                $data['surat_keterangan_link'] =
                    $filename;

            } else {

                $data[$document] = $filename;
            }
        }
    }

    public function index()
    {
        $mahasiswas = Mahasiswa::with(['faculty', 'studyProgram'])
            ->latest('created_at')
            ->get();

        return view('mahasiswa.index', compact('mahasiswas'));
    }

    /**
     * Download surat keterangan.
     */
    public function download($id)
    {
        $mahasiswa = Mahasiswa::findOrFail($id);

        $filename =
            $mahasiswa->surat_keterangan_link;

        if (!$filename) {
            return redirect()
                ->back()
                ->with(
                    'error',
                    'File tidak tersedia.'
                );
        }

        $paths = [
            'mahasiswa/' . $filename,
            'surat_keterangan/' . $filename,
            'private/surat_keterangan/' . $filename,
        ];

        $foundPath = collect($paths)
            ->first(
                fn ($path) =>
                Storage::disk('local')->exists($path)
            );

        if (!$foundPath) {
            return redirect()
                ->back()
                ->with(
                    'error',
                    'File tidak ditemukan di server.'
                );
        }

        return Storage::disk('local')->download(
            $foundPath,
            $filename
        );
    }

    /**
     * Generate PDF mahasiswa.
     */
    public function generatePdf($id)
    {
        $mahasiswa = Mahasiswa::findOrFail($id);

        $pdf = Pdf::loadView(
            'mahasiswa.pdf',
            compact('mahasiswa')
        );

        $filename =
            'mahasiswa_' .
            preg_replace(
                '/[\/\\\\]/',
                '-',
                $mahasiswa->nim
            ) .
            '.pdf';

        return $pdf->download($filename);
    }

    /**
     * Download PDF mahasiswa.
     */
    public function downloadPdf($id)
    {
        $mahasiswa = Mahasiswa::findOrFail($id);

        if (!$mahasiswa->pdf_path) {
            return back()->with(
                'error',
                'File PDF belum tersedia.'
            );
        }

        if (
            !Storage::disk('local')
                ->exists($mahasiswa->pdf_path)
        ) {
            return back()->with(
                'error',
                'File tidak ditemukan di server.'
            );
        }

        $filename =
            'mahasiswa_' .
            preg_replace(
                '/[\/\\\\]/',
                '-',
                $mahasiswa->nim
            ) .
            '.pdf';

        return Storage::disk('local')->download(
            $mahasiswa->pdf_path,
            $filename,
            [
                'Content-Type' =>
                    'application/pdf',
            ]
        );
    }

    /**
     * Form edit mahasiswa.
     */
    public function edit($id)
    {
        $mahasiswa = Mahasiswa::findOrFail($id);

        $faculties = Faculty::orderBy('name')->get();

        $subragamOptions =
            self::getExistingSubragams();

        return view(
            'mahasiswa.create',
            compact(
                'mahasiswa',
                'faculties',
                'subragamOptions'
            )
        );
    }

    /**
     * Update mahasiswa.
     */
    public function update(
        Request $request,
        $id
    ) {
        $mahasiswa =
            Mahasiswa::findOrFail($id);

        $request->validate([

            'nama' =>
                'required|string|max:255',

            'nim' =>
                'required|string|max:20|unique:mahasiswas,nim,' . $id,

            'tahun_asesmen' =>
                'nullable|string|max:10',

            'faculty_id' => [
                'required',
                'exists:faculties,id',
            ],

            'study_program_id' => [
                'required',
                'exists:study_programs,id',

                function (
                    $attribute,
                    $value,
                    $fail
                ) use ($request) {

                    if (
                        !$request->faculty_id ||
                        !$value
                    ) {
                        return;
                    }

                    $studyProgram =
                        StudyProgram::find($value);

                    if (
                        !$studyProgram ||
                        (int) $studyProgram->faculty_id !==
                        (int) $request->faculty_id
                    ) {
                        $fail(
                            'Program studi harus sesuai dengan fakultas yang dipilih.'
                        );
                    }
                },
            ],

            'ktp' => [
                'nullable',
                'file',
                'mimes:pdf,jpg,jpeg,png,gif,webp,bmp',
                'max:51200',
            ],

            'foto' => [
                'nullable',
                'image',
                'max:51200',
            ],

            'surat_keterangan' => [
                'nullable',
                'file',
                'mimes:pdf,jpg,jpeg,png,gif,webp,bmp',
                'max:51200',
            ],

            'ragam_disabilitas' => [
                'required',
                'array',
                'min:1',
            ],

            'ragam_disabilitas.*' => [
                'string',
                'in:Netra,Rungu,Mental,Fisik,Disabilitas Ganda',
            ],
        ]);

        /*
         * Jangan memasukkan file langsung ke $data.
         * File akan diproses oleh handleDocumentUploads().
         */
        $data = $request->except([
            'ktp',
            'foto',
            'surat_keterangan',
        ]);

        $faculty =
            Faculty::find(
                $request->faculty_id
            );

        $studyProgram =
            StudyProgram::find(
                $request->study_program_id
            );

        $data['fakultas'] =
            $faculty
                ? $faculty->name
                : $request->fakultas;

        $data['prodi'] =
            $studyProgram
                ? $studyProgram->name
                : $request->prodi;

        $data['tahun_asesmen'] =
            $request->input('tahun_asesmen')
            ?: (
                $request->input('angkatan')
                ?: date('Y')
            );

        /*
         * Proses ragam dan subragam.
         */
        $disability =
            $this->processDisabilityInput(
                $request
            );

        $data['ragam_disabilitas'] =
            $disability['ragam_disabilitas'];

        $data['ragam_pilihan'] =
            $disability['ragam_pilihan'];

        $data['subragam_disabilitas'] =
            $disability['subragam_disabilitas'];

        /*
         * Upload file baru.
         *
         * Jika tidak ada file baru:
         * file lama TETAP dipertahankan.
         */
        $this->handleDocumentUploads(
            $request,
            $data,
            $mahasiswa
        );

        DB::transaction(
            function () use (
                $mahasiswa,
                $data
            ) {

                $mahasiswa->fill($data);

                $mahasiswa->save();

                /*
                 * Generate ulang PDF.
                 */
                $pdf = Pdf::loadView(
                    'mahasiswa.pdf',
                    compact('mahasiswa')
                );

                $pdfFilename =
                    'mahasiswa_' .
                    preg_replace(
                        '/[\/\\\\]/',
                        '-',
                        $mahasiswa->nim
                    ) .
                    '.pdf';

                $pdfPath =
                    'private/pdf_mahasiswa/' .
                    $pdfFilename;

                Storage::disk('local')->put(
                    $pdfPath,
                    $pdf->output()
                );

                $mahasiswa->update([
                    'pdf_path' =>
                        $pdfPath,
                ]);
            }
        );

        return redirect()
            ->route('mahasiswa.index')
            ->with(
                'success',
                'Data mahasiswa berhasil diperbarui!'
            );
    }

    /**
     * Hapus banyak data mahasiswa.
     */
    public function bulkDelete(
        Request $request
    ) {
        $request->validate([
            'ids' => 'required|string',
        ]);

        $ids =
            array_filter(
                explode(',', $request->ids)
            );

        if (!empty($ids)) {
            Mahasiswa::whereIn(
                'id',
                $ids
            )->delete();
        }

        return redirect()
            ->route('mahasiswa.index')
            ->with(
                'success',
                'Data berhasil dihapus.'
            );
    }

    /**
     * Detail mahasiswa.
     */
    public function show($id)
    {
        $mahasiswa =
            Mahasiswa::with([
                'faculty',
                'studyProgram',
            ])->findOrFail($id);

        return view(
            'mahasiswa.show',
            compact('mahasiswa')
        );
    }

    /**
     * Menampilkan dokumen mahasiswa.
     *
     * URL tetap menggunakan:
     * /document/{id}/ktp
     * /document/{id}/foto
     * /document/{id}/surat_keterangan
     */
    public function document(
        $id,
        $document
    ) {
        abort_unless(
            in_array(
                $document,
                [
                    'ktp',
                    'foto',
                    'surat_keterangan',
                ],
                true
            ),
            404
        );

        $mahasiswa =
            Mahasiswa::findOrFail($id);

        /*
         * Mapping nama parameter URL
         * ke nama kolom database.
         */
        $field =
            $document === 'surat_keterangan'
                ? 'surat_keterangan_link'
                : $document;

        $filename =
            $mahasiswa->{$field};

        abort_unless(
            $filename,
            404
        );

        $paths = [
            'mahasiswa/' . $filename,
            'private/mahasiswa/' . $filename,
            'surat_keterangan/' . $filename,
            'private/surat_keterangan/' . $filename,
        ];

        $foundPath =
            collect($paths)
                ->first(
                    fn ($path) =>
                    Storage::disk('local')
                        ->exists($path)
                );

        abort_unless(
            $foundPath,
            404
        );

        return response()->file(
            Storage::disk('local')
                ->path($foundPath)
        );
    }

    /**
     * Memindahkan mahasiswa menjadi alumni.
     */
    public function jadikanAlumni(
        Request $request
    ) {
        $request->validate([
            'ids' => 'required|string',
        ]);

        $ids =
            array_filter(
                explode(',', $request->ids)
            );

        if (empty($ids)) {
            return redirect()
                ->back()
                ->with(
                    'error',
                    'Pilih minimal satu data mahasiswa.'
                );
        }

        $mahasiswas =
            Mahasiswa::whereIn(
                'id',
                $ids
            )->get();

        DB::transaction(
            function () use ($mahasiswas) {

                foreach ($mahasiswas as $mhs) {

                    $data = Arr::except(
                        $mhs->toArray(),
                        [
                            'id',
                            'created_at',
                            'updated_at',
                            'deleted_at',
                        ]
                    );

                    /*
                     * Alumni menggunakan kolom
                     * surat_keterangan_link.
                     */
                    $data['surat_keterangan_link'] =
                        $data['surat_keterangan_link']
                        ?? '';

                    $data['perlu_update'] =
                        true;

                    Alumni::create($data);

                    $mhs->forceDelete();
                }
            }
        );

        return redirect()
            ->route('alumni.index')
            ->with(
                'success',
                'Mahasiswa berhasil dipindah ke data alumni.'
            );
    }
}