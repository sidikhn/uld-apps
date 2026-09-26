@php
    $storedDisabilities = isset($tendik) ? $tendik->ragam_disabilitas : [];
    if (is_string($storedDisabilities)) {
        $storedDisabilities = json_decode($storedDisabilities, true) ?: [$storedDisabilities];
    }
    $selectedDisabilities = old('ragam_disabilitas', is_array($storedDisabilities) ? $storedDisabilities : []);
@endphp

<form action="{{ $action }}" method="POST" enctype="multipart/form-data" class="space-y-8">
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

    {{-- 1. Dokumen Pendukung --}}
    <section>
        <h2 class="text-2xl font-semibold text-[#083D62] border-b border-[#1B4E71] pb-2 mb-4">Dokumen Pendukung</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @foreach(['ktp' => 'KTP', 'surat_keterangan' => 'Surat keterangan disabilitas'] as $name => $label)
                <div>
                    <label class="block font-medium text-[#083D62] mb-1">{{ $label }}</label>
                    <input type="file" 
                        name="{{ $name }}" 
                        accept=".pdf,.jpg,.jpeg,.png,.gif,.webp,.bmp" 
                        class="w-full border border-gray-300 rounded-2xl p-2 text-sm focus:ring-2 focus:ring-[#1F4E79] focus:outline-none" 
                        {{ (!isset($tendik) || !$tendik->{$name}) ? 'required' : '' }}>
                    
                    @if(isset($tendik) && $tendik->{$name})
                        <a href="{{ route('tendik.document', [$tendik->id, $name]) }}" target="_blank" class="mt-1 inline-block text-sm text-blue-600 hover:underline">
                            Lihat file sebelumnya
                        </a>
                    @endif
                    @error($name) <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>
            @endforeach
        </div>
    </section>

    {{-- 2. Data Pribadi --}}
    <section>
        <h2 class="text-2xl font-semibold text-[#083D62] border-b border-[#1B4E71] pb-2 mb-4">Data Pribadi</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block font-medium text-[#083D62]">Nama</label>
                <input type="text" name="nama" value="{{ old('nama', $tendik->nama ?? '') }}" class="w-full border border-gray-300 rounded-2xl p-2 mt-1 focus:ring-2 focus:ring-[#1F4E79] focus:outline-none" required>
                @error('nama') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- MENU JENIS KELAMIN DITAMBAHKAN DI SINI --}}
            <div>
                <label class="block font-medium text-[#083D62]">Jenis Kelamin</label>
                <select name="jenis_kelamin" class="w-full border border-gray-300 rounded-2xl p-2 mt-1 focus:ring-2 focus:ring-[#1F4E79] focus:outline-none" required>
                    <option value="">Pilih jenis kelamin</option>
                    <option value="Laki-laki" @selected(old('jenis_kelamin', $tendik->jenis_kelamin ?? '') === 'Laki-laki')>Laki-laki</option>
                    <option value="Perempuan" @selected(old('jenis_kelamin', $tendik->jenis_kelamin ?? '') === 'Perempuan')>Perempuan</option>
                </select>
                @error('jenis_kelamin') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block font-medium text-[#083D62]">Tanggal lahir</label>
                <input type="date" 
                    name="tanggal_lahir" 
                    value="{{ old('tanggal_lahir', isset($tendik->tanggal_lahir) ? \Carbon\Carbon::parse($tendik->tanggal_lahir)->format('Y-m-d') : '') }}" 
                    class="w-full border border-gray-300 rounded-2xl p-2 mt-1 focus:ring-2 focus:ring-[#1F4E79] focus:outline-none" 
                    required>                
                    @error('tanggal_lahir') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block font-medium text-[#083D62]">No. KTP</label>
                <input type="text" name="no_ktp" value="{{ old('no_ktp', $tendik->no_ktp ?? '') }}" class="w-full border border-gray-300 rounded-2xl p-2 mt-1 focus:ring-2 focus:ring-[#1F4E79] focus:outline-none" required>
                @error('no_ktp') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block font-medium text-[#083D62]">Email</label>
                <input type="email" name="email" value="{{ old('email', $tendik->email ?? '') }}" class="w-full border border-gray-300 rounded-2xl p-2 mt-1 focus:ring-2 focus:ring-[#1F4E79] focus:outline-none" required>
                @error('email') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block font-medium text-[#083D62]">No HP</label>
                <input type="text" name="no_hp" value="{{ old('no_hp', $tendik->no_hp ?? '') }}" class="w-full border border-gray-300 rounded-2xl p-2 mt-1 focus:ring-2 focus:ring-[#1F4E79] focus:outline-none" required>
                @error('no_hp') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="md:col-span-2">
                <label class="block font-medium text-[#083D62]">Alamat</label>
                <textarea name="alamat" rows="2" class="w-full border border-gray-300 rounded-2xl p-2 mt-1 focus:ring-2 focus:ring-[#1F4E79] focus:outline-none" required>{{ old('alamat', $tendik->alamat ?? '') }}</textarea>
                @error('alamat') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>
        </div>
    </section>

    {{-- 3. Data Pegawai --}}
    <section>
        <h2 class="text-2xl font-semibold text-[#083D62] border-b border-[#1B4E71] pb-2 mb-4">Data Pegawai</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block font-medium text-[#083D62]">NIP/NIKA</label>
                <input name="nip_nika" value="{{ old('nip_nika', $tendik->nip_nika ?? '') }}" class="w-full border border-gray-300 rounded-2xl p-2 mt-1 focus:ring-2 focus:ring-[#1F4E79] focus:outline-none" required>
                @error('nip_nika') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block font-medium text-[#083D62]">Jenis pegawai</label>
                <select name="jenis_pegawai" class="w-full border border-gray-300 rounded-2xl p-2 mt-1 focus:ring-2 focus:ring-[#1F4E79] focus:outline-none" required>
                    <option value="">Pilih jenis pegawai</option>
                    @foreach(['PNS','Pegawai tetap UGM','Pegawai kontrak'] as $value)
                        <option value="{{ $value }}" @selected(old('jenis_pegawai', $tendik->jenis_pegawai ?? '') === $value)>{{ $value }}</option>
                    @endforeach
                </select>
                @error('jenis_pegawai') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block font-medium text-[#083D62]">Kategori pegawai</label>
                <select name="kategori_pegawai" class="w-full border border-gray-300 rounded-2xl p-2 mt-1 focus:ring-2 focus:ring-[#1F4E79] focus:outline-none" required>
                    <option value="">Pilih kategori</option>
                    @foreach(['Dosen','Tenaga kependidikan'] as $value)
                        <option value="{{ $value }}" @selected(old('kategori_pegawai', $tendik->kategori_pegawai ?? '') === $value)>{{ $value }}</option>
                    @endforeach
                </select>
                @error('kategori_pegawai') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block font-medium text-[#083D62]">Unit kerja (Fakultas/Sekolah di UGM)</label>
                <input name="unit_kerja" value="{{ old('unit_kerja', $tendik->unit_kerja ?? '') }}" class="w-full border border-gray-300 rounded-2xl p-2 mt-1 focus:ring-2 focus:ring-[#1F4E79] focus:outline-none" required>
                @error('unit_kerja') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="md:col-span-2">
                <label class="block font-medium text-[#083D62]">Pangkat/Golongan Terakhir</label>
                <input name="pangkat_golongan" value="{{ old('pangkat_golongan', $tendik->pangkat_golongan ?? '') }}" class="w-full border border-gray-300 rounded-2xl p-2 mt-1">
                @error('pangkat_golongan') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>
        </div>
    </section>

    {{-- 4. Disabilitas dan Dukungan --}}
    <section>
        <h2 class="text-2xl font-semibold text-[#083D62] border-b border-[#1B4E71] pb-2 mb-4">Disabilitas dan Dukungan</h2>
        <label class="block font-medium text-[#083D62] mb-2">Ragam disabilitas (boleh lebih dari satu)</label>
        <div class="grid grid-cols-2 md:grid-cols-3 gap-3 rounded-xl bg-gray-50 border border-gray-200 p-4">
            @foreach(['Fisik','Sensorik','Mental','Intelektual','Psikososial','Lainnya'] as $value)
                <label class="flex items-center gap-2 text-gray-700">
                    <input type="checkbox" name="ragam_disabilitas[]" value="{{ $value }}" @checked(is_array($selectedDisabilities) && in_array($value, $selectedDisabilities, true))> 
                    {{ $value }}
                </label>
            @endforeach
        </div>
        @error('ragam_disabilitas') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
            @foreach([
                ['detail_disabilitas','Kondisi disabilitas (narasi)',true],
                ['alat_bantu','Alat bantu yang digunakan (jika ada)',false],
                ['kendala','Kendala utama yang dihadapi dalam menjalankan tugas akibat kondisi disabilitas',true],
                ['akomodasi','Akomodasi layak/fasilitasi yang diperlukan',true],
                ['pendampingan','Catatan pendampingan atau layanan tambahan',false]
            ] as $field)
                <div class="{{ in_array($field[0], ['detail_disabilitas','kendala','akomodasi','pendampingan'], true) ? 'md:col-span-2' : '' }}">
                    <label class="block font-medium text-[#083D62]">{{ $field[1] }}</label>
                    <textarea name="{{ $field[0] }}" class="w-full min-h-[110px] border border-gray-300 rounded-2xl p-2 mt-1 focus:ring-2 focus:ring-[#1F4E79] focus:outline-none" {{ $field[2] ? 'required' : '' }}>{{ old($field[0], $tendik->{$field[0]} ?? '') }}</textarea>
                    @error($field[0]) <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>
            @endforeach
        </div>
    </section>

    <div class="flex justify-end pt-2">
        <button type="submit" class="bg-[#174A6F] hover:bg-[#113854] transition-colors text-white font-medium px-6 py-2 rounded-lg">Simpan Data</button>
    </div>
</form>