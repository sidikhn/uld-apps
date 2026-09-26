<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard | Mahasiswa Disabilitas</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-screen flex items-center justify-center bg-cover bg-center" 
      style="background-image: url('{{ asset('images/Dashboard.jpg') }}')">

    <div class="bg-white p-8 rounded-2xl shadow-lg w-full max-w-md">
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="mb-6">
                <img src="{{ asset('images/logoBaru.png') }}" alt="Logo" class="mx-auto h-16">
            </div>
            <h2 class="text-2xl font-bold text-center text-[#083D62] mb-6">Login</h2>
            
            {{-- Pesan error login --}}
            @if ($errors->any())
                <div class="mb-4">
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-2 rounded">
                        {{ $errors->first() }}
                    </div>
                </div>
            @endif

            <div class="mb-4">
                <input id="email" type="email" name="email"
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-[#083D62]"
                    placeholder="username@mail.ugm.ac.id" required autofocus>
            </div>

            <div class="mb-4">
                <input id="password" type="password" name="password"
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-[#083D62]"
                    placeholder="Password" required>
            </div>

            <button type="submit" class="w-full bg-[#083D62] hover:bg-[#0A4D7A] text-white py-2 rounded-lg transition duration-200">
                Login
            </button>
        </form>

        {{-- Kontak / Narahubung --}}
        <div class="mt-6 text-center text-sm text-gray-600">
            <p>Kesulitan login atau butuh bantuan?</p>
            <p class="mt-1">
                Hubungi kami di 
                <a href="https://mail.google.com/mail/?view=cm&fs=1&to=uld@ugm.ac.id" target="_blank" 
                    class="text-[#083D62] font-semibold hover:underline">
                    uld@ugm.ac.id
                </a>

                atau 
                <a href="https://wa.me/6282227021332" target="_blank" class="text-[#083D62] font-semibold hover:underline">
                    +62 822-2702-1332
                </a>
            </p>
        </div>
    </div>
</body>
</html>
