@extends('layout.sideBar')

@section('title', 'Dashboard | Mahasiswa Disabilitas')

@section('content')
@php
    $currentPilihan = old('ragam_disabilitas', []);
    $currentSubragam = old('subragam', []);
    if (is_string($currentSubragam)) {
        $decoded = json_decode($currentSubragam, true);
        $currentSubragam = is_array($decoded) ? $decoded : [];
    }
    $savedSubData = is_array($currentSubragam) ? $currentSubragam : [];
    $allOptions = isset($subragamOptions) && is_array($subragamOptions)
        ? $subragamOptions
        : \App\Http\Controllers\MahasiswaController::getExistingSubragams();
@endphp
    <!-- Main Content -->
    <main class="flex-1 min-h-0 bg-gray-100 flex flex-col">
        <div class="flex justify-between w-full items-center space-x-3 bg-[#1B4E71] text-white px-6 py-2 cursor-pointer h-18">
            <!-- Home Simple -->
            <div class="flex items-center space-x-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" 
                            fill="none" viewBox="0 0 24 24" 
                            stroke="currentColor" stroke-width="2">
                            <path d="M22 10l-10-5L2 10l10 5 10-5z" 
                                class=" group-hover:stroke-white"/>
                            <path d="M6 12v5c3 3 9 3 12 0v-5" 
                                class=" group-hover:stroke-white"/>
                </svg>
                
                <!-- Teks -->
                <span class="font-medium text-2xl">Data Alumni</span>
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
                <form action="{{ route('alumni.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <!-- 1. Identitas Utama -->
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-2xl font-semibold mb-4 text-[#083D62]">Identitas Utama</h2>
                        <a href="{{ route('alumni.index') }}" 
                        class="flex items-center space-x-1 text-gray-700 cursor-pointer  bg-gray-200 hover:bg-gray-300 p-2 rounded w-26">
                            <!-- Icon panah -->
                            <svg xmlns="http://www.w3.org/2000/svg" 
                                class="h-5 w-5" fill="none" 
                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                            </svg>
                            <span class="font-medium  ">Kembali</span>
                        </a>

                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block font-medium text-[#083D62]">Nama Lengkap</label>
                            <input type="text" name="nama" class="w-full border rounded-2xl p-2 mt-1" required>
                        </div>

                        <div>
                            <label class="block font-medium text-[#083D62]">Jenis Kelamin</label>
                            <select name="jenis_kelamin" class="w-full border rounded-2xl p-2 mt-1 " required>
                                <option value="">-- Pilih --</option>
                                <option value="Laki-laki">Laki-laki</option>
                                <option value="Perempuan">Perempuan</option>
                            </select>
                        </div>

                        <div>
                            <label class="block font-medium text-[#083D62]">Tanggal Lahir</label>
                            <input type="date" name="tanggal_lahir" class="w-full border rounded-2xl p-2  mt-1" required>
                        </div>

                        <div>
                            <label class="block font-medium text-[#083D62]">NIM</label>
                            <input type="text" name="nim" class="w-full border rounded-2xl p-2  mt-1" required>
                        </div>

                        <div>
                            <label class="block font-medium text-[#083D62]">Program Studi</label>
                            <input type="text" name="prodi" class="w-full border rounded-2xl p-2  mt-1" required>
                        </div>

                        <div>
                            <label class="block font-medium text-[#083D62]">Fakultas</label>
                            <input type="text" name="fakultas" class="w-full border rounded-2xl p-2  mt-1" required>
                        </div>

                        <div>
                            <label class="block font-medium text-[#083D62]">Pendidikan</label>
                            <input type="text" name="pendidikan" class="w-full border rounded-2xl p-2  mt-1 h-13" required>
                        </div>
                        <div>
                            <label class="block font-medium text-[#083D62]">Angkatan</label>
                            <input type="text" name="angkatan" class="w-full border rounded-2xl p-2  mt-1 h-13" required>
                        </div>
                        
                        <div>
                            <label class="block font-medium text-[#083D62]">Beasiswa</label>
                            <input type="text" name="beasiswa" class="w-full border rounded-2xl p-2  mt-1">
                        </div>
                        
                        <div>
                            <label class="block font-medium text-[#083D62]">Nomor HP</label>
                            <input type="text" name="nomor_hp" class="w-full border rounded-2xl p-2  mt-1" required>
                        </div>
                        <div class="col-span-2">
                            <label class="block font-medium text-[#083D62] mb-1">
                                Ragam Disabilitas <span class="text-rose-500">*</span>
                            </label>
                            <p class="text-xs text-slate-500 mb-3">
                                Pilih satu atau beberapa ragam disabilitas yang sesuai.
                            </p>

                            <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                                @foreach (['Netra', 'Rungu', 'Mental', 'Fisik'] as $ragam)
                                    @php
                                        $isChecked = in_array($ragam, (array) $currentPilihan);
                                    @endphp
                                    <label class="ragam-checkbox-label group flex items-center gap-3 p-3.5 rounded-xl border cursor-pointer select-none transition-all duration-200 {{ $isChecked ? 'border-[#1B4E71] bg-[#1B4E71]/5 ring-1 ring-[#1B4E71]' : 'border-gray-200 bg-gray-50 hover:bg-gray-100' }}">
                                        <input type="checkbox"
                                               name="ragam_disabilitas[]"
                                               value="{{ $ragam }}"
                                               class="ragam-checkbox w-4 h-4 text-[#1B4E71] rounded accent-[#1B4E71] focus:ring-[#1B4E71]/20 cursor-pointer"
                                               @checked($isChecked)
                                               data-ragam="{{ $ragam }}">
                                        <span class="text-sm font-semibold text-slate-700">
                                            {{ $ragam }}
                                        </span>
                                    </label>
                                @endforeach
                            </div>

                            <div id="disabilitasStatusBox" class="mt-4 hidden"></div>

                            <div id="subragamSection" class="mt-5 p-5 bg-gray-50 border border-gray-200 rounded-2xl hidden">
                                <div class="mb-4">
                                    <h4 class="text-sm font-bold text-[#083D62]">
                                        Subragam Disabilitas
                                    </h4>
                                    <p class="text-xs text-slate-500 mt-1">
                                        Pilih subragam yang sesuai dengan kondisi alumni.
                                    </p>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    @foreach (['Netra', 'Rungu', 'Mental', 'Fisik'] as $ragam)
                                        @php
                                            $optionsList = isset($allOptions[$ragam]) && is_array($allOptions[$ragam])
                                                ? $allOptions[$ragam]
                                                : [];

                                            $savedVal = isset($savedSubData[$ragam])
                                                ? (string) $savedSubData[$ragam]
                                                : '';

                                            $isCustom = !empty($savedVal) && !in_array($savedVal, $optionsList, true);
                                        @endphp

                                        <div id="subragam-card-{{ $ragam }}" class="subragam-card hidden p-4 bg-white border border-gray-200 rounded-xl shadow-sm">
                                            <div class="flex items-center gap-2 mb-3">
                                                <span class="w-2 h-2 rounded-full bg-[#1B4E71]"></span>
                                                <span class="text-sm font-semibold text-[#083D62]">
                                                    Subragam {{ $ragam }}
                                                </span>
                                            </div>

                                            <select name="subragam[{{ $ragam }}]"
                                                    class="subragam-select w-full bg-gray-50 border border-gray-300 rounded-xl px-4 py-2.5 text-sm text-slate-800 focus:bg-white focus:border-[#1B4E71] focus:ring-2 focus:ring-[#1B4E71]/10 focus:outline-none transition-all"
                                                    data-ragam="{{ $ragam }}">
                                                <option value="">Pilih subragam {{ $ragam }}</option>
                                                @foreach ($optionsList as $opt)
                                                    <option value="{{ $opt }}" @selected($savedVal === (string) $opt)>
                                                        {{ $opt }}
                                                    </option>
                                                @endforeach
                                                <option value="__custom__" @selected($isCustom)>
                                                    + Tulis Subragam Baru
                                                </option>
                                            </select>

                                            <div class="subragam-custom-wrapper mt-3 {{ $isCustom ? '' : 'hidden' }}">
                                                <input type="text"
                                                       name="subragam_custom[{{ $ragam }}]"
                                                       value="{{ $isCustom ? $savedVal : '' }}"
                                                       placeholder="Tuliskan subragam {{ $ragam }}..."
                                                       class="subragam-custom-input w-full bg-sky-50/50 border border-sky-200 rounded-xl px-4 py-2.5 text-sm text-slate-800 placeholder-slate-400 focus:bg-white focus:border-[#1B4E71] focus:ring-2 focus:ring-[#1B4E71]/10 focus:outline-none transition-all">
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div>
                            <label class="block font-medium text-[#083D62]">Surat Keterangan Disabilitas</label>
                            <input type="text" name="surat_keterangan_link" class="w-full border rounded-2xl p-2  mt-1 h-13" required>
                        </div>

                        <div>
                            <label class="block font-medium mb-1 text-[#083D62]">Surat Keterangan Disabilitas</label>
                            <div class="w-full border rounded-2xl p-2 pl-5 bg-[#FFFFFF]">
                                <input type="file" 
                                    name="surat_keterangan" 
                                    class="w-full text-sm text-gray-600
                                            file:mr-4 file:py-2 file:px-4
                                            file:rounded-md file:border-0
                                            file:text-sm file:font-semibold
                                            file:bg-[#dedede] file:text-[#7B7E89]
                                            hover:file:bg-[#78a6ba] hover:file:text-[#FFFFFF]"
                                    accept=".pdf,.jpg,.png">
                            </div>
                        </div>
                    </div>

                    <!-- 2. Informasi Tambahan -->
                    <h2 class="text-2xl font-semibold mt-8 mb-4 text-[#083D62]">Informasi Tambahan</h2>

                    <div class="grid grid-cols-2 gap-4">
                        <div class="col-span-2">
                            <label class="block font-medium text-[#083D62]">Detail Disabilitas</label>
                            <textarea name="detail_disabilitas" class="w-full border rounded-2xl p-2 mt-2"></textarea>
                        </div>

                        <div class="col-span-2">
                            <label class="block font-medium text-[#083D62]">Alat Bantu</label>
                            <textarea name="alat_bantu" class="w-full border rounded-2xl p-2 mt-2"></textarea>
                        </div>

                        <div class="col-span-2">
                            <label class="block font-medium text-[#083D62]">Kesulitan/Kendala saat proses belajar</label>
                            <textarea name="kendala" class="w-full border rounded-2xl p-2 mt-2"></textarea>
                        </div>

                        <div class="col-span-2">
                            <label class="block font-medium text-[#083D62]">Akomodasi yang diperlukan</label>
                            <textarea name="akomodasi" class="w-full border rounded-2xl p-2 mt-2"></textarea>
                        </div>

                        <div class="col-span-2">
                            <label class="block font-medium text-[#083D62]">Pendampingan atau layanan</label>
                            <textarea name="pendampingan" class="w-full border rounded-2xl p-2 mt-2"></textarea>
                        </div>
                    </div>

                    <!-- Tombol -->
                    <div class="mt-6">
                        <button type="submit" class="bg-[#174A6F] text-white px-4 py-2 rounded-lg cursor-pointer">
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
        // Ragam & Subragam
        const ragamCheckboxes = document.querySelectorAll('.ragam-checkbox');
        const statusBox = document.getElementById('disabilitasStatusBox');
        const subragamSection = document.getElementById('subragamSection');

        function updateRagamAndSubragam() {
            const checked = Array.from(ragamCheckboxes)
                .filter(cb => cb.checked)
                .map(cb => cb.value);

            ragamCheckboxes.forEach(cb => {
                const label = cb.closest('.ragam-checkbox-label');
                if (!label) return;

                if (cb.checked) {
                    label.classList.add('border-[#1B4E71]', 'bg-[#1B4E71]/5', 'ring-1', 'ring-[#1B4E71]');
                    label.classList.remove('border-gray-200', 'bg-gray-50');
                } else {
                    label.classList.remove('border-[#1B4E71]', 'bg-[#1B4E71]/5', 'ring-1', 'ring-[#1B4E71]');
                    label.classList.add('border-gray-200', 'bg-gray-50');
                }
            });

            if (checked.length === 0) {
                if (statusBox) statusBox.classList.add('hidden');
                if (subragamSection) subragamSection.classList.add('hidden');
            } else if (checked.length === 1) {
                if (statusBox) {
                    statusBox.className = 'mt-4 text-xs font-medium py-3 px-4 rounded-xl bg-sky-50 border border-sky-200 text-sky-900 flex items-center gap-2';
                    statusBox.innerHTML = '<span class="w-2 h-2 rounded-full bg-sky-500"></span>Ragam terpilih: <strong>' + checked[0] + '</strong>';
                }
                if (subragamSection) subragamSection.classList.remove('hidden');
            } else {
                if (statusBox) {
                    statusBox.className = 'mt-4 text-xs font-medium py-3 px-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-900 flex items-center gap-2';
                    statusBox.innerHTML = '<span class="w-2 h-2 rounded-full bg-emerald-500"></span>Terpilih ' + checked.length + ' ragam (' + checked.join(', ') + '). <strong>Otomatis diklasifikasikan sebagai Disabilitas Ganda.</strong>';
                }
                if (subragamSection) subragamSection.classList.remove('hidden');
            }

            ['Netra', 'Rungu', 'Mental', 'Fisik'].forEach(function (ragam) {
                const card = document.getElementById('subragam-card-' + ragam);
                if (!card) return;

                if (checked.includes(ragam)) {
                    card.classList.remove('hidden');
                } else {
                    card.classList.add('hidden');
                }
            });
        }

        ragamCheckboxes.forEach(function (checkbox) {
            checkbox.addEventListener('change', updateRagamAndSubragam);
        });

        document.querySelectorAll('.subragam-select').forEach(function (select) {
            select.addEventListener('change', function () {
                const card = this.closest('.subragam-card');
                const wrapper = card ? card.querySelector('.subragam-custom-wrapper') : null;
                const customInput = wrapper ? wrapper.querySelector('.subragam-custom-input') : null;

                if (this.value === '__custom__') {
                    if (wrapper) wrapper.classList.remove('hidden');
                    if (customInput) customInput.focus();
                } else {
                    if (wrapper) wrapper.classList.add('hidden');
                    if (customInput) customInput.value = '';
                }
            });
        });

        updateRagamAndSubragam();
    });
    function toggleUserMenu() {
        const menu = document.getElementById('user-menu');
        menu.classList.toggle('hidden');
    }

    // Disable submit button after cliked
    document.querySelector("form")?.addEventListener("submit", function() {
        const btn = document.getElementById("submitBtn");
        if (btn) {
            btn.disabled = true;
            btn.innerText = "Menyimpan...";
        }
    });
</script>

@endsection