@extends('layout.sideBar')

@section('title', 'Tambah Data Dosen dan Tendik')

@section('content')
<main class="flex-1 min-h-0 bg-slate-100 overflow-y-auto p-6 md:p-8">
    <div class="max-w-5xl mx-auto bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
        
        <div class="px-6 py-5 bg-slate-50 border-b border-slate-200 flex items-center justify-between">
            <div>
                <h1 class="text-xl font-bold text-[#083D62]">Tambah Data Dosen & Tendik</h1>
                <p class="text-xs text-slate-500 mt-0.5">Isi data identitas, informasi disabilitas, dan dokumen pendukung pegawai</p>
            </div>
            <a href="{{ route('tendik.index') }}" 
                class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-white border border-slate-300 text-slate-700 text-sm font-medium hover:bg-slate-50 transition-all shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                <span>Kembali</span>
            </a>
        </div>

        <form action="{{ route('tendik.store') }}" method="POST" enctype="multipart/form-data" class="p-6 md:p-8 space-y-8">
            @csrf

            <div>
                <div class="border-b border-slate-200 pb-3 mb-6">
                    <h2 class="text-lg font-bold text-[#083D62]">1. Identitas Utama & Kepegawaian</h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1">Nama Lengkap <span class="text-rose-500">*</span></label>
                        <input type="text" name="nama" value="{{ old('nama') }}" required placeholder="Masukkan nama lengkap"
                            class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-[#1B4E71] focus:border-[#1B4E71] text-sm outline-none transition-all">
                        @error('nama') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1">Jenis Kelamin <span class="text-rose-500">*</span></label>
                        <select name="jenis_kelamin" required
                            class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-[#1B4E71] focus:border-[#1B4E71] text-sm outline-none transition-all bg-white">
                            <option value="">-- Pilih Jenis Kelamin --</option>
                            <option value="Laki-laki" @selected(old('jenis_kelamin') == 'Laki-laki')>Laki-laki</option>
                            <option value="Perempuan" @selected(old('jenis_kelamin') == 'Perempuan')>Perempuan</option>
                        </select>
                        @error('jenis_kelamin') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1">Tanggal Lahir <span class="text-rose-500">*</span></label>
                        <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}" required
                            class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-[#1B4E71] focus:border-[#1B4E71] text-sm outline-none transition-all">
                        @error('tanggal_lahir') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1">No. KTP / NIK <span class="text-rose-500">*</span></label>
                        <input type="text" name="no_ktp" value="{{ old('no_ktp') }}" required placeholder="16 digit NIK"
                            class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-[#1B4E71] focus:border-[#1B4E71] text-sm outline-none transition-all">
                        @error('no_ktp') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1">Email <span class="text-rose-500">*</span></label>
                        <input type="email" name="email" value="{{ old('email') }}" required placeholder="email@ugm.ac.id"
                            class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-[#1B4E71] focus:border-[#1B4E71] text-sm outline-none transition-all">
                        @error('email') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1">No. HP / WhatsApp <span class="text-rose-500">*</span></label>
                        <input type="text" name="no_hp" value="{{ old('no_hp') }}" required placeholder="08xxxxxxxxxx"
                            class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-[#1B4E71] focus:border-[#1B4E71] text-sm outline-none transition-all">
                        @error('no_hp') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-slate-700 mb-1">Alamat Lengkap <span class="text-rose-500">*</span></label>
                        <textarea name="alamat" rows="2" required placeholder="Masukkan alamat tempat tinggal saat ini"
                            class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-[#1B4E71] focus:border-[#1B4E71] text-sm outline-none transition-all">{{ old('alamat') }}</textarea>
                        @error('alamat') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1">NIP / NIKA <span class="text-rose-500">*</span></label>
                        <input type="text" name="nip_nika" value="{{ old('nip_nika') }}" required placeholder="Nomor Induk Pegawai"
                            class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-[#1B4E71] focus:border-[#1B4E71] text-sm outline-none transition-all">
                        @error('nip_nika') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1">Kategori Pegawai <span class="text-rose-500">*</span></label>
                        <select name="kategori_pegawai" required
                            class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-[#1B4E71] focus:border-[#1B4E71] text-sm outline-none transition-all bg-white">
                            <option value="">-- Pilih Kategori --</option>
                            <option value="Dosen" @selected(old('kategori_pegawai') == 'Dosen')>Dosen</option>
                            <option value="Tenaga kependidikan" @selected(old('kategori_pegawai') == 'Tenaga kependidikan')>Tenaga Kependidikan</option>
                        </select>
                        @error('kategori_pegawai') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1">Jenis Pegawai <span class="text-rose-500">*</span></label>
                        <select name="jenis_pegawai" required
                            class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-[#1B4E71] focus:border-[#1B4E71] text-sm outline-none transition-all bg-white">
                            <option value="">-- Pilih Status --</option>
                            <option value="PNS" @selected(old('jenis_pegawai') == 'PNS')>PNS</option>
                            <option value="Pegawai tetap UGM" @selected(old('jenis_pegawai') == 'Pegawai tetap UGM')>Pegawai Tetap UGM</option>
                            <option value="Pegawai kontrak" @selected(old('jenis_pegawai') == 'Pegawai kontrak')>Pegawai Kontrak</option>
                        </select>
                        @error('jenis_pegawai') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1">Unit Kerja / Fakultas <span class="text-rose-500">*</span></label>
                        <input type="text" name="unit_kerja" value="{{ old('unit_kerja') }}" required placeholder="Contoh: Fakultas Teknik"
                            class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-[#1B4E71] focus:border-[#1B4E71] text-sm outline-none transition-all">
                        @error('unit_kerja') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1">Pangkat / Golongan Terakhir</label>
                        <input type="text" name="pangkat_golongan" value="{{ old('pangkat_golongan') }}" placeholder="Contoh: Penata Muda / III/a"
                            class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-[#1B4E71] focus:border-[#1B4E71] text-sm outline-none transition-all">
                        @error('pangkat_golongan') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            <div>
                <div class="border-b border-slate-200 pb-3 mb-6">
                    <h2 class="text-lg font-bold text-[#083D62]">2. Informasi Disabilitas & Kebutuhan</h2>
                </div>

                <div class="space-y-5">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Ragam Disabilitas <span class="text-rose-500">*</span></label>
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-3 p-4 bg-slate-50 border border-slate-200 rounded-xl">
                            @foreach(['Fisik','Sensorik','Mental','Intelektual','Psikososial','Lainnya'] as $value)
                                <label class="flex items-center gap-2 cursor-pointer text-sm text-slate-700">
                                    <input type="checkbox" name="ragam_disabilitas[]" value="{{ $value }}" 
                                        @checked(is_array(old('ragam_disabilitas')) && in_array($value, old('ragam_disabilitas')))
                                        class="w-4 h-4 rounded border-slate-300 text-[#1B4E71] focus:ring-[#1B4E71]">
                                    <span>{{ $value }}</span>
                                </label>
                            @endforeach
                        </div>
                        @error('ragam_disabilitas') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1">Detail Disabilitas <span class="text-rose-500">*</span></label>
                        <textarea name="detail_disabilitas" rows="3" required placeholder="Penjelasan kondisi spesifik..."
                            class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-[#1B4E71] focus:border-[#1B4E71] text-sm outline-none transition-all">{{ old('detail_disabilitas') }}</textarea>
                        @error('detail_disabilitas') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1">Alat Bantu yang Digunakan</label>
                        <textarea name="alat_bantu" rows="2" placeholder="Contoh: Kursi roda, Alat bantu dengar..."
                            class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-[#1B4E71] focus:border-[#1B4E71] text-sm outline-none transition-all">{{ old('alat_bantu') }}</textarea>
                        @error('alat_bantu') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1">Kendala / Kesulitan saat Bekerja <span class="text-rose-500">*</span></label>
                        <textarea name="kendala" rows="2" required placeholder="Kendala teknis atau lingkungan kerja..."
                            class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-[#1B4E71] focus:border-[#1B4E71] text-sm outline-none transition-all">{{ old('kendala') }}</textarea>
                        @error('kendala') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1">Akomodasi yang Diperlukan <span class="text-rose-500">*</span></label>
                        <textarea name="akomodasi" rows="2" required placeholder="Fasilitas fisik, perangkat lunak khusus, dll..."
                            class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-[#1B4E71] focus:border-[#1B4E71] text-sm outline-none transition-all">{{ old('akomodasi') }}</textarea>
                        @error('akomodasi') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1">Pendampingan atau Layanan Khusus</label>
                        <textarea name="pendampingan" rows="2" placeholder="Layanan atau asistensi pendamping..."
                            class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-[#1B4E71] focus:border-[#1B4E71] text-sm outline-none transition-all">{{ old('pendampingan') }}</textarea>
                        @error('pendampingan') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            <div>
                <div class="border-b border-slate-200 pb-3 mb-6">
                    <h2 class="text-lg font-bold text-[#083D62]">3. Dokumen Pendukung</h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Scan KTP (.pdf, .jpg, .jpeg, .png, .gif, .webp, .bmp)</label>
                        <input type="file" name="ktp" accept=".pdf,.jpg,.jpeg,.png,.gif,.webp,.bmp"
                            class="block w-full text-sm text-slate-500 border border-slate-300 rounded-xl cursor-pointer bg-slate-50
                                   file:mr-4 file:py-2.5 file:px-4 file:rounded-l-xl file:border-0 file:text-xs file:font-semibold
                                   file:bg-[#1B4E71] file:text-white hover:file:bg-[#143a54] transition-all">
                        @error('ktp') 
                            <p class="text-xs text-rose-500 mt-1 font-medium">{{ $message }}</p> 
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Surat Keterangan Disabilitas (.pdf, .jpg, .jpeg, .png, .gif, .webp, .bmp)</label>
                        <input type="file" name="surat_keterangan" accept=".pdf,.jpg,.jpeg,.png,.gif,.webp,.bmp"
                            class="block w-full text-sm text-slate-500 border border-slate-300 rounded-xl cursor-pointer bg-slate-50
                                   file:mr-4 file:py-2.5 file:px-4 file:rounded-l-xl file:border-0 file:text-xs file:font-semibold
                                   file:bg-[#1B4E71] file:text-white hover:file:bg-[#143a54] transition-all">
                        @error('surat_keterangan') 
                            <p class="text-xs text-rose-500 mt-1 font-medium">{{ $message }}</p> 
                        @enderror
                    </div>
                </div>
            </div>

            <div class="pt-4 border-t border-slate-200 flex justify-end gap-3">
                <a href="{{ route('tendik.index') }}" class="px-5 py-2.5 rounded-xl border border-slate-300 text-slate-700 font-medium text-sm hover:bg-slate-50 transition-all">Batal</a>
                <button type="submit" id="submitBtn" class="px-6 py-2.5 rounded-xl bg-[#1B4E71] hover:bg-[#143a54] text-white font-semibold text-sm transition-all shadow-sm">
                    Simpan Data
                </button>
            </div>
        </form>

    </div>
</main>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const form = document.querySelector("form");
        const btn = document.getElementById("submitBtn");

        if (form && btn) {
            form.addEventListener("submit", function (e) {
                if (form.checkValidity()) {
                    btn.disabled = true;
                    btn.innerText = "Menyimpan Data...";
                    btn.classList.add("opacity-75", "cursor-not-allowed");
                }
            });
        }
    });
</script>
@endsection