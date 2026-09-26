@extends('layout.sideBar')

@section('title', 'Dashboard | Mahasiswa Disabilitas')

@section('content')

<main class="flex-1 bg-gray-100 flex flex-col h-screen min-h-0 overflow-hidden">

    {{-- Header --}}
    <div class="flex-shrink-0 flex justify-between w-full items-center space-x-3 bg-[#1B4E71] text-white px-6 py-2 cursor-pointer h-18">

        <div class="flex items-center space-x-3">
            <svg xmlns="http://www.w3.org/2000/svg"
                class="h-8 w-8"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
                stroke-width="2">
                <rect x="3" y="3" width="7" height="9" rx="1"/>
                <rect x="14" y="3" width="7" height="5" rx="1"/>
                <rect x="14" y="12" width="7" height="9" rx="1"/>
                <rect x="3" y="16" width="7" height="5" rx="1"/>
            </svg>

            <span class="font-medium text-2xl">
                Data Asesmen Kebutuhan Ujian Mahasiswa
            </span>
        </div>

        <a href="https://wa.me/6282227021332"
            target="_blank"
            class="flex items-center space-x-1 hover:text-gray-200 transition">

            <svg xmlns="http://www.w3.org/2000/svg"
                class="h-5 w-5"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
                stroke-width="2">
                <path stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M3 21l1.2-4.2A8.959 8.959 0 015 4a8.959 8.959 0 0112.728 12.728A8.959 8.959 0 018.8 19.8L4.2 21z" />
            </svg>

            <span>Hubungi Kami</span>
        </a>
    </div>

    {{-- AREA YANG BISA SCROLL --}}
    <div class="flex-1 min-h-0 overflow-y-auto bg-gray-100 p-6">

        <div class="max-w-5xl mx-auto bg-white rounded-xl shadow p-6">

            <form action="{{ route('ujian.update', $asesmen_ujian->id) }}"
                method="POST"
                enctype="multipart/form-data">

                @csrf
                @method('PUT')

                {{-- Judul --}}
                <div class="flex items-center justify-between mb-6">

                    <h2 class="text-2xl font-semibold text-[#083D62]">
                        Edit Data Asesmen Ujian Mahasiswa
                    </h2>

                    <a href="{{ route('ujian.index') }}"
                        class="flex items-center space-x-1 text-gray-700 bg-gray-200 hover:bg-gray-300 p-2 rounded-lg">

                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="h-5 w-5"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="2">
                            <path stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M15 19l-7-7 7-7" />
                        </svg>

                        <span class="font-medium">
                            Kembali
                        </span>
                    </a>

                </div>

                {{-- Identitas Utama --}}
                <div class="grid grid-cols-2 gap-4">

                    <div>
                        <label class="block font-medium text-[#083D62]">
                            Nama Lengkap
                        </label>

                        <input type="text"
                            name="nama"
                            value="{{ old('nama', $asesmen_ujian->nama) }}"
                            class="w-full border rounded-2xl p-2 mt-1"
                            required>
                    </div>

                    <div>
                        <label class="block font-medium text-[#083D62]">
                            Jenis Kelamin
                        </label>

                        <select name="jenis_kelamin"
                            class="w-full border rounded-2xl p-2 mt-1"
                            required>

                            <option value="">-- Pilih --</option>

                            <option value="Laki-laki"
                                {{ old('jenis_kelamin', $asesmen_ujian->jenis_kelamin) == 'Laki-laki' ? 'selected' : '' }}>
                                Laki-laki
                            </option>

                            <option value="Perempuan"
                                {{ old('jenis_kelamin', $asesmen_ujian->jenis_kelamin) == 'Perempuan' ? 'selected' : '' }}>
                                Perempuan
                            </option>

                        </select>
                    </div>

                    <div>
                        <label class="block font-medium text-[#083D62]">
                            Tanggal Lahir
                        </label>

                        <input type="date"
                            name="tanggal_lahir"
                            value="{{ old('tanggal_lahir', $asesmen_ujian->tanggal_lahir) }}"
                            class="w-full border rounded-2xl p-2 mt-1"
                            required>
                    </div>

                    <div>
                        <label class="block font-medium text-[#083D62]">
                            NIM
                        </label>

                        <input type="text"
                            name="nim"
                            value="{{ old('nim', $asesmen_ujian->nim) }}"
                            class="w-full border rounded-2xl p-2 mt-1"
                            required>
                    </div>

                    <div>
                        <label class="block font-medium text-[#083D62]">
                            Program Studi
                        </label>

                        <input type="text"
                            name="prodi"
                            value="{{ old('prodi', $asesmen_ujian->prodi) }}"
                            class="w-full border rounded-2xl p-2 mt-1"
                            required>
                    </div>

                    <div>
                        <label class="block font-medium text-[#083D62]">
                            Fakultas
                        </label>

                        <input type="text"
                            name="fakultas"
                            value="{{ old('fakultas', $asesmen_ujian->fakultas) }}"
                            class="w-full border rounded-2xl p-2 mt-1"
                            required>
                    </div>

                    <div>
                        <label class="block font-medium text-[#083D62]">
                            Semester
                        </label>

                        <input type="text"
                            name="semester"
                            value="{{ old('semester', $asesmen_ujian->semester) }}"
                            class="w-full border rounded-2xl p-2 mt-1"
                            required>
                    </div>

                    <div>
                        <label class="block font-medium text-[#083D62]">
                            Ragam Disabilitas
                        </label>

                        <input type="text"
                            name="ragam_disabilitas"
                            value="{{ old('ragam_disabilitas', $asesmen_ujian->ragam_disabilitas) }}"
                            class="w-full border rounded-2xl p-2 mt-1"
                            required>
                    </div>

                </div>

                {{-- Informasi Tambahan --}}
                <h2 class="text-2xl font-semibold mt-8 mb-4 text-[#083D62]">
                    Informasi Tambahan
                </h2>

                <div class="grid grid-cols-2 gap-4">

                    <div class="col-span-2">
                        <label class="block font-medium text-[#083D62]">
                            Keperluan Perpanjangan Waktu
                        </label>

                        <textarea name="keperluan_perpanjangan"
                            class="w-full border rounded-2xl p-2 mt-2"
                            rows="4">{{ old('keperluan_perpanjangan', $asesmen_ujian->keperluan_perpanjangan) }}</textarea>
                    </div>

                    <div class="col-span-2">
                        <label class="block font-medium text-[#083D62]">
                            Alat Bantu
                        </label>

                        <textarea name="alat_bantu"
                            class="w-full border rounded-2xl p-2 mt-2"
                            rows="4">{{ old('alat_bantu', $asesmen_ujian->alat_bantu) }}</textarea>
                    </div>

                    <div class="col-span-2">
                        <label class="block font-medium text-[#083D62]">
                            Preferensi Format Soal Ujian
                        </label>

                        <textarea name="preferensi_format"
                            class="w-full border rounded-2xl p-2 mt-2"
                            rows="4">{{ old('preferensi_format', $asesmen_ujian->preferensi_format) }}</textarea>
                    </div>

                    <div class="col-span-2">
                        <label class="block font-medium text-[#083D62]">
                            Keperluan Pendampingan saat Ujian
                        </label>

                        <textarea name="keperluan_pendampingan"
                            class="w-full border rounded-2xl p-2 mt-2"
                            rows="4">{{ old('keperluan_pendampingan', $asesmen_ujian->keperluan_pendampingan) }}</textarea>
                    </div>

                    <div class="col-span-2">
                        <label class="block font-medium text-[#083D62]">
                            Penyesuaian Lain yang Diperlukan
                        </label>

                        <textarea name="penyesuaian_lain"
                            class="w-full border rounded-2xl p-2 mt-2"
                            rows="4">{{ old('penyesuaian_lain', $asesmen_ujian->penyesuaian_lain) }}</textarea>
                    </div>

                </div>

                {{-- Tombol --}}
                <div class="mt-8 pb-2">
                    <button type="submit"
                        class="bg-[#174A6F] hover:bg-[#123B59] text-white px-6 py-2 rounded-lg cursor-pointer transition">

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

@endsection