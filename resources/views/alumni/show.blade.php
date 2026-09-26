@extends('layout.sideBar')

@section('title', 'Detail Profil Alumni Disabilitas')

@section('content')
<!-- Main Content -->
<main class="flex-1 bg-slate-50 flex flex-col min-h-screen font-sans">
    
    <!-- Top Header Sticky -->
    <div class="flex flex-wrap justify-between items-center bg-[#1B4E71] text-white px-6 md:px-8 py-4 shadow-sm z-20 sticky top-0">
        <!-- Title Area -->
        <div class="flex items-center space-x-3">
            <div class="p-2 bg-white/10 rounded-lg">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                </svg>
            </div>
            <div>
                <span class="font-bold text-xl tracking-wide block">Data Alumni</span>
                <span class="text-xs text-sky-200 font-normal">Detail informasi alumni & rekam jejak karir</span>
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
            
            <!-- Navigation Header -->
            <div class="flex items-center justify-between">
                <a href="{{ route('alumni.index') }}" 
                   class="inline-flex items-center space-x-2 px-4 py-2 text-sm font-medium text-slate-700 bg-white border border-slate-200 rounded-lg hover:bg-slate-100 hover:text-slate-900 transition-all shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    <span>Kembali ke Daftar Alumni</span>
                </a>
            </div>

            <!-- Warning Alert (Warna Merah: Hilang jika aktivitas sudah diisi) -->
            @if(empty($alumni->aktivitas_saat_ini))
                <div class="flex items-start p-4 rounded-xl border border-red-200 bg-red-50 text-red-800 shadow-sm space-x-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-600 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                    <div class="text-sm">
                        <span class="font-bold">Perhatian:</span> Data aktivitas alumni saat ini belum diisi. Silakan perbarui data melalui menu Edit.
                    </div>
                </div>
            @endif

            <!-- Main Profile Header Card -->
            <div class="bg-white rounded-xl border border-slate-200 p-6 shadow-sm flex flex-col md:flex-row items-start md:items-center justify-between gap-6">
                <div class="flex items-center space-x-4">
                    <div class="w-16 h-16 rounded-full bg-[#1B4E71] text-white flex items-center justify-center font-bold text-2xl shrink-0 shadow-md">
                        {{ strtoupper(substr($alumni->nama, 0, 1)) }}
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold text-slate-800">{{ $alumni->nama }}</h1>
                        <p class="text-sm font-medium text-slate-500 mt-1">
                            NIM: <strong class="text-slate-700">{{ $alumni->nim ?? '-' }}</strong>
                        </p>
                        
                        <!-- Disability Badges -->
                        @php
                            $disabilities = is_array($alumni->ragam_disabilitas) 
                                ? $alumni->ragam_disabilitas 
                                : (is_string($alumni->ragam_disabilitas) ? array_filter(array_map('trim', explode(',', $alumni->ragam_disabilitas))) : []);
                        @endphp
                        
                        <div class="flex flex-wrap gap-1.5 mt-2">
                            @forelse($disabilities as $dis)
                                <span class="px-2.5 py-0.5 rounded-md text-xs font-semibold bg-sky-50 text-sky-700 border border-sky-200">
                                    {{ $dis }}
                                </span>
                            @empty
                                <span class="text-xs text-slate-400 italic">Tidak ada ragam disabilitas terdaftar</span>
                            @endforelse
                        </div>
                    </div>
                </div>

                @if($alumni->url_linkedin)
                    <a href="{{ $alumni->url_linkedin }}" target="_blank" 
                       class="inline-flex items-center space-x-2 bg-[#0A66C2] text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-[#084e96] transition-colors shadow-sm">
                        <svg class="h-4 w-4 fill-current" viewBox="0 0 24 24">
                            <path d="M19 3a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h14m-.5 15.5v-5.3a3.26 3.26 0 0 0-3.26-3.26c-.85 0-1.84.52-2.28 1.3v-1.11h-2.79v8.37h2.79v-4.93c0-.77.62-1.4 1.39-1.4a1.4 1.4 0 0 1 1.4 1.4v4.93h2.75M6.88 8.56a1.68 1.68 0 0 0 1.68-1.68c0-.93-.75-1.69-1.68-1.69a1.69 1.69 0 0 0-1.69 1.69c0 .93.76 1.68 1.69 1.68m1.39 9.94v-8.37H5.5v8.37h2.77z"/>
                        </svg>
                        <span>Kunjungi LinkedIn</span>
                    </a>
                @endif
            </div>

            <!-- Details Section Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                
                <!-- Card 1: Data Pribadi & Kontak -->
                <div class="bg-white rounded-xl border border-slate-200 p-6 shadow-sm flex flex-col justify-between">
                    <div>
                        <h2 class="text-base font-bold text-[#1B4E71] uppercase tracking-wider border-b border-slate-100 pb-3 mb-4 flex items-center space-x-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#1B4E71]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            <span>Informasi Pribadi & Kontak</span>
                        </h2>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <div class="bg-slate-50/80 p-3 rounded-lg border border-slate-100">
                                <span class="block text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Jenis Kelamin</span>
                                <span class="block text-slate-800 font-semibold text-sm mt-0.5">{{ $alumni->jenis_kelamin ?? '-' }}</span>
                            </div>

                            <div class="bg-slate-50/80 p-3 rounded-lg border border-slate-100">
                                <span class="block text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Tanggal Lahir</span>
                                <span class="block text-slate-800 font-semibold text-sm mt-0.5">
                                    {{ $alumni->tanggal_lahir ? \Carbon\Carbon::parse($alumni->tanggal_lahir)->translatedFormat('d F Y') : '-' }}
                                </span>
                            </div>

                            <div class="bg-slate-50/80 p-3 rounded-lg border border-slate-100">
                                <span class="block text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Email Aktif</span>
                                <span class="block text-slate-800 font-semibold text-sm mt-0.5">{{ $alumni->email_aktif ?? '-' }}</span>
                            </div>

                            <div class="bg-slate-50/80 p-3 rounded-lg border border-slate-100">
                                <span class="block text-[11px] font-semibold text-slate-400 uppercase tracking-wider">No. HP / WhatsApp</span>
                                <span class="block text-slate-800 font-semibold text-sm mt-0.5">{{ $alumni->nomor_hp ?? '-' }}</span>
                            </div>

                            <div class="bg-slate-50/80 p-3 rounded-lg border border-slate-100 sm:col-span-2">
                                <span class="block text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Alamat Domisili</span>
                                <span class="block text-slate-800 font-semibold text-sm mt-0.5">{{ $alumni->alamat_domisili ?? '-' }}</span>
                            </div>

                            <div class="bg-slate-50/80 p-3 rounded-lg border border-slate-100 sm:col-span-2">
                                <span class="block text-[11px] font-semibold text-slate-400 uppercase tracking-wider mb-1">Surat Keterangan Disabilitas</span>
                                <div>
                                    @if($alumni->surat_keterangan_link)
                                        <a href="{{ $alumni->surat_keterangan_link }}" target="_blank" 
                                           class="inline-flex items-center space-x-1.5 text-xs font-semibold bg-teal-50 text-teal-700 border border-teal-200 px-3 py-1.5 rounded-md hover:bg-teal-600 hover:text-white transition-colors">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                            </svg>
                                            <span>Buka Dokumen Surat Keterangan</span>
                                        </a>
                                    @else
                                        <span class="text-slate-400 italic text-xs">Tidak ada dokumen dilampirkan</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card 2: Aktivitas Saat Ini & Pekerjaan -->
                <div class="bg-white rounded-xl border border-slate-200 p-6 shadow-sm flex flex-col justify-between">
                    <div>
                        <h2 class="text-base font-bold text-[#1B4E71] uppercase tracking-wider border-b border-slate-100 pb-3 mb-4 flex items-center space-x-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#1B4E71]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            <span>Aktivitas & Karir</span>
                        </h2>

                        @php
                            // Pemetaan kode (B1, B2, dsb) ke label teks ramah pengguna
                            $mapAktivitas = [
                                'B1' => 'Bekerja',
                                'B2' => 'Wirausaha',
                                'B3' => 'Studi Lanjut',
                                'B4' => 'Belum / Mencari Kerja',
                            ];
                            $keyAktivitas = trim($alumni->aktivitas_saat_ini ?? '');
                            $labelAktivitas = $mapAktivitas[$keyAktivitas] ?? ($keyAktivitas ?: '-');
                        @endphp

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <div class="bg-slate-50/80 p-3 rounded-lg border border-slate-100 sm:col-span-2">
                                <span class="block text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Aktivitas Saat Ini</span>
                                <span class="block text-slate-900 font-bold text-base mt-0.5">
                                    {{ $labelAktivitas }}
                                </span>
                            </div>

                            <div class="bg-slate-50/80 p-3 rounded-lg border border-slate-100">
                                <span class="block text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Tempat Kerja</span>
                                <span class="block text-slate-800 font-semibold text-sm mt-0.5">{{ $alumni->nama_tempat_kerja ?? '-' }}</span>
                            </div>

                            <div class="bg-slate-50/80 p-3 rounded-lg border border-slate-100">
                                <span class="block text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Jenis Institusi</span>
                                <span class="block text-slate-800 font-semibold text-sm mt-0.5">{{ $alumni->jenis_institusi_pekerjaan ?? '-' }}</span>
                            </div>

                            <div class="bg-slate-50/80 p-3 rounded-lg border border-slate-100">
                                <span class="block text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Posisi Pekerjaan</span>
                                <span class="block text-slate-800 font-semibold text-sm mt-0.5">{{ $alumni->posisi_pekerjaan ?? '-' }}</span>
                            </div>

                            <div class="bg-slate-50/80 p-3 rounded-lg border border-slate-100">
                                <span class="block text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Lama Bekerja</span>
                                <span class="block text-slate-800 font-semibold text-sm mt-0.5">{{ $alumni->lama_bekerja ?? '-' }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card 3: Studi Lanjut -->
                <div class="bg-white rounded-xl border border-slate-200 p-6 shadow-sm flex flex-col justify-between">
                    <div>
                        <h2 class="text-base font-bold text-[#1B4E71] uppercase tracking-wider border-b border-slate-100 pb-3 mb-4 flex items-center space-x-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#1B4E71]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                            </svg>
                            <span>Studi Lanjut</span>
                        </h2>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <div class="bg-slate-50/80 p-3 rounded-lg border border-slate-100">
                                <span class="block text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Jenjang & Program Studi</span>
                                <span class="block text-slate-800 font-semibold text-sm mt-0.5">
                                    {{ $alumni->jenjang_studi_lanjut ?? '-' }} 
                                    @if($alumni->nama_prodi_studi_lanjut)
                                        — {{ $alumni->nama_prodi_studi_lanjut }}
                                    @endif
                                </span>
                            </div>

                            <div class="bg-slate-50/80 p-3 rounded-lg border border-slate-100">
                                <span class="block text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Institusi / Universitas</span>
                                <span class="block text-slate-800 font-semibold text-sm mt-0.5">{{ $alumni->institusi_studi_lanjut ?? '-' }}</span>
                            </div>

                            <div class="bg-slate-50/80 p-3 rounded-lg border border-slate-100 sm:col-span-2">
                                <span class="block text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Lokasi Studi</span>
                                <span class="block text-slate-800 font-semibold text-sm mt-0.5">{{ $alumni->lokasi_studi_lanjut ?? '-' }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card 4: Kebutuhan Disabilitas & Aksesibilitas -->
                <div class="bg-white rounded-xl border border-slate-200 p-6 shadow-sm flex flex-col justify-between">
                    <div>
                        <h2 class="text-base font-bold text-[#1B4E71] uppercase tracking-wider border-b border-slate-100 pb-3 mb-4 flex items-center space-x-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#1B4E71]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                            </svg>
                            <span>Kebutuhan & Aksesibilitas</span>
                        </h2>

                        <div class="space-y-3">
                            <div class="bg-slate-50/80 p-3 rounded-lg border border-slate-100">
                                <span class="block text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Detail Disabilitas</span>
                                <p class="text-slate-800 font-semibold text-sm mt-0.5">{{ $alumni->detail_disabilitas ?? '-' }}</p>
                            </div>

                            <div class="bg-slate-50/80 p-3 rounded-lg border border-slate-100">
                                <span class="block text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Alat Bantu Digunakan</span>
                                <p class="text-slate-800 font-semibold text-sm mt-0.5">{{ $alumni->alat_bantu ?? '-' }}</p>
                            </div>

                            <div class="bg-slate-50/80 p-3 rounded-lg border border-slate-100">
                                <span class="block text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Kendala Proses Belajar</span>
                                <p class="text-slate-800 font-semibold text-sm mt-0.5">{{ $alumni->kendala ?? '-' }}</p>
                            </div>

                            <div class="bg-slate-50/80 p-3 rounded-lg border border-slate-100">
                                <span class="block text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Akomodasi yang Diperlukan</span>
                                <p class="text-slate-800 font-semibold text-sm mt-0.5">{{ $alumni->akomodasi ?? '-' }}</p>
                            </div>

                            <div class="bg-slate-50/80 p-3 rounded-lg border border-slate-100">
                                <span class="block text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Layanan / Pendampingan</span>
                                <p class="text-slate-800 font-semibold text-sm mt-0.5">{{ $alumni->pendampingan ?? '-' }}</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</main>
@endsection