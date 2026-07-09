<x-guest-layout>
    <div class="flex min-h-screen animate-fade-in">
        <div class="hidden lg:flex lg:w-1/2 justify-center items-center relative overflow-hidden bg-gray-950">
            @php
                $officePhoto = public_path('images/kantor-orbit.jpg');
                $photoUrl = asset('images/orbit.png');
                if (file_exists($officePhoto)) {
                    $photoUrl = asset('images/kantor-orbit.jpg');
                }
            @endphp
            <img src="{{ $photoUrl }}" 
                 alt="Kantor Orbit Digital Printing" 
                 class="absolute inset-0 w-full h-full object-cover scale-105 animate-subtle-zoom"
                 onerror="this.src='https://images.unsplash.com/photo-1619614136952-b94d2572a1e6?q=80&w=1974&auto=format&fit=crop'">
            
            <div class="absolute inset-0 bg-gradient-to-br from-indigo-950/95 via-purple-950/90 to-black/80"></div>
            
            <div class="z-10 text-center px-12 space-y-6">
                <div class="mb-8 flex justify-center animate-bounce-subtle">
                    <div class="w-28 h-28 bg-white rounded-3xl shadow-2xl flex items-center justify-center p-4 transform rotate-3 hover:rotate-0 transition-transform duration-300">
                        <img src="{{ asset('images/orbit.png') }}" alt="Logo Orbit" class="max-h-full">
                    </div>
                </div>
                
                <h2 class="text-4xl font-extrabold text-white tracking-tight leading-tight">
                    Orbit <span class="text-indigo-400">Digital</span> Printing
                </h2>
                <p class="text-indigo-100 text-lg font-light max-w-md mx-auto">
                    APLIKASI PENJUALAN DAN MANAJEMEN STOK BAHAN BAKU BERBASIS WEB PADA PERCETAKAN ORBIT DIGITAL PRINTING BANJARMASIN
                </p>
                
                <div class="flex justify-center pt-6 space-x-3">
                    <span class="w-16 h-1 bg-indigo-400 rounded-full"></span>
                    <span class="w-3 h-1 bg-indigo-600 rounded-full"></span>
                    <span class="w-3 h-1 bg-indigo-700 rounded-full"></span>
                </div>

                <div class="pt-4 text-indigo-300 text-xs font-medium">
                    <p>Skripsi - Zailani | Program Studi Teknik Informatika</p>
                </div>
            </div>
            
            <div class="absolute -bottom-32 -left-32 w-80 h-80 bg-indigo-500 rounded-full mix-blend-screen filter blur-3xl opacity-20"></div>
            <div class="absolute -top-32 -right-32 w-80 h-80 bg-purple-500 rounded-full mix-blend-screen filter blur-3xl opacity-20"></div>
        </div>

        <div class="w-full lg:w-1/2 flex items-center justify-center bg-white px-6 md:px-12 py-16">
            <div class="max-w-md w-full">
                <div class="text-center lg:hidden mb-12 animate-fade-in-down">
                     <img src="{{ asset('images/orbit.png') }}" class="mx-auto h-16 w-auto mb-4">
                     <h2 class="text-3xl font-bold text-gray-950">Orbit Digital Printing</h2>
                </div>

                <div class="mb-10 animate-fade-in-down delay-100">
                    <h3 class="text-3xl font-extrabold text-gray-950 tracking-tight">Selamat Datang Kembali!</h3>
                    <p class="text-gray-600 mt-2 text-lg">Silakan masuk untuk mengelola sistem.</p>
                </div>

                <x-auth-session-status class="mb-6" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}" class="space-y-6 animate-fade-in delay-200">
                    @csrf

                    <div class="space-y-1">
                        <label for="email" class="text-sm font-medium text-gray-800">Email</label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400 group-focus-within:text-indigo-600 transition-colors">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" /></svg>
                            </div>
                            <input id="email" type="text" name="email" :value="old('email')" required autofocus placeholder="email@contoh.com"
                                class="mt-1 block w-full pl-11 pr-4 py-3.5 border border-gray-300 focus:border-indigo-600 focus:ring-2 focus:ring-indigo-100 rounded-xl shadow-sm transition duration-150 text-gray-950">
                        </div>
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <div class="space-y-1">
                        <label for="password" class="text-sm font-medium text-gray-800">Kata Sandi</label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400 group-focus-within:text-indigo-600 transition-colors">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
                            </div>
                            <input id="password" type="password" name="password" required autocomplete="current-password" placeholder="password"
                                class="mt-1 block w-full pl-11 pr-4 py-3.5 border border-gray-300 focus:border-indigo-600 focus:ring-2 focus:ring-indigo-100 rounded-xl shadow-sm transition duration-150 text-gray-950">
                        </div>
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <div class="flex items-center justify-between pt-1">
                        <label for="remember_me" class="inline-flex items-center group cursor-pointer">
                            <input id="remember_me" type="checkbox" name="remember" class="rounded-md border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500 transition cursor-pointer">
                            <span class="ms-2 text-sm text-gray-700 group-hover:text-gray-900 transition">Ingat saya</span>
                        </label>
                        @if (Route::has('password.request'))
                            <a class="text-sm text-indigo-600 hover:text-indigo-500 font-semibold transition" href="{{ route('password.request') }}">
                                Lupa sandi?
                            </a>
                        @endif
                    </div>

                    <div class="pt-2">
                        <button type="submit" class="w-full flex justify-center items-center py-4 px-6 border border-transparent rounded-xl shadow-lg text-base font-semibold text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-4 focus:ring-indigo-100 transition duration-150 transform active:scale-[0.98]">
                            Masuk Ke Sistem
                            <svg class="ml-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" /></svg>
                        </button>
                    </div>
                </form>

                <div class="mt-12 text-center text-sm text-gray-700 animate-fade-in delay-300">
                    Belum memiliki akun Orbit Print? 
                    <a href="{{ route('register') }}" class="font-bold text-indigo-600 hover:text-indigo-500 transition ml-1">
                        Daftar Sekarang &rarr;
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
