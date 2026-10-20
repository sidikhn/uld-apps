@extends('layout.sideBar')

@section('title', 'Daftarkan Studi Lanjut Alumni | ULD')

@section('content')
<main class="flex-1 bg-slate-50 flex flex-col min-h-screen font-sans">
    
    <!-- Top Header Sticky -->
    <div class="flex flex-wrap justify-between items-center bg-[#1B4E71] text-white px-6 md:px-8 py-4 shadow-sm z-20 sticky top-0">
        <div class="flex items-center space-x-3">
            <div class="p-2 bg-white/10 rounded-lg">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                </svg>
            </div>
            <div>
                <span class="font-bold text-xl tracking-wide block">Studi Lanjut Alumni</span>
                <span class="text-xs text-sky-200 font-normal">Aktifkan kembali sebagai Mahasiswa Aktif (S2/S3/dll) tanpa menghapus rekam jejak alumni</span>
            </div>
        </div>

        <a href="{{ route('alumni.show', $alumni->id) }}" 
           class="inline-flex items-center space-x-2 bg-white/10 hover:bg-white/20 px-4 py-2 rounded-lg transition-colors border border-transparent text-sm font-medium">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            <span>Batal & Kembali</span>
        </a>
    </div>

    <!-- Scrollable Content -->
    <div class="flex-1 overflow-y-auto p-6 md:p-8">
        <div class="max-w-4xl mx-auto space-y-6">

            @if ($errors->any())
                <div class="p-4 bg-red-50 border border-red-200 rounded-xl text-red-700 text-sm space-y-1">
                    <span class="font-bold">Terdapat kesalahan pengisian:</span>
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Info Profil Asal (Alumni) -->
            <div class="bg-white rounded-xl border border-slate-200 p-6 shadow-sm">
                <div class="flex items-center justify-between pb-4 border-b border-slate-100">
                    <div>
                        <span class="text-xs font-semibold text-[#1B4E71] uppercase tracking-wider">Identitas Terhubung</span>
                        <h2 class="text-xl font-bold text-slate-800">{{ $alumni->nama }}</h2>
                    </div>
                    <div class="text-right">
                        <span class="text-xs text-slate-400 block font-medium">Nomor Induk ULD</span>
                        <span class="inline-block px-3 py-1 bg-sky-50 text-[#1B4E71] font-mono font-bold text-sm rounded-lg border border-sky-200">
                            {{ $alumni->nomor_induk_uld }}
                        </span>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4 text-sm text-slate-600">
                    <div class="bg-slate-50 p-3 rounded-lg border border-slate-100">
                        <span class="text-xs text-slate-400 block">Riwayat Lulusan</span>
                        <span class="font-semibold text-slate-700">{{ $alumni->pendidikan ?? 'S1' }} - {{ $alumni->prodi ?? '-' }}</span>
                        <span class="text-xs text-slate-500 block">NIM Lama: {{ $alumni->nim }}</span>
                    </div>
                    <div class="bg-slate-50 p-3 rounded-lg border border-slate-100">
                        <span class="text-xs text-slate-400 block">Ragam Disabilitas</span>
                        <span class="font-semibold text-slate-700">
                            {{ is_array($alumni->ragam_disabilitas) ? implode(', ', $alumni->ragam_disabilitas) : ($alumni->ragam_disabilitas ?? '-') }}
                        </span>
                    </div>
                    <div class="bg-slate-50 p-3 rounded-lg border border-slate-100">
                        <span class="text-xs text-slate-400 block">Status Baru Nanti</span>
                        <span class="font-semibold text-emerald-600">Mahasiswa Aktif Baru</span>
                        <span class="text-xs text-slate-500 block">Data S1 tetap tersimpan di Alumni</span>
                    </div>
                </div>
            </div>

            <!-- Form Pendaftaran Studi Lanjut -->
            <form action="{{ route('alumni.lanjutStudiSubmit', $alumni->id) }}" method="POST" class="bg-white rounded-xl border border-slate-200 p-6 shadow-sm space-y-6">
                @csrf

                <div>
                    <h3 class="text-base font-bold text-slate-800 flex items-center space-x-2">
                        <span class="w-2.5 h-2.5 bg-[#1B4E71] rounded-full inline-block"></span>
                        <span>Informasi Akademik Baru</span>
                    </h3>
                    <p class="text-xs text-slate-500 mt-1">Masukkan NIM baru dan program studi jenjang lanjut yang ditempuh.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <!-- NIM Baru -->
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">
                            NIM Baru <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="nim" value="{{ old('nim') }}" required
                               placeholder="Contoh: 24/524602/SHK/00431"
                               class="w-full px-3.5 py-2 text-sm border border-slate-300 rounded-lg focus:ring-2 focus:ring-[#1B4E71] focus:border-transparent outline-none">
                    </div>

                    <!-- Jenjang Pendidikan Baru -->
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">
                            Jenjang Pendidikan Baru <span class="text-red-500">*</span>
                        </label>
                        <select name="pendidikan" required
                                class="w-full px-3.5 py-2 text-sm border border-slate-300 rounded-lg focus:ring-2 focus:ring-[#1B4E71] focus:border-transparent outline-none bg-white">
                            <option value="">-- Pilih Jenjang --</option>
                            <option value="S1" {{ old('pendidikan') == 'S1' ? 'selected' : '' }}>S1 (Sarjana)</option>
                            <option value="S2" {{ old('pendidikan', 'S2') == 'S2' ? 'selected' : '' }}>S2 (Magister)</option>
                            <option value="S3" {{ old('pendidikan') == 'S3' ? 'selected' : '' }}>S3 (Doktor)</option>
                            <option value="Profesi" {{ old('pendidikan') == 'Profesi' ? 'selected' : '' }}>Profesi</option>
                            <option value="Spesialis" {{ old('pendidikan') == 'Spesialis' ? 'selected' : '' }}>Spesialis</option>
                            <option value="D4" {{ old('pendidikan') == 'D4' ? 'selected' : '' }}>D4 (Sarjana Terapan)</option>
                        </select>
                    </div>

                    <!-- Fakultas -->
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">
                            Fakultas <span class="text-red-500">*</span>
                        </label>
                        <select name="faculty_id" id="faculty_id" required
                                class="w-full px-3.5 py-2 text-sm border border-slate-300 rounded-lg focus:ring-2 focus:ring-[#1B4E71] focus:border-transparent outline-none bg-white">
                            <option value="">-- Pilih Fakultas --</option>
                            @foreach($faculties as $fac)
                                <option value="{{ $fac->id }}" {{ old('faculty_id') == $fac->id ? 'selected' : '' }}>
                                    {{ $fac->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Program Studi -->
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">
                            Program Studi
                        </label>
                        <select name="study_program_id" id="study_program_id"
                                class="w-full px-3.5 py-2 text-sm border border-slate-300 rounded-lg focus:ring-2 focus:ring-[#1B4E71] focus:border-transparent outline-none bg-white">
                            <option value="">-- Pilih Fakultas Terlebih Dahulu --</option>
                        </select>
                    </div>

                    <!-- Angkatan Baru -->
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">
                            Tahun Angkatan Baru <span class="text-red-500">*</span>
                        </label>
                        <input type="number" name="angkatan" value="{{ old('angkatan', date('Y')) }}" required
                               min="2000" max="{{ date('Y') + 1 }}"
                               class="w-full px-3.5 py-2 text-sm border border-slate-300 rounded-lg focus:ring-2 focus:ring-[#1B4E71] focus:border-transparent outline-none">
                    </div>

                    <!-- Tahun Asesmen -->
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">
                            Tahun Asesmen <span class="text-red-500">*</span>
                        </label>
                        <input type="number" name="tahun_asesmen" value="{{ old('tahun_asesmen', date('Y')) }}" required
                               min="2000" max="{{ date('Y') + 1 }}"
                               class="w-full px-3.5 py-2 text-sm border border-slate-300 rounded-lg focus:ring-2 focus:ring-[#1B4E71] focus:border-transparent outline-none">
                    </div>

                    <!-- Nomor HP -->
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">
                            Nomor WhatsApp / HP
                        </label>
                        <input type="text" name="nomor_hp" value="{{ old('nomor_hp', $alumni->nomor_hp) }}"
                               placeholder="08xxxxxxxx"
                               class="w-full px-3.5 py-2 text-sm border border-slate-300 rounded-lg focus:ring-2 focus:ring-[#1B4E71] focus:border-transparent outline-none">
                    </div>

                    <!-- Beasiswa -->
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">
                            Beasiswa (Jika ada)
                        </label>
                        <input type="text" name="beasiswa" value="{{ old('beasiswa', $alumni->beasiswa) }}"
                               placeholder="Contoh: LPDP, BPI, dll"
                               class="w-full px-3.5 py-2 text-sm border border-slate-300 rounded-lg focus:ring-2 focus:ring-[#1B4E71] focus:border-transparent outline-none">
                    </div>
                </div>

                <div class="pt-4 border-t border-slate-100 flex items-center justify-between">
                    <span class="text-xs text-slate-500">
                        ℹ️ Seluruh catatan ragam disabilitas, alat bantu, akomodasi, dan berkas dari profil alumni akan disalin otomatis ke mahasiswa aktif baru.
                    </span>

                    <button type="submit" 
                            class="inline-flex items-center space-x-2 bg-[#1B4E71] hover:bg-[#153e5a] text-white px-5 py-2.5 rounded-lg text-sm font-semibold transition-all shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                        </svg>
                        <span>Simpan & Aktifkan Mahasiswa</span>
                    </button>
                </div>
            </form>

        </div>
    </div>
</main>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const facultySelect = document.getElementById('faculty_id');
    const prodiSelect = document.getElementById('study_program_id');

    function loadStudyPrograms(facultyId, selectedId = null) {
        if (!facultyId) {
            prodiSelect.innerHTML = '<option value="">-- Pilih Fakultas Terlebih Dahulu --</option>';
            return;
        }

        prodiSelect.innerHTML = '<option value="">Memuat program studi...</option>';

        fetch(`{{ route('api.studyPrograms') }}?faculty_id=${facultyId}`)
            .then(res => res.json())
            .then(data => {
                prodiSelect.innerHTML = '<option value="">-- Pilih Program Studi --</option>';
                data.forEach(prodi => {
                    const opt = document.createElement('option');
                    opt.value = prodi.id;
                    opt.textContent = prodi.name;
                    if (selectedId && selectedId == prodi.id) {
                        opt.selected = true;
                    }
                    prodiSelect.appendChild(opt);
                });
            })
            .catch(() => {
                prodiSelect.innerHTML = '<option value="">Gagal memuat data program studi</option>';
            });
    }

    if (facultySelect.value) {
        loadStudyPrograms(facultySelect.value, '{{ old('study_program_id') }}');
    }

    facultySelect.addEventListener('change', function () {
        loadStudyPrograms(this.value);
    });
});
</script>
@endsection
