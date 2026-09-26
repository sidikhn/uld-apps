@extends('layout.sideBar')

@section('title', 'Dashboard | Data Dosen dan Tendik')

@section('content')
<!-- Main Content -->
<main class="flex-1 bg-slate-50 flex flex-col min-h-screen font-sans">
    
    <!-- Top Header -->
    <div class="flex flex-wrap justify-between items-center bg-[#1B4E71] text-white px-6 md:px-8 py-4 shadow-sm z-20 sticky top-0">
        <!-- Title Area -->
        <div class="flex items-center space-x-3">
            <div class="p-2 bg-white/10 rounded-lg">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                </svg>
            </div>
            <span class="font-bold text-xl tracking-wide">Data Dosen dan Tendik</span>
        </div>

        <!-- Contact Button -->
        <a href="https://wa.me/6282227021332" target="_blank"
           class="flex items-center space-x-2 bg-white/10 hover:bg-white/20 px-4 py-2 rounded-lg transition-colors border border-transparent">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 21l1.2-4.2A8.959 8.959 0 015 4a8.959 8.959 0 0112.728 12.728A8.959 8.959 0 018.8 19.8L4.2 21z" />
            </svg>
            <span class="font-medium text-sm">Hubungi Kami</span>
        </a>
    </div>

    <!-- Main Content Area -->
    <div class="flex-1 overflow-y-auto">
        
        <!-- Toolbar Section -->
    <!-- Toolbar Section (Tendik / Dosen) -->
    <div class="px-6 md:px-8 pt-6 z-10 relative">
        <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm flex flex-wrap items-center justify-between gap-4">
            
            <!-- Sisi Kiri: Search & Filter (Sejajar & Rapi) -->
            <div class="flex items-center gap-3 flex-1 min-w-[320px]">
                
                <!-- Search Input -->
                <div class="relative flex-1 min-w-[200px]">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M11 18a7 7 0 100-14 7 7 0 000 14z" />
                        </svg>
                    </div>
                    <input id="searchMahasiswa" type="text" placeholder="Cari dosen atau tendik...."
                        class="w-full pl-10 pr-4 py-2 bg-slate-50 hover:bg-slate-100 focus:bg-white text-slate-700 placeholder-slate-400 rounded-lg border border-slate-200 focus:ring-2 focus:ring-[#1B4E71] focus:border-[#1B4E71] outline-none text-sm font-medium transition-all" />
                </div>

                <!-- Filter Dropdown -->
                <div class="relative w-48 shrink-0">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400 z-10">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h7" />
                        </svg>
                    </div>
                    <select id="filterTendik"
                        class="w-full pl-10 pr-8 py-2 bg-slate-50 hover:bg-slate-100 focus:bg-white text-slate-700 font-medium text-sm rounded-lg border border-slate-200 focus:ring-2 focus:ring-[#1B4E71] focus:border-[#1B4E71] outline-none cursor-pointer transition-all">
                        <option value="all">Filter</option>
                        @foreach($tendiks->pluck('kategori_pegawai')->filter()->unique() as $kategori)
                            <option value="{{ strtolower($kategori) }}">{{ $kategori }}</option>
                        @endforeach
                    </select>
                </div>

            </div>

            <!-- Sisi Kanan: Action Buttons -->
            <div class="flex items-center gap-2 shrink-0">
                
                <!-- Tombol Edit Data (muncul saat 1 data dipilih) -->
                <a id="edit-btn" href="#"
                    class="hidden items-center gap-1.5 text-emerald-700 font-semibold bg-emerald-50 hover:bg-emerald-100 border border-emerald-200 rounded-lg px-3.5 py-2 transition-all">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/>
                    </svg>
                    <span>Edit</span>
                </a>

                <!-- Hapus Data Form -->
                <form id="delete-form" action="{{ route('tendik.bulkDelete') }}" method="POST" class="hidden m-0">
                    @csrf
                    @method('DELETE')
                    <input type="hidden" name="ids" id="delete-ids">
                    <button type="submit" 
                        class="flex items-center gap-1.5 text-rose-700 font-semibold bg-rose-50 hover:bg-rose-100 border border-rose-200 rounded-lg px-3.5 py-2 transition-all"
                        onclick="return confirm('Apakah Anda yakin ingin menghapus data yang dipilih?')">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3m-4 0h14"/>
                        </svg>
                        <span>Hapus</span>
                    </button>
                </form>

                <!-- Tambah Data Button -->
                @if(auth()->user()->role === 'superadmin')
                    <a href="{{ route('tendik.create') }}" 
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

        <!-- Table Section -->
        <div class="p-6 md:p-8 pt-6">
            
            <!-- Alert Success -->
            @if(session('success'))
                <div class="flex items-center bg-emerald-50 border-l-4 border-emerald-500 text-emerald-800 p-4 rounded-lg mb-6 shadow-sm" role="alert">
                    <svg class="h-5 w-5 mr-3 text-emerald-500" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <p class="font-semibold">{{ session('success') }}</p>
                </div>
            @endif

            <!-- Table Card Container -->
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
                <div class="overflow-x-auto">
                    <table id="tendikTable" class="w-full text-left border-collapse whitespace-nowrap">
                        <thead>
                            <tr class="bg-slate-50 border-b border-slate-200 text-slate-600 text-xs uppercase tracking-wider font-bold">
                                @if(auth()->user()->role === 'superadmin')
                                    <th class="p-4 text-center w-16">
                                        <input type="checkbox" id="select-all" class="w-4 h-4 rounded border-slate-300 text-[#1B4E71] focus:ring-[#1B4E71] transition-colors cursor-pointer">
                                    </th>
                                @endif
                                <th class="p-4 text-center w-16">No.</th>
                                <th class="p-4">Nama</th>
                                <th class="p-4">NIP/NIKA</th>
                                <th class="p-4">Kategori</th>
                                <th class="p-4">Unit Kerja</th>
                                <th class="p-4">Ragam Disabilitas</th>
                                <th class="p-4 text-center">Surat Asesmen</th>
                                <th class="p-4 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="tableMahasiswa" class="text-sm text-slate-700 divide-y divide-slate-100">
                            @foreach($tendiks as $tendik)
                            <tr class="hover:bg-blue-50/50 transition-colors duration-200 group" data-kategori="{{ strtolower($tendik->kategori_pegawai ?? '') }}">
                                
                                @if(auth()->user()->role === 'superadmin')
                                    <td class="p-4 text-center">
                                        <input type="checkbox" class="select-mahasiswa w-4 h-4 rounded border-slate-300 text-[#1B4E71] focus:ring-[#1B4E71] cursor-pointer transition-colors" value="{{ $tendik->id }}">
                                    </td>
                                @endif
                                
                                <td class="p-4 text-center font-semibold text-slate-500 group-hover:text-slate-800">
                                    {{ $loop->iteration }}
                                </td>
                                <td class="p-4 font-bold text-slate-800">{{ $tendik->nama }}</td>
                                <td class="p-4 text-slate-600 font-medium">{{ $tendik->nip_nika }}</td>
                                <td class="p-4 text-slate-600">{{ $tendik->kategori_pegawai }}</td>
                                <td class="p-4 text-slate-600">{{ $tendik->unit_kerja }}</td>
                                @php($disabilities = is_array($tendik->ragam_disabilitas) ? $tendik->ragam_disabilitas : json_decode($tendik->ragam_disabilitas ?: '[]', true))
                                <td class="p-4 text-slate-600">{{ is_array($disabilities) ? implode(', ', $disabilities) : $tendik->ragam_disabilitas }}</td>
                                
                                <td class="p-4 text-center">
                                    <a href="{{ route('tendik.pdf', $tendik->id) }}" 
                                        class="inline-flex items-center space-x-1.5 px-3 py-1.5 rounded-lg text-xs font-semibold bg-teal-50 text-teal-700 border border-teal-200 hover:bg-teal-600 hover:text-white transition-colors">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                        </svg>
                                        <span>Unduh PDF</span>
                                    </a>
                                </td>
                                
                                <td class="p-4 text-center">
                                    <a href="{{ route('tendik.show', $tendik->id) }}" 
                                        class="inline-flex items-center space-x-1.5 px-3 py-1.5 rounded-lg text-xs font-semibold bg-blue-50 text-blue-700 border border-blue-200 hover:bg-[#1B4E71] hover:text-white transition-colors">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                        <span>Detail</span>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <!-- If Table Empty Handling -->
                @if($tendiks->isEmpty())
                <div class="p-12 text-center text-slate-500 flex flex-col items-center justify-center">
                    <div class="bg-slate-50 p-4 rounded-full mb-4 border border-slate-100">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <p class="text-lg font-bold text-slate-700">Belum ada data dosen dan tendik</p>
                    <p class="text-sm text-slate-500 mt-1">Silakan tambahkan data baru melalui tombol "Tambah Data".</p>
                </div>
                @endif
                
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
                editBtn.classList.remove("hidden");
                editBtn.classList.add("flex");
                editBtn.href = "/dosen-tendik/" + selected[0].value + "/edit";
            } else {
                editBtn.classList.add("hidden");
                editBtn.classList.remove("flex");
                editBtn.href = "#";
            }

            // Toggle Delete (boleh >0)
            if (selected.length > 0) {
                deleteForm.classList.remove("hidden");
                deleteForm.classList.add("block");
                deleteIds.value = selected.map(cb => cb.value).join(",");
            } else {
                deleteForm.classList.add("hidden");
                deleteForm.classList.remove("block");
                deleteIds.value = "";
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

    const searchInput = document.getElementById("searchMahasiswa");
    const filterSelect = document.getElementById("filterTendik");
    const tableRows = document.querySelectorAll("#tableMahasiswa tr");

    function applyTableFilter() {
        const keyword = (searchInput ? searchInput.value : "").toLowerCase();
        const category = (filterSelect ? filterSelect.value : "all").toLowerCase();

        tableRows.forEach(function (row) {
            const matchesSearch = row.textContent.toLowerCase().includes(keyword);
            const matchesCategory = category === "all" || row.dataset.kategori === category;
            row.style.display = matchesSearch && matchesCategory ? "" : "none";
        });
    }

    if (searchInput) searchInput.addEventListener("keyup", applyTableFilter);
    if (filterSelect) filterSelect.addEventListener("change", applyTableFilter);
</script>
@endsection