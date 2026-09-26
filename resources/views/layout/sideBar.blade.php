<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard | Mahasiswa Disabilitas')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { overflow: hidden; }
        
        /* Container Sidebar */
        .app-sidebar { 
            position: fixed; 
            top: 0;
            bottom: 0;
            left: 0;
            width: 16rem;
            z-index: 50; 
            overflow: hidden; /* Memastikan logo dan teks tidak bocor saat slide */
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        /* Area Content Utama */
        .app-main { 
            margin-left: 16rem; 
            width: calc(100% - 16rem); 
            height: 100vh; 
            min-width: 0;
            min-height: 0;
            transition: margin-left 0.3s cubic-bezier(0.4, 0, 0.2, 1), width 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        /* State Saat Sidebar Sembunyi */
        body.sidebar-collapsed .app-sidebar { 
            transform: translateX(-100%);
        }
        body.sidebar-collapsed .app-main { 
            margin-left: 0; 
            width: 100%; 
        }

        /* Styling Custom Scrollbar Sidebar */
        .sidebar-scroll::-webkit-scrollbar { width: 4px; }
        .sidebar-scroll::-webkit-scrollbar-thumb { background: rgba(255, 255, 255, 0.15); border-radius: 4px; }
        .sidebar-scroll::-webkit-scrollbar-track { background: transparent; }
    </style>
</head>
<body class="bg-slate-100 flex h-screen min-h-0 font-sans antialiased text-slate-800">
    
    <!-- Sidebar -->
    <aside class="app-sidebar bg-[#083D62] shadow-xl flex flex-col h-screen shrink-0 border-r border-white/10 text-white select-none">
        
        <!-- Top Header Logo -->
        <div class="h-16 flex items-center justify-between px-4 bg-[#062E4A] border-b border-white/10 shrink-0">
            <div class="flex items-center space-x-3 overflow-hidden">
                <img src="{{ asset('images/newlogo.png') }}" alt="Logo ULD UGM" class="h-8 w-auto object-contain shrink-0">
            </div>
            <!-- Button Sembunyikan Sidebar -->
            <button type="button" onclick="toggleSidebar()" 
                class="p-1.5 rounded-lg text-white/70 hover:text-white hover:bg-white/10 transition-colors shrink-0" 
                aria-label="Sembunyikan sidebar" title="Sembunyikan sidebar">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M11 19l-7-7 7-7m8 14l-7-7 7-7" />
                </svg>
            </button>
        </div>

        <!-- Scrollable Navigation Items -->
        <nav class="flex-1 overflow-y-auto py-4 px-3 space-y-1 sidebar-scroll">
            
            <!-- Dashboard -->
            <a href="{{ route('dashboard') }}" 
               class="group flex items-center space-x-3 px-3.5 py-2.5 rounded-xl transition-all duration-150 {{ request()->routeIs('dashboard') ? 'bg-[#1B4E71] text-white font-semibold shadow-inner border-l-4 border-sky-400' : 'text-slate-300 hover:bg-white/5 hover:text-white' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0 opacity-80 group-hover:opacity-100" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 00-1-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                <span class="text-sm">Dashboard</span>
            </a>

            <!-- Data Mahasiswa -->
            <a href="{{ route('mahasiswa.index') }}" 
               class="group flex items-center space-x-3 px-3.5 py-2.5 rounded-xl transition-all duration-150 {{ request()->routeIs('mahasiswa.*') ? 'bg-[#1B4E71] text-white font-semibold shadow-inner border-l-4 border-sky-400' : 'text-slate-300 hover:bg-white/5 hover:text-white' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0 opacity-80 group-hover:opacity-100" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4"/>
                </svg>
                <span class="text-sm">Data Mahasiswa</span>
            </a>

            <!-- Data Alumni -->
            <a href="{{ route('alumni.index') }}" 
               class="group flex items-center space-x-3 px-3.5 py-2.5 rounded-xl transition-all duration-150 {{ request()->routeIs('alumni.*') ? 'bg-[#1B4E71] text-white font-semibold shadow-inner border-l-4 border-sky-400' : 'text-slate-300 hover:bg-white/5 hover:text-white' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0 opacity-80 group-hover:opacity-100" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0112 20.055a11.952 11.952 0 01-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/>
                </svg>
                <span class="text-sm">Data Alumni</span>
            </a>

            <!-- Asesmen Ujian -->
            <a href="{{ route('ujian.index') }}" 
               class="group flex items-center space-x-3 px-3.5 py-2.5 rounded-xl transition-all duration-150 {{ request()->routeIs('ujian.*') ? 'bg-[#1B4E71] text-white font-semibold shadow-inner border-l-4 border-sky-400' : 'text-slate-300 hover:bg-white/5 hover:text-white' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0 opacity-80 group-hover:opacity-100" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01m-.01 4h.01"/>
                </svg>
                <span class="text-sm">Asesmen Kebutuhan Ujian</span>
            </a>

            <!-- Data Dosen/Tendik -->
            <a href="{{ route('tendik.index') }}" 
               class="group flex items-center space-x-3 px-3.5 py-2.5 rounded-xl transition-all duration-150 {{ request()->routeIs('tendik.*') ? 'bg-[#1B4E71] text-white font-semibold shadow-inner border-l-4 border-sky-400' : 'text-slate-300 hover:bg-white/5 hover:text-white' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0 opacity-80 group-hover:opacity-100" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
                <span class="text-sm">Data Dosen/Tendik</span>
            </a>

            <!-- Sampah -->
            <a href="{{ route('trash.index') }}" 
               class="group flex items-center space-x-3 px-3.5 py-2.5 rounded-xl transition-all duration-150 {{ request()->routeIs('trash.*') ? 'bg-[#1B4E71] text-white font-semibold shadow-inner border-l-4 border-sky-400' : 'text-slate-300 hover:bg-white/5 hover:text-white' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0 opacity-80 group-hover:opacity-100" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3m-4 0h14" />
                </svg>
                <span class="text-sm">Sampah</span>
            </a>

            @if (strcasecmp((string) Auth::user()->role, 'superadmin') === 0)
                <!-- Kelola Admin -->
                <a href="{{ route('admin.index') }}" 
                   class="group flex items-center space-x-3 px-3.5 py-2.5 rounded-xl transition-all duration-150 {{ request()->routeIs('admin.*') ? 'bg-[#1B4E71] text-white font-semibold shadow-inner border-l-4 border-sky-400' : 'text-slate-300 hover:bg-white/5 hover:text-white' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0 opacity-80 group-hover:opacity-100" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    <span class="text-sm">Kelola Admin</span>
                </a>
            @endif

        </nav>

        <!-- Subtle Bottom User Profile -->
        <div class="p-3 bg-[#083D62] border-t border-white/10 shrink-0 relative">
            
            <!-- User Bar (Simpel & Menyatu) -->
            <div class="flex items-center justify-between p-2 rounded-lg hover:bg-white/5 transition-colors cursor-pointer select-none" onclick="toggleUserMenu()">
                <div class="flex items-center space-x-2.5 truncate">
                    <div class="w-8 h-8 rounded-full bg-white/10 text-white flex items-center justify-center font-medium text-xs shrink-0">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                    <div class="truncate">
                        <p class="text-xs font-medium text-white/90 truncate leading-tight">{{ Auth::user()->name }}</p>
                        <p class="text-[10px] text-white/50 capitalize truncate mt-0.5">{{ Auth::user()->role ?? 'User' }}</p>
                    </div>
                </div>
                <svg id="arrow-icon" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white/50 transition-transform duration-200 shrink-0 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
                </svg>
            </div>

            <!-- Pop-up Dropdown (Muncul Ringan ke Atas) -->
            <div id="user-menu" class="hidden absolute bottom-full left-3 right-3 mb-2 bg-white rounded-lg shadow-lg border border-slate-100 py-1 z-50 overflow-hidden">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full flex items-center space-x-2 px-3 py-2 text-xs font-medium text-red-600 hover:bg-red-50 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        <span>Keluar (Logout)</span>
                    </button>
                </form>
            </div>

        </div>

    </aside>

    <!-- Content Utama -->
    <div class="app-main flex min-h-0 flex-col">
        @yield('content')
    </div>

    <!-- Tombol Mengembalikan Sidebar saat Tersembunyi -->
    <button type="button" onclick="toggleSidebar()" 
            class="fixed left-4 top-4 z-40 hidden rounded-xl bg-[#083D62] p-2.5 text-white shadow-md hover:bg-[#1B4E71] transition-all" 
            id="show-sidebar" aria-label="Tampilkan sidebar" title="Tampilkan sidebar">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M13 5l7 7-7 7M5 5l7 7-7 7" />
        </svg>
    </button>

    <script>
        function toggleSidebar() {
            document.body.classList.toggle('sidebar-collapsed');
            document.getElementById('show-sidebar').classList.toggle('hidden');
        }

        function toggleUserMenu() {
            const menu = document.getElementById('user-menu');
            const arrow = document.getElementById('arrow-icon');
            if (menu) {
                menu.classList.toggle('hidden');
                if (arrow) arrow.classList.toggle('rotate-180');
            }
        }

        // Menutup menu logout otomatis jika area luar diklik
        document.addEventListener('click', function(event) {
            const userMenu = document.getElementById('user-menu');
            const profileBox = event.target.closest('[onclick="toggleUserMenu()"]');
            
            if (userMenu && !userMenu.classList.contains('hidden') && !profileBox && !userMenu.contains(event.target)) {
                userMenu.classList.add('hidden');
                const arrow = document.getElementById('arrow-icon');
                if (arrow) arrow.classList.remove('rotate-180');
            }
        });
    </script>
</body>
</html>