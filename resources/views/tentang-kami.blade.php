<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Tentang Kami - Orbit Digital Printing</title>
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
                    <a href="{{ url('/') }}" class="flex items-center space-x-3">
                        <div class="flex items-center">
                            <img src="{{ asset('images/orbit.png') }}" class="h-12 w-auto" alt="Logo Orbit">
                        </div>
                        <span class="text-2xl font-extrabold tracking-tighter text-white uppercase">Orbit <span class="gradient-text">Digital</span></span>
                    </a>

                    <div class="hidden md:flex items-center space-x-8 text-base font-bold">
                        <a href="{{ url('/') }}" class="text-white/70 hover:text-white transition">Beranda</a>
                        <a href="{{ route('katalog.index') }}" class="text-white/70 hover:text-white transition">Katalog</a>
                        <a href="{{ route('tentang-kami') }}" class="text-white hover:text-white transition border-b-2 border-purple-400 pb-0.5">Tentang Kami</a>

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

        <section class="pt-40 pb-16 relative overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-b from-purple-900/20 via-transparent to-transparent pointer-events-none"></div>
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
                <div class="space-y-6 animate-fade-in">
                    <span class="inline-block px-4 py-1.5 bg-purple-500/15 text-purple-300 text-xs font-extrabold rounded-full tracking-widest uppercase italic border border-purple-500/20">Kenali Kami Lebih Dekat</span>
                    <h1 class="text-5xl lg:text-7xl font-extrabold leading-none tracking-tighter">
                        Tentang <span class="gradient-text">Kami</span>
                    </h1>
                    <p class="text-xl text-white/70 max-w-3xl mx-auto leading-relaxed font-medium">
                        Orbit Digital Printing hadir sebagai solusi cetak digital terpercaya di Banjarmasin dengan kualitas terbaik dan pelayanan prima.
                    </p>
                </div>
            </div>
        </section>

        <section class="py-16 relative">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="glass-card-static p-10 md:p-16">
                    <div class="grid md:grid-cols-2 gap-12 items-center">
                        <div class="space-y-6">
                            <h2 class="text-3xl font-extrabold tracking-tight italic uppercase">Cetak <span class="gradient-text">Tanpa Batas</span></h2>
                            <p class="text-white/70 leading-relaxed font-medium">
                                Orbit Digital Printing didirikan dengan visi menjadi pusat layanan cetak digital terlengkap dan terpercaya di Banjarmasin. Kami memahami bahwa setiap cetakan memiliki cerita tersendiri, mulai dari kebutuhan bisnis, promosi, hingga kenangan personal yang tak ternilai.
                            </p>
                            <p class="text-white/70 leading-relaxed font-medium">
                                Dengan peralatan modern dan tim profesional berpengalaman, kami berkomitmen menghadirkan hasil cetak berkualitas tinggi, warna yang tajam dan akurat, serta pengerjaan yang tepat waktu sesuai deadline Anda.
                            </p>
                        </div>
                        <div class="flex justify-center">
                            <div class="w-72 h-72 rounded-3xl overflow-hidden border border-white/10 bg-white/[0.03] shadow-2xl shadow-purple-500/10">
                                <img src="{{ asset('images/orbit.png') }}" class="w-full h-full object-contain p-8" alt="Orbit Digital Printing">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="py-16 relative">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16 space-y-4">
                    <h2 class="text-4xl font-extrabold tracking-tight italic uppercase">Mengapa <span class="gradient-text">Pilih Kami?</span></h2>
                    <p class="text-white/70 font-medium max-w-2xl mx-auto">Kami memberikan yang terbaik untuk setiap kebutuhan cetak Anda.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div class="glass-card-static p-8 text-center space-y-5">
                        <div class="w-16 h-16 mx-auto bg-purple-500/15 rounded-2xl flex items-center justify-center border border-purple-500/20">
                            <svg class="w-8 h-8 text-purple-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                        </div>
                        <h3 class="font-black text-white uppercase tracking-tight text-lg">Kualitas Terjamin</h3>
                        <p class="text-white/60 text-sm leading-relaxed font-medium">Menggunakan mesin cetak modern dan tinta berkualitas tinggi untuk menghasilkan warna yang tajam, akurat, dan tahan lama pada setiap produk.</p>
                    </div>

                    <div class="glass-card-static p-8 text-center space-y-5">
                        <div class="w-16 h-16 mx-auto bg-cyan-500/15 rounded-2xl flex items-center justify-center border border-cyan-500/20">
                            <svg class="w-8 h-8 text-cyan-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <h3 class="font-black text-white uppercase tracking-tight text-lg">Pengerjaan Cepat</h3>
                        <p class="text-white/60 text-sm leading-relaxed font-medium">Kami memahami waktu Anda berharga. Dengan alur kerja yang efisien, pesanan Anda akan selesai tepat waktu tanpa mengorbankan kualitas.</p>
                    </div>

                    <div class="glass-card-static p-8 text-center space-y-5">
                        <div class="w-16 h-16 mx-auto bg-pink-500/15 rounded-2xl flex items-center justify-center border border-pink-500/20">
                            <svg class="w-8 h-8 text-pink-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        </div>
                        <h3 class="font-black text-white uppercase tracking-tight text-lg">Tim Profesional</h3>
                        <p class="text-white/60 text-sm leading-relaxed font-medium">Didukung oleh tim desainer dan operator cetak berpengalaman yang siap membantu mewujudkan ide dan kebutuhan cetak Anda.</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="py-16 relative">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="glass-card-static p-10 md:p-16">
                    <div class="text-center mb-12 space-y-4">
                        <h2 class="text-3xl font-extrabold tracking-tight italic uppercase">Layanan <span class="gradient-text">Kami</span></h2>
                        <p class="text-white/70 font-medium">Berbagai solusi cetak digital untuk kebutuhan Anda.</p>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                        <div class="flex items-center gap-4 p-5 bg-white/[0.03] rounded-2xl border border-white/[0.06] hover:border-purple-500/30 transition-all">
                            <div class="w-10 h-10 bg-purple-500/15 rounded-xl flex items-center justify-center shrink-0">
                                <svg class="w-5 h-5 text-purple-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            </div>
                            <span class="font-bold text-white text-sm">Banner & Spanduk</span>
                        </div>
                        <div class="flex items-center gap-4 p-5 bg-white/[0.03] rounded-2xl border border-white/[0.06] hover:border-purple-500/30 transition-all">
                            <div class="w-10 h-10 bg-cyan-500/15 rounded-xl flex items-center justify-center shrink-0">
                                <svg class="w-5 h-5 text-cyan-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            </div>
                            <span class="font-bold text-white text-sm">Brochure & Flyer</span>
                        </div>
                        <div class="flex items-center gap-4 p-5 bg-white/[0.03] rounded-2xl border border-white/[0.06] hover:border-purple-500/30 transition-all">
                            <div class="w-10 h-10 bg-pink-500/15 rounded-xl flex items-center justify-center shrink-0">
                                <svg class="w-5 h-5 text-pink-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                            </div>
                            <span class="font-bold text-white text-sm">Mug & Souvenir</span>
                        </div>
                        <div class="flex items-center gap-4 p-5 bg-white/[0.03] rounded-2xl border border-white/[0.06] hover:border-purple-500/30 transition-all">
                            <div class="w-10 h-10 bg-yellow-500/15 rounded-xl flex items-center justify-center shrink-0">
                                <svg class="w-5 h-5 text-yellow-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            </div>
                            <span class="font-bold text-white text-sm">Kartu Nama & Undangan</span>
                        </div>
                        <div class="flex items-center gap-4 p-5 bg-white/[0.03] rounded-2xl border border-white/[0.06] hover:border-purple-500/30 transition-all">
                            <div class="w-10 h-10 bg-emerald-500/15 rounded-xl flex items-center justify-center shrink-0">
                                <svg class="w-5 h-5 text-emerald-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"/></svg>
                            </div>
                            <span class="font-bold text-white text-sm">Sticker & Cutting</span>
                        </div>
                        <div class="flex items-center gap-4 p-5 bg-white/[0.03] rounded-2xl border border-white/[0.06] hover:border-purple-500/30 transition-all">
                            <div class="w-10 h-10 bg-orange-500/15 rounded-xl flex items-center justify-center shrink-0">
                                <svg class="w-5 h-5 text-orange-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            </div>
                            <span class="font-bold text-white text-sm">Kaos & Apparel</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="py-16 relative border-y border-white/[0.04]">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16 space-y-4">
                    <h2 class="text-4xl font-extrabold tracking-tight italic uppercase">Sistem <span class="gradient-text">Manajemen</span></h2>
                    <p class="text-white/70 font-medium max-w-2xl mx-auto">Kami menggunakan sistem manajemen digital untuk memberikan layanan terbaik.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="glass-card-static p-8 space-y-4">
                        <div class="w-14 h-14 bg-purple-500/15 rounded-2xl flex items-center justify-center border border-purple-500/20 mb-4">
                            <svg class="w-7 h-7 text-purple-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>
                        </div>
                        <h3 class="font-black text-white uppercase tracking-tight text-lg">Order & Cetak Online</h3>
                        <p class="text-white/60 text-sm leading-relaxed font-medium">Pesan langsung dari website tanpa perlu datang ke toko. Pilih produk, unggah desain, dan lakukan pembayaran secara online.</p>
                    </div>

                    <div class="glass-card-static p-8 space-y-4">
                        <div class="w-14 h-14 bg-cyan-500/15 rounded-2xl flex items-center justify-center border border-cyan-500/20 mb-4">
                            <svg class="w-7 h-7 text-cyan-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                        </div>
                        <h3 class="font-black text-white uppercase tracking-tight text-lg">Notifikasi Real-Time via WhatsApp</h3>
                        <p class="text-white/60 text-sm leading-relaxed font-medium">Setiap perubahan status pesanan akan dikirimkan notifikasi otomatis melalui WhatsApp agar Anda selalu tahu progress pesanan.</p>
                    </div>

                    <div class="glass-card-static p-8 space-y-4">
                        <div class="w-14 h-14 bg-emerald-500/15 rounded-2xl flex items-center justify-center border border-emerald-500/20 mb-4">
                            <svg class="w-7 h-7 text-emerald-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                        </div>
                        <h3 class="font-black text-white uppercase tracking-tight text-lg">Manajemen Stok Real-Time</h3>
                        <p class="text-white/60 text-sm leading-relaxed font-medium">Melacak stok bahan baku dan barang jadi secara real time memudahkan penyesuaian stok dan pemindahan produk antar gudang.</p>
                    </div>

                    <div class="glass-card-static p-8 space-y-4">
                        <div class="w-14 h-14 bg-pink-500/15 rounded-2xl flex items-center justify-center border border-pink-500/20 mb-4">
                            <svg class="w-7 h-7 text-pink-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                        </div>
                        <h3 class="font-black text-white uppercase tracking-tight text-lg">Laporan & Analitik</h3>
                        <p class="text-white/60 text-sm leading-relaxed font-medium">Sistem laporan otomatis membantu pemilik bisnis memantau penjualan, stok bahan baku, produk terlaris, dan loyalitas pelanggan.</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="py-16 relative">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <div class="glass-card-static p-12 md:p-16 space-y-6">
                    <h2 class="text-3xl font-extrabold tracking-tight italic uppercase">Siap <span class="gradient-text">Mencetak?</span></h2>
                    <p class="text-white/70 font-medium max-w-xl mx-auto">Jangan ragu untuk menghubungi kami. Kami siap membantu mewujudkan ide cetak Anda.</p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center pt-4">
                        <a href="{{ route('katalog.index') }}" class="px-10 py-5 cosmic-btn text-sm rounded-2xl">
                            Lihat Katalog
                        </a>
                        <a href="{{ url('/') }}" class="px-10 py-5 bg-white/[0.06] hover:bg-white/[0.1] text-white font-bold text-sm rounded-2xl border border-white/[0.1] transition-all">
                            Kembali ke Beranda
                        </a>
                    </div>
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
