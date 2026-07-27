<x-guest-layout>
    {{-- CSS Kustom untuk Efek Cosmic --}}
    <style>
        .cosmic-stars {
            position: absolute;
            inset: 0;
            pointer-events: none;
            z-index: 1;
            overflow: hidden;
        }
        .cosmic-stars::before, .cosmic-stars::after {
            content: "";
            position: absolute;
            inset: -100%;
            background-image: 
                radial-gradient(1.5px 1.5px at 20px 30px, #ffffff, rgba(0,0,0,0)),
                radial-gradient(2px 2px at 80px 70px, #e0e7ff, rgba(0,0,0,0)),
                radial-gradient(1px 1px at 150px 160px, #ffffff, rgba(0,0,0,0)),
                radial-gradient(1.5px 1.5px at 250px 90px, #c7d2fe, rgba(0,0,0,0)),
                radial-gradient(2px 2px at 300px 220px, #ffffff, rgba(0,0,0,0)),
                radial-gradient(1px 1px at 400px 50px, #e0e7ff, rgba(0,0,0,0));
            background-repeat: repeat;
            background-size: 500px 500px;
            animation: cosmic-drift 20s linear infinite, cosmic-twinkle 4s ease-in-out infinite alternate;
            opacity: 0.6;
        }
        .cosmic-stars::after {
            background-size: 350px 350px;
            animation-delay: -10s, -2s;
            opacity: 0.4;
            transform: rotate(45deg);
        }
        @keyframes cosmic-drift {
            0% { transform: translateY(0) rotate(0deg); }
            100% { transform: translateY(-20%) rotate(5deg); }
        }
        @keyframes cosmic-twinkle {
            0% { opacity: 0.3; }
            100% { opacity: 0.8; }
        }
    </style>

    <div class="relative min-h-screen flex items-center justify-center bg-gray-950 overflow-hidden py-8">
        
        {{-- Background Split Full Screen dengan Efek Nebula --}}
        <div class="absolute inset-0 flex z-0">
            {{-- Kiri: logo2 --}}
            <div class="hidden lg:block w-1/2 relative h-full">
                <img src="{{ asset('images/logo2.jpeg') }}" 
                     alt="Storefront" 
                     class="absolute inset-0 w-full h-full object-cover">
                {{-- Nebula Overlay Kiri --}}
                <div class="absolute inset-0 bg-gradient-to-br from-indigo-900/80 via-purple-900/70 to-gray-950/90 mix-blend-multiply"></div>
            </div>
            
            {{-- Kanan: bglogin --}}
            <div class="w-full lg:w-1/2 relative h-full">
                <img src="{{ asset('images/bglogin.jpeg') }}" 
                     alt="Indoor Banner" 
                     class="absolute inset-0 w-full h-full object-cover">
                {{-- Nebula Overlay Kanan --}}
                <div class="absolute inset-0 bg-gradient-to-bl from-blue-900/80 via-purple-900/70 to-gray-950/90 mix-blend-multiply"></div>
            </div>
        </div>

        {{-- Layer Efek Bintang Kosmik --}}
        <div class="cosmic-stars"></div>

        {{-- Form / Card Container (Berada di tengah layar) --}}
        <div class="relative z-10 w-full max-w-[420px] flex flex-col gap-5 p-4 my-auto">
            
            {{-- Kartu Atas: Header & Logo --}}
            <div class="bg-[#0b0d17]/80 backdrop-blur-md rounded-xl p-8 flex flex-col items-center text-center shadow-[0_0_40px_rgba(139,92,246,0.15)] border border-purple-500/20 relative overflow-hidden group">
                {{-- Cahaya Kosmik Halus di belakang logo --}}
                <div class="absolute -top-10 -right-10 w-32 h-32 bg-purple-500/20 rounded-full blur-3xl group-hover:bg-purple-500/30 transition duration-700"></div>
                <div class="absolute -bottom-10 -left-10 w-32 h-32 bg-blue-500/20 rounded-full blur-3xl group-hover:bg-blue-500/30 transition duration-700"></div>

                {{-- Box Putih Logo --}}
                <div class="bg-white p-3 rounded-2xl mb-5 shadow-[0_0_20px_rgba(255,255,255,0.1)] relative z-10">
                    <img src="{{ asset('images/orbit.png') }}" 
                         class="h-10 w-auto" 
                         alt="Logo Orbit">
                </div>
                
                <h1 class="text-2xl font-bold text-white mb-2 tracking-wide relative z-10">
                    Orbit Digital Printing
                </h1>
                
                <p class="text-[10px] text-indigo-200/70 mb-6 leading-relaxed font-semibold relative z-10">
                    APLIKASI PENJUALAN DAN MANAJEMEN STOK BAHAN<br>BAKU BERBASIS WEB
                </p>
                
                {{-- Divider Gradient --}}
                <div class="w-full h-[1px] bg-gradient-to-r from-transparent via-purple-400/50 to-transparent mb-5 relative z-10"></div>
                
                <p class="text-[10px] text-indigo-300/50 relative z-10">
                    Skripsi - Zailani | Program Studi Teknik Informatika
                </p>
            </div>

            {{-- Kartu Bawah: Form Register --}}
            <div class="bg-[#0b0d17]/80 backdrop-blur-md rounded-xl p-8 shadow-[0_0_40px_rgba(139,92,246,0.15)] border border-purple-500/20 relative overflow-hidden">
                <h2 class="text-lg font-bold text-white mb-1 relative z-10">Buat Akun Baru</h2>
                <p class="text-xs text-indigo-200/60 mb-6 relative z-10">Daftar sekarang untuk mulai melakukan pemesanan cetak.</p>

                <form method="POST" action="{{ route('register') }}" class="space-y-4 relative z-10">
                    @csrf

                    {{-- Nama Lengkap --}}
                    <div>
                        <label for="name" class="block text-xs font-medium text-indigo-200/80 mb-1.5">Nama Lengkap</label>
                        <input id="name" type="text" name="name" :value="old('name')" required autofocus 
                               placeholder="Zailani"
                               class="block w-full px-4 py-2.5 rounded-lg bg-gray-100 border-0 focus:ring-2 focus:ring-purple-500 text-gray-900 placeholder-gray-400 text-sm transition shadow-inner">
                        <x-input-error :messages="$errors->get('name')" class="mt-1" />
                    </div>

                    {{-- Email --}}
                    <div>
                        <label for="email" class="block text-xs font-medium text-indigo-200/80 mb-1.5">Email</label>
                        <input id="email" type="email" name="email" :value="old('email')" required 
                               placeholder="email@contoh.com"
                               class="block w-full px-4 py-2.5 rounded-lg bg-gray-100 border-0 focus:ring-2 focus:ring-purple-500 text-gray-900 placeholder-gray-400 text-sm transition shadow-inner">
                        <x-input-error :messages="$errors->get('email')" class="mt-1" />
                    </div>

                    {{-- Kata Sandi --}}
                    <div>
                        <label for="password" class="block text-xs font-medium text-indigo-200/80 mb-1.5">Kata Sandi</label>
                        <input id="password" type="password" name="password" required autocomplete="new-password" 
                               placeholder="••••••••"
                               class="block w-full px-4 py-2.5 rounded-lg bg-gray-100 border-0 focus:ring-2 focus:ring-purple-500 text-gray-900 placeholder-gray-400 text-sm transition shadow-inner">
                        <x-input-error :messages="$errors->get('password')" class="mt-1" />
                    </div>

                    {{-- Konfirmasi Kata Sandi --}}
                    <div>
                        <label for="password_confirmation" class="block text-xs font-medium text-indigo-200/80 mb-1.5">Konfirmasi Kata Sandi</label>
                        <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" 
                               placeholder="••••••••"
                               class="block w-full px-4 py-2.5 rounded-lg bg-gray-100 border-0 focus:ring-2 focus:ring-purple-500 text-gray-900 placeholder-gray-400 text-sm transition shadow-inner">
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1" />
                    </div>

                    {{-- Submit Button --}}
                    <button type="submit" 
                        class="w-full mt-4 bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-500 hover:to-indigo-500 text-white font-bold text-xs py-3 rounded-lg transition-all shadow-[0_0_20px_rgba(139,92,246,0.3)] hover:shadow-[0_0_25px_rgba(139,92,246,0.5)] flex justify-center items-center gap-2 group">
                        DAFTAR AKUN 
                        <span class="group-hover:translate-x-1 transition-transform">&rarr;</span>
                    </button>
                </form>

                {{-- Login Link --}}
                <p class="mt-6 text-center text-xs text-indigo-200/50 relative z-10">
                    Sudah punya akun? 
                    <a href="{{ route('login') }}" class="text-purple-400 hover:text-purple-300 transition font-medium">
                        Masuk di sini &rarr;
                    </a>
                </p>
            </div>
            
        </div>
    </div>
</x-guest-layout>