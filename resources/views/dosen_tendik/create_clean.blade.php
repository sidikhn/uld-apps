@extends('layout.sideBar')

@section('title', 'Tambah Data Dosen dan Tendik')

@section('content')
<main class="flex-1 min-h-0 bg-gray-100 flex flex-col">
    <div class="flex justify-between w-full items-center space-x-3 bg-[#1B4E71] text-white px-6 py-2 h-18">
        <div class="flex items-center space-x-3"><span class="font-medium text-2xl">Data Dosen dan Tendik</span></div>
        <a href="https://wa.me/6282227021332" target="_blank" class="flex items-center space-x-1 hover:text-gray-200 transition">Hubungi Kami</a>
    </div>
    <div class="flex-1 min-h-0 overflow-y-auto bg-gray-100 p-6">
        <div class="max-w-5xl mx-auto bg-white rounded-xl shadow p-6">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-2xl font-semibold text-[#083D62]">Identitas Utama</h2>
                <a href="{{ route('tendik.index') }}" class="flex items-center space-x-1 text-gray-700 cursor-pointer bg-gray-200 hover:bg-gray-300 p-2 rounded transition">Kembali</a>
            </div>
            @include('dosen_tendik._form', ['action' => route('tendik.store'), 'method' => 'POST', 'tendik' => null])
        </div>
    </div>
</main>
@endsection
