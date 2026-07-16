<x-guest-layout>
    <div class="flex min-h-screen animate-fade-in">
        <div class="hidden lg:flex lg:w-1/2 justify-center items-center relative overflow-hidden guest-cosmic">
            <img src="{{ asset('images/orbit.png') }}" 
                 alt="Orbit Digital Printing" 
                 class="absolute inset-0 w-full h-full object-cover scale-105 animate-subtle-zoom opacity-10"
                 onerror="this.style.display='none'">

            <div class="absolute inset-0 bg-gradient-to-br from-purple-950/95 via-indigo-950/90 to-black/80"></div>

            <div class="absolute w-96 h-96 bg-purple-600/20 rounded-full blur-3xl -top-48 -left-48 animate-float-orb"></div>
            <div class="absolute w-80 h-80 bg-cyan-500/15 rounded-full blur-3xl -bottom-40 -right-40" style="animation: floatOrb 18s infinite ease-in-out reverse;"></div>
            
            <div class="z-10 text-center px-12 space-y-6">
                <div class="mb-8 flex justify-center animate-bounce-subtle">
                    <div class="w-28 h-28 bg-white/10 backdrop-blur-xl rounded-3xl shadow-2xl flex items-center justify-center p-4 transform rotate-3 hover:rotate-0 transition-transform duration-300 border border-white/10">
                        <img src="{{ asset('images/orbit.png') }}" alt="Logo Orbit" class="max-h-full">
                    </div>
                </div>
                
                <h2 class="text-4xl font-extrabold tracking-tight leading-tight">
                    Mulai <span class="gradient-text">Bisnis</span> Anda
                </h2>
                <p class="text-white/50 text-lg font-light max-w-md mx-auto">
                    Bergabunglah dengan ribuan mitra Orbit Print dan rasakan kemudahan cetak digital skala Enterprise.
                </p>
                
                <div class="flex justify-center pt-6 space-x-3">
                    <span class="w-16 h-1 bg-gradient-to-r from-purple-400 to-cyan-400 rounded-full"></span>
                    <span class="w-3 h-1 bg-white/20 rounded-full"></span>
                    <span class="w-3 h-1 bg-white/10 rounded-full"></span>
                </div>
            </div>
        </div>

        <div class="w-full lg:w-1/2 flex items-center justify-center px-6 md:px-12 py-12 guest-cosmic relative">
            <div class="absolute w-96 h-96 bg-purple-600/10 rounded-full blur-3xl -top-48 -right-48"></div>

            <div class="max-w-md w-full relative z-10">
                <div class="text-center lg:hidden mb-12 animate-fade-in-down">
                     <img src="{{ asset('images/orbit.png') }}" class="mx-auto h-16 w-auto mb-4">
                     <h2 class="text-3xl font-bold text-white">Orbit Digital Printing</h2>
                </div>

                <div class="mb-10 animate-fade-in-down">
                    <h3 class="text-3xl font-extrabold text-white tracking-tight">Buat Akun Baru</h3>
                    <p class="text-white/40 mt-2">Daftar sekarang untuk mulai melakukan pemesanan cetak.</p>
                </div>

                <form method="POST" action="{{ route('register') }}" class="space-y-5 animate-fade-in delay-100">
                    @csrf

                    <div class="space-y-1">
                        <label for="name" class="text-sm font-medium text-white/60">Nama Lengkap</label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-white/20 group-focus-within:text-purple-400 transition-colors">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                            </div>
                            <input id="name" type="text" name="name" :value="old('name')" required autofocus placeholder="Zailani"
                                class="mt-1 block w-full pl-11 pr-4 py-3.5 rounded-xl glass-input font-bold text-white placeholder-white/20">
                        </div>
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <div class="space-y-1">
                        <label for="email" class="text-sm font-medium text-white/60">Email</label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-white/20 group-focus-within:text-purple-400 transition-colors">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                            </div>
                            <input id="email" type="email" name="email" :value="old('email')" required placeholder="email@contoh.com"
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
                            <input id="password" type="password" name="password" required placeholder="••••••••"
                                class="mt-1 block w-full pl-11 pr-4 py-3.5 rounded-xl glass-input font-bold text-white placeholder-white/20">
                        </div>
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <div class="space-y-1">
                        <label for="password_confirmation" class="text-sm font-medium text-white/60">Konfirmasi Kata Sandi</label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-white/20 group-focus-within:text-purple-400 transition-colors">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" /></svg>
                            </div>
                            <input id="password_confirmation" type="password" name="password_confirmation" required placeholder="••••••••"
                                class="mt-1 block w-full pl-11 pr-4 py-3.5 rounded-xl glass-input font-bold text-white placeholder-white/20">
                        </div>
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                    </div>

                    <div class="pt-4">
                        <button type="submit" class="w-full cosmic-btn py-4 text-center flex items-center justify-center">
                            Daftar Akun
                            <svg class="ml-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" /></svg>
                        </button>
                    </div>
                </form>

                <div class="mt-8 text-center text-sm text-white/30 animate-fade-in delay-200">
                    Sudah punya akun? 
                    <a href="{{ route('login') }}" class="font-bold gradient-text hover:opacity-80 transition ml-1">
                        Masuk di sini &rarr;
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
