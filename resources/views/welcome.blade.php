<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Orbit Digital Printing - Berkualitas & Cepat</title>
        <link rel="icon" type="image/png" href="{{ asset('images/orbit.png') }}">
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <link href="https://fonts.bunny.net/css?family=figtree:400,600,800&display=swap" rel="stylesheet" />
    </head>
    <body class="antialiased font-sans text-white cosmic-body">
        <div class="cosmic-orb w-96 h-96 bg-purple-600/10 -top-48 -left-48" style="animation-delay: 0s;"></div>
        <div class="cosmic-orb w-80 h-80 bg-cyan-500/8 top-1/3 -right-40" style="animation-delay: 5s;"></div>
        <div class="cosmic-orb w-64 h-64 bg-pink-500/6 bottom-20 left-1/4" style="animation-delay: 10s;"></div>
        
        <nav class="fixed w-full z-50 bg-white/[0.03] backdrop-blur-xl border-b border-white/[0.06]">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-20 items-center">
                    <div class="flex items-center space-x-3">
                        <div class="flex items-center">
                            <img src="{{ asset('images/orbit.png') }}" class="h-12 w-auto" alt="Logo Orbit">
                        </div>
                        <span class="text-2xl font-extrabold tracking-tighter text-white uppercase">Orbit <span class="gradient-text">Digital</span></span>
                    </div>

                    <div class="hidden md:flex items-center space-x-8 text-base font-bold">
                        <a href="#" class="text-white/70 hover:text-white transition">Beranda</a>
                        <a href="{{ route('katalog.index') }}" class="text-white/70 hover:text-white transition">Katalog</a>
                        <a href="{{ route('tentang-kami') }}" class="text-white/70 hover:text-white transition">Tentang Kami</a>
                        
                        @if (Route::has('login'))
                            <div class="flex items-center space-x-4">
                                @auth
                                    <a href="{{ url('/dashboard') }}" class="cosmic-btn">Dashboard</a>
                                @else
                                    <a href="{{ route('login') }}" class="text-white/70 hover:text-white transition">Masuk</a>
                                    <a href="{{ route('register') }}" class="cosmic-btn">Daftar Akun</a>
                                @endauth
                            </div>
                        @endif
                    </div>

                    <button id="mobile-toggle" class="md:hidden text-white/70 hover:text-white">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                    </button>
                </div>
            </div>
        </nav>

        <section class="pt-40 pb-24 relative overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-b from-purple-900/20 via-transparent to-transparent pointer-events-none"></div>
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
                <div class="space-y-8 animate-fade-in">
                    <span class="inline-block px-4 py-1.5 bg-purple-500/15 text-purple-300 text-xs font-extrabold rounded-full tracking-widest uppercase italic border border-purple-500/20">Pusat Cetak Digital Terpercaya di Banjarmasin</span>
                    <h1 class="text-6xl lg:text-8xl font-extrabold leading-none tracking-tighter">
                        Cetak Ide Anda <br> <span class="gradient-text">Jadi Nyata.</span>
                    </h1>
                    <p class="text-xl text-white/70 max-w-2xl mx-auto leading-relaxed font-medium">
                        Kualitas tajam, warna akurat, dan pengerjaan tepat waktu. Orbit Digital Printing siap melayani segala kebutuhan cetak Anda.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center">
                        <a href="{{ route('katalog.index') }}" class="px-10 py-5 cosmic-btn text-sm rounded-2xl">
                            Lihat Semua Katalog
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <section id="produk" class="py-24 relative">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col md:flex-row md:items-end justify-between mb-16 gap-4">
                    <div class="space-y-2">
                        <h2 class="text-4xl font-extrabold tracking-tight italic uppercase">Produk <span class="gradient-text">Unggulan</span></h2>
                        <p class="text-white/70 font-medium">Layanan cetak paling populer pilihan pelanggan kami.</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                    @forelse($produk as $item)
                        <div class="group glass-card p-3">
                            <div class="h-56 rounded-2xl overflow-hidden mb-4 relative border border-white/[0.06] bg-white/[0.03]">
                                @if($item->gambar)
                                    <img src="{{ asset('storage/'.$item->gambar) }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                                @else
                                    <div class="w-full h-full flex items-center justify-center bg-white/[0.03] text-white/20">
                                        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    </div>
                                @endif
                            </div>
                            <div class="px-3 pb-3">
                                <h3 class="font-bold group-hover:text-purple-300 transition-colors uppercase tracking-tight text-lg text-white">{{ $item->nama_produk }}</h3>
                                <p class="text-xs text-white/60 mt-1 font-bold tracking-widest uppercase italic">{{ $item->bahanBaku->pluck('nama_bahan')->implode(', ') ?: 'Material Custom' }}</p>
                                <div class="mt-8 flex justify-between items-center border-t border-white/[0.06] pt-4">
                                    <div class="flex flex-col">
                                        <span class="text-[10px] font-bold text-white/60 uppercase tracking-widest">Mulai Dari</span>
                                        <span class="text-xl font-extrabold text-white">Rp {{ number_format($item->harga_dasar, 0, ',', '.') }}</span>
                                    </div>
                                    <a href="{{ route('pesan.show', $item->id) }}" class="p-3 bg-purple-500/15 text-purple-300 rounded-xl hover:bg-purple-500/30 transition-all border border-purple-500/20">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full text-center py-24 glass-card-static border-2 border-dashed border-white/10 text-white/60 font-bold uppercase italic tracking-widest">
                            Data produk segera hadir.
                        </div>
                    @endforelse
                </div>
            </div>
        </section>
        @php $ulasanPublik = \App\Models\Ulasan::with('user')->latest()->take(3)->get(); @endphp

        <section class="py-24 relative border-y border-white/[0.04]">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16 space-y-4">
                    <h2 class="text-4xl font-extrabold tracking-tight italic uppercase">Testimoni <span class="gradient-text">Pelanggan</span></h2>
                    <p class="text-white/70 font-medium">Apa kata mereka yang telah mencetak di Orbit Digital?</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    @forelse($ulasanPublik as $ul)
                    <div class="glass-card-static p-8 flex flex-col justify-between">
                        <div>
                            <div class="flex gap-1 mb-6 text-yellow-400">
                                @foreach(range(1, $ul->rating) as $star)
                                    <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                                @endforeach
                            </div>
                            <p class="text-white/70 font-bold italic text-lg leading-relaxed">"{{ $ul->komentar }}"</p>
                        </div>
                        <div class="mt-8 pt-6 border-t border-white/[0.06] flex items-center gap-4">
                            <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-cyan-500 rounded-full flex items-center justify-center text-white font-black uppercase shadow-lg shadow-purple-500/20">
                                {{ substr($ul->user->name, 0, 1) }}
                            </div>
                            <div>
                                <h4 class="font-black text-white uppercase text-sm tracking-tight">{{ $ul->user->name }}</h4>
                                <p class="text-[10px] font-bold text-white/60 uppercase tracking-widest">Pelanggan Terverifikasi</p>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="col-span-full text-center text-white/60 font-bold uppercase italic tracking-widest">Belum ada ulasan saat ini.</div>
                    @endforelse
                </div>
            </div>
        </section>

        <footer class="py-12 border-t border-white/[0.04]">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row justify-between items-center gap-8 text-center md:text-left">
                <div class="flex flex-col items-center md:items-start space-y-4">
                    <img src="{{ asset('images/orbit.png') }}" class="h-10 w-auto" alt="Logo Footer">
                    <p class="text-white/60 text-sm font-medium tracking-wide">&copy; {{ date('Y') }} Orbit Digital Printing. High Quality Output.</p>
                </div>
                <div class="flex space-x-8 text-sm font-bold text-white/60 uppercase">
                    <a href="#" class="hover:text-white transition">Instagram</a>
                    <a href="#" class="hover:text-white transition">WhatsApp</a>
                </div>
            </div>
        </footer>

        <script>
            document.getElementById('mobile-toggle')?.addEventListener('click', function() {
                const nav = document.querySelector('nav .hidden.md\\:flex');
                if (nav) nav.classList.toggle('hidden');
                if (nav) nav.classList.toggle('flex');
                if (nav) nav.classList.toggle('flex-col');
                if (nav) nav.classList.toggle('absolute');
                if (nav) nav.classList.toggle('top-20');
                if (nav) nav.classList.toggle('right-4');
                if (nav) nav.classList.toggle('bg-white/[0.05]');
                if (nav) nav.classList.toggle('backdrop-blur-xl');
                if (nav) nav.classList.toggle('p-6');
                if (nav) nav.classList.toggle('rounded-2xl');
                if (nav) nav.classList.toggle('border');
                if (nav) nav.classList.toggle('border-white/[0.08]');
            });
        </script>
    </body>
</html>
