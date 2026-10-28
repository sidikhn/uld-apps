@extends('layout.sideBar')

@section('title', 'Dashboard | Mahasiswa Disabilitas')

@section('content')
    <!-- Main Content -->
    <main class="flex-1 bg-slate-50 flex flex-col min-h-screen font-sans">
        
        <!-- Top Header Bar -->
        <div class="flex items-center justify-between w-full bg-gradient-to-r from-[#1B4E71] to-[#25638a] text-white px-8 py-4 shadow-md z-10">
            <!-- Kiri: Icon + Judul -->
            <div class="flex items-center space-x-3">
                <div class="p-2 bg-white/10 rounded-xl backdrop-blur-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" 
                        fill="none" viewBox="0 0 24 24" 
                        stroke="currentColor" stroke-width="2">
                        <path d="M22 10l-10-5L2 10l10 5 10-5z" class="group-hover:stroke-white"/>
                        <path d="M6 12v5c3 3 9 3 12 0v-5" class="group-hover:stroke-white"/>
                    </svg>
                </div>
                <span class="font-semibold text-2xl tracking-wide">Data Alumni</span>
            </div>

            <!-- Kanan: Hubungi Kami -->
            <a href="https://wa.me/6282227021332" target="_blank"
               class="flex items-center space-x-2 bg-white/10 hover:bg-white/20 px-4 py-2 rounded-xl transition-all duration-300 backdrop-blur-sm text-sm font-medium">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M3 21l1.2-4.2A8.959 8.959 0 015 4a8.959 8.959 0 0112.728 12.728A8.959 8.959 0 018.8 19.8L4.2 21z" />
                </svg>
                <span>Hubungi Kami</span>
            </a>
        </div>

        <!-- Content Area -->
        <div class="flex-1 overflow-y-auto">
            
            <!-- Toolbar Section (Alumni) -->
            <div class="px-6 md:px-8 pt-6 z-10 relative">
                <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm flex flex-wrap items-center justify-between gap-4">
                    
                    <!-- Sisi Kiri: Search & Filter Fakultas -->
                    <div class="flex items-center gap-3 flex-1 min-w-[320px]">
                        
                        <!-- Search Input -->
                        <div class="relative flex-1 min-w-[200px]">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M11 18a7 7 0 100-14 7 7 0 000 14z" />
                                </svg>
                            </div>
                            <input id="searchMahasiswa" type="text" placeholder="Cari alumni...."
                                class="w-full pl-10 pr-4 py-2 bg-slate-50 hover:bg-slate-100 focus:bg-white text-slate-700 placeholder-slate-400 rounded-lg border border-slate-200 focus:ring-2 focus:ring-[#1B4E71] focus:border-[#1B4E71] outline-none text-sm font-medium transition-all" />
                        </div>

                        <!-- Dropdown Filter Fakultas -->
                        <div class="relative w-48 shrink-0">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400 z-10">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h7" />
                                </svg>
                            </div>
                            <select id="filterFakultas"
                                class="w-full pl-10 pr-8 py-2 bg-slate-50 hover:bg-slate-100 focus:bg-white text-slate-700 font-medium text-sm rounded-lg border border-slate-200 focus:ring-2 focus:ring-[#1B4E71] focus:border-[#1B4E71] outline-none cursor-pointer transition-all">
                                <option value="all">Semua Fakultas</option>
                                @foreach($alumnis->map(fn($a) => $a->faculty?->name ?? $a->fakultas)->filter()->unique() as $fakultas)
                                    <option value="{{ strtolower(trim($fakultas)) }}">{{ $fakultas }}</option>
                                @endforeach
                            </select>
                        </div>

                    </div>

                    <!-- Sisi Kanan: Action Buttons -->
                    <div class="flex items-center gap-2 shrink-0">
                        
                        <!-- Tombol Edit Data (hidden) -->
                        <a id="edit-btn" href="#"
                            class="hidden items-center gap-1.5 text-emerald-700 font-semibold bg-emerald-50 hover:bg-emerald-100 border border-emerald-200 rounded-lg px-3.5 py-2 transition-all">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/>
                            </svg>
                            <span>Edit Data</span>
                        </a>

                        <!-- Tombol Hapus Data (hidden) -->
                        <form id="delete-form" action="{{ route('alumni.bulkDelete') }}" method="POST" class="hidden m-0">
                            @csrf
                            @method('DELETE')
                            <input type="hidden" name="ids" id="delete-ids">
                            <button type="submit" 
                                class="flex items-center gap-1.5 text-rose-700 font-semibold bg-rose-50 hover:bg-rose-100 border border-rose-200 rounded-lg px-3.5 py-2 transition-all cursor-pointer"
                                onclick="return confirm('Apakah Anda yakin ingin menghapus data alumni yang dipilih?')">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3m-4 0h14"/>
                                </svg>
                                <span>Hapus Data</span>
                            </button>
                        </form>

                        <!-- Tombol Ubah Status Alumni (hidden, muncul jika dipilih) -->
                        <div class="relative text-left hidden" id="alumni-status-dropdown-wrapper">
                            <button
                                type="button"
                                id="alumni-status-dropdown-btn"
                                class="flex items-center gap-1.5 text-sky-800 font-semibold bg-sky-50 hover:bg-sky-100 border border-sky-200 rounded-lg px-3.5 py-2 transition-all cursor-pointer shadow-sm"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-sky-700" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                </svg>
                                <span>Ubah Status</span>
                                <svg xmlns="http://www.w3.org/2000/svg" id="alumni-status-arrow-icon" class="h-3.5 w-3.5 text-sky-600 ml-0.5 transition-transform duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </button>

                            <div id="alumni-status-dropdown-menu" class="hidden absolute right-0 mt-2 w-60 rounded-xl shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-50 py-1.5 border border-slate-100">
                                <form id="alumni-bulk-status-form" action="{{ route('alumni.bulkUpdateStatus') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="ids" id="alumni-status-ids">
                                    <input type="hidden" name="status" id="alumni-target-status">

                                    <button type="button" onclick="submitAlumniBulkStatus('lulus_bekerja', 'Lulus (Bekerja / Wiraswasta)')" class="w-full text-left flex items-center gap-2.5 px-4 py-2 text-xs font-medium text-slate-700 hover:bg-sky-50 hover:text-sky-800 transition-colors cursor-pointer">
                                        <span class="w-2.5 h-2.5 rounded-full bg-sky-500 shrink-0"></span>
                                        <span>Lulus (Bekerja / Wiraswasta)</span>
                                    </button>
                                    <button type="button" onclick="submitAlumniBulkStatus('lulus_mencari_kerja', 'Lulus (Sedang Mencari Kerja)')" class="w-full text-left flex items-center gap-2.5 px-4 py-2 text-xs font-medium text-slate-700 hover:bg-amber-50 hover:text-amber-800 transition-colors cursor-pointer">
                                        <span class="w-2.5 h-2.5 rounded-full bg-amber-500 shrink-0"></span>
                                        <span>Lulus (Mencari Kerja)</span>
                                    </button>
                                    <button type="button" onclick="submitAlumniBulkStatus('lulus_studi_lanjut', 'Lulus (Studi Lanjut)')" class="w-full text-left flex items-center gap-2.5 px-4 py-2 text-xs font-medium text-slate-700 hover:bg-indigo-50 hover:text-indigo-800 transition-colors cursor-pointer">
                                        <span class="w-2.5 h-2.5 rounded-full bg-indigo-500 shrink-0"></span>
                                        <span>Lulus (Studi Lanjut)</span>
                                    </button>
                                    <button type="button" onclick="submitAlumniBulkStatus('lulus', 'Lulus (Standar / Belum Bekerja)')" class="w-full text-left flex items-center gap-2.5 px-4 py-2 text-xs font-medium text-slate-700 hover:bg-emerald-50 hover:text-emerald-800 transition-colors cursor-pointer">
                                        <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 shrink-0"></span>
                                        <span>Lulus (Standar / Belum Aktif)</span>
                                    </button>
                                    <div class="my-1 border-t border-slate-100"></div>
                                    <button type="button" onclick="submitAlumniBulkStatus('mengundurkan_diri', 'Mengundurkan Diri')" class="w-full text-left flex items-center gap-2.5 px-4 py-2 text-xs font-medium text-slate-700 hover:bg-rose-50 hover:text-rose-700 transition-colors cursor-pointer">
                                        <span class="w-2.5 h-2.5 rounded-full bg-rose-500 shrink-0"></span>
                                        <span>Mengundurkan Diri</span>
                                    </button>
                                    <button type="button" onclick="submitAlumniBulkStatus('meninggal', 'Meninggal Dunia')" class="w-full text-left flex items-center gap-2.5 px-4 py-2 text-xs font-medium text-slate-700 hover:bg-slate-100 hover:text-slate-900 transition-colors cursor-pointer">
                                        <span class="w-2.5 h-2.5 rounded-full bg-slate-700 shrink-0"></span>
                                        <span>Meninggal Dunia</span>
                                    </button>
                                </form>
                            </div>
                        </div>

                        {{-- Tombol Ekspor Data Alumni --}}
                        <div class="relative inline-block text-left" id="alumni-export-dropdown-wrapper">
                            <button
                                type="button"
                                id="alumni-export-dropdown-btn"
                                class="flex items-center gap-1.5 bg-white hover:bg-slate-50 text-slate-700 font-medium border border-slate-200 rounded-lg px-3.5 py-2 transition-all shadow-sm shrink-0 cursor-pointer"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-[#1B4E71]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                                </svg>
                                <span>Ekspor Data</span>
                                <svg xmlns="http://www.w3.org/2000/svg" id="alumni-export-arrow-icon" class="h-3.5 w-3.5 text-slate-400 ml-0.5 transition-transform duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </button>

                            <div id="alumni-export-dropdown-menu" class="hidden absolute right-0 mt-2 w-48 rounded-xl shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-50 py-1.5 divide-y divide-slate-100 border border-slate-100">
                                <div class="py-1">
                                    <a href="{{ route('alumni.exportPdf') }}" class="group flex items-center px-4 py-2.5 text-sm text-slate-700 hover:bg-sky-50 hover:text-[#1B4E71] transition-colors cursor-pointer">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="mr-3 h-4 w-4 text-rose-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                        </svg>
                                        <span class="font-medium">Ekspor PDF</span>
                                    </a>
                                    <a href="{{ route('alumni.export') }}" class="group flex items-center px-4 py-2.5 text-sm text-slate-700 hover:bg-emerald-50 hover:text-emerald-700 transition-colors cursor-pointer">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="mr-3 h-4 w-4 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                        </svg>
                                        <span class="font-medium">Ekspor Excel (.xlsx)</span>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Tombol Tambah Data -->
                        @if(auth()->user()->role === 'superadmin')
                            <a href="{{ route('alumni.create') }}" 
                                class="flex items-center gap-1.5 bg-[#1B4E71] hover:bg-[#143a54] text-white font-medium rounded-lg px-4 py-2 transition-all shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                                </svg>
                                <span>Tambah Data</span>
                            </a>
                        @endif

                    </div>

                </div>
            </div>

            <!-- Alert Messages -->
            <div class="px-6 md:px-8 mt-4">
                @if(session('success'))
                    <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-xl flex items-center space-x-3 shadow-sm mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-500" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                        <span class="text-sm font-medium">{{ session('success') }}</span>
                    </div>
                @endif
            </div>

            <!-- Table Card -->
            <div class="mx-6 md:mx-8 mb-8 bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse whitespace-nowrap">
                        <thead>
                            <tr class="bg-slate-50 border-b border-slate-200 text-slate-600 text-xs uppercase tracking-wider font-semibold">
                                @if(auth()->user()->role === 'superadmin')
                                    <th class="py-4 px-4 text-center w-12">
                                        <input type="checkbox" id="select-all" class="w-4 h-4 text-[#1B4E71] bg-white border-slate-300 rounded focus:ring-[#1B4E71] focus:ring-2 cursor-pointer transition-all">
                                    </th>
                                @endif
                                <th class="py-4 px-4">Nama</th>
                                <th class="py-4 px-4">NIM</th>
                                <th class="py-4 px-4">Email Aktif</th>
                                <th class="py-4 px-4">Aktivitas Saat Ini</th>
                                <th class="py-4 px-4">Ragam Disabilitas</th>
                                <th class="py-4 px-4">Status Data</th>
                                <th class="py-4 px-4 text-center">Hasil Asesmen</th>
                                <th class="py-4 px-4 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="tableMahasiswa" class="divide-y divide-slate-100 text-sm text-slate-700">
                            @foreach($alumnis as $alumni)
                            @php $namaFakultas = $alumni->faculty?->name ?? $alumni->fakultas; @endphp
                            <tr class="hover:bg-slate-50/80 transition-colors duration-200" data-fakultas="{{ strtolower(trim($namaFakultas ?? '')) }}">
                                @if(auth()->user()->role === 'superadmin')
                                    <td class="py-3 px-4 text-center">
                                        <input type="checkbox" class="select-mahasiswa w-4 h-4 text-[#1B4E71] bg-white border-slate-300 rounded focus:ring-[#1B4E71] focus:ring-2 cursor-pointer transition-all" value="{{ $alumni->id }}">
                                    </td>
                                @endif
                                <td class="py-3 px-4 font-medium text-slate-900">
                                    <div class="flex items-center gap-1.5 flex-wrap">
                                        <span>{{ $alumni->nama }}</span>
                                        @if($alumni->status === 'meninggal')
                                            <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[10px] font-semibold bg-slate-700 text-white tracking-wide" title="Meninggal Dunia">
                                                Meninggal Dunia
                                            </span>
                                        @elseif($alumni->status === 'lulus_bekerja')
                                            <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[10px] font-semibold bg-sky-100 text-sky-800 border border-sky-200" title="Bekerja / Wiraswasta">
                                                Bekerja
                                            </span>
                                        @elseif($alumni->status === 'lulus_mencari_kerja')
                                            <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[10px] font-semibold bg-amber-100 text-amber-800 border border-amber-200" title="Sedang Mencari Kerja">
                                                Mencari Kerja
                                            </span>
                                        @elseif($alumni->status === 'lulus_studi_lanjut')
                                            <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[10px] font-semibold bg-indigo-100 text-indigo-800 border border-indigo-200" title="Studi Lanjut">
                                                Studi Lanjut
                                            </span>
                                        @elseif($alumni->status === 'mengundurkan_diri')
                                            <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[10px] font-semibold bg-rose-100 text-rose-700 border border-rose-200" title="Mengundurkan Diri">
                                                Mengundurkan Diri
                                            </span>
                                        @endif
                                    </div>
                                    @if($alumni->nomor_induk_uld)
                                        <span class="inline-block text-[11px] font-mono text-[#1B4E71] bg-sky-50 px-1.5 py-0.5 rounded border border-sky-100 mt-0.5">
                                            {{ $alumni->nomor_induk_uld }}
                                        </span>
                                    @endif
                                </td>
                                <td class="py-3 px-4">{{ $alumni->nim }}</td>
                                <td class="py-3 px-4">{{ $alumni->email_aktif }}</td>
                                <td class="py-3 px-4">{{ $alumni->aktivitas_saat_ini }}</td>
                                @php($disabilities = is_array($alumni->ragam_disabilitas) ? $alumni->ragam_disabilitas : [$alumni->ragam_disabilitas])
                                <td class="py-3 px-4">{{ implode(', ', array_filter($disabilities)) }}</td>
                                <td class="py-3 px-4">
                                    @if($alumni->perlu_update)
                                        <span class="inline-flex rounded-full bg-amber-100 px-3 py-1 text-xs font-semibold text-amber-800">Perlu update</span>
                                    @else
                                        <span class="inline-flex rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-800">Sudah diperbarui</span>
                                    @endif
                                </td>
                                <td class="py-3 px-4 text-center">
                                    <a href="{{ route('alumni.pdf', $alumni->id) }}" 
                                        class="action-button bg-teal-50 text-teal-700 border border-teal-200 hover:bg-teal-600 hover:text-white">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                        </svg>
                                        <span>Unduh PDF</span>
                                    </a>
                                </td>
                                <td class="py-3 px-4 text-center">
                                    <a href="{{ route('alumni.show', $alumni->id) }}" 
                                        class="action-button bg-blue-50 text-blue-700 border border-blue-200 hover:bg-[#1B4E71] hover:text-white">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                        <span>Detail</span>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Footer Pagination & Show Rows Section -->
                @if($alumnis->count() > 0)
                    <div class="px-6 py-4 bg-white border-t border-slate-200/80 flex flex-col md:flex-row items-center justify-between gap-4">
                        <div class="flex items-center gap-3 text-xs sm:text-sm text-slate-500 font-medium">
                            <span class="shrink-0">Tampilkan</span>
                            <div class="relative">
                                <select id="alumniPerPageSelect"
                                        class="h-9 pl-3 pr-8 bg-slate-50 border border-slate-200 rounded-lg text-xs sm:text-sm font-semibold text-slate-600 appearance-none cursor-pointer outline-none focus:ring-2 focus:ring-[#1B4E71]/20">
                                    <option value="10">10 Baris</option>
                                    <option value="50">50 Baris</option>
                                    <option value="100">100 Baris</option>
                                    <option value="all">Semua Data</option>
                                </select>
                                <svg xmlns="http://www.w3.org/2000/svg"
                                     class="absolute right-2.5 top-1/2 -translate-y-1/2 w-3.5 h-3.5 text-slate-400 pointer-events-none"
                                     fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M6 9l6 6 6-6"/>
                                </svg>
                            </div>
                            <span>
                                Menampilkan
                                <strong id="alumniShowingStart" class="text-slate-700">0</strong>
                                -
                                <strong id="alumniShowingEnd" class="text-slate-700">0</strong>
                                dari
                                <strong id="alumniTotalEntries" class="text-slate-700">{{ $alumnis->count() }}</strong>
                                data
                            </span>
                        </div>

                        <div id="alumniPaginationButtons" class="flex items-center justify-start md:justify-end gap-1"></div>
                    </div>
                @endif
            </div>
        </div>
    </main>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const selectAll = document.getElementById("select-all"); 
        const checkboxes = document.querySelectorAll(".select-mahasiswa");
        const editBtn = document.getElementById("edit-btn");
        const deleteForm = document.getElementById("delete-form");
        const deleteIds = document.getElementById("delete-ids");
        const alumniStatusDropdownWrapper = document.getElementById("alumni-status-dropdown-wrapper");
        const alumniStatusIds = document.getElementById("alumni-status-ids");

        function updateSelection() {
            const selected = Array.from(document.querySelectorAll(".select-mahasiswa:checked"));

            if (selectAll) {
                selectAll.checked = checkboxes.length > 0 && selected.length === checkboxes.length;
                selectAll.indeterminate = selected.length > 0 && selected.length < checkboxes.length;
            }

            // Toggle Edit (hanya 1 terpilih)
            if (selected.length === 1) {
                editBtn?.classList.remove("hidden");
                editBtn?.classList.add("inline-flex");
                if (editBtn) editBtn.href = "/alumni/" + selected[0].value + "/edit";
            } else {
                editBtn?.classList.add("hidden");
                editBtn?.classList.remove("inline-flex");
                if (editBtn) editBtn.href = "#";
            }

            // Toggle Delete & Ubah Status (boleh >0)
            if (selected.length > 0) {
                deleteForm?.classList.remove("hidden");
                if (deleteIds) deleteIds.value = selected.map(cb => cb.value).join(",");

                alumniStatusDropdownWrapper?.classList.remove("hidden");
                alumniStatusDropdownWrapper?.classList.add("inline-block");
                if (alumniStatusIds) alumniStatusIds.value = selected.map(cb => cb.value).join(",");
            } else {
                deleteForm?.classList.add("hidden");
                if (deleteIds) deleteIds.value = "";

                alumniStatusDropdownWrapper?.classList.add("hidden");
                alumniStatusDropdownWrapper?.classList.remove("inline-block");
                const alumniStatusMenu = document.getElementById('alumni-status-dropdown-menu');
                const alumniStatusArrow = document.getElementById('alumni-status-arrow-icon');
                if (alumniStatusMenu) alumniStatusMenu.classList.add("hidden");
                if (alumniStatusArrow) alumniStatusArrow.classList.remove("rotate-180");
                if (alumniStatusIds) alumniStatusIds.value = "";
            }
        }

        // Checkbox tiap baris
        checkboxes.forEach(cb => {
            cb.addEventListener("change", updateSelection);
        });

        // Checkbox "select all"
        if (selectAll) {
            selectAll.addEventListener("change", function () {
                checkboxes.forEach(cb => cb.checked = this.checked);
                updateSelection();
            });
        }

        // Pastikan inisialisasi awal tombol bulk hidden
        updateSelection();
    });

    function toggleUserMenu() {
        const menu = document.getElementById('user-menu');
        if (menu) menu.classList.toggle('hidden');
    }

    // Filter gabungan Search, Fakultas, dan Pagination (10, 50, 100, semua data)
    let currentAlumniPage = 1;
    const searchInput = document.getElementById("searchMahasiswa");
    const filterSelect = document.getElementById("filterFakultas");
    const alumniPerPageSelect = document.getElementById("alumniPerPageSelect");

    function renderAlumniPaginationControls(totalPages) {
        const container = document.getElementById("alumniPaginationButtons");
        if (!container) return;

        container.innerHTML = "";
        if (totalPages <= 1) return;

        // Tombol Sebelumnya
        const prevBtn = document.createElement("button");
        prevBtn.type = "button";
        prevBtn.setAttribute("aria-label", "Halaman sebelumnya");
        prevBtn.className = "w-9 h-9 flex items-center justify-center rounded-lg text-slate-500 transition-all duration-200 " +
            (currentAlumniPage === 1 ? "bg-slate-50 text-slate-300 cursor-not-allowed" : "bg-white hover:bg-slate-50 hover:text-[#1B4E71] border border-slate-200");
        prevBtn.innerHTML = `
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
            </svg>
        `;
        prevBtn.disabled = currentAlumniPage === 1;
        prevBtn.addEventListener("click", function () {
            if (currentAlumniPage > 1) {
                currentAlumniPage--;
                applyTableFilter();
            }
        });
        container.appendChild(prevBtn);

        // Nomor Halaman
        const maxVisible = 5;
        let startPage = Math.max(1, currentAlumniPage - Math.floor(maxVisible / 2));
        let endPage = Math.min(totalPages, startPage + maxVisible - 1);

        if (endPage - startPage + 1 < maxVisible) {
            startPage = Math.max(1, endPage - maxVisible + 1);
        }

        for (let i = startPage; i <= endPage; i++) {
            const pageBtn = document.createElement("button");
            pageBtn.type = "button";
            pageBtn.textContent = i;
            pageBtn.className = "min-w-9 h-9 px-2 flex items-center justify-center rounded-lg text-xs sm:text-sm font-semibold transition-all duration-200 " +
                (i === currentAlumniPage ? "bg-[#1B4E71] text-white shadow-sm" : "bg-white text-slate-500 hover:bg-slate-50 hover:text-[#1B4E71] border border-slate-200");
            pageBtn.addEventListener("click", function () {
                currentAlumniPage = i;
                applyTableFilter();
            });
            container.appendChild(pageBtn);
        }

        // Tombol Berikutnya
        const nextBtn = document.createElement("button");
        nextBtn.type = "button";
        nextBtn.setAttribute("aria-label", "Halaman berikutnya");
        nextBtn.className = "w-9 h-9 flex items-center justify-center rounded-lg text-slate-500 transition-all duration-200 " +
            (currentAlumniPage === totalPages ? "bg-slate-50 text-slate-300 cursor-not-allowed" : "bg-white hover:bg-slate-50 hover:text-[#1B4E71] border border-slate-200");
        nextBtn.innerHTML = `
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
            </svg>
        `;
        nextBtn.disabled = currentAlumniPage === totalPages;
        nextBtn.addEventListener("click", function () {
            if (currentAlumniPage < totalPages) {
                currentAlumniPage++;
                applyTableFilter();
            }
        });
        container.appendChild(nextBtn);
    }

    function applyTableFilter() {
        const keyword = (searchInput?.value || "").toLowerCase().trim();
        const facultyFilter = (filterSelect?.value || "all").toLowerCase().trim();
        const perPageVal = alumniPerPageSelect?.value || "10";
        const rows = Array.from(document.querySelectorAll("#tableMahasiswa tr"));

        const filteredRows = rows.filter(function (row) {
            const text = row.textContent.toLowerCase();
            const faculty = (row.getAttribute("data-fakultas") || "").toLowerCase().trim();

            const matchesSearch = text.includes(keyword);
            const matchesFilter = facultyFilter === "all" || faculty === facultyFilter;

            return matchesSearch && matchesFilter;
        });

        // Sembunyikan semua baris terlebih dahulu
        rows.forEach(row => row.style.display = "none");

        const totalEntries = filteredRows.length;
        const perPage = perPageVal === "all" ? totalEntries : parseInt(perPageVal, 10);
        const totalPages = Math.ceil(totalEntries / (perPage || 1)) || 1;

        if (currentAlumniPage > totalPages) currentAlumniPage = totalPages;
        if (currentAlumniPage < 1) currentAlumniPage = 1;

        const startIdx = (currentAlumniPage - 1) * (perPage || 1);
        const endIdx = perPageVal === "all" ? totalEntries : Math.min(startIdx + perPage, totalEntries);

        filteredRows.slice(startIdx, endIdx).forEach(function (row) {
            row.style.display = "";
        });

        // Update info data (Menampilkan X - Y dari Z data)
        const showingStartEl = document.getElementById("alumniShowingStart");
        const showingEndEl = document.getElementById("alumniShowingEnd");
        const totalEntriesEl = document.getElementById("alumniTotalEntries");

        if (showingStartEl) showingStartEl.textContent = totalEntries === 0 ? 0 : startIdx + 1;
        if (showingEndEl) showingEndEl.textContent = endIdx;
        if (totalEntriesEl) totalEntriesEl.textContent = totalEntries;

        renderAlumniPaginationControls(totalPages);
    }

    if (searchInput) {
        searchInput.addEventListener("input", function () {
            currentAlumniPage = 1;
            applyTableFilter();
        });
    }

    if (filterSelect) {
        filterSelect.addEventListener("change", function () {
            currentAlumniPage = 1;
            applyTableFilter();
        });
    }

    if (alumniPerPageSelect) {
        alumniPerPageSelect.addEventListener("change", function () {
            currentAlumniPage = 1;
            applyTableFilter();
        });
    }

    // Jalankan filter dan pagination awal saat halaman dimuat
    applyTableFilter();

    // Dropdown toggle & close on outside click untuk Ubah Status Alumni
    const alumniStatusBtn = document.getElementById('alumni-status-dropdown-btn');
    const alumniStatusMenu = document.getElementById('alumni-status-dropdown-menu');
    const alumniStatusArrow = document.getElementById('alumni-status-arrow-icon');
    const alumniStatusWrapper = document.getElementById('alumni-status-dropdown-wrapper');

    if (alumniStatusBtn && alumniStatusMenu) {
        alumniStatusBtn.addEventListener('click', function (e) {
            e.stopPropagation();
            alumniStatusMenu.classList.toggle('hidden');
            if (alumniStatusArrow) alumniStatusArrow.classList.toggle('rotate-180');
        });

        document.addEventListener('click', function (e) {
            if (alumniStatusWrapper && !alumniStatusWrapper.contains(e.target)) {
                alumniStatusMenu.classList.add('hidden');
                if (alumniStatusArrow) alumniStatusArrow.classList.remove('rotate-180');
            }
        });
    }

    // Dropdown toggle & close on outside click untuk Ekspor Data Alumni
    const alumniExportBtn = document.getElementById('alumni-export-dropdown-btn');
    const alumniExportMenu = document.getElementById('alumni-export-dropdown-menu');
    const alumniExportArrow = document.getElementById('alumni-export-arrow-icon');
    const alumniExportWrapper = document.getElementById('alumni-export-dropdown-wrapper');

    if (alumniExportBtn && alumniExportMenu) {
        alumniExportBtn.addEventListener('click', function (e) {
            e.stopPropagation();
            alumniExportMenu.classList.toggle('hidden');
            if (alumniExportArrow) alumniExportArrow.classList.toggle('rotate-180');
        });

        document.addEventListener('click', function (e) {
            if (alumniExportWrapper && !alumniExportWrapper.contains(e.target)) {
                alumniExportMenu.classList.add('hidden');
                if (alumniExportArrow) alumniExportArrow.classList.remove('rotate-180');
            }
        });
    }

    function submitAlumniBulkStatus(status, label) {
        const idsInput = document.getElementById('alumni-status-ids');
        if (!idsInput || !idsInput.value) {
            alert('Pilih minimal satu alumni terlebih dahulu.');
            return;
        }

        const count = idsInput.value.split(',').filter(Boolean).length;
        if (confirm(`Yakin ingin mengubah status ${count} alumni yang dipilih menjadi "${label}"?`)) {
            document.getElementById('alumni-target-status').value = status;
            document.getElementById('alumni-bulk-status-form').submit();
        }
    }
</script>
@endsection