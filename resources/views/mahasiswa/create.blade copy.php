@extends('layout.sideBar')

@section('title', 'Dashboard | Mahasiswa Disabilitas')

@section('content')

@php
    $editing = isset($mahasiswa) && $mahasiswa;
    $facultiesList = $faculties ?? [];

    $currentPilihan = old('ragam_disabilitas', $mahasiswa->ragam_pilihan ?? []);

    if (empty($currentPilihan) && isset($mahasiswa)) {
        $rawRagam = (array) ($mahasiswa->ragam_disabilitas ?? []);
        $currentPilihan = $rawRagam;
    }

    if (is_string($currentPilihan)) {
        $currentPilihan = array_filter(
            array_map('trim', explode(',', $currentPilihan))
        );
    }

    $currentSubragam = old(
        'subragam',
        $mahasiswa->subragam_disabilitas ?? []
    );

    if (is_string($currentSubragam)) {
        $decoded = json_decode($currentSubragam, true);
        $currentSubragam = is_array($decoded) ? $decoded : [];
    }

    if (!is_array($currentSubragam)) {
        $currentSubragam = [];
    }

    $savedSubData = [];

    if (isset($mahasiswa) && !empty($mahasiswa->subragam_disabilitas)) {
        $savedSubData = is_array($mahasiswa->subragam_disabilitas)
            ? $mahasiswa->subragam_disabilitas
            : (json_decode($mahasiswa->subragam_disabilitas, true) ?? []);
    } else {
        $savedSubData = $currentSubragam;
    }

    $allOptions = isset($subragamOptions) && is_array($subragamOptions)
        ? $subragamOptions
        : [];
@endphp


<main class="flex-1 min-h-0 bg-slate-100 flex flex-col overflow-hidden">

    {{-- =========================================================
         HEADER
    ========================================================== --}}
    <header class="w-full bg-[#1B4E71] text-white px-6 md:px-8 py-5 md:py-6 
                shadow-md flex items-center justify-between shrink-0">

        <div class="flex items-center gap-4">

            <div class="w-11 h-11 rounded-xl bg-white/10 
                        flex items-center justify-center shrink-0">

                <svg xmlns="http://www.w3.org/2000/svg"
                    class="h-6 w-6 text-sky-100"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    stroke-width="2">

                    <ellipse cx="12" cy="5" rx="9" ry="3"/>
                    <path d="M3 5v14c0 1.66 4.03 3 9 3s9-1.34 9-3V5"/>
                    <path d="M3 12c0 1.66 4.03 3 9 3s9-1.34 9-3"/>
                </svg>

            </div>

            <div>
                <h1 class="font-bold text-lg md:text-xl leading-tight">
                    Data Mahasiswa
                </h1>

                <p class="text-xs md:text-sm text-sky-100/80 mt-1.5">
                    {{ $editing
                        ? 'Perbarui informasi mahasiswa'
                        : 'Tambahkan data mahasiswa disabilitas' }}
                </p>
            </div>

        </div>

        <a href="https://wa.me/6282227021332"
        target="_blank"
        class="hidden sm:inline-flex items-center gap-2.5 
                bg-white/10 hover:bg-white/20 
                text-white text-xs md:text-sm font-medium 
                px-4 py-2.5 md:px-5 md:py-3 rounded-xl 
                transition-all duration-200">

            <svg xmlns="http://www.w3.org/2000/svg"
                class="h-5 w-5 text-emerald-300"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
                stroke-width="2">

                <path stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M3 21l1.2-4.2A8.959 8.959 0 015 4a8.959 8.959 0 0112.728 12.728A8.959 8.959 0 018.8 19.8L4.2 21z" />

            </svg>

            <span>Bantuan & Hubungi Kami</span>

        </a>

    </header>


    {{-- =========================================================
         FORM AREA
    ========================================================== --}}
    <div class="flex-1 overflow-y-auto">

        <div class="px-4 py-6 md:px-7 md:py-8 lg:px-10 lg:py-9">

            <div class="max-w-5xl mx-auto">


                {{-- =================================================
                     PAGE INTRO
                ================================================== --}}
                <div class="mb-7">

                    <div class="flex flex-col sm:flex-row
                                sm:items-center sm:justify-between gap-5">

                        <div class="min-w-0">

                            <div class="flex items-center gap-2 mb-2">

                                <span class="inline-flex items-center
                                             px-2.5 py-1 rounded-lg
                                             bg-[#1B4E71]/10
                                             text-[#1B4E71]
                                             text-[11px] font-bold
                                             tracking-wide">

                                    FORMULIR MAHASISWA

                                </span>

                            </div>

                            <h2 class="text-2xl md:text-3xl
                                       font-bold text-slate-800
                                       tracking-tight">

                                {{ $editing
                                    ? 'Edit Data Mahasiswa'
                                    : 'Tambah Data Mahasiswa' }}

                            </h2>

                            <p class="text-sm text-slate-500
                                      mt-2 max-w-xl leading-relaxed">

                                {{ $editing
                                    ? 'Periksa dan perbarui informasi mahasiswa pada bagian yang diperlukan.'
                                    : 'Lengkapi informasi mahasiswa dengan data yang sesuai agar dapat diproses dengan baik.' }}

                            </p>

                        </div>


                        <a href="{{ route('mahasiswa.index') }}"
                           class="shrink-0 inline-flex items-center justify-center
                                  gap-2 px-4 py-2.5 rounded-xl
                                  bg-white border border-slate-200
                                  text-slate-600 text-sm font-semibold
                                  shadow-sm
                                  hover:bg-slate-50
                                  hover:text-[#1B4E71]
                                  hover:border-[#1B4E71]/20
                                  transition-all duration-200">

                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="h-4 w-4"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                stroke-width="2">

                                <path stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M15 19l-7-7 7-7" />

                            </svg>

                            <span>Kembali</span>

                        </a>

                    </div>

                </div>


                {{-- =================================================
                     FORM
                ================================================== --}}
                <form
                    action="{{ $editing
                        ? route('mahasiswa.update', $mahasiswa->id)
                        : route('mahasiswa.store') }}"
                    method="POST"
                    enctype="multipart/form-data"
                    class="space-y-6">

                    @csrf

                    @if($editing)
                        @method('PUT')
                    @endif


                    {{-- =================================================
                         SECTION 1
                    ================================================== --}}
                    <section class="bg-white rounded-2xl
                                    border border-slate-200
                                    shadow-sm overflow-hidden">

                        {{-- Section Header --}}
                        <div class="px-6 py-5 md:px-7
                                    border-b border-slate-100
                                    bg-white">

                            <div class="flex items-start gap-4">

                                <div class="w-10 h-10 rounded-xl
                                            bg-[#1B4E71]/10
                                            flex items-center justify-center
                                            shrink-0">

                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="h-5 w-5 text-[#1B4E71]"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor"
                                        stroke-width="2">

                                        <path stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />

                                    </svg>

                                </div>

                                <div>

                                    <div class="flex items-center gap-2">

                                        <h3 class="text-base font-bold
                                                   text-slate-800">

                                            Identitas Utama

                                        </h3>

                                        <span class="text-[10px] font-semibold
                                                     text-slate-400
                                                     bg-slate-100
                                                     px-2 py-0.5 rounded-md">

                                            BAGIAN 01

                                        </span>

                                    </div>

                                    <p class="text-xs text-slate-500
                                              mt-1">

                                        Informasi dasar dan data akademik mahasiswa.

                                    </p>

                                </div>

                            </div>

                        </div>


                        {{-- Section Body --}}
                        <div class="p-6 md:p-7">

                            <div class="grid grid-cols-1
                                        md:grid-cols-2
                                        gap-x-6 gap-y-6">


                                {{-- Nama --}}
                                <div>
                                    <label class="block text-sm font-semibold
                                                  text-slate-700 mb-2">

                                        Nama Lengkap
                                        <span class="text-rose-500">*</span>

                                    </label>

                                    <input
                                        type="text"
                                        name="nama"
                                        value="{{ old('nama', $mahasiswa->nama ?? '') }}"
                                        placeholder="Masukkan nama lengkap"
                                        class="w-full bg-slate-50
                                               border border-slate-200
                                               rounded-xl px-4 py-3
                                               text-sm text-slate-800
                                               placeholder-slate-400
                                               focus:bg-white
                                               focus:border-[#1B4E71]
                                               focus:ring-2
                                               focus:ring-[#1B4E71]/10
                                               focus:outline-none
                                               transition-all"
                                        required>
                                </div>


                                {{-- Jenis Kelamin --}}
                                <div>
                                    <label class="block text-sm font-semibold
                                                  text-slate-700 mb-2">

                                        Jenis Kelamin
                                        <span class="text-rose-500">*</span>

                                    </label>

                                    <select
                                        name="jenis_kelamin"
                                        class="w-full bg-slate-50
                                               border border-slate-200
                                               rounded-xl px-4 py-3
                                               text-sm text-slate-800
                                               focus:bg-white
                                               focus:border-[#1B4E71]
                                               focus:ring-2
                                               focus:ring-[#1B4E71]/10
                                               focus:outline-none
                                               transition-all"
                                        required>

                                        <option value="">
                                            Pilih jenis kelamin
                                        </option>

                                        <option value="Laki-laki"
                                            @selected(old('jenis_kelamin', $mahasiswa->jenis_kelamin ?? '') === 'Laki-laki')}>
                                            Laki-laki
                                        </option>

                                        <option value="Perempuan"
                                            @selected(old('jenis_kelamin', $mahasiswa->jenis_kelamin ?? '') === 'Perempuan')}>
                                            Perempuan
                                        </option>

                                    </select>
                                </div>


                                {{-- Tanggal Lahir --}}
                                <div>
                                    <label class="block text-sm font-semibold
                                                  text-slate-700 mb-2">

                                        Tanggal Lahir
                                        <span class="text-rose-500">*</span>

                                    </label>

                                    <input
                                        type="date"
                                        name="tanggal_lahir"
                                        value="{{ old('tanggal_lahir', $mahasiswa->tanggal_lahir ?? '') }}"
                                        class="w-full bg-slate-50
                                               border border-slate-200
                                               rounded-xl px-4 py-3
                                               text-sm text-slate-800
                                               focus:bg-white
                                               focus:border-[#1B4E71]
                                               focus:ring-2
                                               focus:ring-[#1B4E71]/10
                                               focus:outline-none
                                               transition-all"
                                        required>
                                </div>


                                {{-- NIM --}}
                                <div>
                                    <label class="block text-sm font-semibold
                                                  text-slate-700 mb-2">

                                        NIM
                                        <span class="text-rose-500">*</span>

                                    </label>

                                    <input
                                        type="text"
                                        id="nimInput"
                                        name="nim"
                                        value="{{ old('nim', $mahasiswa->nim ?? '') }}"
                                        placeholder="Contoh: 23/XXXXX"
                                        class="w-full bg-slate-50
                                               border border-slate-200
                                               rounded-xl px-4 py-3
                                               text-sm text-slate-800
                                               placeholder-slate-400
                                               focus:bg-white
                                               focus:border-[#1B4E71]
                                               focus:ring-2
                                               focus:ring-[#1B4E71]/10
                                               focus:outline-none
                                               transition-all"
                                        required>

                                    <p class="text-[11px] text-slate-400
                                              mt-2">

                                        Tahun angkatan akan terisi otomatis berdasarkan NIM.

                                    </p>
                                </div>


                                {{-- Pendidikan --}}
                                <div>
                                    <label class="block text-sm font-semibold
                                                  text-slate-700 mb-2">

                                        Jenjang Pendidikan
                                        <span class="text-rose-500">*</span>

                                    </label>

                                    <select
                                        name="pendidikan"
                                        class="w-full bg-slate-50
                                               border border-slate-200
                                               rounded-xl px-4 py-3
                                               text-sm text-slate-800
                                               focus:bg-white
                                               focus:border-[#1B4E71]
                                               focus:ring-2
                                               focus:ring-[#1B4E71]/10
                                               focus:outline-none
                                               transition-all"
                                        required>

                                        <option value="">
                                            Pilih jenjang pendidikan
                                        </option>

                                        @foreach (['D4', 'S1', 'S2', 'S3', 'Profesi', 'Spesialis'] as $value)

                                            <option value="{{ $value }}"
                                                @selected(old('pendidikan', $mahasiswa->pendidikan ?? '') === $value)>

                                                {{ $value }}

                                            </option>

                                        @endforeach

                                    </select>
                                </div>


                                {{-- Fakultas --}}
                                <div>
                                    <label class="block text-sm font-semibold
                                                  text-slate-700 mb-2">

                                        Fakultas
                                        <span class="text-rose-500">*</span>

                                    </label>

                                    <select
                                        id="facultySelect"
                                        name="faculty_id"
                                        class="w-full bg-slate-50
                                               border border-slate-200
                                               rounded-xl px-4 py-3
                                               text-sm text-slate-800
                                               focus:bg-white
                                               focus:border-[#1B4E71]
                                               focus:ring-2
                                               focus:ring-[#1B4E71]/10
                                               focus:outline-none
                                               transition-all"
                                        required>

                                        <option value="">
                                            Pilih fakultas
                                        </option>

                                        @foreach($facultiesList as $faculty)

                                            <option
                                                value="{{ $faculty->id }}"
                                                @selected(old('faculty_id', $mahasiswa->faculty_id ?? '') == $faculty->id)>

                                                {{ $faculty->name }}

                                            </option>

                                        @endforeach

                                    </select>
                                </div>


                                {{-- Program Studi --}}
                                <div>
                                    <label class="block text-sm font-semibold
                                                  text-slate-700 mb-2">

                                        Program Studi
                                        <span class="text-rose-500">*</span>

                                    </label>

                                    <select
                                        id="studyProgramSelect"
                                        name="study_program_id"
                                        class="w-full bg-slate-100
                                               border border-slate-200
                                               rounded-xl px-4 py-3
                                               text-sm text-slate-800
                                               focus:bg-white
                                               focus:border-[#1B4E71]
                                               focus:ring-2
                                               focus:ring-[#1B4E71]/10
                                               focus:outline-none
                                               transition-all"
                                        required
                                        disabled>

                                        <option value="">
                                            Pilih fakultas terlebih dahulu
                                        </option>

                                    </select>

                                    <p class="text-[11px] text-slate-400
                                              mt-2">

                                        Program studi akan menyesuaikan fakultas yang dipilih.

                                    </p>
                                </div>


                                {{-- Angkatan --}}
                                <div>
                                    <label class="block text-sm font-semibold
                                                  text-slate-700 mb-2">

                                        Angkatan

                                    </label>

                                    <div class="relative">

                                        <input
                                            type="text"
                                            id="angkatanInput"
                                            name="angkatan"
                                            value="{{ old('angkatan', $mahasiswa->angkatan ?? '') }}"
                                            class="w-full bg-slate-100
                                                   border border-slate-200
                                                   rounded-xl px-4 py-3
                                                   pr-24 text-sm
                                                   font-semibold
                                                   text-slate-500
                                                   cursor-not-allowed"
                                            required
                                            readonly>

                                        <span class="absolute right-3
                                                     top-1/2
                                                     -translate-y-1/2
                                                     text-[10px]
                                                     font-bold
                                                     text-slate-400
                                                     bg-white
                                                     px-2.5 py-1
                                                     rounded-lg
                                                     border border-slate-200">

                                            OTOMATIS

                                        </span>

                                    </div>
                                </div>


                                {{-- Tahun Asesmen --}}
                                <div>
                                    <label class="block text-sm font-semibold
                                                  text-slate-700 mb-2">

                                        Tahun Asesmen
                                        <span class="text-rose-500">*</span>

                                    </label>

                                    <input
                                        type="number"
                                        min="2000"
                                        max="2099"
                                        id="tahunAsesmenInput"
                                        name="tahun_asesmen"
                                        value="{{ old('tahun_asesmen', $mahasiswa->tahun_asesmen ?? date('Y')) }}"
                                        placeholder="Contoh: {{ date('Y') }}"
                                        class="w-full bg-slate-50
                                               border border-slate-200
                                               rounded-xl px-4 py-3
                                               text-sm text-slate-800
                                               focus:bg-white
                                               focus:border-[#1B4E71]
                                               focus:ring-2
                                               focus:ring-[#1B4E71]/10
                                               focus:outline-none
                                               transition-all"
                                        required>
                                </div>


                                {{-- Beasiswa --}}
                                <div>
                                    <label class="block text-sm font-semibold
                                                  text-slate-700 mb-2">

                                        Beasiswa

                                    </label>

                                    <input
                                        type="text"
                                        name="beasiswa"
                                        value="{{ old('beasiswa', $mahasiswa->beasiswa ?? '') }}"
                                        placeholder="Kosongkan jika tidak ada"
                                        class="w-full bg-slate-50
                                               border border-slate-200
                                               rounded-xl px-4 py-3
                                               text-sm text-slate-800
                                               placeholder-slate-400
                                               focus:bg-white
                                               focus:border-[#1B4E71]
                                               focus:ring-2
                                               focus:ring-[#1B4E71]/10
                                               focus:outline-none
                                               transition-all">
                                </div>


                                {{-- Nomor HP --}}
                                <div>
                                    <label class="block text-sm font-semibold
                                                  text-slate-700 mb-2">

                                        Nomor HP / WhatsApp
                                        <span class="text-rose-500">*</span>

                                    </label>

                                    <input
                                        type="text"
                                        name="nomor_hp"
                                        value="{{ old('nomor_hp', $mahasiswa->nomor_hp ?? '') }}"
                                        placeholder="08xxxxxxxxxx"
                                        class="w-full bg-slate-50
                                               border border-slate-200
                                               rounded-xl px-4 py-3
                                               text-sm text-slate-800
                                               placeholder-slate-400
                                               focus:bg-white
                                               focus:border-[#1B4E71]
                                               focus:ring-2
                                               focus:ring-[#1B4E71]/10
                                               focus:outline-none
                                               transition-all"
                                        required>
                                </div>

                            </div>

                        </div>

                    </section>


                    {{-- =================================================
                         SECTION 2
                    ================================================== --}}
                    <section class="bg-white rounded-2xl
                                    border border-slate-200
                                    shadow-sm overflow-hidden">

                        <div class="px-6 py-5 md:px-7
                                    border-b border-slate-100">

                            <div class="flex items-start gap-4">

                                <div class="w-10 h-10 rounded-xl
                                            bg-[#1B4E71]/10
                                            flex items-center justify-center
                                            shrink-0">

                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="h-5 w-5 text-[#1B4E71]"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor"
                                        stroke-width="2">

                                        <path stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M18.364 5.636a9 9 0 11-12.728 0M12 3v9m0 0l3 3m-3-3l-3 3" />

                                    </svg>

                                </div>

                                <div>

                                    <div class="flex items-center gap-2">

                                        <h3 class="text-base font-bold
                                                   text-slate-800">

                                            Kategori Disabilitas

                                        </h3>

                                        <span class="text-[10px] font-semibold
                                                     text-slate-400
                                                     bg-slate-100
                                                     px-2 py-0.5 rounded-md">

                                            BAGIAN 02

                                        </span>

                                    </div>

                                    <p class="text-xs text-slate-500 mt-1">
                                        Pilih satu atau beberapa ragam disabilitas yang sesuai.
                                    </p>

                                </div>

                            </div>

                        </div>


                        <div class="p-6 md:p-7">

                            <label class="block text-sm font-semibold
                                          text-slate-700 mb-3">

                                Ragam Disabilitas
                                <span class="text-rose-500">*</span>

                            </label>


                            <div class="grid grid-cols-1 sm:grid-cols-2
                                        lg:grid-cols-4 gap-3">

                                @foreach (['Netra', 'Rungu', 'Mental', 'Fisik'] as $ragam)

                                    @php
                                        $isChecked = in_array(
                                            $ragam,
                                            (array) $currentPilihan
                                        );
                                    @endphp

                                    <label
                                        class="ragam-checkbox-label group
                                               flex items-center gap-3
                                               p-4 rounded-xl
                                               border cursor-pointer
                                               select-none
                                               transition-all duration-200
                                               {{ $isChecked
                                                    ? 'border-[#1B4E71] bg-[#1B4E71]/5'
                                                    : 'border-slate-200 bg-slate-50 hover:bg-slate-100' }}">

                                        <input
                                            type="checkbox"
                                            name="ragam_disabilitas[]"
                                            value="{{ $ragam }}"
                                            class="ragam-checkbox
                                                   w-4 h-4
                                                   text-[#1B4E71]
                                                   rounded
                                                   accent-[#1B4E71]
                                                   focus:ring-[#1B4E71]/20
                                                   cursor-pointer"
                                            @checked($isChecked)
                                            data-ragam="{{ $ragam }}">

                                        <span class="text-sm font-semibold
                                                     text-slate-700">

                                            {{ $ragam }}

                                        </span>

                                    </label>

                                @endforeach

                            </div>


                            <div
                                id="disabilitasStatusBox"
                                class="mt-4 hidden">
                            </div>


                            <div
                                id="subragamSection"
                                class="mt-6 p-5 md:p-6
                                       bg-slate-50
                                       border border-slate-200
                                       rounded-2xl hidden">

                                <div class="mb-5">

                                    <h4 class="text-sm font-bold text-slate-700">
                                        Subragam Disabilitas
                                    </h4>

                                    <p class="text-xs text-slate-500 mt-1.5">
                                        Pilih subragam yang sesuai dengan kondisi mahasiswa.
                                    </p>

                                </div>


                                <div class="grid grid-cols-1 md:grid-cols-2
                                            gap-4">

                                    @foreach (['Netra', 'Rungu', 'Mental', 'Fisik'] as $ragam)

                                        @php
                                            $optionsList = isset($allOptions[$ragam])
                                                && is_array($allOptions[$ragam])
                                                    ? $allOptions[$ragam]
                                                    : [];

                                            $savedVal = isset($savedSubData[$ragam])
                                                ? (string) $savedSubData[$ragam]
                                                : '';

                                            $isCustom = !empty($savedVal)
                                                && !in_array(
                                                    $savedVal,
                                                    $optionsList,
                                                    true
                                                );
                                        @endphp

                                        <div
                                            id="subragam-card-{{ $ragam }}"
                                            class="subragam-card hidden
                                                   p-4 md:p-5
                                                   bg-white
                                                   border border-slate-200
                                                   rounded-xl">

                                            <div class="flex items-center
                                                        gap-2 mb-3">

                                                <span class="w-2 h-2 rounded-full
                                                             bg-[#1B4E71]">
                                                </span>

                                                <span class="text-sm font-semibold
                                                             text-slate-700">

                                                    Subragam {{ $ragam }}

                                                </span>

                                            </div>


                                            <select
                                                name="subragam[{{ $ragam }}]"
                                                class="subragam-select
                                                       w-full bg-slate-50
                                                       border border-slate-200
                                                       rounded-xl px-4 py-3
                                                       text-sm text-slate-800
                                                       focus:bg-white
                                                       focus:border-[#1B4E71]
                                                       focus:ring-2
                                                       focus:ring-[#1B4E71]/10
                                                       focus:outline-none
                                                       transition-all"
                                                data-ragam="{{ $ragam }}">

                                                <option value="">
                                                    Pilih subragam {{ $ragam }}
                                                </option>

                                                @foreach ($optionsList as $opt)

                                                    <option
                                                        value="{{ $opt }}"
                                                        @selected($savedVal === (string) $opt)>

                                                        {{ $opt }}

                                                    </option>

                                                @endforeach

                                                <option
                                                    value="__custom__"
                                                    @selected($isCustom)>

                                                    + Tulis Subragam Baru

                                                </option>

                                            </select>


                                            <div
                                                class="subragam-custom-wrapper
                                                       mt-3
                                                       {{ $isCustom ? '' : 'hidden' }}">

                                                <input
                                                    type="text"
                                                    name="subragam_custom[{{ $ragam }}]"
                                                    value="{{ $isCustom ? $savedVal : '' }}"
                                                    placeholder="Tuliskan subragam {{ $ragam }}..."
                                                    class="subragam-custom-input
                                                           w-full
                                                           bg-sky-50/50
                                                           border border-sky-200
                                                           rounded-xl
                                                           px-4 py-3
                                                           text-sm
                                                           text-slate-800
                                                           placeholder-slate-400
                                                           focus:bg-white
                                                           focus:border-[#1B4E71]
                                                           focus:ring-2
                                                           focus:ring-[#1B4E71]/10
                                                           focus:outline-none
                                                           transition-all">

                                            </div>

                                        </div>

                                    @endforeach

                                </div>

                            </div>

                        </div>

                    </section>


                    {{-- =================================================
                         SECTION 3
                    ================================================== --}}
                    <section class="bg-white rounded-2xl
                                    border border-slate-200
                                    shadow-sm overflow-hidden">

                        <div class="px-6 py-5 md:px-7
                                    border-b border-slate-100">

                            <div class="flex items-start gap-4">

                                <div class="w-10 h-10 rounded-xl
                                            bg-[#1B4E71]/10
                                            flex items-center justify-center
                                            shrink-0">

                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="h-5 w-5 text-[#1B4E71]"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor"
                                        stroke-width="2">

                                        <path stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />

                                        <path stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M13 3v6h6" />

                                    </svg>

                                </div>

                                <div>

                                    <div class="flex items-center gap-2">

                                        <h3 class="text-base font-bold
                                                   text-slate-800">

                                            Dokumen Pendukung

                                        </h3>

                                        <span class="text-[10px] font-semibold
                                                     text-slate-400
                                                     bg-slate-100
                                                     px-2 py-0.5 rounded-md">

                                            BAGIAN 03

                                        </span>

                                    </div>

                                    <p class="text-xs text-slate-500 mt-1">
                                        Unggah dokumen yang diperlukan untuk melengkapi data.
                                    </p>

                                </div>

                            </div>

                        </div>


                        <div class="p-6 md:p-7">

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">


                                {{-- KTP --}}
                                <div>

                                    <label class="block text-sm font-semibold
                                                  text-slate-700 mb-2">

                                        KTP

                                        @if(!$editing)
                                            <span class="text-rose-500">*</span>
                                        @endif

                                    </label>

                                    <label
                                        class="document-upload-box group
                                               flex flex-col items-center
                                               justify-center
                                               min-h-[165px]
                                               p-5 rounded-2xl
                                               border-2 border-dashed
                                               border-slate-200
                                               bg-slate-50
                                               cursor-pointer
                                               hover:bg-[#1B4E71]/5
                                               hover:border-[#1B4E71]/40
                                               transition-all duration-200">

                                        <div class="w-11 h-11 rounded-xl
                                                    bg-white
                                                    border border-slate-200
                                                    flex items-center
                                                    justify-center mb-3
                                                    shadow-sm">

                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                class="h-5 w-5 text-slate-400
                                                       group-hover:text-[#1B4E71]"
                                                fill="none"
                                                viewBox="0 0 24 24"
                                                stroke="currentColor">

                                                <path stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="2"
                                                    d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M8 10l4-4m0 0l4 4m-4-4v12" />

                                            </svg>

                                        </div>

                                        <span class="text-sm font-semibold
                                                     text-slate-700">

                                            Pilih Berkas

                                        </span>

                                        <span class="text-[11px] text-slate-400 mt-1">
                                            PDF, JPG, PNG
                                        </span>

                                        <input
                                            type="file"
                                            name="ktp"
                                            {{ $editing ? '' : 'required' }}
                                            class="hidden document-input"
                                            accept=".pdf,.jpg,.jpeg,.png,.gif,.webp,.bmp">

                                        <span
                                            class="file-name mt-2
                                                   text-[11px]
                                                   text-slate-400
                                                   font-medium
                                                   text-center
                                                   truncate
                                                   max-w-[180px]">

                                            Belum ada file

                                        </span>

                                    </label>


                                    @if($editing && !empty($mahasiswa->ktp))

                                        <a
                                            href="{{ route('mahasiswa.document', [$mahasiswa->id, 'ktp']) }}"
                                            target="_blank"
                                            class="inline-flex items-center gap-1.5
                                                   mt-2.5
                                                   text-xs font-semibold
                                                   text-sky-600
                                                   hover:text-[#1B4E71]
                                                   hover:underline">

                                            Lihat KTP terupload

                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                class="h-3.5 w-3.5"
                                                fill="none"
                                                viewBox="0 0 24 24"
                                                stroke="currentColor">

                                                <path stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="2"
                                                    d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />

                                            </svg>

                                        </a>

                                    @endif

                                </div>


                                {{-- Foto --}}
                                <div>

                                    <label class="block text-sm font-semibold
                                                  text-slate-700 mb-2">

                                        Pas Foto

                                        @if(!$editing)
                                            <span class="text-rose-500">*</span>
                                        @endif

                                    </label>

                                    <label
                                        class="document-upload-box group
                                               flex flex-col items-center
                                               justify-center
                                               min-h-[165px]
                                               p-5 rounded-2xl
                                               border-2 border-dashed
                                               border-slate-200
                                               bg-slate-50
                                               cursor-pointer
                                               hover:bg-[#1B4E71]/5
                                               hover:border-[#1B4E71]/40
                                               transition-all duration-200">

                                        <div class="w-11 h-11 rounded-xl
                                                    bg-white
                                                    border border-slate-200
                                                    flex items-center
                                                    justify-center mb-3
                                                    shadow-sm">

                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                class="h-5 w-5 text-slate-400
                                                       group-hover:text-[#1B4E71]"
                                                fill="none"
                                                viewBox="0 0 24 24"
                                                stroke="currentColor">

                                                <path stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="2"
                                                    d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M8 10l4-4m0 0l4 4m-4-4v12" />

                                            </svg>

                                        </div>

                                        <span class="text-sm font-semibold
                                                     text-slate-700">

                                            Pilih Berkas

                                        </span>

                                        <span class="text-[11px] text-slate-400 mt-1">
                                            JPG, PNG
                                        </span>

                                        <input
                                            type="file"
                                            name="foto"
                                            {{ $editing ? '' : 'required' }}
                                            class="hidden document-input"
                                            accept=".jpg,.jpeg,.png,.gif,.webp,.bmp">

                                        <span
                                            class="file-name mt-2
                                                   text-[11px]
                                                   text-slate-400
                                                   font-medium
                                                   text-center
                                                   truncate
                                                   max-w-[180px]">

                                            Belum ada file

                                        </span>

                                    </label>


                                    @if($editing && !empty($mahasiswa->foto))

                                        <a
                                            href="{{ route('mahasiswa.document', [$mahasiswa->id, 'foto']) }}"
                                            target="_blank"
                                            class="inline-flex items-center gap-1.5
                                                   mt-2.5
                                                   text-xs font-semibold
                                                   text-sky-600
                                                   hover:text-[#1B4E71]
                                                   hover:underline">

                                            Lihat foto terupload

                                        </a>

                                    @endif

                                </div>


                                {{-- Surat --}}
                                <div>

                                    <label class="block text-sm font-semibold
                                                  text-slate-700 mb-2">

                                        Surat Keterangan

                                    </label>

                                    <label
                                        class="document-upload-box group
                                               flex flex-col items-center
                                               justify-center
                                               min-h-[165px]
                                               p-5 rounded-2xl
                                               border-2 border-dashed
                                               border-slate-200
                                               bg-slate-50
                                               cursor-pointer
                                               hover:bg-[#1B4E71]/5
                                               hover:border-[#1B4E71]/40
                                               transition-all duration-200">

                                        <div class="w-11 h-11 rounded-xl
                                                    bg-white
                                                    border border-slate-200
                                                    flex items-center
                                                    justify-center mb-3
                                                    shadow-sm">

                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                class="h-5 w-5 text-slate-400
                                                       group-hover:text-[#1B4E71]"
                                                fill="none"
                                                viewBox="0 0 24 24"
                                                stroke="currentColor">

                                                <path stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="2"
                                                    d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M8 10l4-4m0 0l4 4m-4-4v12" />

                                            </svg>

                                        </div>

                                        <span class="text-sm font-semibold
                                                     text-slate-700">

                                            Pilih Berkas

                                        </span>

                                        <span class="text-[11px] text-slate-400 mt-1">
                                            PDF, JPG, PNG · Opsional
                                        </span>

                                        <input
                                            type="file"
                                            name="surat_keterangan"
                                            class="hidden document-input"
                                            accept=".pdf,.jpg,.jpeg,.png">

                                        <span
                                            class="file-name mt-2
                                                   text-[11px]
                                                   text-slate-400
                                                   font-medium
                                                   text-center
                                                   truncate
                                                   max-w-[180px]">

                                            Belum ada file

                                        </span>

                                    </label>


                                    @if($editing && !empty($mahasiswa->surat_keterangan))

                                        <a
                                            href="{{ route('mahasiswa.document', [$mahasiswa->id, 'surat_keterangan']) }}"
                                            target="_blank"
                                            class="inline-flex items-center gap-1.5
                                                   mt-2.5
                                                   text-xs font-semibold
                                                   text-sky-600
                                                   hover:text-[#1B4E71]
                                                   hover:underline">

                                            Lihat surat terupload

                                        </a>

                                    @elseif($editing && !empty($mahasiswa->surat_keterangan_link))

                                        <a
                                            href="{{ $mahasiswa->surat_keterangan_link }}"
                                            target="_blank"
                                            class="inline-flex items-center gap-1.5
                                                   mt-2.5
                                                   text-xs font-semibold
                                                   text-sky-600
                                                   hover:text-[#1B4E71]
                                                   hover:underline">

                                            Lihat tautan surat

                                        </a>

                                    @endif

                                </div>

                            </div>

                        </div>

                    </section>


                    {{-- =================================================
                         SECTION 4
                    ================================================== --}}
                    <section class="bg-white rounded-2xl
                                    border border-slate-200
                                    shadow-sm overflow-hidden">

                        <div class="px-6 py-5 md:px-7
                                    border-b border-slate-100">

                            <div class="flex items-start gap-4">

                                <div class="w-10 h-10 rounded-xl
                                            bg-[#1B4E71]/10
                                            flex items-center justify-center
                                            shrink-0">

                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="h-5 w-5 text-[#1B4E71]"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor"
                                        stroke-width="2">

                                        <path stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M13 16h-1v-4h-1m1-4h.01M12 20a8 8 0 100-16 8 8 0 000 16z" />

                                    </svg>

                                </div>

                                <div>

                                    <div class="flex items-center gap-2">

                                        <h3 class="text-base font-bold
                                                   text-slate-800">

                                            Informasi Tambahan

                                        </h3>

                                        <span class="text-[10px] font-semibold
                                                     text-slate-400
                                                     bg-slate-100
                                                     px-2 py-0.5 rounded-md">

                                            BAGIAN 04

                                        </span>

                                    </div>

                                    <p class="text-xs text-slate-500 mt-1">
                                        Informasi tambahan mengenai kebutuhan mahasiswa.
                                    </p>

                                </div>

                            </div>

                        </div>


                        <div class="p-6 md:p-7">

                            <div class="space-y-6">


                                {{-- Detail --}}
                                <div>

                                    <label class="block text-sm font-semibold
                                                  text-slate-700 mb-2">

                                        Detail Kondisi Disabilitas

                                    </label>

                                    <textarea
                                        name="detail_disabilitas"
                                        rows="3"
                                        placeholder="Jelaskan detail kondisi disabilitas..."
                                        class="w-full bg-slate-50
                                               border border-slate-200
                                               rounded-xl
                                               px-4 py-3
                                               text-sm text-slate-800
                                               placeholder-slate-400
                                               leading-relaxed
                                               focus:bg-white
                                               focus:border-[#1B4E71]
                                               focus:ring-2
                                               focus:ring-[#1B4E71]/10
                                               focus:outline-none
                                               transition-all
                                               resize-y">{{ old('detail_disabilitas', $mahasiswa->detail_disabilitas ?? '') }}</textarea>

                                </div>


                                {{-- Alat Bantu --}}
                                <div>

                                    <label class="block text-sm font-semibold
                                                  text-slate-700 mb-2">

                                        Alat Bantu yang Digunakan

                                    </label>

                                    <textarea
                                        name="alat_bantu"
                                        rows="3"
                                        placeholder="Sebutkan alat bantu yang biasa digunakan..."
                                        class="w-full bg-slate-50
                                               border border-slate-200
                                               rounded-xl
                                               px-4 py-3
                                               text-sm text-slate-800
                                               placeholder-slate-400
                                               leading-relaxed
                                               focus:bg-white
                                               focus:border-[#1B4E71]
                                               focus:ring-2
                                               focus:ring-[#1B4E71]/10
                                               focus:outline-none
                                               transition-all
                                               resize-y">{{ old('alat_bantu', $mahasiswa->alat_bantu ?? '') }}</textarea>

                                </div>


                                {{-- Kendala --}}
                                <div>

                                    <label class="block text-sm font-semibold
                                                  text-slate-700 mb-2">

                                        Kendala / Kesulitan saat Pembelajaran

                                    </label>

                                    <textarea
                                        name="kendala"
                                        rows="3"
                                        placeholder="Tuliskan kendala yang dialami saat proses pembelajaran..."
                                        class="w-full bg-slate-50
                                               border border-slate-200
                                               rounded-xl
                                               px-4 py-3
                                               text-sm text-slate-800
                                               placeholder-slate-400
                                               leading-relaxed
                                               focus:bg-white
                                               focus:border-[#1B4E71]
                                               focus:ring-2
                                               focus:ring-[#1B4E71]/10
                                               focus:outline-none
                                               transition-all
                                               resize-y">{{ old('kendala', $mahasiswa->kendala ?? '') }}</textarea>

                                </div>


                                {{-- Akomodasi --}}
                                <div>

                                    <label class="block text-sm font-semibold
                                                  text-slate-700 mb-2">

                                        Akomodasi yang Diperlukan

                                    </label>

                                    <textarea
                                        name="akomodasi"
                                        rows="3"
                                        placeholder="Tuliskan kebutuhan aksesibilitas fisik maupun non-fisik..."
                                        class="w-full bg-slate-50
                                               border border-slate-200
                                               rounded-xl
                                               px-4 py-3
                                               text-sm text-slate-800
                                               placeholder-slate-400
                                               leading-relaxed
                                               focus:bg-white
                                               focus:border-[#1B4E71]
                                               focus:ring-2
                                               focus:ring-[#1B4E71]/10
                                               focus:outline-none
                                               transition-all
                                               resize-y">{{ old('akomodasi', $mahasiswa->akomodasi ?? '') }}</textarea>

                                </div>


                                {{-- Pendampingan --}}
                                <div>

                                    <label class="block text-sm font-semibold
                                                  text-slate-700 mb-2">

                                        Pendampingan atau Layanan Khusus

                                    </label>

                                    <textarea
                                        name="pendampingan"
                                        rows="3"
                                        placeholder="Tuliskan layanan pendampingan yang dibutuhkan..."
                                        class="w-full bg-slate-50
                                               border border-slate-200
                                               rounded-xl
                                               px-4 py-3
                                               text-sm text-slate-800
                                               placeholder-slate-400
                                               leading-relaxed
                                               focus:bg-white
                                               focus:border-[#1B4E71]
                                               focus:ring-2
                                               focus:ring-[#1B4E71]/10
                                               focus:outline-none
                                               transition-all
                                               resize-y">{{ old('pendampingan', $mahasiswa->pendampingan ?? '') }}</textarea>

                                </div>

                            </div>

                        </div>

                    </section>


                    {{-- =================================================
                         SUBMIT BAR
                    ================================================== --}}
                    <div class="bg-white rounded-2xl
                                border border-slate-200
                                shadow-sm
                                p-5 md:p-6
                                flex flex-col
                                sm:flex-row
                                sm:items-center
                                justify-between
                                gap-4">

                        <div class="flex items-start gap-3">

                            <div class="w-8 h-8 rounded-lg
                                        bg-slate-100
                                        flex items-center justify-center
                                        shrink-0">

                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="h-4 w-4 text-slate-500"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor">

                                    <path stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M13 16h-1v-4h-1m1-4h.01M12 20a8 8 0 100-16 8 8 0 000 16z" />

                                </svg>

                            </div>

                            <div>

                                <p class="text-sm font-semibold text-slate-700">
                                    Sudah selesai mengisi?
                                </p>

                                <p class="text-xs text-slate-400 mt-0.5">
                                    Pastikan data yang dimasukkan sudah benar.
                                </p>

                            </div>

                        </div>


                        <div class="flex flex-col-reverse
                                    sm:flex-row
                                    items-stretch
                                    sm:items-center
                                    gap-3">

                            <a
                                href="{{ route('mahasiswa.index') }}"
                                class="px-5 py-2.5 rounded-xl
                                       bg-white
                                       border border-slate-200
                                       text-slate-600
                                       text-sm font-semibold
                                       hover:bg-slate-50
                                       transition-all
                                       text-center">

                                Batal

                            </a>


                            <button
                                type="submit"
                                id="submitBtn"
                                class="bg-[#1B4E71]
                                       hover:bg-[#143B56]
                                       text-white
                                       text-sm font-semibold
                                       px-7 py-2.5
                                       rounded-xl
                                       shadow-sm
                                       hover:shadow-md
                                       transition-all duration-200
                                       cursor-pointer
                                       flex items-center
                                       justify-center gap-2">

                                <span>
                                    {{ $editing ? 'Simpan Perubahan' : 'Simpan Data' }}
                                </span>

                            </button>

                        </div>

                    </div>

                </form>

            </div>

        </div>

    </div>

</main>


<script>

document.addEventListener("DOMContentLoaded", function () {

    /* =========================================================
       AUTO FILL ANGKATAN DARI NIM
    ========================================================== */

    const nimInput = document.getElementById("nimInput");
    const angkatanInput = document.getElementById("angkatanInput");
    const tahunAsesmenInput = document.getElementById("tahunAsesmenInput");

    if (nimInput && angkatanInput) {

        function updateAngkatan() {

            const nimValue = nimInput.value;

            if (nimValue.length >= 2) {

                const awalanTahun = nimValue.substring(0, 2);

                if (
                    !isNaN(awalanTahun) &&
                    awalanTahun.trim() !== ''
                ) {

                    angkatanInput.value = "20" + awalanTahun;

                    if (
                        tahunAsesmenInput &&
                        (
                            !tahunAsesmenInput.value ||
                            tahunAsesmenInput.dataset.touched !== 'true'
                        )
                    ) {
                        tahunAsesmenInput.value = "20" + awalanTahun;
                    }

                } else {

                    angkatanInput.value = "";

                }

            } else {

                angkatanInput.value = "";

            }

        }


        nimInput.addEventListener(
            "input",
            updateAngkatan
        );

        updateAngkatan();

    }


    if (tahunAsesmenInput) {

        tahunAsesmenInput.addEventListener(
            "input",
            function () {

                this.dataset.touched = 'true';

            }
        );

    }


    /* =========================================================
       RAGAM & SUBRAGAM DISABILITAS
    ========================================================== */

    const ragamCheckboxes =
        document.querySelectorAll('.ragam-checkbox');

    const statusBox =
        document.getElementById('disabilitasStatusBox');

    const subragamSection =
        document.getElementById('subragamSection');


    function updateRagamAndSubragam() {

        const checked =
            Array.from(ragamCheckboxes)
                .filter(cb => cb.checked)
                .map(cb => cb.value);


        ragamCheckboxes.forEach(cb => {

            const label =
                cb.closest('.ragam-checkbox-label');

            if (!label) return;

            if (cb.checked) {

                label.classList.add(
                    'border-[#1B4E71]',
                    'bg-[#1B4E71]/5'
                );

                label.classList.remove(
                    'border-slate-200',
                    'bg-slate-50'
                );

            } else {

                label.classList.remove(
                    'border-[#1B4E71]',
                    'bg-[#1B4E71]/5'
                );

                label.classList.add(
                    'border-slate-200',
                    'bg-slate-50'
                );

            }

        });


        if (checked.length === 0) {

            if (statusBox) {
                statusBox.classList.add('hidden');
            }

            if (subragamSection) {
                subragamSection.classList.add('hidden');
            }

        } else if (checked.length === 1) {

            if (statusBox) {

                statusBox.className =
                    'mt-4 text-xs font-medium py-3 px-4 rounded-xl ' +
                    'bg-sky-50 border border-sky-200 text-sky-900 ' +
                    'flex items-center gap-2';

                statusBox.innerHTML =
                    '<span class="w-2 h-2 rounded-full bg-sky-500"></span>' +
                    'Ragam terpilih: ' +
                    '<strong>' + checked[0] + '</strong>';

            }

            if (subragamSection) {
                subragamSection.classList.remove('hidden');
            }

        } else {

            if (statusBox) {

                statusBox.className =
                    'mt-4 text-xs font-medium py-3 px-4 rounded-xl ' +
                    'bg-emerald-50 border border-emerald-200 text-emerald-900 ' +
                    'flex items-center gap-2';

                statusBox.innerHTML =
                    '<span class="w-2 h-2 rounded-full bg-emerald-500"></span>' +
                    'Terpilih ' + checked.length +
                    ' ragam (' + checked.join(', ') + '). ' +
                    '<strong>Otomatis diklasifikasikan sebagai Disabilitas Ganda.</strong>';

            }

            if (subragamSection) {
                subragamSection.classList.remove('hidden');
            }

        }


        ['Netra', 'Rungu', 'Mental', 'Fisik'].forEach(function (ragam) {

            const card =
                document.getElementById(
                    'subragam-card-' + ragam
                );

            if (!card) return;

            if (checked.includes(ragam)) {

                card.classList.remove('hidden');

            } else {

                card.classList.add('hidden');

            }

        });

    }


    ragamCheckboxes.forEach(function (checkbox) {

        checkbox.addEventListener(
            'change',
            updateRagamAndSubragam
        );

    });


    /* =========================================================
       CUSTOM SUBRAGAM
    ========================================================== */

    document
        .querySelectorAll('.subragam-select')
        .forEach(function (select) {

            select.addEventListener('change', function () {

                const card =
                    this.closest('.subragam-card');

                const wrapper =
                    card
                        ? card.querySelector(
                            '.subragam-custom-wrapper'
                        )
                        : null;

                const customInput =
                    wrapper
                        ? wrapper.querySelector(
                            '.subragam-custom-input'
                        )
                        : null;


                if (this.value === '__custom__') {

                    if (wrapper) {
                        wrapper.classList.remove('hidden');
                    }

                    if (customInput) {
                        customInput.focus();
                    }

                } else {

                    if (wrapper) {
                        wrapper.classList.add('hidden');
                    }

                    if (customInput) {
                        customInput.value = '';
                    }

                }

            });

        });


    updateRagamAndSubragam();


    /* =========================================================
       FILE INPUT
    ========================================================== */

    document
        .querySelectorAll('.document-input')
        .forEach(function (input) {

            input.addEventListener('change', function () {

                const container =
                    this.closest('.document-upload-box');

                const fileName =
                    container
                        ? container.querySelector('.file-name')
                        : null;

                if (!fileName) return;


                if (this.files.length) {

                    fileName.textContent =
                        this.files[0].name;

                    fileName.classList.remove(
                        'text-slate-400'
                    );

                    fileName.classList.add(
                        'text-[#1B4E71]',
                        'font-bold'
                    );

                } else {

                    fileName.textContent =
                        'Belum ada file';

                    fileName.classList.remove(
                        'text-[#1B4E71]',
                        'font-bold'
                    );

                    fileName.classList.add(
                        'text-slate-400'
                    );

                }

            });

        });


    /* =========================================================
       DYNAMIC STUDY PROGRAM
    ========================================================== */

    const facultySelect =
        document.getElementById('facultySelect');

    const studyProgramSelect =
        document.getElementById('studyProgramSelect');

    const selectedStudyProgramId =
        '{{ old('study_program_id', $mahasiswa->study_program_id ?? '') }}';


    if (facultySelect && studyProgramSelect) {

        async function loadStudyPrograms(facultyId) {

            const selectedFacultyId =
                String(facultyId || '').trim();


            if (!selectedFacultyId) {

                studyProgramSelect.innerHTML =
                    '<option value="">Pilih fakultas terlebih dahulu</option>';

                studyProgramSelect.disabled = true;

                return;

            }


            studyProgramSelect.disabled = true;

            studyProgramSelect.innerHTML =
                '<option value="">Memuat program studi...</option>';


            try {

                const url =
                    `${window.location.origin}/api/study-programs?faculty_id=${encodeURIComponent(selectedFacultyId)}`;


                const response =
                    await fetch(url, {

                        headers: {
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        },

                        credentials: 'same-origin'

                    });


                if (!response.ok) {

                    throw new Error(
                        `Server status ${response.status}`
                    );

                }


                const responseText =
                    await response.text();


                let programs = [];


                if (responseText) {

                    try {

                        programs =
                            JSON.parse(responseText);

                    } catch (error) {

                        throw new Error(
                            'Respons server bukan JSON'
                        );

                    }

                }


                studyProgramSelect.innerHTML =
                    '<option value="">Pilih Program Studi</option>';


                if (
                    !Array.isArray(programs) ||
                    programs.length === 0
                ) {

                    studyProgramSelect.innerHTML =
                        '<option value="">Fakultas ini belum memiliki program studi</option>';

                    studyProgramSelect.disabled = true;

                    return;

                }


                programs.forEach(function (program) {

                    const option =
                        document.createElement('option');

                    option.value =
                        program.id;

                    option.textContent =
                        program.name;


                    if (
                        String(program.id) ===
                        String(selectedStudyProgramId)
                    ) {

                        option.selected = true;

                    }


                    studyProgramSelect.appendChild(option);

                });


                studyProgramSelect.disabled = false;


            } catch (error) {

                console.error(
                    'Gagal memuat program studi:',
                    error
                );

                studyProgramSelect.innerHTML =
                    '<option value="">Data program studi tidak tersedia</option>';

                studyProgramSelect.disabled = true;

            }

        }


        facultySelect.addEventListener(
            'change',
            function () {

                loadStudyPrograms(this.value);

            }
        );


        const initialFacultyId =
            String(facultySelect.value || '').trim();


        if (initialFacultyId) {

            loadStudyPrograms(initialFacultyId);

        }

    }


    /* =========================================================
       SUBMIT BUTTON
    ========================================================== */

    const formElement =
        document.querySelector("form");

    if (formElement) {

        formElement.addEventListener(
            "submit",
            function () {

                const btn =
                    document.getElementById("submitBtn");

                if (!btn) return;


                btn.disabled = true;

                btn.innerHTML = `
                    <svg
                        class="animate-spin h-4 w-4 text-white"
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24">

                        <circle
                            class="opacity-25"
                            cx="12"
                            cy="12"
                            r="10"
                            stroke="currentColor"
                            stroke-width="4">
                        </circle>

                        <path
                            class="opacity-75"
                            fill="currentColor"
                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                        </path>

                    </svg>

                    <span>Menyimpan...</span>
                `;

                btn.classList.add(
                    "opacity-70",
                    "cursor-not-allowed"
                );

            }
        );

    }

});

</script>

@endsection