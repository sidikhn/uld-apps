@extends('layout.sideBar')

@section('title', 'Dashboard | Mahasiswa Disabilitas')

@section('content')
<!-- Main Content -->
<main class="flex-1 bg-slate-50 flex flex-col min-h-screen font-sans">
    
    <!-- Top Header (Menyesuaikan dengan Referensi Gambar) -->
    <div class="flex flex-wrap justify-between items-center bg-[#1B4E71] text-white px-6 md:px-8 py-4 shadow-sm z-10 relative">
        <!-- Title Area -->
        <div class="flex items-center space-x-3">
            <div class="p-2 bg-white/10 rounded-lg">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <rect x="3" y="3" width="7" height="9" rx="1"/>
                    <rect x="14" y="3" width="7" height="5" rx="1"/>
                    <rect x="14" y="12" width="7" height="9" rx="1"/>
                    <rect x="3" y="16" width="7" height="5" rx="1"/>
                </svg>
            </div>
            <span class="font-bold text-xl tracking-wide">Data Asesmen Kebutuhan Ujian Mahasiswa</span>
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
        
        <!-- Toolbar Section (Ujian) -->
        <div class="px-6 md:px-8 pt-6 z-10 relative">
            <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm flex flex-wrap items-center justify-between gap-4">
                
                <!-- Sisi Kiri: Search & Filter Semester -->
                <div class="flex items-center gap-3 flex-1 min-w-[320px]">
                    
                    <!-- Search Input -->
                    <div class="relative flex-1 min-w-[200px]">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M11 18a7 7 0 100-14 7 7 0 000 14z" />
                            </svg>
                        </div>
                        <input id="searchMahasiswa" type="text" placeholder="Cari mahasiswa...."
                            class="w-full pl-10 pr-4 py-2 bg-slate-50 hover:bg-slate-100 focus:bg-white text-slate-700 placeholder-slate-400 rounded-lg border border-slate-200 focus:ring-2 focus:ring-[#1B4E71] focus:border-[#1B4E71] outline-none text-sm font-medium transition-all" />
                    </div>

                    <!-- Filter Semester Form -->
                    <form method="GET" action="{{ route('ujian.index') }}" class="m-0 relative w-56 shrink-0">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400 z-10">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <select name="semester" onchange="this.form.submit()"
                            class="w-full pl-10 pr-8 py-2 bg-slate-50 hover:bg-slate-100 focus:bg-white text-slate-700 font-medium text-sm rounded-lg border border-slate-200 focus:ring-2 focus:ring-[#1B4E71] focus:border-[#1B4E71] outline-none cursor-pointer transition-all">
                            <option value="">-- Semua Semester --</option>
                            <option value="Gasal 2021/2022" {{ $semester == 'Gasal 2021/2022' ? 'selected' : '' }}>Gasal 2021/2022</option>
                            <option value="Genap 2021/2022" {{ $semester == 'Genap 2021/2022' ? 'selected' : '' }}>Genap 2021/2022</option>
                            <option value="Gasal 2022/2023" {{ $semester == 'Gasal 2022/2023' ? 'selected' : '' }}>Gasal 2022/2023</option>
                            <option value="Genap 2022/2023" {{ $semester == 'Genap 2022/2023' ? 'selected' : '' }}>Genap 2022/2023</option>
                        </select>
                    </form>

                </div>

                <!-- Sisi Kanan: Action Buttons -->
                <div class="flex items-center gap-2 shrink-0">
                    
                    <!-- Tombol Edit Data (hidden) -->
                    <a id="edit-btn" href="#"
                        class="hidden items-center gap-1.5 text-emerald-700 font-semibold bg-emerald-50 hover:bg-emerald-100 border border-emerald-200 rounded-lg px-3.5 py-2 transition-all text-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/>
                        </svg>
                        <span>Edit Data</span>
                    </a>

                    <!-- Tombol Hapus Data (hidden) -->
                    <form id="delete-form" action="{{ route('ujian.bulkDelete') }}" method="POST" class="hidden m-0">
                        @csrf
                        @method('DELETE')
                        <input type="hidden" name="ids" id="delete-ids">
                        <button type="submit" 
                            class="flex items-center gap-1.5 text-rose-700 font-semibold bg-rose-50 hover:bg-rose-100 border border-rose-200 rounded-lg px-3.5 py-2 transition-all text-sm"
                            onclick="return confirm('Apakah Anda yakin ingin menghapus data yang dipilih?')">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3m-4 0h14"/>
                            </svg>
                            <span>Hapus Data</span>
                        </button>
                    </form>

                    <!-- Tombol Tambah Data -->
                    @if(auth()->user()->role === 'superadmin')
                        <a href="{{ route('ujian.create') }}" 
                            class="flex items-center gap-1.5 bg-[#1B4E71] hover:bg-[#143a54] text-white font-medium rounded-lg px-4 py-2 transition-all shrink-0 text-sm">
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
                    <table class="w-full text-left border-collapse whitespace-nowrap">
                        <thead>
                            <tr class="bg-slate-50 border-b border-slate-200 text-slate-600 text-xs uppercase tracking-wider font-bold">
                                @if(auth()->user()->role === 'superadmin')
                                    <th class="p-4 text-center w-16">
                                        <input type="checkbox" id="select-all" class="w-4 h-4 rounded border-slate-300 text-[#1B4E71] focus:ring-[#1B4E71] transition-colors cursor-pointer">
                                    </th>
                                @endif
                                <th class="p-4">Nama</th>
                                <th class="p-4">Fakultas</th>
                                <th class="p-4 text-center">Semester</th>
                                <th class="p-4">Jenis Disabilitas</th>
                                <th class="p-4 text-center">Surat Hasil Asesmen</th>
                                <th class="p-4 text-center">Detail</th>
                            </tr>
                        </thead>
                        <tbody id="tableMahasiswa" class="text-sm text-slate-700 divide-y divide-slate-100">
                            @foreach($data as $asesmen_ujian)
                            <tr class="hover:bg-blue-50/50 transition-colors duration-200 group">
                                @if(auth()->user()->role === 'superadmin')
                                    <td class="p-4 text-center">
                                        <input type="checkbox" class="select-mahasiswa w-4 h-4 rounded border-slate-300 text-[#1B4E71] focus:ring-[#1B4E71] cursor-pointer transition-colors" value="{{ $asesmen_ujian->id }}">
                                    </td>
                                @endif
                                <td class="p-4 font-bold text-slate-800">{{ $asesmen_ujian->nama }}</td>
                                <td class="p-4 text-slate-600 font-medium">{{ $asesmen_ujian->fakultas }}</td>
                                <td class="p-4 text-center text-slate-600">{{ $asesmen_ujian->semester }}</td>
                                <td class="p-4 text-slate-600">{{ $asesmen_ujian->ragam_disabilitas }}</td>
                                
                                <td class="p-4 text-center">
                                    <a href="{{ route('asesmen_ujian.pdf', $asesmen_ujian->id) }}" 
                                        class="action-button bg-teal-50 text-teal-700 border border-teal-200 hover:bg-teal-600 hover:text-white">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                        </svg>
                                        <span>Download PDF</span>
                                    </a>
                                </td>
                                
                                <td class="p-4 text-center">
                                    <a href="{{ route('ujian.show', $asesmen_ujian->id) }}" 
                                    class="action-button bg-blue-50 text-blue-700 border border-blue-200 hover:bg-[#1B4E71] hover:text-white">
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
                @if($data->isEmpty())
                <div class="p-12 text-center text-slate-500 flex flex-col items-center justify-center">
                    <div class="bg-slate-50 p-4 rounded-full mb-4 border border-slate-100">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <p class="text-lg font-bold text-slate-700">Belum ada data asesmen</p>
                </div>
                @endif
                
            </div>

            <!-- Pagination Container -->
            <div class="mt-6 flex justify-end">
                {{ $data->withQueryString()->links() }}
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
            let selected = [];
            document.querySelectorAll(".select-mahasiswa:checked").forEach(el => {
                selected.push(el.value);
            });

            if (selectAll) {
                selectAll.checked = checkboxes.length > 0 && selected.length === checkboxes.length;
                selectAll.indeterminate = selected.length > 0 && selected.length < checkboxes.length;
            }

            // Toggle Edit (hanya 1 terpilih)
            if (selected.length === 1) {
                editBtn.classList.remove("hidden");
                editBtn.classList.add("flex");
                editBtn.href = "/asesmen-ujian/" + selected[0] + "/edit";
            } else {
                editBtn.classList.add("hidden");
                editBtn.classList.remove("flex");
                editBtn.href = "#";
            }

            // Toggle Delete (boleh >0)
            if (selected.length > 0) {
                deleteForm.classList.remove("hidden");
                deleteForm.classList.add("block");
                deleteIds.value = selected.join(","); // kirim ID array
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

    document.getElementById("searchMahasiswa").addEventListener("keyup", function() {
        let keyword = this.value.toLowerCase();
        let rows = document.querySelectorAll("#tableMahasiswa tr");

        rows.forEach(function(row) {
            let text = row.textContent.toLowerCase();
            if (text.includes(keyword)) {
                row.style.display = "";
            } else {
                row.style.display = "none";
            }
        });
    });
</script>
@endsection