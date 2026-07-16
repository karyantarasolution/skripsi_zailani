<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-black text-2xl text-white uppercase tracking-tight">
                Dashboard <span class="gradient-text">Pegawai</span>
            </h2>
            <div class="flex items-center gap-3 text-sm">
                <span class="text-white/40 font-medium">{{ now()->isoFormat('dddd, D MMMM Y') }}</span>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if(session('error'))
                <div class="p-5 bg-red-500/10 border border-red-500/20 text-red-300 rounded-2xl font-black uppercase tracking-wider text-sm flex items-center gap-3 backdrop-blur-xl">
                    <svg class="w-6 h-6 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            {{-- Welcome --}}
            <div class="glass-card-static p-8 relative overflow-hidden animate-fade-in">
                <div class="absolute -top-24 -right-24 w-80 h-80 bg-cyan-600/15 rounded-full blur-3xl animate-cosmic-pulse"></div>
                <div class="relative z-10 flex items-center justify-between">
                    <div>
                        <h3 class="text-3xl font-black uppercase tracking-tighter mb-2 text-white">
                            Selamat Datang, <span class="gradient-text-alt">{{ $user->name }}</span>!
                        </h3>
                        <p class="text-white/50 font-medium text-sm">
                            Anda login sebagai <span class="font-black uppercase bg-cyan-500/20 text-cyan-300 px-3 py-1 rounded-lg ml-1 border border-cyan-500/30">Pegawai</span>.
                            Berikut ringkasan pekerjaan hari ini.
                        </p>
                    </div>
                    <a href="{{ route('profile.edit') }}" class="hidden md:flex items-center gap-2 cosmic-btn">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        Lengkapi Profil
                    </a>
                </div>
            </div>

            {{-- Profile Completion --}}
            @if($stats['profile_completion'] < 100)
            <div class="p-6 bg-amber-500/10 border border-amber-500/20 rounded-2xl backdrop-blur-xl">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-amber-500/15 text-amber-400 flex items-center justify-center shrink-0 border border-amber-500/20">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"/></svg>
                    </div>
                    <div class="flex-1">
                        <p class="font-black text-sm text-amber-300 uppercase tracking-wider">Profil Belum Lengkap</p>
                        <p class="text-sm text-amber-300/60 mt-1">Lengkapi data diri Anda sesuai KTP.</p>
                        <div class="mt-2 w-full bg-white/5 rounded-full h-2">
                            <div class="bg-gradient-to-r from-amber-500 to-orange-500 h-2 rounded-full transition-all" style="width: {{ $stats['profile_completion'] }}%"></div>
                        </div>
                        <p class="text-xs text-amber-400/70 mt-1 font-bold">{{ $stats['profile_completion'] }}% terisi</p>
                    </div>
                    <a href="{{ route('profile.edit') }}" class="px-4 py-2 bg-amber-500/20 text-amber-300 rounded-xl font-black text-xs uppercase tracking-wider hover:bg-amber-500/30 transition border border-amber-500/30 shrink-0">Lengkapi</a>
                </div>
            </div>
            @endif

            {{-- Stats --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="stat-card" style="--stat-color: rgba(59,130,246,0.5);">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-xl bg-blue-500/15 text-blue-400 flex items-center justify-center shrink-0 border border-blue-500/20">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                        </div>
                        <div>
                            <p class="text-[10px] font-black text-white/30 uppercase tracking-widest">Pesanan Aktif</p>
                            <p class="text-2xl font-black text-white">{{ $stats['pesanan_aktif'] }}</p>
                        </div>
                    </div>
                </div>

                <div class="stat-card" style="--stat-color: rgba(16,185,129,0.5);">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-xl bg-emerald-500/15 text-emerald-400 flex items-center justify-center shrink-0 border border-emerald-500/20">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <div>
                            <p class="text-[10px] font-black text-white/30 uppercase tracking-widest">Selesai</p>
                            <p class="text-2xl font-black text-white">{{ $stats['pesanan_selesai'] }}</p>
                        </div>
                    </div>
                </div>

                <div class="stat-card" style="--stat-color: rgba(168,85,247,0.5);">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-xl bg-purple-500/15 text-purple-400 flex items-center justify-center shrink-0 border border-purple-500/20">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        </div>
                        <div>
                            <p class="text-[10px] font-black text-white/30 uppercase tracking-widest">Pelanggan</p>
                            <p class="text-2xl font-black text-white">{{ $stats['total_pelanggan'] }}</p>
                        </div>
                    </div>
                </div>
            </div>

            @if($stats['stok_menipis'] > 0)
            <div class="p-5 bg-amber-500/10 border border-amber-500/20 text-amber-300 rounded-2xl flex items-center gap-3 backdrop-blur-xl">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"/></svg>
                <p class="font-bold text-sm">{{ $stats['stok_menipis'] }} bahan baku stoknya menipis.</p>
            </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div class="glass-card-static p-8">
                    <h4 class="font-black text-white uppercase tracking-tighter mb-6">Pesanan Terbaru</h4>
                    <div class="overflow-x-auto">
                        <table class="cosmic-table">
                            <thead>
                                <tr><th>Invoice</th><th>Pelanggan</th><th>Status</th><th class="text-right">Total</th></tr>
                            </thead>
                            <tbody>
                                @forelse($stats['pesanan_terbaru'] as $p)
                                <tr>
                                    <td class="font-bold text-white font-mono text-xs">{{ $p->nomor_invoice }}</td>
                                    <td class="text-white/50">{{ $p->user->name ?? '-' }}</td>
                                    <td>
                                        @php
                                            $badgeClass = match($p->status) {
                                                'Menunggu Pembayaran' => 'bg-yellow-500/15 text-yellow-300 border-yellow-500/30',
                                                'Verifikasi' => 'bg-orange-500/15 text-orange-300 border-orange-500/30',
                                                'Antrean Cetak' => 'bg-blue-500/15 text-blue-300 border-blue-500/30',
                                                'Produksi' => 'bg-purple-500/15 text-purple-300 border-purple-500/30',
                                                'Siap Ambil' => 'bg-emerald-500/15 text-emerald-300 border-emerald-500/30',
                                                'Sedang Dikirim' => 'bg-cyan-500/15 text-cyan-300 border-cyan-500/30',
                                                default => 'bg-white/5 text-white/50 border-white/10',
                                            };
                                        @endphp
                                        <span class="badge-glow border {{ $badgeClass }}">{{ $p->status }}</span>
                                    </td>
                                    <td class="text-right font-bold text-white">Rp{{ number_format($p->total_bayar, 0, ',', '.') }}</td>
                                </tr>
                                @empty
                                <tr><td colspan="4" class="py-8 text-center text-white/30 text-sm">Tidak ada pesanan aktif.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="glass-card-static p-8">
                    <h4 class="font-black text-white uppercase tracking-tighter mb-6">Riwayat Selesai</h4>
                    <div class="overflow-x-auto">
                        <table class="cosmic-table">
                            <thead>
                                <tr><th>Invoice</th><th>Pelanggan</th><th>Tanggal</th><th class="text-right">Total</th></tr>
                            </thead>
                            <tbody>
                                @forelse($stats['pesanan_selesai_list'] as $p)
                                <tr>
                                    <td class="font-bold text-white font-mono text-xs">{{ $p->nomor_invoice }}</td>
                                    <td class="text-white/50">{{ $p->user->name ?? '-' }}</td>
                                    <td class="text-white/40 text-xs">{{ $p->updated_at->format('d/m/Y') }}</td>
                                    <td class="text-right font-bold text-white">Rp{{ number_format($p->total_bayar, 0, ',', '.') }}</td>
                                </tr>
                                @empty
                                <tr><td colspan="4" class="py-8 text-center text-white/30 text-sm">Belum ada pesanan selesai.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- Quick Actions --}}
            <div class="glass-card-static p-8">
                <h4 class="font-black text-white uppercase tracking-tighter mb-6">Aksi Cepat</h4>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    @php
                        $actions = [
                            ['route' => 'admin.pesanan.index', 'label' => 'Antrean Pesanan', 'icon' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4', 'color' => 'blue'],
                            ['route' => 'admin.pesanan.selesai', 'label' => 'Riwayat Selesai', 'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z', 'color' => 'emerald'],
                            ['route' => 'admin.bahan.index', 'label' => 'Data Bahan', 'icon' => 'M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4', 'color' => 'orange'],
                            ['route' => 'profile.edit', 'label' => 'Edit Profil', 'icon' => 'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z', 'color' => 'purple'],
                        ];
                    @endphp
                    @foreach($actions as $a)
                    <a href="{{ route($a['route']) }}" class="glass-card p-5 text-center group">
                        <div class="w-10 h-10 rounded-xl bg-{{ $a['color'] }}-500/15 text-{{ $a['color'] }}-400 flex items-center justify-center mx-auto mb-3 group-hover:scale-110 transition-transform border border-{{ $a['color'] }}-500/20">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $a['icon'] }}"/></svg>
                        </div>
                        <p class="text-xs font-black uppercase tracking-wider text-white/70 group-hover:text-white transition-colors">{{ $a['label'] }}</p>
                    </a>
                    @endforeach
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
