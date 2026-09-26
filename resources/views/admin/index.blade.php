@extends('layout.sideBar')

@section('title', 'Kelola Admin | ULD UGM')

@section('content')
<main class="flex-1 min-h-0 overflow-y-auto bg-slate-50 font-sans">
    <header class="flex flex-wrap items-center justify-between gap-4 bg-[#1B4E71] px-6 py-4 text-white shadow-sm md:px-8">
        <div class="flex items-center gap-3">
            <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-white/10">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path stroke-linecap="round" d="M19 8v6m3-3h-6"/></svg>
            </span>
            <div>
                <h1 class="text-xl font-bold tracking-wide">Kelola Admin</h1>
                <p class="text-sm text-sky-100">Buat akun dengan akses lihat data saja.</p>
            </div>
        </div>
    </header>

    <div class="mx-auto grid max-w-7xl gap-6 p-6 md:grid-cols-[minmax(0,1fr)_22rem] md:p-8">
        <section class="order-2 overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm md:order-1">
            <div class="flex items-center justify-between border-b border-slate-100 px-6 py-5">
                <div>
                    <h2 class="font-bold text-slate-800">Daftar akun admin</h2>
                    <p class="mt-1 text-sm text-slate-500">{{ $admins->count() }} akun dengan akses view-only</p>
                </div>
                <span class="rounded-full bg-indigo-50 px-3 py-1 text-xs font-bold text-indigo-700">Admin (View)</span>
            </div>

            @if(session('success'))
                <div class="mx-6 mt-5 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-800">{{ session('success') }}</div>
            @endif

            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="border-y border-slate-100 bg-slate-50 text-xs uppercase tracking-wide text-slate-500">
                        <tr>
                            <th class="px-6 py-3 font-semibold">Nama</th>
                            <th class="px-6 py-3 font-semibold">Email</th>
                            <th class="px-6 py-3 font-semibold">Akses</th>
                            <th class="px-6 py-3 font-semibold">Dibuat</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-slate-700">
                        @forelse($admins as $admin)
                            <tr class="transition hover:bg-slate-50">
                                <td class="px-6 py-4 font-semibold text-slate-800">{{ $admin->name }}</td>
                                <td class="px-6 py-4">{{ $admin->email }}</td>
                                <td class="px-6 py-4"><span class="rounded-md bg-indigo-50 px-2.5 py-1 text-xs font-semibold text-indigo-700">View only</span></td>
                                <td class="px-6 py-4 text-slate-500">{{ $admin->created_at?->format('d M Y') }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="px-6 py-12 text-center text-slate-500">Belum ada akun admin.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>

        <aside class="order-1 rounded-2xl border border-slate-200 bg-white p-6 shadow-sm md:order-2">
            <div class="mb-6">
                <span class="inline-flex rounded-xl bg-indigo-50 p-2 text-indigo-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                </span>
                <h2 class="mt-3 font-bold text-slate-800">Tambah admin</h2>
                <p class="mt-1 text-sm leading-5 text-slate-500">Akun baru otomatis hanya dapat melihat data.</p>
            </div>

            <form method="POST" action="{{ route('admin.store') }}" class="space-y-4">
                @csrf
                <div>
                    <label for="name" class="mb-1.5 block text-sm font-medium text-slate-700">Nama</label>
                    <input id="name" name="name" type="text" value="{{ old('name') }}" required autocomplete="name" class="w-full rounded-xl border border-slate-200 px-3 py-2.5 text-sm outline-none transition focus:border-[#1B4E71] focus:ring-2 focus:ring-[#1B4E71]/15">
                    @error('name')<p class="mt-1.5 text-xs text-rose-600">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="email" class="mb-1.5 block text-sm font-medium text-slate-700">Email UGM</label>
                    <input id="email" name="email" type="email" value="{{ old('email') }}" required autocomplete="email" placeholder="nama@mail.ugm.ac.id" class="w-full rounded-xl border border-slate-200 px-3 py-2.5 text-sm outline-none transition focus:border-[#1B4E71] focus:ring-2 focus:ring-[#1B4E71]/15">
                    @error('email')<p class="mt-1.5 text-xs text-rose-600">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="password" class="mb-1.5 block text-sm font-medium text-slate-700">Kata sandi</label>
                    <input id="password" name="password" type="password" required autocomplete="new-password" class="w-full rounded-xl border border-slate-200 px-3 py-2.5 text-sm outline-none transition focus:border-[#1B4E71] focus:ring-2 focus:ring-[#1B4E71]/15">
                    @error('password')<p class="mt-1.5 text-xs text-rose-600">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="password_confirmation" class="mb-1.5 block text-sm font-medium text-slate-700">Konfirmasi kata sandi</label>
                    <input id="password_confirmation" name="password_confirmation" type="password" required autocomplete="new-password" class="w-full rounded-xl border border-slate-200 px-3 py-2.5 text-sm outline-none transition focus:border-[#1B4E71] focus:ring-2 focus:ring-[#1B4E71]/15">
                </div>
                <div class="rounded-xl border border-indigo-100 bg-indigo-50 px-3 py-2.5 text-xs leading-5 text-indigo-800">Peran yang diberikan: <strong>Admin (View only)</strong>.</div>
                <button type="submit" class="flex w-full items-center justify-center rounded-xl bg-[#1B4E71] px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-[#143a54]">Tambahkan akun</button>
            </form>
        </aside>
    </div>
</main>
@endsection
