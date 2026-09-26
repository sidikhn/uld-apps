@extends('layout.sideBar')

@section('title', 'Dashboard | Mahasiswa Disabilitas')

@section('content')

<main class="flex-1 bg-slate-50 flex flex-col min-h-screen font-sans text-slate-700">

{{-- =========================================================
     HEADER
========================================================== --}}
<div class="flex items-center justify-between w-full
            bg-gradient-to-r from-[#1B4E71] to-[#25638a]
            text-white px-6 md:px-8 py-4
            shadow-md z-10">

    <div class="flex items-center gap-3 min-w-0">

        <div class="p-2 bg-white/10 rounded-xl shrink-0">

            <svg xmlns="http://www.w3.org/2000/svg"
                 class="h-6 w-6"
                 fill="none"
                 viewBox="0 0 24 24"
                 stroke="currentColor"
                 stroke-width="2">

                <ellipse cx="12" cy="5" rx="9" ry="3"/>
                <path d="M3 5v14c0 1.66 4.03 3 9 3s9-1.34 9-3V5"/>
                <path d="M3 12c0 1.66 4.03 3 9 3s9-1.34 9-3"/>

            </svg>

        </div>

        <div class="min-w-0">

            <span class="block font-semibold text-xl sm:text-2xl tracking-wide truncate">
                Data Mahasiswa
            </span>

            <span class="hidden sm:block text-xs text-white/70 mt-0.5">
                Kelola data mahasiswa disabilitas
            </span>

        </div>

    </div>


    <a href="https://wa.me/6282227021332"
       target="_blank"
       rel="noopener noreferrer"
       class="flex items-center gap-2
              bg-white/10 hover:bg-white/20
              px-4 py-2 rounded-xl
              transition-all duration-300
              text-sm font-medium
              shrink-0">

        <svg xmlns="http://www.w3.org/2000/svg"
             class="h-5 w-5"
             fill="none"
             viewBox="0 0 24 24"
             stroke="currentColor"
             stroke-width="2">

            <path stroke-linecap="round"
                  stroke-linejoin="round"
                  d="M3 21l1.2-4.2A8.959 8.959 0 015 4a8.959 8.959 0 0112.728 12.728A8.959 8.959 0 018.8 19.8L4.2 21z"/>

        </svg>

        <span class="hidden sm:inline">
            Hubungi Kami
        </span>

    </a>

</div>


{{-- =========================================================
     CONTENT
========================================================== --}}
<div class="flex-1 overflow-y-auto">

    {{-- SATU CONTAINER UNTUK SEMUA KOMPONEN --}}
    <div class="px-5 md:px-6 lg:px-8 py-6">


        {{-- =====================================================
             SUCCESS ALERT
        ====================================================== --}}
        @if(session('success'))

            <div class="bg-emerald-50
                        text-emerald-800
                        px-4 py-3
                        rounded-xl
                        flex items-center gap-3
                        mb-5">

                <svg xmlns="http://www.w3.org/2000/svg"
                     class="h-5 w-5 text-emerald-500 shrink-0"
                     viewBox="0 0 20 20"
                     fill="currentColor">

                    <path fill-rule="evenodd"
                          d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                          clip-rule="evenodd"/>

                </svg>

                <span class="text-sm font-medium">
                    {{ session('success') }}
                </span>

            </div>

        @endif




{{-- =========================================================
     TOOLBAR SECTION (MAHASISWA)
========================================================== --}}
<div class="w-full mb-5"> 
    <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm flex flex-wrap items-center justify-between gap-4">
        {{-- =====================================================
             SISI KIRI: SEARCH & FILTER FAKULTAS
        ====================================================== --}}
        <div class="flex items-center gap-3 flex-1 min-w-[320px]">

            {{-- Search Input --}}
            <div class="relative flex-1 min-w-[200px]">

                <div class="absolute inset-y-0 left-0 pl-3.5
                            flex items-center pointer-events-none
                            text-slate-400">

                    <svg xmlns="http://www.w3.org/2000/svg"
                         class="h-4 w-4"
                         fill="none"
                         viewBox="0 0 24 24"
                         stroke="currentColor">

                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M21 21l-4.35-4.35M11 18a7 7 0 100-14 7 7 0 000 14z"
                        />

                    </svg>
                </div>

                <input
                    id="searchMahasiswa"
                    type="text"
                    placeholder="Cari mahasiswa...."
                    class="w-full pl-10 pr-4 py-2
                           bg-slate-50
                           hover:bg-slate-100
                           focus:bg-white
                           text-slate-700
                           placeholder-slate-400
                           rounded-lg
                           border border-slate-200
                           focus:ring-2
                           focus:ring-[#1B4E71]
                           focus:border-[#1B4E71]
                           outline-none
                           text-sm
                           font-medium
                           transition-all"
                />

            </div>


            {{-- =================================================
                 DROPDOWN FILTER FAKULTAS
            ================================================== --}}
            <div class="relative w-48 shrink-0">

                {{-- Filter Icon --}}
                <div class="absolute inset-y-0 left-0 pl-3.5
                            flex items-center pointer-events-none
                            text-slate-400 z-10">

                    <svg xmlns="http://www.w3.org/2000/svg"
                         class="h-4 w-4"
                         fill="none"
                         viewBox="0 0 24 24"
                         stroke="currentColor"
                         stroke-width="2">

                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M4 6h16M4 12h16M4 18h7"
                        />

                    </svg>
                </div>


                <select
                    id="filterMahasiswa"
                    class="w-full pl-10 pr-8 py-2
                           bg-slate-50
                           hover:bg-slate-100
                           focus:bg-white
                           text-slate-700
                           font-medium
                           text-sm
                           rounded-lg
                           border border-slate-200
                           focus:ring-2
                           focus:ring-[#1B4E71]
                           focus:border-[#1B4E71]
                           outline-none
                           cursor-pointer
                           transition-all"
                >

                    <option value="">Semua Fakultas</option>

                    @foreach(
                        $mahasiswas
                            ->map(fn($mhs) => $mhs->faculty?->name ?? $mhs->fakultas)
                            ->filter()
                            ->unique()
                            ->sort()
                        as $fakultas
                    )

                        <option value="{{ strtolower(trim($fakultas)) }}">
                            {{ $fakultas }}
                        </option>

                    @endforeach

                </select>

            </div>

        </div>


        {{-- =====================================================
             SISI KANAN: ACTION BUTTONS
        ====================================================== --}}
        <div class="flex items-center gap-2 shrink-0">

            @if(auth()->user()->role === 'superadmin')

                {{-- =================================================
                     TOMBOL EDIT DATA
                ================================================== --}}
                <a
                    id="edit-btn"
                    href="#"
                    class="hidden items-center gap-1.5
                           text-emerald-700
                           font-semibold
                           bg-emerald-50
                           hover:bg-emerald-100
                           border border-emerald-200
                           rounded-lg
                           px-3.5 py-2
                           transition-all"
                >

                    <svg xmlns="http://www.w3.org/2000/svg"
                         class="h-4 w-4"
                         fill="none"
                         viewBox="0 0 24 24"
                         stroke="currentColor"
                         stroke-width="2">

                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"
                        />

                    </svg>

                    <span>Edit Data</span>

                </a>


                {{-- =================================================
                     TOMBOL HAPUS DATA
                ================================================== --}}
                <form
                    id="delete-form"
                    action="{{ route('mahasiswa.bulkDelete') }}"
                    method="POST"
                    class="hidden m-0"
                >

                    @csrf
                    @method('DELETE')

                    <input
                        type="hidden"
                        name="ids"
                        id="delete-ids"
                    >

                    <button
                        type="submit"
                        class="flex items-center gap-1.5
                               text-rose-700
                               font-semibold
                               bg-rose-50
                               hover:bg-rose-100
                               border border-rose-200
                               rounded-lg
                               px-3.5 py-2
                               transition-all"
                        onclick="return confirm('Apakah Anda yakin ingin menghapus data mahasiswa yang dipilih?')"
                    >

                        <svg xmlns="http://www.w3.org/2000/svg"
                             class="h-4 w-4"
                             fill="none"
                             viewBox="0 0 24 24"
                             stroke="currentColor"
                             stroke-width="2">

                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3m-4 0h14"
                            />

                        </svg>

                        <span>Hapus Data</span>

                    </button>

                </form>


                {{-- =================================================
                     TOMBOL JADIKAN ALUMNI
                ================================================== --}}
                <form
                    id="alumni-form"
                    action="{{ route('mahasiswa.jadikanAlumni') }}"
                    method="POST"
                    class="hidden m-0"
                >

                    @csrf

                    <input
                        type="hidden"
                        name="ids"
                        id="alumni-ids"
                    >

                    <button
                        type="submit"
                        class="flex items-center gap-1.5
                               text-amber-700
                               font-semibold
                               bg-amber-50
                               hover:bg-amber-100
                               border border-amber-200
                               rounded-lg
                               px-3.5 py-2
                               transition-all"
                        onclick="return confirm('Apakah Anda yakin ingin menjadikan mahasiswa yang dipilih sebagai alumni?')"
                    >

                        <svg xmlns="http://www.w3.org/2000/svg"
                             class="h-4 w-4"
                             fill="none"
                             viewBox="0 0 24 24"
                             stroke="currentColor"
                             stroke-width="2">

                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M12 14a4 4 0 1 0 0-8 4 4 0 0 0 0 8Zm7 7a7 7 0 0 0-14 0"
                            />

                        </svg>

                        <span>Jadikan Alumni</span>

                    </button>

                </form>


                {{-- =================================================
                     TOMBOL TAMBAH DATA
                ================================================== --}}
                <a
                    href="{{ route('mahasiswa.create') }}"
                    class="flex items-center gap-1.5
                           bg-[#1B4E71]
                           hover:bg-[#143a54]
                           text-white
                           font-medium
                           rounded-lg
                           px-4 py-2
                           transition-all
                           shrink-0"
                >

                    <svg xmlns="http://www.w3.org/2000/svg"
                         class="h-4 w-4"
                         fill="none"
                         viewBox="0 0 24 24"
                         stroke="currentColor"
                         stroke-width="2">

                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M12 4v16m8-8H4"
                        />

                    </svg>

                    <span>Tambah Data</span>

                </a>

            @endif

        </div>

    </div>
</div>








        {{-- =====================================================
             TABLE
        ====================================================== --}}
        <div class="bg-white
                    rounded-2xl
                    shadow-sm
                    overflow-hidden
                    mb-8">


            {{-- Table --}}
            <div class="overflow-x-auto">

                <table id="mahasiswaTable"
                       class="w-full min-w-[1200px]
                              text-left
                              border-collapse
                              whitespace-nowrap">

                    <thead>

                        <tr class="bg-slate-50
                                   text-slate-500
                                   text-xs
                                   uppercase
                                   tracking-wider
                                   font-semibold">

                            @if(auth()->user()->role === 'superadmin')

                                <th class="py-4 px-4 text-center w-12">

                                    <input type="checkbox"
                                           id="select-all"
                                           class="w-4 h-4
                                                  text-[#1B4E71]
                                                  bg-white
                                                  border-slate-300
                                                  rounded
                                                  focus:ring-[#1B4E71]
                                                  focus:ring-2
                                                  cursor-pointer">

                                </th>

                            @endif

                            <th class="py-4 px-4 text-center w-14">
                                No.
                            </th>

                            <th class="py-4 px-4 min-w-[190px]">
                                Nama
                            </th>

                            <th class="py-4 px-4 min-w-[190px]">
                                Fakultas
                            </th>

                            <th class="py-4 px-4 min-w-[210px]">
                                Program Studi
                            </th>

                            <th class="py-4 px-4 min-w-[120px]">
                                Pendidikan
                            </th>

                            <th class="py-4 px-4 min-w-[100px] text-center">
                                Angkatan
                            </th>

                            <th class="py-4 px-4 min-w-[125px] text-center">
                                Tahun Asesmen
                            </th>

                            <th class="py-4 px-4 min-w-[240px]">
                                Jenis Disabilitas
                            </th>

                            <th class="py-4 px-4 min-w-[135px] text-center">
                                Surat Asesmen
                            </th>

                            <th class="py-4 px-4 min-w-[100px] text-center">
                                Aksi
                            </th>

                        </tr>

                    </thead>


                    <tbody id="tableMahasiswa"
                           class="text-sm text-slate-700">

                        @foreach($mahasiswas as $mhs)

                            <tr class="
                                odd:bg-white
                                even:bg-slate-100/60
                                hover:bg-sky-50
                                transition-colors duration-150
                            ">

                                {{-- Checkbox --}}
                                @if(auth()->user()->role === 'superadmin')

                                    <td class="py-3 px-4 text-center">

                                        <input type="checkbox"
                                               class="select-mahasiswa
                                                      w-4 h-4
                                                      text-[#1B4E71]
                                                      bg-white
                                                      border-slate-300
                                                      rounded
                                                      focus:ring-[#1B4E71]
                                                      focus:ring-2
                                                      cursor-pointer"
                                               value="{{ $mhs->id }}">

                                    </td>

                                @endif


                                {{-- Number --}}
                                <td class="py-3 px-4 text-center">

                                    <span class="text-xs text-slate-400 font-medium">
                                        {{ $loop->iteration }}
                                    </span>

                                </td>


                                {{-- Name --}}
                                <td class="py-3 px-4 font-medium text-slate-800">

                                    <span class="block max-w-[190px] truncate"
                                          title="{{ $mhs->nama }}">

                                        {{ $mhs->nama }}

                                    </span>

                                </td>


                                {{-- Faculty --}}
                                <td class="py-3 px-4">

                                    {{ $mhs->faculty?->name ?? $mhs->fakultas ?? '-' }}

                                </td>


                                {{-- Study Program --}}
                                <td class="py-3 px-4">

                                    {{ $mhs->studyProgram?->name ?? $mhs->prodi ?? '-' }}

                                </td>


                                {{-- Education --}}
                                <td class="py-3 px-4">

                                    {{ $mhs->pendidikan ?? '-' }}

                                </td>


                                {{-- Angkatan --}}
                                <td class="py-3 px-4 text-center">

                                    {{ $mhs->angkatan ?? '-' }}

                                </td>


                                {{-- Assessment Year --}}
                                <td class="py-3 px-4 text-center">

                                    <span class="inline-flex
                                                 rounded-full
                                                 bg-sky-100
                                                 px-3 py-1
                                                 text-xs
                                                 font-semibold
                                                 text-sky-700">

                                        {{ $mhs->tahun_asesmen ?? '-' }}

                                    </span>

                                </td>


                                {{-- Disability --}}
                                <td class="py-3 px-4">

                                    @php

                                        $ragamList =
                                            (array) ($mhs->ragam_disabilitas ?? []);

                                        $ragamStr =
                                            implode(', ', $ragamList);

                                        $subragamStr =
                                            $mhs->subragam_formatted ?? '-';

                                    @endphp

                                    <div>

                                        <div class="font-medium text-slate-700">

                                            {{ $ragamStr ?: '-' }}

                                            @if(
                                                !empty($mhs->ragam_pilihan) &&
                                                count((array) $mhs->ragam_pilihan) > 1
                                            )

                                                <span class="text-xs font-normal text-slate-400">

                                                    ({{ implode(', ', (array) $mhs->ragam_pilihan) }})

                                                </span>

                                            @endif

                                        </div>


                                        @if($subragamStr && $subragamStr !== '-')

                                            <div class="text-xs
                                                        text-[#1B4E71]
                                                        font-medium
                                                        max-w-[240px]
                                                        truncate"
                                                 title="{{ $subragamStr }}">

                                                Sub: {{ $subragamStr }}

                                            </div>

                                        @endif

                                    </div>

                                </td>


                                {{-- PDF --}}
                                <td class="py-3 px-4 text-center">

                                    <a href="{{ route('mahasiswa.pdf', $mhs->id) }}"
                                       class="inline-flex
                                              items-center
                                              justify-center
                                              gap-1.5
                                              bg-teal-50
                                              text-teal-700
                                              hover:bg-teal-600
                                              hover:text-white
                                              rounded-lg
                                              px-3 py-2
                                              text-xs
                                              font-semibold
                                              transition-all">

                                        <svg xmlns="http://www.w3.org/2000/svg"
                                             class="h-4 w-4"
                                             fill="none"
                                             viewBox="0 0 24 24"
                                             stroke="currentColor">

                                            <path stroke-linecap="round"
                                                  stroke-linejoin="round"
                                                  stroke-width="2"
                                                  d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1
                                                     m-4-4l-4 4
                                                     m0 0l-4-4
                                                     m4 4V4"/>

                                        </svg>

                                        <span>
                                            Unduh PDF
                                        </span>

                                    </a>

                                </td>


                                {{-- Action --}}
                                <td class="py-3 px-4 text-center">

                                    <a href="{{ route('mahasiswa.show', $mhs->id) }}"
                                       class="inline-flex
                                              items-center
                                              justify-center
                                              gap-1.5
                                              bg-blue-50
                                              text-blue-700
                                              hover:bg-[#1B4E71]
                                              hover:text-white
                                              rounded-lg
                                              px-3 py-2
                                              text-xs
                                              font-semibold
                                              transition-all">

                                        <svg xmlns="http://www.w3.org/2000/svg"
                                             class="h-4 w-4"
                                             fill="none"
                                             viewBox="0 0 24 24"
                                             stroke="currentColor">

                                            <path stroke-linecap="round"
                                                  stroke-linejoin="round"
                                                  stroke-width="2"
                                                  d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>

                                            <path stroke-linecap="round"
                                                  stroke-linejoin="round"
                                                  stroke-width="2"
                                                  d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>

                                        </svg>

                                        <span>
                                            Detail
                                        </span>

                                    </a>

                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>


            {{-- Empty State --}}
            @if($mahasiswas->isEmpty())

                <div class="px-6 py-14 text-center">

                    <div class="w-14 h-14 mx-auto
                                rounded-2xl
                                bg-slate-100
                                flex items-center justify-center">

                        <svg xmlns="http://www.w3.org/2000/svg"
                             class="w-7 h-7 text-slate-400"
                             fill="none"
                             viewBox="0 0 24 24"
                             stroke="currentColor"
                             stroke-width="1.5">

                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>

                        </svg>

                    </div>

                    <h3 class="mt-4 text-base font-semibold text-slate-700">
                        Belum ada data mahasiswa
                    </h3>

                    <p class="mt-1 text-sm text-slate-400">
                        Silakan tambahkan data baru melalui tombol Tambah Data.
                    </p>

                </div>

            @endif

        </div>


        {{-- =====================================================
             PAGINATION
        ====================================================== --}}
        @if(!$mahasiswas->isEmpty())

            <div class="bg-white
                        rounded-xl
                        shadow-sm
                        px-4 sm:px-5 py-4
                        flex flex-col md:flex-row
                        md:items-center
                        md:justify-between
                        gap-4">

                <div class="flex flex-wrap
                            items-center
                            gap-3
                            text-xs sm:text-sm
                            text-slate-400">

                    <div class="relative">

                        <select id="perPageSelect"
                                class="h-9
                                       pl-3 pr-8
                                       bg-slate-50
                                       rounded-lg
                                       text-xs sm:text-sm
                                       font-semibold
                                       text-slate-600
                                       appearance-none
                                       cursor-pointer
                                       outline-none
                                       focus:ring-2
                                       focus:ring-[#1B4E71]/20">

                            <option value="10">10 Baris</option>
                            <option value="50">50 Baris</option>
                            <option value="100">100 Baris</option>
                            <option value="all">Semua Data</option>

                        </select>

                        <svg xmlns="http://www.w3.org/2000/svg"
                             class="absolute right-2.5 top-1/2
                                    -translate-y-1/2
                                    w-3.5 h-3.5
                                    text-slate-400
                                    pointer-events-none"
                             fill="none"
                             viewBox="0 0 24 24"
                             stroke="currentColor">

                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  stroke-width="1.8"
                                  d="M6 9l6 6 6-6"/>

                        </svg>

                    </div>


                    <span>

                        Menampilkan

                        <strong id="showingStart"
                                class="text-slate-700">
                            0
                        </strong>

                        -

                        <strong id="showingEnd"
                                class="text-slate-700">
                            0
                        </strong>

                        dari

                        <strong id="totalEntries"
                                class="text-slate-700">
                            0
                        </strong>

                        data

                    </span>

                </div>


                <div id="paginationButtons"
                     class="flex items-center
                            justify-start
                            md:justify-end
                            gap-1">
                </div>

            </div>

        @endif

    </div>

</div>

</main>


{{-- =============================================================
     JAVASCRIPT
============================================================= --}}
<script>

document.addEventListener("DOMContentLoaded", function () {

    const alumniForm = document.getElementById("alumni-form");
    const alumniIds = document.getElementById("alumni-ids");

    const selectAll = document.getElementById("select-all");

    const editBtn = document.getElementById("edit-btn");

    const deleteForm = document.getElementById("delete-form");
    const deleteIds = document.getElementById("delete-ids");


    function getCheckboxes() {

        return Array.from(
            document.querySelectorAll(".select-mahasiswa")
        );

    }


    function updateSelection() {

        const checkboxes = getCheckboxes();

        const selected = checkboxes.filter(
            checkbox => checkbox.checked
        );


        if (selectAll) {

            selectAll.checked =
                checkboxes.length > 0 &&
                selected.length === checkboxes.length;

            selectAll.indeterminate =
                selected.length > 0 &&
                selected.length < checkboxes.length;

        }


        if (editBtn) {

            if (selected.length === 1) {

                editBtn.classList.remove("hidden");
                editBtn.classList.add("inline-flex");

                editBtn.href =
                    "/mahasiswa/" +
                    selected[0].value +
                    "/edit";

            } else {

                editBtn.classList.add("hidden");
                editBtn.classList.remove("inline-flex");

                editBtn.href = "#";

            }

        }


        if (selected.length > 0) {

            if (deleteForm) {

                deleteForm.classList.remove("hidden");

                deleteIds.value =
                    selected
                        .map(checkbox => checkbox.value)
                        .join(",");

            }


            if (alumniForm) {

                alumniForm.classList.remove("hidden");

                alumniIds.value =
                    selected
                        .map(checkbox => checkbox.value)
                        .join(",");

            }

        } else {

            if (deleteForm) {

                deleteForm.classList.add("hidden");

                deleteIds.value = "";

            }


            if (alumniForm) {

                alumniForm.classList.add("hidden");

                alumniIds.value = "";

            }

        }

    }


    document
        .querySelectorAll(".select-mahasiswa")
        .forEach(function (checkbox) {

            checkbox.addEventListener(
                "change",
                updateSelection
            );

        });


    if (selectAll) {

        selectAll.addEventListener(
            "change",
            function () {

                getCheckboxes().forEach(
                    checkbox => {
                        checkbox.checked = this.checked;
                    }
                );

                updateSelection();

            }
        );

    }

});


/* =============================================================
   TABLE FILTER + PAGINATION
============================================================= */

let currentPage = 1;


function applyTableFilter() {

    const searchInput =
        document.getElementById("searchMahasiswa");

    const filterSelect =
        document.getElementById("filterMahasiswa");

    const perPageSelect =
        document.getElementById("perPageSelect");


    const keyword =
        (searchInput?.value || "")
            .trim()
            .toLowerCase();


    const facultyFilter =
        (filterSelect?.value || "all")
            .trim()
            .toLowerCase();


    const perPageVal =
        perPageSelect?.value || "10";


    const rows = Array.from(
        document.querySelectorAll("#tableMahasiswa tr")
    );


    const isSuperadmin =
        !!document.getElementById("select-all");


    const facultyColumnIndex =
        isSuperadmin ? 3 : 2;


    const filteredRows =
        rows.filter(function (row) {

            const text =
                row.textContent.toLowerCase();


            const faculty =
                row.children[facultyColumnIndex]
                    ?.textContent
                    ?.trim()
                    .toLowerCase() || "";


            const matchesSearch =
                text.includes(keyword);


            const matchesFaculty =
                facultyFilter === "all" ||
                faculty === facultyFilter;


            return matchesSearch && matchesFaculty;

        });


    rows.forEach(function (row) {

        row.style.display = "none";

    });


    const totalEntries =
        filteredRows.length;


    const perPage =
        perPageVal === "all"
            ? totalEntries
            : parseInt(perPageVal);


    const totalPages =
        Math.ceil(
            totalEntries / (perPage || 1)
        ) || 1;


    if (currentPage > totalPages) {
        currentPage = totalPages;
    }


    if (currentPage < 1) {
        currentPage = 1;
    }


    const startIdx =
        (currentPage - 1) *
        (perPage || 1);


    const endIdx =
        perPageVal === "all"
            ? totalEntries
            : Math.min(
                startIdx + perPage,
                totalEntries
            );


    filteredRows
        .slice(startIdx, endIdx)
        .forEach(function (row) {

            row.style.display = "";

        });


    const showingStartEl =
        document.getElementById("showingStart");

    const showingEndEl =
        document.getElementById("showingEnd");

    const totalEntriesEl =
        document.getElementById("totalEntries");

    const tableTotalLabel =
        document.getElementById("tableTotalLabel");


    if (showingStartEl) {

        showingStartEl.textContent =
            totalEntries === 0
                ? 0
                : startIdx + 1;

    }


    if (showingEndEl) {
        showingEndEl.textContent = endIdx;
    }


    if (totalEntriesEl) {
        totalEntriesEl.textContent = totalEntries;
    }


    if (tableTotalLabel) {
        tableTotalLabel.textContent = totalEntries;
    }


    renderPaginationControls(totalPages);

}


/* =============================================================
   PAGINATION
============================================================= */

function renderPaginationControls(totalPages) {

    const container =
        document.getElementById(
            "paginationButtons"
        );


    if (!container) return;


    container.innerHTML = "";


    if (totalPages <= 1) return;


    const prevBtn =
        document.createElement("button");


    prevBtn.type = "button";


    prevBtn.setAttribute(
        "aria-label",
        "Halaman sebelumnya"
    );


    prevBtn.className =
        "w-9 h-9 flex items-center justify-center " +
        "rounded-lg text-slate-500 " +
        "transition-all duration-200 " +
        (
            currentPage === 1
                ? "bg-slate-50 text-slate-300 cursor-not-allowed"
                : "bg-white hover:bg-slate-50 hover:text-[#1B4E71]"
        );


    prevBtn.innerHTML = `
        <svg xmlns="http://www.w3.org/2000/svg"
             class="w-4 h-4"
             fill="none"
             viewBox="0 0 24 24"
             stroke="currentColor"
             stroke-width="1.8">

            <path stroke-linecap="round"
                  stroke-linejoin="round"
                  d="M15 19l-7-7 7-7"/>

        </svg>
    `;


    prevBtn.disabled =
        currentPage === 1;


    prevBtn.addEventListener(
        "click",
        function () {

            if (currentPage > 1) {

                currentPage--;

                applyTableFilter();

            }

        }
    );


    container.appendChild(prevBtn);


    const maxVisiblePages = 5;


    let startPage =
        Math.max(
            1,
            currentPage -
            Math.floor(maxVisiblePages / 2)
        );


    let endPage =
        Math.min(
            totalPages,
            startPage +
            maxVisiblePages -
            1
        );


    if (
        endPage -
        startPage +
        1 <
        maxVisiblePages
    ) {

        startPage =
            Math.max(
                1,
                endPage -
                maxVisiblePages +
                1
            );

    }


    for (
        let i = startPage;
        i <= endPage;
        i++
    ) {

        const pageBtn =
            document.createElement("button");


        pageBtn.type = "button";


        pageBtn.textContent = i;


        pageBtn.className =
            "min-w-9 h-9 px-2 " +
            "flex items-center justify-center " +
            "rounded-lg " +
            "text-xs sm:text-sm " +
            "font-semibold " +
            "transition-all duration-200 " +
            (
                i === currentPage
                    ? "bg-[#1B4E71] text-white shadow-sm"
                    : "bg-white text-slate-500 hover:bg-slate-50 hover:text-[#1B4E71]"
            );


        pageBtn.addEventListener(
            "click",
            function () {

                currentPage = i;

                applyTableFilter();

            }
        );


        container.appendChild(pageBtn);

    }


    const nextBtn =
        document.createElement("button");


    nextBtn.type = "button";


    nextBtn.setAttribute(
        "aria-label",
        "Halaman berikutnya"
    );


    nextBtn.className =
        "w-9 h-9 flex items-center justify-center " +
        "rounded-lg text-slate-500 " +
        "transition-all duration-200 " +
        (
            currentPage === totalPages
                ? "bg-slate-50 text-slate-300 cursor-not-allowed"
                : "bg-white hover:bg-slate-50 hover:text-[#1B4E71]"
        );


    nextBtn.innerHTML = `
        <svg xmlns="http://www.w3.org/2000/svg"
             class="w-4 h-4"
             fill="none"
             viewBox="0 0 24 24"
             stroke="currentColor"
             stroke-width="1.8">

            <path stroke-linecap="round"
                  stroke-linejoin="round"
                  d="M9 5l7 7-7 7"/>

        </svg>
    `;


    nextBtn.disabled =
        currentPage === totalPages;


    nextBtn.addEventListener(
        "click",
        function () {

            if (currentPage < totalPages) {

                currentPage++;

                applyTableFilter();

            }

        }
    );


    container.appendChild(nextBtn);

}


/* =============================================================
   SEARCH / FILTER / PER PAGE
============================================================= */

document.addEventListener(
    "DOMContentLoaded",
    function () {

        const searchInput =
            document.getElementById(
                "searchMahasiswa"
            );


        const filterSelect =
            document.getElementById(
                "filterMahasiswa"
            );


        const perPageSelect =
            document.getElementById(
                "perPageSelect"
            );


        if (searchInput) {

            searchInput.addEventListener(
                "input",
                function () {

                    currentPage = 1;

                    applyTableFilter();

                }
            );

        }


        if (filterSelect) {

            filterSelect.addEventListener(
                "change",
                function () {

                    currentPage = 1;

                    applyTableFilter();

                }
            );

        }


        if (perPageSelect) {

            perPageSelect.addEventListener(
                "change",
                function () {

                    currentPage = 1;

                    applyTableFilter();

                }
            );

        }


        applyTableFilter();

    }
);

</script>

@endsection

