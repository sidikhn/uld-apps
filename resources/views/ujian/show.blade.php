@extends('layout.sideBar')

@section('title', 'Detail Asesmen Kebutuhan Ujian')

@section('content')

<main class="flex-1 min-h-0 bg-gray-100 flex flex-col">

<!-- ================= HEADER ================= -->
<div class="flex-shrink-0 flex justify-between items-center bg-[#1B4E71] text-white px-6 md:px-8 py-4 shadow-sm">

    <div class="flex items-center space-x-3">

        <div class="bg-white/10 p-2 rounded-lg">
            <svg xmlns="http://www.w3.org/2000/svg"
                 class="h-7 w-7"
                 fill="none"
                 viewBox="0 0 24 24"
                 stroke="currentColor"
                 stroke-width="2">

                <rect x="3" y="3" width="7" height="9" rx="1"/>
                <rect x="14" y="3" width="7" height="5" rx="1"/>
                <rect x="14" y="12" width="7" height="9" rx="1"/>
                <rect x="3" y="16" width="7" height="5" rx="1"/>

            </svg>
        </div>

        <div>
            <h1 class="font-semibold text-xl md:text-2xl">
                Data Asesmen Kebutuhan Ujian
            </h1>

            <p class="text-sm text-white/70 mt-0.5">
                Detail informasi kebutuhan ujian mahasiswa
            </p>
        </div>

    </div>


    <!-- Hubungi Kami -->
    <a href="https://wa.me/6282227021332"
       target="_blank"
       class="hidden md:flex items-center gap-2 text-sm hover:text-gray-200 transition">

        <svg xmlns="http://www.w3.org/2000/svg"
             class="h-5 w-5"
             fill="none"
             viewBox="0 0 24 24"
             stroke="currentColor"
             stroke-width="2">

            <path stroke-linecap="round"
                  stroke-linejoin="round"
                  d="M3 21l1.2-4.2A8.959 8.959 0 015 4a8.959 8.959 0 0112.728 12.728A8.959 8.959 0 018.8 19.8L4.2 21z"/>

        </svg>

        <span>Hubungi Kami</span>

    </a>

</div>


<!-- ================= SCROLL AREA ================= -->
<div class="flex-1 min-h-0 overflow-y-auto">

    <div class="p-6 md:p-8">

        <div class="max-w-5xl mx-auto">



            <!-- ================= IDENTITAS ================= -->
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden mb-6">

                <div class="px-6 py-5 border-b border-gray-100 flex items-center gap-3">

                    <div class="w-10 h-10 rounded-xl bg-blue-50 flex items-center justify-center">

                        <svg xmlns="http://www.w3.org/2000/svg"
                             class="h-5 w-5 text-[#1B4E71]"
                             fill="none"
                             viewBox="0 0 24 24"
                             stroke="currentColor"
                             stroke-width="2">

                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>

                        </svg>

                    </div>

                    <div>
                        <h3 class="font-bold text-gray-800">
                            Identitas Utama
                        </h3>

                        <p class="text-xs text-gray-500">
                            Informasi dasar mahasiswa
                        </p>
                    </div>

                </div>


                <div class="p-6">

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">


                        <!-- Nama -->
                        <div class="group">

                            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-1.5">
                                Nama Lengkap
                            </p>

                            <div class="bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-gray-800 font-semibold">
                                {{ $asesmen_ujian->nama ?? '-' }}
                            </div>

                        </div>


                        <!-- NIM -->
                        <div>

                            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-1.5">
                                NIM
                            </p>

                            <div class="bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-gray-800 font-semibold">
                                {{ $asesmen_ujian->nim ?? '-' }}
                            </div>

                        </div>


                        <!-- Jenis Kelamin -->
                        <div>

                            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-1.5">
                                Jenis Kelamin
                            </p>

                            <div class="bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-gray-700">
                                {{ $asesmen_ujian->jenis_kelamin ?? '-' }}
                            </div>

                        </div>


                        <!-- Tanggal Lahir -->
                        <div>

                            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-1.5">
                                Tanggal Lahir
                            </p>

                            <div class="bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-gray-700">
                                {{ $asesmen_ujian->tanggal_lahir ?? '-' }}
                            </div>

                        </div>


                        <!-- Fakultas -->
                        <div>

                            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-1.5">
                                Fakultas
                            </p>

                            <div class="bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-gray-700">
                                {{ $asesmen_ujian->fakultas ?? '-' }}
                            </div>

                        </div>


                        <!-- Prodi -->
                        <div>

                            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-1.5">
                                Program Studi
                            </p>

                            <div class="bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-gray-700">
                                {{ $asesmen_ujian->prodi ?? '-' }}
                            </div>

                        </div>


                        <!-- Semester -->
                        <div>

                            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-1.5">
                                Semester
                            </p>

                            <div class="bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-gray-700">
                                {{ $asesmen_ujian->semester ?? '-' }}
                            </div>

                        </div>


                        <!-- Ragam Disabilitas -->
                        <div>

                            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-1.5">
                                Ragam Disabilitas
                            </p>

                            <div class="bg-blue-50 border border-blue-100 rounded-xl px-4 py-3 text-[#1B4E71] font-semibold">
                                {{ $asesmen_ujian->ragam_disabilitas ?? '-' }}
                            </div>

                        </div>

                    </div>

                </div>

            </div>



            <!-- ================= INFORMASI TAMBAHAN ================= -->
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden mb-6">

                <div class="px-6 py-5 border-b border-gray-100 flex items-center gap-3">

                    <div class="w-10 h-10 rounded-xl bg-amber-50 flex items-center justify-center">

                        <svg xmlns="http://www.w3.org/2000/svg"
                             class="h-5 w-5 text-amber-600"
                             fill="none"
                             viewBox="0 0 24 24"
                             stroke="currentColor"
                             stroke-width="2">

                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  d="M13 16h-1v-4h-1m1-4h.01M12 21a9 9 0 100-18 9 9 0 000 18z"/>

                        </svg>

                    </div>

                    <div>
                        <h3 class="font-bold text-gray-800">
                            Informasi Tambahan
                        </h3>

                        <p class="text-xs text-gray-500">
                            Kebutuhan dan penyesuaian selama pelaksanaan ujian
                        </p>
                    </div>

                </div>


                <div class="p-6 space-y-5">


                    <!-- Perpanjangan Waktu -->
                    <div>

                        <div class="flex items-center justify-between mb-2">

                            <p class="text-sm font-bold text-[#083D62]">
                                Keperluan Perpanjangan Waktu
                            </p>

                            <span class="text-xs text-gray-400">
                                01
                            </span>

                        </div>

                        <div class="bg-gray-50 border border-gray-200 rounded-xl p-4 text-sm text-gray-700 leading-relaxed whitespace-pre-line min-h-[70px]">

                            {{ $asesmen_ujian->keperluan_perpanjangan ?? $asesmen_ujian->detail_disabilitas ?? '-' }}

                        </div>

                    </div>


                    <!-- Alat Bantu -->
                    <div>

                        <div class="flex items-center justify-between mb-2">

                            <p class="text-sm font-bold text-[#083D62]">
                                Alat Bantu
                            </p>

                            <span class="text-xs text-gray-400">
                                02
                            </span>

                        </div>

                        <div class="bg-gray-50 border border-gray-200 rounded-xl p-4 text-sm text-gray-700 leading-relaxed whitespace-pre-line min-h-[70px]">

                            {{ $asesmen_ujian->alat_bantu ?? '-' }}

                        </div>

                    </div>


                    <!-- Preferensi Format -->
                    <div>

                        <div class="flex items-center justify-between mb-2">

                            <p class="text-sm font-bold text-[#083D62]">
                                Preferensi Format Soal Ujian
                            </p>

                            <span class="text-xs text-gray-400">
                                03
                            </span>

                        </div>

                        <div class="bg-gray-50 border border-gray-200 rounded-xl p-4 text-sm text-gray-700 leading-relaxed whitespace-pre-line min-h-[70px]">

                            {{ $asesmen_ujian->preferensi_format ?? $asesmen_ujian->kendala ?? '-' }}

                        </div>

                    </div>


                    <!-- Pendampingan -->
                    <div>

                        <div class="flex items-center justify-between mb-2">

                            <p class="text-sm font-bold text-[#083D62]">
                                Keperluan Pendampingan saat Ujian
                            </p>

                            <span class="text-xs text-gray-400">
                                04
                            </span>

                        </div>

                        <div class="bg-gray-50 border border-gray-200 rounded-xl p-4 text-sm text-gray-700 leading-relaxed whitespace-pre-line min-h-[70px]">

                            {{ $asesmen_ujian->keperluan_pendampingan ?? $asesmen_ujian->akomodasi ?? '-' }}

                        </div>

                    </div>


                    <!-- Penyesuaian Lain -->
                    <div>

                        <div class="flex items-center justify-between mb-2">

                            <p class="text-sm font-bold text-[#083D62]">
                                Penyesuaian Lain yang Diperlukan
                            </p>

                            <span class="text-xs text-gray-400">
                                05
                            </span>

                        </div>

                        <div class="bg-gray-50 border border-gray-200 rounded-xl p-4 text-sm text-gray-700 leading-relaxed whitespace-pre-line min-h-[70px]">

                            {{ $asesmen_ujian->penyesuaian_lain ?? $asesmen_ujian->pendampingan ?? '-' }}

                        </div>

                    </div>

                </div>

            </div>



            <!-- ================= DOKUMEN ================= -->
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden mb-6">

                <div class="px-6 py-5 border-b border-gray-100 flex items-center gap-3">

                    <div class="w-10 h-10 rounded-xl bg-red-50 flex items-center justify-center">

                        <svg xmlns="http://www.w3.org/2000/svg"
                             class="h-5 w-5 text-red-500"
                             fill="none"
                             viewBox="0 0 24 24"
                             stroke="currentColor"
                             stroke-width="2">

                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>

                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  d="M13 3v6h6"/>

                        </svg>

                    </div>

                    <div>
                        <h3 class="font-bold text-gray-800">
                            Dokumen Asesmen
                        </h3>

                        <p class="text-xs text-gray-500">
                            Surat hasil asesmen kebutuhan ujian
                        </p>
                    </div>

                </div>


                <div class="p-6">

                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-gray-50 border border-gray-200 rounded-xl p-4">

                        <div class="flex items-center gap-3">

                            <div class="w-11 h-11 bg-red-100 rounded-lg flex items-center justify-center">

                                <svg xmlns="http://www.w3.org/2000/svg"
                                     class="h-6 w-6 text-red-600"
                                     fill="none"
                                     viewBox="0 0 24 24"
                                     stroke="currentColor"
                                     stroke-width="2">

                                    <path stroke-linecap="round"
                                          stroke-linejoin="round"
                                          d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>

                                    <path stroke-linecap="round"
                                          stroke-linejoin="round"
                                          d="M13 3v6h6"/>

                                </svg>

                            </div>

                            <div>

                                <p class="font-semibold text-gray-800">
                                    Surat Hasil Asesmen
                                </p>

                                <p class="text-xs text-gray-500">
                                    Dokumen PDF hasil asesmen
                                </p>

                            </div>

                        </div>


                        <a href="{{ route('asesmen_ujian.pdf', $asesmen_ujian->id) }}"
                           target="_blank"
                           class="inline-flex items-center justify-center gap-2 bg-[#1B4E71] hover:bg-[#143a54] text-white px-4 py-2.5 rounded-lg text-sm font-medium transition">

                            <svg xmlns="http://www.w3.org/2000/svg"
                                 class="h-4 w-4"
                                 fill="none"
                                 viewBox="0 0 24 24"
                                 stroke="currentColor"
                                 stroke-width="2">

                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>

                            </svg>

                            Lihat PDF

                        </a>

                    </div>

                </div>

            </div>



            <!-- ================= FOOTER ACTION ================= -->
            <div class="flex justify-end items-center gap-3 pb-4">

                <a href="{{ route('ujian.index') }}"
                   class="px-5 py-2.5 rounded-lg border border-gray-300 bg-white hover:bg-gray-50 text-gray-700 text-sm font-medium transition">

                    Kembali ke Data

                </a>


                @if(auth()->user()->role === 'superadmin')

                    <a href="{{ route('ujian.edit', $asesmen_ujian->id) }}"
                       class="inline-flex items-center gap-2 px-5 py-2.5 rounded-lg bg-[#1B4E71] hover:bg-[#143a54] text-white text-sm font-medium transition">

                        <svg xmlns="http://www.w3.org/2000/svg"
                             class="h-4 w-4"
                             fill="none"
                             viewBox="0 0 24 24"
                             stroke="currentColor">

                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  stroke-width="2"
                                  d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/>

                        </svg>

                        Edit Data

                    </a>

                @endif

            </div>

        </div>

    </div>

</div>

</main>

@endsection
