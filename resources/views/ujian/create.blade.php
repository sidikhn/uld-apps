@extends('layout.sideBar')

@section('title', 'Dashboard | Mahasiswa Disabilitas')

@section('content')
    <!-- Main Content -->
    <main class="flex-1 min-h-0 bg-gray-100 flex flex-col">
        <div class="flex justify-between w-full items-center space-x-3 bg-[#1B4E71] text-white px-6 py-2 cursor-pointer h-18">
            <!-- Home Simple -->
            <div class="flex items-center space-x-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" 
                            fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <rect x="3" y="3" width="7" height="9" rx="1"/>
                        <rect x="14" y="3" width="7" height="5" rx="1"/>
                        <rect x="14" y="12" width="7" height="9" rx="1"/>
                        <rect x="3" y="16" width="7" height="5" rx="1"/>
                </svg>

                <!-- Teks -->
                <span class="font-medium text-2xl">Data Asesmen Kebutuhan Ujian Mahasiswa</span>
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

        <div class="flex-1 min-h-0 overflow-y-auto bg-gray-100 p-6">
            <div class="max-w-5xl mx-auto bg-white rounded-xl shadow p-6">
            {{-- <div class="p-6 bg-white rounded-xl shadow"> --}}
                <form action="{{ route('ujian.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <!-- 1. Identitas Utama -->
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-2xl font-semibold mb-4 text-[#083D62]">Identitas Utama</h2>
                        <a href="{{ route('ujian.index') }}" 
                        class="flex items-center space-x-1 text-gray-700 cursor-pointer bg-gray-200 hover:bg-gray-300 p-2 rounded w-26">
                            <svg xmlns="http://www.w3.org/2000/svg" 
                                class="h-5 w-5" fill="none" 
                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                            </svg>
                            <span class="font-medium">Kembali</span>
                        </a>
                    </div>

                    {{-- Dropdown Pilih Mahasiswa --}}
                    <div class="mb-6">
                        <label class="block font-medium text-[#083D62] mb-1">Pilih Mahasiswa</label>
                        <select id="mahasiswaSelect" name="mahasiswa_id" 
                                class="w-full border rounded-2xl p-2 mt-1 focus:ring-[#083D62] focus:border-[#083D62]">
                            <option value="">-- Pilih Mahasiswa --</option>
                            @foreach($mahasiswas as $mhs)
                                <option value="{{ $mhs->id }}"
                                    data-nama="{{ $mhs->nama }}"
                                    data-jenis_kelamin="{{ $mhs->jenis_kelamin }}"
                                    data-tanggal_lahir="{{ $mhs->tanggal_lahir }}"
                                    data-nim="{{ $mhs->nim }}"
                                    data-prodi="{{ $mhs->prodi }}"
                                    data-fakultas="{{ $mhs->fakultas }}"
                                    data-ragam="{{ is_array($mhs->ragam_disabilitas) ? implode(', ', $mhs->ragam_disabilitas) : $mhs->ragam_disabilitas }}">
                                    {{ $mhs->nama }} ({{ $mhs->nim }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block font-medium text-[#083D62]">Nama Lengkap</label>
                            <input type="text" id="nama" name="nama" class="w-full border rounded-2xl p-2 mt-1" readonly>
                        </div>
                        <div>
                            <label class="block font-medium text-[#083D62]">Jenis Kelamin</label>
                            <input type="text" id="jenis_kelamin" name="jenis_kelamin" class="w-full border rounded-2xl p-2 mt-1" readonly>
                        </div>
                        <div>
                            <label class="block font-medium text-[#083D62]">Tanggal Lahir</label>
                            <input type="text" id="tanggal_lahir" name="tanggal_lahir" class="w-full border rounded-2xl p-2 mt-1" readonly>
                        </div>

                        <div>
                            <label class="block font-medium text-[#083D62]">NIM</label>
                            <input type="text" id="nim" name="nim" class="w-full border rounded-2xl p-2 mt-1" readonly>
                        </div>

                        <div>
                            <label class="block font-medium text-[#083D62]">Program Studi</label>
                            <input type="text" id="prodi" name="prodi" class="w-full border rounded-2xl p-2 mt-1" readonly>
                        </div>

                        <div>
                            <label class="block font-medium text-[#083D62]">Fakultas</label>
                            <input type="text" id="fakultas" name="fakultas" class="w-full border rounded-2xl p-2 mt-1" readonly>
                        </div>

                        <div>
                            <label class="block font-medium text-[#083D62]">Ragam Disabilitas</label>
                            <input type="text" id="ragam_disabilitas" name="ragam_disabilitas" class="w-full border rounded-2xl p-2 mt-1" readonly>
                        </div>

                        <div>
                            <label class="block font-medium text-[#083D62]">Semester</label>
                            <input type="text" name="semester" class="w-full border rounded-2xl p-2 mt-1" required>
                        </div>
                    </div>


                    <!-- 2. Informasi Tambahan -->
                    <h2 class="text-2xl font-semibold mt-8 mb-4 text-[#083D62]">Informasi Tambahan</h2>

                    <div class="grid grid-cols-2 gap-4">
                        <div class="col-span-2">
                            <label class="block font-medium text-[#083D62]">Keperluan Perpanjangan Waktu</label>
                            <textarea name="keperluan_perpanjangan" class="w-full border rounded-2xl p-2 mt-2"></textarea>
                        </div>

                        <div class="col-span-2">
                            <label class="block font-medium text-[#083D62]">Alat Bantu</label>
                            <textarea name="alat_bantu" class="w-full border rounded-2xl p-2 mt-2"></textarea>
                        </div>

                        <div class="col-span-2">
                            <label class="block font-medium text-[#083D62]">Preferensi Format Soal Ujian</label>
                            <textarea name="preferensi_format" class="w-full border rounded-2xl p-2 mt-2"></textarea>
                        </div>

                        <div class="col-span-2">
                            <label class="block font-medium text-[#083D62]">Keperluan Pendampingan saat Ujian</label>
                            <textarea name="keperluan_pendampingan" class="w-full border rounded-2xl p-2 mt-2"></textarea>
                        </div>

                        <div class="col-span-2">
                            <label class="block font-medium text-[#083D62]">Penyesuaian Lain yang Diperlukan</label>
                            <textarea name="penyesuaian_lain" class="w-full border rounded-2xl p-2 mt-2"></textarea>
                        </div>
                    </div>

                    <!-- Tombol -->
                    <div class="mt-6">
                        <button type="submit" id="submitBtn" class="bg-[#174A6F] text-white px-4 py-2 rounded-lg cursor-pointer">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </main>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const checkboxes = document.querySelectorAll(".select-mahasiswa");
        const editBtn = document.getElementById("edit-btn");
        const deleteForm = document.getElementById("delete-form");
        const deleteIds = document.getElementById("delete-ids");

        checkboxes.forEach(cb => {
            cb.addEventListener("change", function () {
                let selected = [];
                document.querySelectorAll(".select-mahasiswa:checked").forEach(el => {
                    selected.push(el.value);
                });

                // Toggle Edit (hanya 1 terpilih)
                if (selected.length === 1) {
                    editBtn.classList.remove("hidden");
                    editBtn.href = "/alumni/" + selected[0] + "/edit";
                } else {
                    editBtn.classList.add("hidden");
                    editBtn.href = "#";
                }

                // Toggle Delete (boleh >0)
                if (selected.length > 0) {
                    deleteForm.classList.remove("hidden");
                    deleteIds.value = selected.join(","); // kirim ID array
                } else {
                    deleteForm.classList.add("hidden");
                    deleteIds.value = "";
                }
            });
        });
    });
    function toggleUserMenu() {
        const menu = document.getElementById('user-menu');
        menu.classList.toggle('hidden');
    }
    document.addEventListener("DOMContentLoaded", function() {
        const mahasiswaSelect = document.getElementById('mahasiswaSelect');

        mahasiswaSelect.addEventListener('change', function() {
            const selected = this.options[this.selectedIndex];
            document.getElementById('nama').value = selected.dataset.nama || '';
            document.getElementById('jenis_kelamin').value = selected.dataset.jenis_kelamin || '';
            document.getElementById('tanggal_lahir').value = selected.dataset.tanggal_lahir || '';
            document.getElementById('nim').value = selected.dataset.nim || '';
            document.getElementById('prodi').value = selected.dataset.prodi || '';
            document.getElementById('fakultas').value = selected.dataset.fakultas || '';
            document.getElementById('ragam_disabilitas').value = selected.dataset.ragam || '';
        });
    });

    // Disable submit button after cliked
    document.querySelector("form").addEventListener("submit", function() {
        const btn = document.getElementById("submitBtn");
        btn.disabled = true;
        btn.innerText = "Menyimpan...";
    });

</script>
@endsection