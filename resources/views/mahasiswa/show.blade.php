@extends('layout.sideBar')

@section('title', 'Detail Profil Mahasiswa | Mahasiswa Disabilitas')

@section('content')
<!-- Main Content -->
<main class="flex-1 bg-slate-50 flex flex-col min-h-screen font-sans">
    
    <!-- Top Header Sticky -->
    <div class="flex flex-wrap justify-between items-center bg-[#1B4E71] text-white px-6 md:px-8 py-4 shadow-sm z-20 sticky top-0">
        <!-- Title Area -->
        <div class="flex items-center space-x-3">
            <div class="p-2 bg-white/10 rounded-lg">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <ellipse cx="12" cy="5" rx="9" ry="3"/>
                    <path d="M3 5v14c0 1.66 4.03 3 9 3s9-1.34 9-3V5"/>
                    <path d="M3 12c0 1.66 4.03 3 9 3s9-1.34 9-3"/>
                </svg>
            </div>
            <span class="font-bold text-xl tracking-wide">Data Mahasiswa</span>
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
                <a href="{{ route('mahasiswa.index') }}" 
                   class="inline-flex items-center space-x-2 px-4 py-2 text-sm font-medium text-slate-700 bg-white border border-slate-200 rounded-lg hover:bg-slate-100 hover:text-slate-900 transition-all shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    <span>Kembali ke Daftar Mahasiswa</span>
                </a>

                <a href="{{ route('mahasiswa.edit', $mahasiswa->id) }}" 
                   class="inline-flex items-center space-x-1.5 px-4 py-2 text-sm font-semibold text-white bg-[#1B4E71] rounded-lg hover:bg-[#153e5a] transition-colors shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    <span>Edit Profil</span>
                </a>
            </div>

            <!-- Main Profile Header Card -->
            <div class="bg-white rounded-xl border border-slate-200 p-6 shadow-sm flex flex-col md:flex-row items-start md:items-center justify-between gap-6">
                <div class="flex items-center space-x-4">
                    <!-- Ukuran Foto Profil Dikecilkan (w-14 h-14) -->
                    @if($mahasiswa->foto)
                        <a href="{{ route('mahasiswa.document', [$mahasiswa->id, 'foto']) }}" target="_blank" class="shrink-0 group relative">
                            <img src="{{ route('mahasiswa.document', [$mahasiswa->id, 'foto']) }}" 
                                 alt="Foto {{ $mahasiswa->nama }}" 
                                 class="w-14 h-14 rounded-full object-cover border border-slate-200 group-hover:border-[#1B4E71] transition-all shadow-sm">
                        </a>
                    @else
                        <div class="w-14 h-14 rounded-full bg-[#1B4E71]/10 text-[#1B4E71] flex items-center justify-center font-bold text-xl shrink-0 border border-slate-200">
                            {{ strtoupper(substr($mahasiswa->nama, 0, 1)) }}
                        </div>
                    @endif

                    <div>
                        <h1 class="text-xl font-bold text-slate-800">{{ $mahasiswa->nama }}</h1>
                        <p class="text-xs font-medium text-slate-500 mt-0.5">
                            NIM: <span class="text-slate-800 font-semibold">{{ $mahasiswa->nim ?? '-' }}</span> 
                            <span class="mx-1 text-slate-300">•</span> 
                            Angkatan: <span class="text-slate-800 font-semibold">{{ $mahasiswa->angkatan ?? '-' }}</span>
                            <span class="mx-1 text-slate-300">•</span> 
                            Tahun Asesmen: <span class="text-[#1B4E71] font-bold">{{ $mahasiswa->tahun_asesmen ?? '-' }}</span>
                        </p>
                        
                        <div class="flex flex-wrap items-center gap-1.5 mt-2">
                        <!-- Disability Badge -->
                            @if(!empty($mahasiswa->ragam_disabilitas))
                                @foreach((array) $mahasiswa->ragam_disabilitas as $ragam)
                                    <span class="px-2.5 py-0.5 rounded-full text-xs font-semibold bg-sky-50 text-sky-700 border border-sky-200">
                                        {{ $ragam }}
                                    </span>
                                @endforeach
                            @endif
                            @if($mahasiswa->subragam_formatted && $mahasiswa->subragam_formatted !== '-')
                                <span class="px-2.5 py-0.5 rounded-full text-xs font-semibold bg-indigo-50 text-indigo-700 border border-indigo-200">
                                    Sub: {{ $mahasiswa->subragam_formatted }}
                                </span>
                            @endif
                            <!-- Beasiswa Badge -->
                            @if($mahasiswa->beasiswa)
                                <span class="px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                    Beasiswa: {{ $mahasiswa->beasiswa }}
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Content Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                
                <!-- Card 1: Data Akademik -->
                <div class="bg-white rounded-xl border border-slate-200 p-6 shadow-sm">
                    <h2 class="text-base font-bold text-[#1B4E71] uppercase tracking-wider border-b border-slate-100 pb-3 mb-4 flex items-center space-x-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#1B4E71]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                        </svg>
                        <span>Informasi Akademik</span>
                    </h2>

                    <dl class="grid grid-cols-1 sm:grid-cols-2 gap-y-4 gap-x-6 text-sm">
                        <div>
                            <dt class="text-xs font-semibold text-slate-400 uppercase tracking-wider">NIM</dt>
                            <dd class="text-slate-800 font-medium mt-0.5">{{ $mahasiswa->nim ?? '-' }}</dd>
                        </div>

                        <div>
                            <dt class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Jenjang Pendidikan</dt>
                            <dd class="text-slate-800 font-medium mt-0.5">{{ $mahasiswa->pendidikan ?? '-' }}</dd>
                        </div>

                        <div>
                            <dt class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Fakultas</dt>
                            <dd class="text-slate-800 font-medium mt-0.5">{{ $mahasiswa->faculty?->name ?? $mahasiswa->fakultas ?? '-' }}</dd>
                        </div>

                        <div>
                            <dt class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Program Studi</dt>
                            <dd class="text-slate-800 font-medium mt-0.5">{{ $mahasiswa->studyProgram?->name ?? $mahasiswa->prodi ?? '-' }}</dd>
                        </div>

                        <div>
                            <dt class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Angkatan</dt>
                            <dd class="text-slate-800 font-medium mt-0.5">{{ $mahasiswa->angkatan ?? '-' }}</dd>
                        </div>

                        <div>
                            <dt class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Tahun Asesmen</dt>
                            <dd class="text-[#1B4E71] font-bold mt-0.5">{{ $mahasiswa->tahun_asesmen ?? '-' }}</dd>
                        </div>

                        <div>
                            <dt class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Beasiswa</dt>
                            <dd class="text-slate-800 font-medium mt-0.5">{{ $mahasiswa->beasiswa ?? '-' }}</dd>
                        </div>
                    </dl>
                </div>

                <!-- Card 2: Data Pribadi & Kontak -->
                <div class="bg-white rounded-xl border border-slate-200 p-6 shadow-sm">
                    <h2 class="text-base font-bold text-[#1B4E71] uppercase tracking-wider border-b border-slate-100 pb-3 mb-4 flex items-center space-x-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#1B4E71]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        <span>Informasi Pribadi & Kontak</span>
                    </h2>

                    <dl class="grid grid-cols-1 sm:grid-cols-2 gap-y-4 gap-x-6 text-sm">
                        <div>
                            <dt class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Nama Lengkap</dt>
                            <dd class="text-slate-800 font-medium mt-0.5">{{ $mahasiswa->nama }}</dd>
                        </div>

                        <div>
                            <dt class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Jenis Kelamin</dt>
                            <dd class="text-slate-800 font-medium mt-0.5">{{ $mahasiswa->jenis_kelamin ?? '-' }}</dd>
                        </div>

                        <div>
                            <dt class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Tanggal Lahir</dt>
                            <dd class="text-slate-800 font-medium mt-0.5">{{ $mahasiswa->tanggal_lahir ?? '-' }}</dd>
                        </div>

                        <div>
                            <dt class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Nomor HP / Telepon</dt>
                            <dd class="text-slate-800 font-medium mt-0.5">{{ $mahasiswa->nomor_hp ?? '-' }}</dd>
                        </div>
                    </dl>
                </div>

                <!-- Card 3: Dokumen Pendukung -->
                <div class="bg-white rounded-xl border border-slate-200 p-6 shadow-sm lg:col-span-2">
                    <h2 class="text-base font-bold text-[#1B4E71] uppercase tracking-wider border-b border-slate-100 pb-3 mb-4 flex items-center space-x-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#1B4E71]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                        </svg>
                        <span>Dokumen Pendukung</span>
                    </h2>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Surat Keterangan Disabilitas -->
                        <div class="p-4 bg-slate-50 border border-slate-200 rounded-xl flex flex-col justify-between">
                            <div>
                                <h3 class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2">Surat Keterangan Disabilitas</h3>
                                @if($mahasiswa->surat_keterangan)
                                    <p class="text-xs text-slate-600 mb-3">Dokumen telah terunggah dalam sistem.</p>
                                @elseif($mahasiswa->surat_keterangan_link)
                                    <p class="text-xs text-slate-600 mb-3">Dokumen tersedia melalui tautan eksternal.</p>
                                @else
                                    <p class="text-xs text-amber-600 font-medium mb-3">Dokumen belum terunggah.</p>
                                @endif
                            </div>

                            <div>
                                @if($mahasiswa->surat_keterangan)
                                    <a href="{{ route('mahasiswa.document', [$mahasiswa->id, 'surat_keterangan']) }}" target="_blank" 
                                       class="inline-flex items-center space-x-1.5 text-xs font-semibold bg-sky-50 text-sky-700 border border-sky-200 px-3 py-2 rounded-lg hover:bg-sky-600 hover:text-white transition-colors w-full justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                        </svg>
                                        <span>Lihat Dokumen</span>
                                    </a>
                                @elseif($mahasiswa->surat_keterangan_link)
                                    <a href="{{ $mahasiswa->surat_keterangan_link }}" target="_blank" 
                                       class="inline-flex items-center space-x-1.5 text-xs font-semibold bg-sky-50 text-sky-700 border border-sky-200 px-3 py-2 rounded-lg hover:bg-sky-600 hover:text-white transition-colors w-full justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                        </svg>
                                        <span>Lihat Dokumen Link</span>
                                    </a>
                                @else
                                    <a href="{{ route('mahasiswa.edit', $mahasiswa->id) }}" 
                                       class="inline-flex items-center space-x-1.5 text-xs font-semibold bg-amber-50 text-amber-700 border border-amber-200 px-3 py-2 rounded-lg hover:bg-amber-600 hover:text-white transition-colors w-full justify-center">
                                        <span>Upload via Edit</span>
                                    </a>
                                @endif
                            </div>
                        </div>

                        <!-- Kartu Tanda Penduduk (KTP) -->
                        <div class="p-4 bg-slate-50 border border-slate-200 rounded-xl flex flex-col justify-between">
                            <div>
                                <h3 class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2">Kartu Tanda Penduduk (KTP)</h3>
                                @if($mahasiswa->ktp)
                                    @if(in_array(strtolower(pathinfo($mahasiswa->ktp, PATHINFO_EXTENSION)), ['jpg', 'jpeg', 'png', 'gif', 'webp', 'bmp']))
                                        <div class="mt-1 mb-3">
                                            <a href="{{ route('mahasiswa.document', [$mahasiswa->id, 'ktp']) }}" target="_blank" class="block group">
                                                <img src="{{ route('mahasiswa.document', [$mahasiswa->id, 'ktp']) }}" 
                                                     alt="KTP {{ $mahasiswa->nama }}" 
                                                     class="h-20 w-full object-cover rounded-lg border border-slate-200 group-hover:opacity-90 transition-opacity">
                                            </a>
                                        </div>
                                    @else
                                        <p class="text-xs text-slate-600 mb-3">Dokumen KTP berupa berkas non-gambar.</p>
                                    @endif
                                @else
                                    <p class="text-xs text-amber-600 font-medium mb-3">KTP belum terunggah.</p>
                                @endif
                            </div>

                            <div>
                                @if($mahasiswa->ktp)
                                    <a href="{{ route('mahasiswa.document', [$mahasiswa->id, 'ktp']) }}" target="_blank" 
                                       class="inline-flex items-center space-x-1.5 text-xs font-semibold bg-sky-50 text-sky-700 border border-sky-200 px-3 py-2 rounded-lg hover:bg-sky-600 hover:text-white transition-colors w-full justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                        <span>Lihat KTP</span>
                                    </a>
                                @else
                                    <a href="{{ route('mahasiswa.edit', $mahasiswa->id) }}" 
                                       class="inline-flex items-center space-x-1.5 text-xs font-semibold bg-amber-50 text-amber-700 border border-amber-200 px-3 py-2 rounded-lg hover:bg-amber-600 hover:text-white transition-colors w-full justify-center">
                                        <span>Upload via Edit</span>
                                    </a>
                                @endif
                            </div>
                        </div>

                        <!-- Pas Foto (Ukuran Preview Dikecilkan: h-20 w-16) -->
                        <div class="p-4 bg-slate-50 border border-slate-200 rounded-xl flex flex-col justify-between">
                            <div>
                                <h3 class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2">Pas Foto</h3>
                                @if($mahasiswa->foto)
                                    <div class="mt-1 mb-3 flex justify-center">
                                        <a href="{{ route('mahasiswa.document', [$mahasiswa->id, 'foto']) }}" target="_blank" class="block group">
                                            <img src="{{ route('mahasiswa.document', [$mahasiswa->id, 'foto']) }}" 
                                                 alt="Pas foto {{ $mahasiswa->nama }}" 
                                                 class="h-20 w-16 object-cover rounded-lg border border-slate-200 group-hover:opacity-90 transition-opacity">
                                        </a>
                                    </div>
                                @else
                                    <p class="text-xs text-amber-600 font-medium mb-3">Pas Foto belum terunggah.</p>
                                @endif
                            </div>

                            <div>
                                @if($mahasiswa->foto)
                                    <a href="{{ route('mahasiswa.document', [$mahasiswa->id, 'foto']) }}" target="_blank" 
                                       class="inline-flex items-center space-x-1.5 text-xs font-semibold bg-sky-50 text-sky-700 border border-sky-200 px-3 py-2 rounded-lg hover:bg-sky-600 hover:text-white transition-colors w-full justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                        <span>Lihat Foto</span>
                                    </a>
                                @else
                                    <a href="{{ route('mahasiswa.edit', $mahasiswa->id) }}" 
                                       class="inline-flex items-center space-x-1.5 text-xs font-semibold bg-amber-50 text-amber-700 border border-amber-200 px-3 py-2 rounded-lg hover:bg-amber-600 hover:text-white transition-colors w-full justify-center">
                                        <span>Upload via Edit</span>
                                    </a>
                                @endif
                            </div>
                        </div>

                    </div>
                </div>

                <!-- Card 4: Detail Disabilitas & Aksesibilitas -->
                <div class="bg-white rounded-xl border border-slate-200 p-6 shadow-sm lg:col-span-2">
                    <h2 class="text-base font-bold text-[#1B4E71] uppercase tracking-wider border-b border-slate-100 pb-3 mb-4 flex items-center space-x-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#1B4E71]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                        </svg>
                        <span>Kebutuhan Disabilitas & Aksesibilitas</span>
                    </h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                        <div>
                            <dt class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Ragam Disabilitas</dt>
                            <dd class="text-slate-800 bg-slate-50 border border-slate-100 p-3 rounded-lg mt-1 font-semibold">
                                {{ !empty($mahasiswa->ragam_disabilitas) ? implode(', ', (array) $mahasiswa->ragam_disabilitas) : '-' }}
                                @if(!empty($mahasiswa->ragam_pilihan) && count((array) $mahasiswa->ragam_pilihan) > 1)
                                    <span class="text-xs font-normal text-slate-500 block mt-0.5">Ragam Terpilih: {{ implode(', ', (array) $mahasiswa->ragam_pilihan) }}</span>
                                @endif
                            </dd>
                        </div>

                        <div>
                            <dt class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Subragam Disabilitas</dt>
                            <dd class="text-slate-800 bg-slate-50 border border-slate-100 p-3 rounded-lg mt-1 font-semibold text-[#1B4E71]">
                                {{ $mahasiswa->subragam_formatted ?: '-' }}
                            </dd>
                        </div>

                        <div class="md:col-span-2">
                            <dt class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Detail Disabilitas</dt>
                            <dd class="text-slate-800 bg-slate-50 border border-slate-100 p-3 rounded-lg mt-1 font-medium">
                                {{ $mahasiswa->detail_disabilitas ?? '-' }}
                            </dd>
                        </div>

                        <div>
                            <dt class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Alat Bantu Digunakan</dt>
                            <dd class="text-slate-800 bg-slate-50 border border-slate-100 p-3 rounded-lg mt-1 font-medium">
                                {{ $mahasiswa->alat_bantu ?? '-' }}
                            </dd>
                        </div>

                        <div>
                            <dt class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Kesulitan / Kendala Saat Berbelajar</dt>
                            <dd class="text-slate-800 bg-slate-50 border border-slate-100 p-3 rounded-lg mt-1 font-medium">
                                {{ $mahasiswa->kendala ?? '-' }}
                            </dd>
                        </div>

                        <div>
                            <dt class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Akomodasi yang Diperlukan</dt>
                            <dd class="text-slate-800 bg-slate-50 border border-slate-100 p-3 rounded-lg mt-1 font-medium">
                                {{ $mahasiswa->akomodasi ?? '-' }}
                            </dd>
                        </div>

                        <div>
                            <dt class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Pendampingan / Layanan</dt>
                            <dd class="text-slate-800 bg-slate-50 border border-slate-100 p-3 rounded-lg mt-1 font-medium">
                                {{ $mahasiswa->pendampingan ?? '-' }}
                            </dd>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</main>

<script>
    function toggleUserMenu() {
        const menu = document.getElementById('user-menu');
        if (menu) menu.classList.toggle('hidden');
    }
</script>
@endsection