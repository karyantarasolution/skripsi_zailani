<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $produk->nama_produk }} - Orbit Digital Printing</title>
    <link rel="icon" type="image/png" href="{{ asset('images/orbit.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.bunny.net/css?family=figtree:400,600,800&display=swap" rel="stylesheet" />
</head>
<body class="font-sans text-white cosmic-body">
    <div class="cosmic-orb w-96 h-96 bg-purple-600/10 -top-48 -left-48" style="animation-delay: 0s;"></div>
    <div class="cosmic-orb w-80 h-80 bg-cyan-500/8 top-1/3 -right-40" style="animation-delay: 5s;"></div>
    <div class="cosmic-orb w-64 h-64 bg-pink-500/6 bottom-20 left-1/4" style="animation-delay: 10s;"></div>

    <nav class="bg-white/[0.03] backdrop-blur-xl sticky top-0 z-50 border-b border-white/[0.06]">
        <div class="max-w-7xl mx-auto px-4 h-20 flex justify-between items-center">
            <a href="/" class="flex items-center space-x-3">
                <img src="{{ asset('images/orbit.png') }}" class="h-10 w-auto">
                <span class="text-xl font-black uppercase tracking-tighter text-white">Orbit <span class="gradient-text">Digital</span></span>
            </a>
            <a href="{{ route('katalog.index') }}" class="text-xs font-black uppercase text-white/60 hover:text-white tracking-widest transition">&larr; Kembali ke Katalog</a>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto px-4 py-16 relative z-10">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-start">

            <div class="glass-card-static p-4 rounded-[30px] overflow-hidden animate-fade-in-up">
                <div class="rounded-2xl overflow-hidden border border-white/[0.08] bg-white/[0.03] aspect-square flex items-center justify-center">
                    @if($produk->gambar)
                        <img src="{{ asset('storage/'.$produk->gambar) }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-white/20 uppercase font-black text-sm italic">No Preview</div>
                    @endif
                </div>
            </div>

            <div class="space-y-8 animate-fade-in-up delay-100">
                <div class="space-y-4">
                    <p class="text-[10px] font-black text-purple-300 uppercase tracking-widest italic">Detail Layanan</p>
                    <h1 class="text-4xl md:text-5xl font-black uppercase tracking-tighter italic text-white">{{ $produk->nama_produk }}</h1>
                    <div class="flex flex-wrap gap-2">
                        @foreach($produk->bahanBaku as $bahan)
                            <span class="text-[10px] font-bold text-purple-200 uppercase tracking-widest px-3 py-1.5 bg-purple-500/15 rounded-full border border-purple-500/20">{{ $bahan->nama_bahan }}</span>
                        @endforeach
                        @if($produk->bahanBaku->isEmpty())
                            <span class="text-[10px] font-bold text-cyan-200 uppercase tracking-widest px-3 py-1.5 bg-cyan-500/15 rounded-full border border-cyan-500/20">Material Custom</span>
                        @endif
                    </div>
                </div>

                @if($produk->deskripsi)
                    <div class="glass-card-static p-6 rounded-2xl">
                        <h3 class="text-[10px] font-black text-white/40 uppercase tracking-widest mb-3">Deskripsi Produk</h3>
                        <p class="text-white/70 font-medium leading-relaxed whitespace-pre-line">{{ $produk->deskripsi }}</p>
                    </div>
                @endif

                <div class="glass-card-static p-6 rounded-2xl space-y-4">
                    <div class="flex justify-between items-center pb-4 border-b border-white/[0.06]">
                        <span class="text-[10px] font-black text-white/40 uppercase tracking-widest">Harga Mulai Dari</span>
                        <span class="text-3xl font-black gradient-text-alt tracking-tighter">Rp {{ number_format($produk->harga_dasar, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-[10px] font-black text-white/40 uppercase tracking-widest">Satuan Hitung</span>
                        <span class="text-xs font-black text-white uppercase tracking-widest">{{ $produk->satuan == 'cm' ? 'Centimeter' : ($produk->satuan == 'mm' ? 'Milimeter' : 'Meter') }}</span>
                    </div>
                    <p class="text-[11px] text-white/40 font-medium italic leading-relaxed">*Harga dihitung berdasarkan panjang &times; lebar &times; jumlah cetak. Diskon grosir 10% otomatis untuk pembelian 5 pcs atau lebih.</p>
                </div>

                <div class="flex flex-col sm:flex-row gap-4">
                    <a href="{{ route('pesan.show', $produk->id) }}" class="flex-1 py-5 cosmic-btn rounded-2xl text-center flex items-center justify-center gap-3">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                        Pesan Sekarang
                    </a>
                    <a href="{{ route('katalog.index') }}" class="py-5 px-8 bg-white/[0.05] text-white/60 font-black uppercase text-xs tracking-widest rounded-2xl hover:bg-white/[0.08] transition border border-white/[0.08] flex items-center justify-center gap-3">
                        Lihat Layanan Lain
                    </a>
                </div>
            </div>
        </div>

        @if($produkLain->isNotEmpty())
            <div class="mt-24">
                <div class="mb-10 text-center space-y-3">
                    <h2 class="text-3xl font-black uppercase tracking-tighter italic">Layanan <span class="gradient-text">Lainnya</span></h2>
                    <p class="text-white/60 font-medium">Temukan kebutuhan cetak lainnya di Orbit Digital Printing.</p>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-8">
                    @foreach($produkLain as $item)
                        <div class="glass-card p-3 group">
                            <div class="h-44 rounded-2xl overflow-hidden mb-4 border border-white/[0.06] bg-white/[0.03] relative">
                                @if($item->gambar)
                                    <img src="{{ asset('storage/'.$item->gambar) }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-white/20 uppercase font-black text-[10px] italic">No Preview</div>
                                @endif
                            </div>
                            <div class="px-3 pb-3 text-center">
                                <h3 class="font-black uppercase text-base group-hover:text-purple-300 transition-colors tracking-tight text-white">{{ $item->nama_produk }}</h3>
                                <span class="text-lg font-black text-white tracking-tighter block mt-3">Rp {{ number_format($item->harga_dasar, 0, ',', '.') }}</span>
                                <a href="{{ route('katalog.show', $item->id) }}" class="mt-4 block w-full py-3 cosmic-btn-outline text-center rounded-xl text-[10px]">
                                    Lihat Detail
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </main>

    <footer class="py-12 mt-20 border-t border-white/[0.04]">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <p class="text-xs font-bold text-white/60 uppercase tracking-widest italic">Orbit Digital Printing - Layanan Cetak Masa Kini</p>
        </div>
    </footer>
</body>
</html>
