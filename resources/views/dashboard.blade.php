<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-2xl text-white uppercase tracking-tight">
            Dashboard <span class="gradient-text">Saya</span>
        </h2>
    </x-slot>

    @php
        $pesananAktif = \App\Models\Pesanan::where('user_id', Auth::id())
                            ->whereNotIn('status', ['Selesai', 'Dibatalkan'])->count();
        $totalSelesai = \App\Models\Pesanan::where('user_id', Auth::id())
                            ->where('status', 'Selesai')->count();
        $pesananTerbaru = \App\Models\Pesanan::with('detailPesanan.produk')
                            ->where('user_id', Auth::id())->latest()->take(3)->get();
    @endphp

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            {{-- Welcome --}}
            <div class="glass-card-static p-8 md:p-12 relative overflow-hidden animate-fade-in">
                <div class="absolute -top-24 -right-24 w-80 h-80 bg-emerald-600/15 rounded-full blur-3xl animate-cosmic-pulse"></div>
                <div class="absolute -bottom-20 -left-20 w-60 h-60 bg-purple-500/10 rounded-full blur-3xl" style="animation: floatOrb 12s infinite ease-in-out;"></div>
                <div class="relative z-10 flex flex-col md:flex-row items-center justify-between gap-6">
                    <div class="space-y-2">
                        <p class="text-white/40 font-black uppercase tracking-widest text-xs">Selamat Datang Kembali,</p>
                        <h3 class="text-3xl md:text-4xl font-black tracking-tighter text-white">{{ Auth::user()->name }}! <span class="glow-cyan">🚀</span></h3>
                        <p class="text-sm font-medium text-white/40 max-w-xl">
                            Siap mencetak kebutuhan digital Anda hari ini? Pantau status pesanan atau jelajahi katalog produk terbaru.
                        </p>
                    </div>
                    <a href="{{ route('katalog.index') }}" class="cosmic-btn cosmic-btn-success whitespace-nowrap">
                        Pesan Produk Baru
                    </a>
                </div>
            </div>

            {{-- Stats --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="stat-card" style="--stat-color: rgba(59,130,246,0.5);">
                    <div class="flex items-center gap-6">
                        <div class="w-16 h-16 rounded-2xl bg-blue-500/15 text-blue-400 flex items-center justify-center border border-blue-500/20">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <div>
                            <p class="text-xs font-black text-white/30 uppercase tracking-widest mb-1">Pesanan Aktif</p>
                            <h4 class="text-4xl font-black text-white">{{ $pesananAktif }} <span class="text-sm text-white/30 uppercase">Transaksi</span></h4>
                        </div>
                    </div>
                </div>

                <div class="stat-card" style="--stat-color: rgba(16,185,129,0.5);">
                    <div class="flex items-center gap-6">
                        <div class="w-16 h-16 rounded-2xl bg-emerald-500/15 text-emerald-400 flex items-center justify-center border border-emerald-500/20">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <div>
                            <p class="text-xs font-black text-white/30 uppercase tracking-widest mb-1">Pesanan Selesai</p>
                            <h4 class="text-4xl font-black text-white">{{ $totalSelesai }} <span class="text-sm text-white/30 uppercase">Transaksi</span></h4>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Recent Activity --}}
            <div class="glass-card-static overflow-hidden">
                <div class="p-6 border-b border-white/5 flex justify-between items-center">
                    <h3 class="font-bold text-white uppercase tracking-tight">3 Aktivitas Terakhir</h3>
                    <a href="{{ route('pesanan.riwayat') }}" class="text-xs font-black uppercase tracking-widest gradient-text hover:opacity-80 transition">Lihat Semua &rarr;</a>
                </div>

                <div class="overflow-x-auto">
                    <table class="cosmic-table">
                        <tbody>
                            @forelse($pesananTerbaru as $item)
                            <tr>
                                <td>
                                    <span class="block font-black text-white">{{ $item->nomor_invoice }}</span>
                                    <span class="text-xs font-bold text-white/30">{{ $item->created_at->format('d M Y') }}</span>
                                </td>
                                <td>
                                    <span class="badge-glow bg-white/5 text-white/60 border border-white/10">{{ $item->status }}</span>
                                </td>
                                <td class="text-right font-black gradient-text">
                                    Rp {{ number_format($item->total_bayar, 0, ',', '.') }}
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="px-6 py-12 text-center text-white/30 font-bold uppercase tracking-widest">Anda belum memiliki riwayat pesanan.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
