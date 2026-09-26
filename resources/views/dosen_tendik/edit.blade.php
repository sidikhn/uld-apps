@extends('layout.sideBar')

@section('title', 'Edit Data Dosen dan Tendik')

@section('content')
<main class="flex-1 min-h-0 bg-gray-100 overflow-y-auto p-6">
    <div class="max-w-5xl mx-auto bg-white rounded-xl shadow p-6">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-semibold text-[#083D62]">Edit Data Dosen dan Tendik</h1>
            <a href="{{ route('tendik.index') }}" class="px-4 py-2 rounded-lg bg-gray-200 text-gray-700 hover:bg-gray-300">Kembali</a>
        </div>
        @include('dosen_tendik._form', ['action' => route('tendik.update', $tendik->id), 'method' => 'PUT', 'tendik' => $tendik])
    </div>
</main>
@endsection{{--@extends('layout.sideBar')

@section('title', 'Dashboard | Mahasiswa Disabilitas')

@section('content')
    <!-- Main Content -->
    <main class="flex-1 bg-gray-100 flex flex-col">
        <div class="flex justify-between w-full items-center space-x-3 bg-[#1B4E71] text-white px-6 py-2 cursor-pointer h-18">
            <!-- Home Simple -->
            <div class="flex items-center space-x-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" 
                            fill="none" viewBox="0 0 24 24" 
                            stroke="currentColor" stroke-width="2">
                            <path d="M22 10l-10-5L2 10l10 5 10-5z" 
                                class=" group-hover:stroke-white"/>
                            <path d="M6 12v5c3 3 9 3 12 0v-5" 
                                class=" group-hover:stroke-white"/>
                </svg>

                <!-- Teks -->
                <span class="font-medium text-2xl">Data Dosen dan Tendik</span>
            </div>
            
            <!-- Narahubung (kanan) -->
            <a href="https://wa.me/6282227021332" target="_blank"
            class="flex items-center space-x-1 hover:text-gray-200 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M3 21l1.2-4.2A8.959 8.959 0 015 4a8.959 8.959 0 0112.728 12.728A8.959 8.959 0 018.8 19.8L4.2 21z" />
                </svg>
                <span>Hubungi Kami</span>
            </a>
        </div>

        <div class="flex-1 overflow-y-auto bg-gray-100 p-6">
            {{-- <div class="flex-1 overflow-y-auto bg-gray-100"> --}}
            {{-- <div class="p-6 bg-white rounded-xl shadow"> --}}
            <div class="max-w-5xl mx-auto bg-white rounded-xl shadow p-6">
                <form action="{{ route('tendik.update', $tendik->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <!-- 1. Identitas Utama -->
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-2xl font-semibold mb-4 text-[#083D62]">Edit Data Dosen dan Tendik</h2>
                        <a href="{{ route('tendik.index') }}" 
                        class="flex items-center space-x-1 text-gray-700 cursor-pointer  bg-gray-200 hover:bg-gray-300 p-2 rounded w-26">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" 
                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                            </svg>
                            <span class="font-medium">Kembali</span>
                        </a>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block font-medium text-[#083D62]">Nama Lengkap</label>
                            <input type="text" name="nama" 
                                value="{{ old('nama', $tendik->nama) }}" 
                                class="w-full border rounded-2xl p-2 mt-1" required>
                        </div>

                        <div>
                            <label class="block font-medium text-[#083D62]">Jenis Kelamin</label>
                            <select name="jenis_kelamin" class="w-full border rounded-2xl p-2 mt-1">
                                <option value="">-- Pilih --</option>
                                <option value="Laki-laki" {{ old('jenis_kelamin', $tendik->jenis_kelamin) == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="Perempuan" {{ old('jenis_kelamin', $tendik->jenis_kelamin) == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                        </div>

                        <div>
                            <label class="block font-medium text-[#083D62]">Tanggal Lahir</label>
                            <input type="date" name="tanggal_lahir" 
                                value="{{ old('tanggal_lahir', $tendik->tanggal_lahir) }}" 
                                class="w-full border rounded-2xl p-2 mt-1" required>
                        </div>

                        <div><label class="block font-medium text-[#083D62]">Alamat</label><input type="text" name="alamat" value="{{ old('alamat', $tendik->alamat) }}" class="w-full border rounded-2xl p-2 mt-1" required></div>
                        <div><label class="block font-medium text-[#083D62]">No. KTP</label><input type="text" name="no_ktp" value="{{ old('no_ktp', $tendik->no_ktp) }}" class="w-full border rounded-2xl p-2 mt-1" required></div>
                        <div><label class="block font-medium text-[#083D62]">Email</label><input type="email" name="email" value="{{ old('email', $tendik->email) }}" class="w-full border rounded-2xl p-2 mt-1" required></div>
                        <div><label class="block font-medium text-[#083D62]">No HP</label><input type="text" name="no_hp" value="{{ old('no_hp', $tendik->no_hp) }}" class="w-full border rounded-2xl p-2 mt-1" required></div>
                        <div><label class="block font-medium text-[#083D62]">NIP/NIKA</label><input type="text" name="nip_nika" value="{{ old('nip_nika', $tendik->nip_nika) }}" class="w-full border rounded-2xl p-2 mt-1" required></div>
                        <div><label class="block font-medium text-[#083D62]">Jenis Pegawai</label><select name="jenis_pegawai" class="w-full border rounded-2xl p-2 mt-1" required><option value="">Pilih</option>@foreach(['PNS','Pegawai tetap UGM','Pegawai kontrak'] as $value)<option @selected(old('jenis_pegawai', $tendik->jenis_pegawai) === $value)>{{ $value }}</option>@endforeach</select></div>
                        <div><label class="block font-medium text-[#083D62]">Kategori Pegawai</label><select name="kategori_pegawai" class="w-full border rounded-2xl p-2 mt-1" required><option value="">Pilih</option>@foreach(['Dosen','Tenaga kependidikan'] as $value)<option @selected(old('kategori_pegawai', $tendik->kategori_pegawai) === $value)>{{ $value }}</option>@endforeach</select></div>
                        <div><label class="block font-medium text-[#083D62]">Unit Kerja</label><input type="text" name="unit_kerja" value="{{ old('unit_kerja', $tendik->unit_kerja) }}" class="w-full border rounded-2xl p-2 mt-1" required></div>
                        <div><label class="block font-medium text-[#083D62]">Pangkat/Golongan Terakhir</label><input type="text" name="pangkat_golongan" value="{{ old('pangkat_golongan', $tendik->pangkat_golongan) }}" class="w-full border rounded-2xl p-2 mt-1"></div>

                        <div>
                            <label class="block font-medium text-[#083D62]">NIP</label>
                        </div>

                        <div>
                            <label class="block font-medium text-[#083D62]">Program Studi</label>
                        </div>

                        <div>
                            <label class="block font-medium text-[#083D62]">Fakultas</label>
                            <input type="hidden" name="fakultas" value="">
                        </div>

                        <div>
                            <label class="block font-medium text-[#083D62]">Pendidikan</label>
                            <input type="hidden" name="pendidikan" value="">
                        </div>

                        <div>
                            <label class="block font-medium text-[#083D62]">Tahun Masuk</label>
                        </div>

                        <div>
                            <label class="block font-medium text-[#083D62]">Nomor HP</label>
                            <input type="hidden" name="nomor_hp" value="">
                        </div>

                        <div>
                            <label class="block font-medium text-[#083D62]">Ragam Disabilitas</label>
                            @php($disabilities = old('ragam_disabilitas', $tendik->ragam_disabilitas ?: []))
                            <div class="grid grid-cols-2 gap-2 mt-1">@foreach(['Fisik','Sensorik','Mental','Intelektual','Psikososial','Lainnya'] as $value)<label><input type="checkbox" name="ragam_disabilitas[]" value="{{ $value }}" @checked(is_array($disabilities) && in_array($value, $disabilities, true))> {{ $value }}</label>@endforeach</div>
                        </div>

                        <div>
                            <label class="block font-medium text-[#083D62]">Surat Keterangan Disabilitas</label>
                            <input type="text" name="surat_keterangan_link" 
                                value="{{ old('surat_keterangan_link', $tendik->surat_keterangan_link) }}" 
                                class="w-full border rounded-2xl p-2 mt-1">
                        </div>

                        <div>
                            <label class="block font-medium mb-1 text-[#083D62]">Upload Surat Keterangan Baru</label>
                            <div class="w-full border rounded-2xl p-2 pl-5 bg-[#FFFFFF]">
                                <input type="file" 
                                    name="surat_keterangan"
                                    class="w-full text-sm text-gray-600
                                            file:mr-4 file:py-2 file:px-4
                                            file:rounded-md file:border-0
                                            file:text-sm file:font-semibold
                                            file:bg-[#dedede] file:text-[#7B7E89]
                                            hover:file:bg-[#78a6ba] hover:file:text-[#FFFFFF]"
                                    accept=".pdf,.jpg,.png">
                            </div>
                            @if($tendik->surat_keterangan)
                                <p class="mt-1 text-sm text-gray-500">File lama: {{ $tendik->surat_keterangan }}</p>
                            @endif
                        </div>
                    </div>

                    <!-- 2. Informasi Tambahan -->
                    <h2 class="text-2xl font-semibold mt-8 mb-4 text-[#083D62]">Informasi Tambahan</h2>

                    <div class="grid grid-cols-2 gap-4">
                        <div class="col-span-2">
                            <label class="block font-medium text-[#083D62]">Detail Disabilitas</label>
                            <textarea name="detail_disabilitas" class="w-full border rounded-2xl p-2 mt-2">{{ old('detail_disabilitas', $tendik->detail_disabilitas) }}</textarea>
                        </div>

                        <div class="col-span-2">
                            <label class="block font-medium text-[#083D62]">Alat Bantu</label>
                            <textarea name="alat_bantu" class="w-full border rounded-2xl p-2 mt-2">{{ old('alat_bantu', $tendik->alat_bantu) }}</textarea>
                        </div>

                        <div class="col-span-2">
                            <label class="block font-medium text-[#083D62]">Kesulitan/Kendala saat mengajar</label>
                            <textarea name="kendala" class="w-full border rounded-2xl p-2 mt-2">{{ old('kendala', $tendik->kendala) }}</textarea>
                        </div>

                        <div class="col-span-2">
                            <label class="block font-medium text-[#083D62]">Akomodasi yang diperlukan</label>
                            <textarea name="akomodasi" class="w-full border rounded-2xl p-2 mt-2">{{ old('akomodasi', $tendik->akomodasi) }}</textarea>
                        </div>

                        <div class="col-span-2">
                            <label class="block font-medium text-[#083D62]">Pendampingan atau layanan</label>
                            <textarea name="pendampingan" class="w-full border rounded-2xl p-2 mt-2">{{ old('pendampingan', $tendik->pendampingan) }}</textarea>
                        </div>
                    </div>

                    <!-- Tombol -->
                    <div class="mt-6">
                        <button type="submit" class="bg-[#174A6F] text-white px-4 py-2 rounded-lg cursor-pointer">
                            Update
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </main>
    <script>
        function toggleUserMenu() {
            const menu = document.getElementById('user-menu');
            menu.classList.toggle('hidden');
        }
    </script>
--}}