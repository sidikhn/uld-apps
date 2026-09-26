@extends('layout.sideBar')

@section('title', 'Detail Profil Dosen & Tendik | Mahasiswa Disabilitas')

@section('content')
<!-- Main Content -->
<main class="flex-1 bg-slate-50 flex flex-col min-h-screen font-sans">
    
    <!-- Top Header Sticky -->
    <div class="flex flex-wrap justify-between items-center bg-[#1B4E71] text-white px-6 md:px-8 py-4 shadow-sm z-20 sticky top-0">
        <!-- Title Area -->
        <div class="flex items-center space-x-3">
            <div class="p-2 bg-white/10 rounded-lg">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
            </div>
            <div>
                <span class="font-bold text-xl tracking-wide block">Data Dosen dan Tendik</span>
                <span class="text-xs text-sky-200 font-normal">Detail informasi profil kepegawaian & aksesibilitas</span>
            </div>
        </div>

        <!-- Contact Button -->
        <a href="https://wa.me/6282227021332" target="_blank"
           class="flex items-center space-x-2 bg-white/10 hover:bg-white/20 px-4 py-2 rounded-lg transition-colors border border-transparent text-sm font-medium">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 21l1.2-4.2A8.959 8.959 0 015 4a8.959 8.959 0 0112.728 12.728A8.959 8.959 0 018.8 19.8L4.2 21z" />
            </svg>
            <span>Hubungi Kami</span>
        </a>
    </div>

    <!-- Scrollable Content -->
    <div class="flex-1 overflow-y-auto p-6 md:p-8">
        <div class="max-w-6xl mx-auto space-y-6">
            
            <!-- Navigation / Back Button -->
            <div>
                <a href="{{ route('tendik.index') }}" 
                   class="inline-flex items-center space-x-2 px-4 py-2 text-sm font-medium text-slate-700 bg-white border border-slate-200 rounded-lg hover:bg-slate-100 hover:text-slate-900 transition-all shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    <span>Kembali ke Daftar</span>
                </a>
            </div>

            <!-- Profile Header Card -->
            <div class="bg-white rounded-xl border border-slate-200 p-6 shadow-sm flex flex-col md:flex-row items-start md:items-center justify-between gap-6">
                <div class="flex items-center space-x-4">
                    <div class="w-16 h-16 rounded-full bg-[#1B4E71] text-white flex items-center justify-center font-bold text-2xl shrink-0 shadow-md">
                        {{ strtoupper(substr($tendik->nama, 0, 1)) }}
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold text-slate-800">{{ $tendik->nama }}</h1>
                        <p class="text-sm font-medium text-slate-500 mt-1 flex flex-wrap items-center gap-2">
                            <span>NIP/NIKA: <strong class="text-slate-700">{{ $tendik->nip_nika ?? '-' }}</strong></span>
                            <span class="text-slate-300">•</span>
                            <span>Unit Kerja: <strong class="text-slate-700">{{ $tendik->unit_kerja ?? '-' }}</strong></span>
                        </p>
                        
                        <div class="flex flex-wrap items-center gap-2 mt-3">
                            @if($tendik->jenis_pegawai)
                                <span class="px-3 py-1 rounded-md text-xs font-semibold bg-sky-50 text-sky-700 border border-sky-200">
                                    {{ $tendik->jenis_pegawai }}
                                </span>
                            @endif
                            @if($tendik->kategori_pegawai)
                                <span class="px-3 py-1 rounded-md text-xs font-semibold bg-indigo-50 text-indigo-700 border border-indigo-200">
                                    {{ $tendik->kategori_pegawai }}
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Grid 2 Kolom untuk Informasi Kepegawaian & Pribadi -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                
                <!-- Card 1: Data Pribadi & Kontak -->
                <div class="bg-white rounded-xl border border-slate-200 p-6 shadow-sm flex flex-col justify-between">
                    <div>
                        <h2 class="text-base font-bold text-[#1B4E71] uppercase tracking-wider border-b border-slate-100 pb-3 mb-4 flex items-center space-x-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#1B4E71]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            <span>Data Pribadi & Kontak</span>
                        </h2>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <div class="bg-slate-50/80 p-3 rounded-lg border border-slate-100">
                                <span class="block text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Nama Lengkap</span>
                                <span class="block text-slate-800 font-semibold text-sm mt-0.5">{{ $tendik->nama ?? '-' }}</span>
                            </div>

                            <div class="bg-slate-50/80 p-3 rounded-lg border border-slate-100">
                                <span class="block text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Tanggal Lahir</span>
                                <span class="block text-slate-800 font-semibold text-sm mt-0.5">
                                    {{ $tendik->tanggal_lahir ? \Carbon\Carbon::parse($tendik->tanggal_lahir)->translatedFormat('d F Y') : '-' }}
                                </span>
                            </div>

                            <div class="bg-slate-50/80 p-3 rounded-lg border border-slate-100 sm:col-span-2">
                                <span class="block text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Alamat Domisili</span>
                                <span class="block text-slate-800 font-semibold text-sm mt-0.5">{{ $tendik->alamat ?? '-' }}</span>
                            </div>

                            <div class="bg-slate-50/80 p-3 rounded-lg border border-slate-100">
                                <span class="block text-[11px] font-semibold text-slate-400 uppercase tracking-wider">No. KTP</span>
                                <span class="block text-slate-800 font-semibold text-sm mt-0.5">{{ $tendik->no_ktp ?? '-' }}</span>
                            </div>

                            <div class="bg-slate-50/80 p-3 rounded-lg border border-slate-100">
                                <span class="block text-[11px] font-semibold text-slate-400 uppercase tracking-wider">No. HP / WA</span>
                                <span class="block text-slate-800 font-semibold text-sm mt-0.5">{{ $tendik->no_hp ?? '-' }}</span>
                            </div>

                            <div class="bg-slate-50/80 p-3 rounded-lg border border-slate-100 sm:col-span-2">
                                <span class="block text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Alamat Email</span>
                                <span class="block text-slate-800 font-semibold text-sm mt-0.5">{{ $tendik->email ?? '-' }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card 2: Informasi Kepegawaian -->
                <div class="bg-white rounded-xl border border-slate-200 p-6 shadow-sm flex flex-col justify-between">
                    <div>
                        <h2 class="text-base font-bold text-[#1B4E71] uppercase tracking-wider border-b border-slate-100 pb-3 mb-4 flex items-center space-x-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#1B4E71]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            <span>Informasi Kepegawaian</span>
                        </h2>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <div class="bg-slate-50/80 p-3 rounded-lg border border-slate-100">
                                <span class="block text-[11px] font-semibold text-slate-400 uppercase tracking-wider">NIP / NIKA</span>
                                <span class="block text-slate-800 font-semibold text-sm mt-0.5">{{ $tendik->nip_nika ?? '-' }}</span>
                            </div>

                            <div class="bg-slate-50/80 p-3 rounded-lg border border-slate-100">
                                <span class="block text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Jenis Pegawai</span>
                                <span class="block text-slate-800 font-semibold text-sm mt-0.5">{{ $tendik->jenis_pegawai ?? '-' }}</span>
                            </div>

                            <div class="bg-slate-50/80 p-3 rounded-lg border border-slate-100">
                                <span class="block text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Kategori Pegawai</span>
                                <span class="block text-slate-800 font-semibold text-sm mt-0.5">{{ $tendik->kategori_pegawai ?? '-' }}</span>
                            </div>

                            <div class="bg-slate-50/80 p-3 rounded-lg border border-slate-100">
                                <span class="block text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Pangkat / Golongan</span>
                                <span class="block text-slate-800 font-semibold text-sm mt-0.5">{{ $tendik->pangkat_golongan ?? '-' }}</span>
                            </div>

                            <div class="bg-slate-50/80 p-3 rounded-lg border border-slate-100 sm:col-span-2">
                                <span class="block text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Unit Kerja</span>
                                <span class="block text-slate-800 font-semibold text-sm mt-0.5">{{ $tendik->unit_kerja ?? '-' }}</span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Card 3: Detail Disabilitas & Aksesibilitas (FULL WIDTH) -->
            <div class="bg-white rounded-xl border border-slate-200 p-6 shadow-sm w-full">
                <h2 class="text-base font-bold text-[#1B4E71] uppercase tracking-wider border-b border-slate-100 pb-3 mb-4 flex items-center space-x-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#1B4E71]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                    </svg>
                    <span>Kebutuhan Disabilitas & Aksesibilitas</span>
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    
                    <!-- Ragam Disabilitas dengan Badges -->
                    <div class="bg-slate-50/80 p-4 rounded-xl border border-slate-100 md:col-span-2">
                        <span class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2">Ragam Disabilitas</span>
                        <div class="flex flex-wrap gap-2">
                            @php
                                $ragamList = is_array($tendik->ragam_disabilitas) 
                                    ? $tendik->ragam_disabilitas 
                                    : (is_string($tendik->ragam_disabilitas) ? array_filter(array_map('trim', explode(',', $tendik->ragam_disabilitas))) : []);
                            @endphp
                            
                            @forelse($ragamList as $ragam)
                                <span class="px-3 py-1 rounded-lg text-xs font-semibold bg-amber-50 text-amber-800 border border-amber-200 shadow-sm">
                                    {{ $ragam }}
                                </span>
                            @empty
                                <span class="text-slate-500 font-medium text-sm">-</span>
                            @endforelse
                        </div>
                    </div>

                    <div class="bg-slate-50/80 p-4 rounded-xl border border-slate-100">
                        <span class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1">Kondisi Disabilitas</span>
                        <p class="text-slate-800 font-medium text-sm leading-relaxed">{{ $tendik->detail_disabilitas ?? '-' }}</p>
                    </div>

                    <div class="bg-slate-50/80 p-4 rounded-xl border border-slate-100">
                        <span class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1">Alat Bantu yang Digunakan</span>
                        <p class="text-slate-800 font-medium text-sm leading-relaxed">{{ $tendik->alat_bantu ?? '-' }}</p>
                    </div>

                    <div class="bg-slate-50/80 p-4 rounded-xl border border-slate-100">
                        <span class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1">Kendala / Kesulitan Mengajar</span>
                        <p class="text-slate-800 font-medium text-sm leading-relaxed">{{ $tendik->kendala ?? '-' }}</p>
                    </div>

                    <div class="bg-slate-50/80 p-4 rounded-xl border border-slate-100">
                        <span class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1">Akomodasi yang Diperlukan</span>
                        <p class="text-slate-800 font-medium text-sm leading-relaxed">{{ $tendik->akomodasi ?? '-' }}</p>
                    </div>

                    <div class="bg-slate-50/80 p-4 rounded-xl border border-slate-100 md:col-span-2">
                        <span class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1">Pendampingan / Layanan Dibutuhkan</span>
                        <p class="text-slate-800 font-medium text-sm leading-relaxed">{{ $tendik->pendampingan ?? '-' }}</p>
                    </div>

                </div>
            </div>

        </div>
    </div>
</main>
@endsection