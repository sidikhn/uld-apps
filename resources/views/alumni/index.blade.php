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
                                class="flex items-center gap-1.5 text-rose-700 font-semibold bg-rose-50 hover:bg-rose-100 border border-rose-200 rounded-lg px-3.5 py-2 transition-all"
                                onclick="return confirm('Apakah Anda yakin ingin menghapus data alumni yang dipilih?')">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3m-4 0h14"/>
                                </svg>
                                <span>Hapus Data</span>
                            </button>
                        </form>

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
                                <td class="py-3 px-4 font-medium text-slate-900">{{ $alumni->nama }}</td>
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

            // Toggle Delete (boleh >0)
            if (selected.length > 0) {
                deleteForm?.classList.remove("hidden");
                if (deleteIds) deleteIds.value = selected.map(cb => cb.value).join(",");
            } else {
                deleteForm?.classList.add("hidden");
                if (deleteIds) deleteIds.value = "";
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
    });

    function toggleUserMenu() {
        const menu = document.getElementById('user-menu');
        if (menu) menu.classList.toggle('hidden');
    }

    // Filter gabungan Search & Fakultas
    const searchInput = document.getElementById("searchMahasiswa");
    const filterSelect = document.getElementById("filterFakultas");

    function applyTableFilter() {
        const keyword = (searchInput?.value || "").toLowerCase().trim();
        const facultyFilter = (filterSelect?.value || "all").toLowerCase().trim();
        const rows = document.querySelectorAll("#tableMahasiswa tr");

        rows.forEach(function (row) {
            const text = row.textContent.toLowerCase();
            const faculty = (row.getAttribute("data-fakultas") || "").toLowerCase().trim();

            const matchesSearch = text.includes(keyword);
            const matchesFilter = facultyFilter === "all" || faculty === facultyFilter;

            row.style.display = (matchesSearch && matchesFilter) ? "" : "none";
        });
    }

    if (searchInput) {
        searchInput.addEventListener("input", applyTableFilter);
    }

    if (filterSelect) {
        filterSelect.addEventListener("change", applyTableFilter);
    }
</script>
@endsection