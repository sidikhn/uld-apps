@php
    // Ragam Pilihan (checkboxes)
    $currentPilihan = old('ragam_disabilitas', $alumni->ragam_pilihan ?? []);
    if (empty($currentPilihan) && isset($alumni)) {
        $rawRagam = (array) ($alumni->ragam_disabilitas ?? []);
        if (!empty($alumni->ragam_pilihan)) {
            $currentPilihan = (array) $alumni->ragam_pilihan;
        } else {
            $currentPilihan = $rawRagam;
        }
    }
    if (!is_array($currentPilihan)) {
        $currentPilihan = [$currentPilihan];
    }

    // Subragam
    $currentSubragam = old('subragam', $alumni->subragam_disabilitas ?? []);
    if (is_string($currentSubragam)) {
        $decoded = json_decode($currentSubragam, true);
        $currentSubragam = is_array($decoded) ? $decoded : [];
    }
    if (!is_array($currentSubragam)) {
        $currentSubragam = [];
    }

    if (isset($alumni) && !empty($alumni->subragam_disabilitas)) {
        $savedSubData = is_array($alumni->subragam_disabilitas)
            ? $alumni->subragam_disabilitas
            : (json_decode($alumni->subragam_disabilitas, true) ?? []);
    } else {
        $savedSubData = $currentSubragam;
    }

    $allOptions = isset($subragamOptions) && is_array($subragamOptions)
        ? $subragamOptions
        : \App\Http\Controllers\MahasiswaController::getExistingSubragams();

    $activity = old('aktivitas_saat_ini', $alumni->aktivitas_saat_ini ?? '');
    $ways = old('cara_mendapatkan_pekerjaan', $alumni->cara_mendapatkan_pekerjaan ?? []);
    $barriers = old('kendala_mencari_pekerjaan', $alumni->kendala_mencari_pekerjaan ?? []);
@endphp

<form action="{{ $action }}" method="POST" class="space-y-8">
    @csrf
    @if($method === 'PUT') @method('PUT') @endif
    @if($errors->any())
        <div class="rounded-lg bg-red-100 px-4 py-3 text-red-700">
            <ul class="list-disc pl-5">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Data Sosio Biografi -->
    <section>
        <h2 class="text-2xl font-semibold text-[#083D62] border-b border-[#1B4E71] pb-2 mb-4">Data Sosio Biografi</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @foreach([['nama','Nama','text'],['nim','NIM','text'],['alamat_domisili','Alamat domisili saat ini','text'],['email_aktif','Email aktif','email'],['url_linkedin','URL Profil LinkedIn','url'],['nomor_hp','Nomor HP','text']] as $field)
                <div class="{{ $field[0] === 'alamat_domisili' ? 'md:col-span-2' : '' }}">
                    <label class="block font-medium text-[#083D62]">{{ $field[1] }}</label>
                    <input type="{{ $field[2] }}" name="{{ $field[0] }}" value="{{ old($field[0], $alumni->{$field[0]} ?? '') }}" class="w-full border border-gray-300 rounded-2xl p-2 mt-1 focus:ring-2 focus:ring-[#1F4E79] focus:outline-none" required>
                </div>
            @endforeach
            <div class="md:col-span-2">
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

                <!-- Status Klasifikasi Disabilitas (Otomatis Disabilitas Ganda jika > 1) -->
                <div id="disabilitasStatusBox" class="mt-4 hidden"></div>

                <!-- Subragam Section -->
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
        </div>
    </section>

    <!-- Aktivitas Lulusan -->
    <section>
        <h2 class="text-2xl font-semibold text-[#083D62] border-b border-[#1B4E71] pb-2 mb-4">Aktivitas Lulusan UGM</h2>
        <div class="space-y-4">
            <div>
                <label class="block font-medium text-[#083D62]">Apa aktivitas Anda saat ini?</label>
                <select name="aktivitas_saat_ini" id="aktivitas_saat_ini" class="w-full border border-gray-300 rounded-2xl p-2 mt-1 focus:ring-2 focus:ring-[#1F4E79] focus:outline-none">
                    <option value="">Pilih aktivitas</option>
                    @foreach(['B1'=>'Bekerja','B2'=>'Pernah bekerja (saat ini mencari pekerjaan)','B3'=>'Berwirausaha','B4'=>'Pernah berwirausaha (sedang menyiapkan usaha)','B5'=>'Masih mencari pekerjaan','B6'=>'Belum memungkinkan bekerja','B7'=>'Melanjutkan studi'] as $code => $label)
                        <option value="{{ $code }}" @selected($activity === $code)>{{ $code }} - {{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block font-medium text-[#083D62]">Waktu mendapatkan pekerjaan/wirausaha pertama (bulan)</label>
                    <input type="number" min="-12" max="12" name="waktu_mendapatkan_pekerjaan_bulan" value="{{ old('waktu_mendapatkan_pekerjaan_bulan', $alumni->waktu_mendapatkan_pekerjaan_bulan ?? '') }}" class="w-full border border-gray-300 rounded-2xl p-2 mt-1">
                </div>
                <div>
                    <label class="block font-medium text-[#083D62]">Mulai mencari pekerjaan/mempersiapkan usaha (bulan)</label>
                    <input type="number" min="-12" max="12" name="waktu_mulai_mencari_pekerjaan_bulan" value="{{ old('waktu_mulai_mencari_pekerjaan_bulan', $alumni->waktu_mulai_mencari_pekerjaan_bulan ?? '') }}" class="w-full border border-gray-300 rounded-2xl p-2 mt-1">
                </div>
            </div>
        </div>
    </section>

    <!-- Section Lanjutan B1-B4 -->
    <section id="section-b1-b4" class="hidden">
        <h2 class="text-xl font-semibold text-[#083D62] mb-4">Lanjutan B1-B4</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="md:col-span-2">
                <label class="block font-medium text-[#083D62] mb-2">Cara mendapatkan pekerjaan (boleh lebih dari satu)</label>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-2 rounded-xl bg-gray-50 border border-gray-200 p-4">
                    @foreach(['Ikatan Dinas','Dihubungi pemberi kerja','Bantuan career development center','Jejaring selama studi','Media sosial/iklan online','Rekan/relasi/keluarga','Instansi penyedia tenaga kerja','Menghubungi perusahaan langsung','Membangun usaha sendiri','Tempat kerja semasa kuliah','Iklan koran/majalah/brosur','Pameran kerja','Dinas Tenaga Kerja','Penempatan kerja/magang'] as $value)
                        <label class="flex items-center gap-2">
                            <input type="checkbox" name="cara_mendapatkan_pekerjaan[]" value="{{ $value }}" @checked(is_array($ways) && in_array($value, $ways, true))> {{ $value }}
                        </label>
                    @endforeach
                </div>
            </div>
            <div>
                <label class="block font-medium text-[#083D62]">Lainnya</label>
                <input name="cara_mendapatkan_pekerjaan_lainnya" value="{{ old('cara_mendapatkan_pekerjaan_lainnya', $alumni->cara_mendapatkan_pekerjaan_lainnya ?? '') }}" class="w-full border border-gray-300 rounded-2xl p-2 mt-1">
            </div>
            <div>
                <label class="block font-medium text-[#083D62]">Jenis institusi tempat bekerja</label>
                <select name="jenis_institusi_pekerjaan" class="w-full border border-gray-300 rounded-2xl p-2 mt-1">
                    <option value="">Pilih institusi</option>
                    @foreach(['Instansi pemerintah','Organisasi nonprofit/LSM','Perusahaan swasta','Wiraswasta/perusahaan sendiri','BUMN/BUMD','Institusi/Organisasi Multilateral'] as $value)
                        <option @selected(old('jenis_institusi_pekerjaan', $alumni->jenis_institusi_pekerjaan ?? '') === $value)>{{ $value }}</option>
                    @endforeach
                </select>
            </div>
            @foreach([['nama_tempat_kerja','Nama perusahaan/tempat bekerja'],['alamat_tempat_kerja','Alamat perusahaan/tempat bekerja'],['kontak_tempat_kerja','Nomor telepon/media sosial tempat bekerja'],['posisi_pekerjaan','Posisi/jabatan saat ini'],['lama_bekerja','Lama bekerja/menekuni usaha']] as $field)
                <div class="{{ in_array($field[0], ['alamat_tempat_kerja'], true) ? 'md:col-span-2' : '' }}">
                    <label class="block font-medium text-[#083D62]">{{ $field[1] }}</label>
                    <input name="{{ $field[0] }}" value="{{ old($field[0], $alumni->{$field[0]} ?? '') }}" class="w-full border border-gray-300 rounded-2xl p-2 mt-1">
                </div>
            @endforeach
            <div>
                <label class="block font-medium text-[#083D62]">Lainnya (posisi)</label>
                <input name="posisi_pekerjaan_lainnya" value="{{ old('posisi_pekerjaan_lainnya', $alumni->posisi_pekerjaan_lainnya ?? '') }}" class="w-full border border-gray-300 rounded-2xl p-2 mt-1">
            </div>
        </div>
    </section>

    <!-- Section Lanjutan B5-B6 -->
    <section id="section-b5-b6" class="hidden">
        <h2 class="text-xl font-semibold text-[#083D62] mb-4">Lanjutan B5-B6</h2>
        <label class="block font-medium text-[#083D62] mb-2">Kendala mencari pekerjaan</label>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-2 rounded-xl bg-gray-50 border border-gray-200 p-4">
            @foreach(['Minimnya tawaran untuk lulusan di prodi tersebut','Terbatasnya informasi lowongan kerja','Kegagalan pada tes kesehatan','Kegagalan saat wawancara kerja','Kurangnya pengalaman kerja'] as $value)
                <label class="flex items-center gap-2">
                    <input type="checkbox" name="kendala_mencari_pekerjaan[]" value="{{ $value }}" @checked(is_array($barriers) && in_array($value, $barriers, true))> {{ $value }}
                </label>
            @endforeach
        </div>
        <input name="kendala_mencari_pekerjaan_lainnya" value="{{ old('kendala_mencari_pekerjaan_lainnya', $alumni->kendala_mencari_pekerjaan_lainnya ?? '') }}" placeholder="Kendala lainnya" class="w-full border border-gray-300 rounded-2xl p-2 mt-3">
    </section>

    <!-- Section Lanjutan B7 -->
    <section id="section-b7" class="hidden">
        <h2 class="text-xl font-semibold text-[#083D62] mb-4">Lanjutan B7 - Melanjutkan Studi</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @foreach([['jenjang_studi_lanjut','Jenjang pendidikan'],['nama_prodi_studi_lanjut','Nama program studi'],['institusi_studi_lanjut','Institusi'],['lokasi_studi_lanjut','Lokasi (kota, negara)'],['tanggal_mulai_studi_lanjut','Tanggal mulai','date'],['tanggal_selesai_studi_lanjut','Selesai/perkiraan selesai','date']] as $field)
                <div>
                    <label class="block font-medium text-[#083D62]">{{ $field[1] }}</label>
                    <input type="{{ $field[2] ?? 'text' }}" name="{{ $field[0] }}" value="{{ old($field[0], $alumni->{$field[0]} ?? '') }}" class="w-full border border-gray-300 rounded-2xl p-2 mt-1">
                </div>
            @endforeach
        </div>
    </section>

    <!-- Container Tombol Simpan dengan Jarak & Pembatas -->
    <div class="flex justify-end pt-6 border-t border-slate-200 mt-10 mb-4">
        <button type="submit" class="bg-[#174A6F] hover:bg-[#113854] text-white font-semibold px-8 py-2.5 rounded-xl shadow-sm transition-colors">
            Simpan Data
        </button>
    </div>
</form>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const selectAktivitas = document.getElementById('aktivitas_saat_ini');
        const secB1B4 = document.getElementById('section-b1-b4');
        const secB5B6 = document.getElementById('section-b5-b6');
        const secB7 = document.getElementById('section-b7');

        function toggleSections() {
            if (!selectAktivitas) return;
            const val = selectAktivitas.value;

            if (secB1B4) secB1B4.classList.add('hidden');
            if (secB5B6) secB5B6.classList.add('hidden');
            if (secB7) secB7.classList.add('hidden');

            if (['B1', 'B2', 'B3', 'B4'].includes(val)) {
                if (secB1B4) secB1B4.classList.remove('hidden');
            } else if (['B5', 'B6'].includes(val)) {
                if (secB5B6) secB5B6.classList.remove('hidden');
            } else if (val === 'B7') {
                if (secB7) secB7.classList.remove('hidden');
            }
        }

        if (selectAktivitas) {
            selectAktivitas.addEventListener('change', toggleSections);
            toggleSections();
        }

        /* =========================================================
           RAGAM & SUBRAGAM DISABILITAS INTERACTIVITY
        ========================================================== */
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
</script>