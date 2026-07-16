<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Katalog Layanan - Orbit Digital Printing</title>
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
            <a href="/" class="text-xs font-black uppercase text-white/40 hover:text-white tracking-widest transition">Kembali ke Beranda</a>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto px-4 py-16 relative z-10">
        <div class="mb-16 text-center space-y-4">
            <h1 class="text-5xl font-black uppercase tracking-tighter italic">Katalog <span class="gradient-text">Lengkap</span></h1>
            <p class="text-white/40 mt-2 font-medium">Solusi cetak profesional untuk segala media dan ukuran.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-8">
            @forelse($produk as $item)
                <div class="glass-card p-3 group">
                    <div class="h-56 rounded-2xl overflow-hidden mb-4 border border-white/[0.06] bg-white/[0.03] relative">
                        @if($item->gambar)
                            <img src="{{ asset('storage/'.$item->gambar) }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-white/20 uppercase font-black text-[10px] italic">No Preview</div>
                        @endif
                    </div>
                    <div class="px-3 pb-3 text-center">
                        <h3 class="font-black uppercase text-lg group-hover:text-purple-300 transition-colors tracking-tight text-white">{{ $item->nama_produk }}</h3>
                        <p class="text-[10px] font-bold text-white/30 uppercase tracking-widest mt-1 italic">{{ $item->bahanBaku->pluck('nama_bahan')->implode(', ') ?: 'Material Custom' }}</p>
                        
                        <div class="mt-6 pt-6 border-t border-white/[0.06]">
                            <span class="text-[10px] font-bold text-white/30 block uppercase tracking-widest mb-1 italic">Mulai Dari</span>
                            <span class="text-2xl font-black text-white tracking-tighter">Rp {{ number_format($item->harga_dasar, 0, ',', '.') }}</span>
                        </div>
                        
                        <a href="{{ route('pesan.show', $item->id) }}" class="mt-6 block w-full py-4 cosmic-btn text-center rounded-2xl">
                            Pesan Sekarang
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-20 glass-card-static border-2 border-dashed border-white/10 text-white/30 font-bold uppercase italic tracking-widest">
                    Belum ada layanan yang tersedia saat ini.
                </div>
            @endforelse
        </div>
    </main>

    <footer class="py-12 mt-20 border-t border-white/[0.04]">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <p class="text-xs font-bold text-white/30 uppercase tracking-widest italic">Orbit Digital Printing - Layanan Cetak Masa Kini</p>
        </div>
    </footer>
</body>
</html>
