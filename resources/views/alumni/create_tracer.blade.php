@extends('layout.sideBar')

@section('title', 'Tambah Data Alumni')

@section('content')
<main class="flex-1 min-h-0 bg-gray-100 flex flex-col">
    <div class="flex justify-between w-full items-center bg-[#1B4E71] text-white px-6 py-2 h-18">
        <span class="font-medium text-2xl">Data Alumni</span>
        <a href="https://wa.me/6282227021332" target="_blank" class="hover:text-gray-200">Hubungi Kami</a>
    </div>
    <div class="flex-1 min-h-0 overflow-y-auto bg-gray-100 p-6">
        <div class="max-w-5xl mx-auto bg-white rounded-xl shadow p-6">
            <div class="flex items-center justify-between mb-6"><h1 class="text-2xl font-semibold text-[#083D62]">Tambah Data Alumni</h1><a href="{{ route('alumni.index') }}" class="px-4 py-2 rounded-lg bg-gray-200 text-gray-700 hover:bg-gray-300">Kembali</a></div>
            @include('alumni._tracer_form', ['action' => route('alumni.store'), 'method' => 'POST', 'alumni' => null])
        </div>
    </div>
</main>
@endsection
