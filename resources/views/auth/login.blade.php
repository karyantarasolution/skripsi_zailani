<x-guest-layout>
    <div class="flex min-h-screen animate-fade-in">
        {{-- Left Panel - Cosmic --}}
        <div class="hidden lg:flex lg:w-1/2 justify-center items-center relative overflow-hidden guest-cosmic">
            @php
                $officePhoto = public_path('images/bglogin.jpeg');
                $photoUrl = asset('images/orbit.png');
                if (file_exists($officePhoto)) {
                    $photoUrl = asset('images/bglogin.jpeg');
                }
            @endphp
            <img src="{{ $photoUrl }}" 
                 alt="Kantor Orbit Digital Printing" 
                 class="absolute inset-0 w-full h-full object-cover scale-105 animate-subtle-zoom opacity-30"
                 onerror="this.style.display='none'">

            <div class="absolute inset-0 bg-gradient-to-br from-purple-950/95 via-indigo-950/90 to-black/80"></div>

            {{-- Animated orbs --}}
            <div class="absolute w-96 h-96 bg-purple-600/20 rounded-full blur-3xl -top-48 -left-48 animate-float-orb"></div>
            <div class="absolute w-80 h-80 bg-cyan-500/15 rounded-full blur-3xl -bottom-40 -right-40" style="animation: floatOrb 18s infinite ease-in-out reverse;"></div>
            <div class="absolute w-60 h-60 bg-pink-500/10 rounded-full blur-3xl top-1/3 left-1/4" style="animation: floatOrb 12s infinite ease-in-out; animation-delay: 3s;"></div>

            <div class="z-10 text-center px-12 space-y-6">
                <div class="mb-8 flex justify-center animate-bounce-subtle">
                    <div class="w-28 h-28 bg-white/10 backdrop-blur-xl rounded-3xl shadow-2xl flex items-center justify-center p-4 transform rotate-3 hover:rotate-0 transition-transform duration-300 border border-white/10">
                        <img src="{{ asset('images/orbit.png') }}" alt="Logo Orbit" class="max-h-full">
                    </div>
                </div>
                
                <h2 class="text-4xl font-extrabold tracking-tight leading-tight">
                    Orbit <span class="gradient-text">Digital</span> Printing
                </h2>
                <p class="text-white/50 text-lg font-light max-w-md mx-auto">
                    APLIKASI PENJUALAN DAN MANAJEMEN STOK BAHAN BAKU BERBASIS WEB
                </p>
                
                <div class="flex justify-center pt-6 space-x-3">
                    <span class="w-16 h-1 bg-gradient-to-r from-purple-400 to-cyan-400 rounded-full"></span>
                    <span class="w-3 h-1 bg-white/20 rounded-full"></span>
                    <span class="w-3 h-1 bg-white/10 rounded-full"></span>
                </div>

                <div class="pt-4 text-white/30 text-xs font-medium">
                    <p>Skripsi - Zailani | Program Studi Teknik Informatika</p>
                </div>
            </div>
        </div>

        {{-- Right Panel - Login Form --}}
        <div class="w-full lg:w-1/2 flex items-center justify-center px-6 md:px-12 py-16 guest-cosmic relative">
            <div class="absolute w-96 h-96 bg-purple-600/10 rounded-full blur-3xl -top-48 -right-48"></div>

            <div class="max-w-md w-full relative z-10">
                <div class="text-center lg:hidden mb-12 animate-fade-in-down">
                     <img src="{{ asset('images/orbit.png') }}" class="mx-auto h-16 w-auto mb-4">
                     <h2 class="text-3xl font-bold text-white">Orbit Digital Printing</h2>
                </div>

                <div class="mb-10 animate-fade-in-down delay-100">
                    <h3 class="text-3xl font-extrabold text-white tracking-tight">Selamat Datang Kembali!</h3>
                    <p class="text-white/40 mt-2 text-lg">Silakan masuk untuk mengelola sistem.</p>
                </div>

                <x-auth-session-status class="mb-6" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}" class="space-y-6 animate-fade-in delay-200">
                    @csrf

                    <div class="space-y-1">
                        <label for="email" class="text-sm font-medium text-white/60">Email</label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-white/20 group-focus-within:text-purple-400 transition-colors">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" /></svg>
                            </div>
                            <input id="email" type="text" name="email" :value="old('email')" required autofocus placeholder="email@contoh.com"
                                class="mt-1 block w-full pl-11 pr-4 py-3.5 rounded-xl glass-input font-bold text-white placeholder-white/20">
                        </div>
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <div class="space-y-1">
                        <label for="password" class="text-sm font-medium text-white/60">Kata Sandi</label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-white/20 group-focus-within:text-purple-400 transition-colors">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
                            </div>
                            <input id="password" type="password" name="password" required autocomplete="current-password" placeholder="password"
                                class="mt-1 block w-full pl-11 pr-4 py-3.5 rounded-xl glass-input font-bold text-white placeholder-white/20">
                        </div>
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <div class="flex items-center justify-between pt-1">
                        <label for="remember_me" class="inline-flex items-center group cursor-pointer">
                            <input id="remember_me" type="checkbox" name="remember" class="rounded-lg border-white/10 bg-white/5 text-purple-500 focus:ring-purple-500/50 focus:ring-offset-0 cursor-pointer">
                            <span class="ms-2 text-sm text-white/50 group-hover:text-white/70 transition">Ingat saya</span>
                        </label>
                        @if (Route::has('password.request'))
                            <a class="text-sm text-purple-400 hover:text-purple-300 font-semibold transition" href="{{ route('password.request') }}">
                                Lupa sandi?
                            </a>
                        @endif
                    </div>

                    <div class="pt-2">
                        <button type="submit" class="w-full cosmic-btn py-4 text-center flex items-center justify-center">
                            Masuk Ke Sistem
                            <svg class="ml-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" /></svg>
                        </button>
                    </div>
                </form>

                <div class="mt-12 text-center text-sm text-white/30 animate-fade-in delay-300">
                    Belum memiliki akun? 
                    <a href="{{ route('register') }}" class="font-bold gradient-text hover:opacity-80 transition ml-1">
                        Daftar Sekarang &rarr;
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
