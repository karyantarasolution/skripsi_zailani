<nav x-data="{ open: false, openLaporan: false, openData: false }" class="bg-indigo-900 text-white w-64 h-screen fixed left-0 top-0 hidden lg:flex flex-col shadow-2xl z-50">
    <div class="p-6 border-b border-indigo-800 flex-none">
        <a href="{{ Auth::user()->isStaff() ? route('admin.dashboard') : route('dashboard') }}" class="flex items-center space-x-3 group">
            <div class="bg-white p-2 rounded-lg transform group-hover:rotate-12 transition-transform">
                <img src="{{ asset('images/orbit.png') }}" class="h-8 w-8" alt="Logo">
            </div>
            <span class="text-xl font-bold tracking-wider uppercase">Orbit <span class="text-indigo-400">Digital</span></span>
        </a>
    </div>

    <div class="flex-1 overflow-y-auto custom-scrollbar px-4 py-6 space-y-2">
        @if(Auth::user()->isStaff())
            @php
                $notif_antrean = \App\Models\Pesanan::where('status', 'Antrean Cetak')->count();
                $notif_selesai = \App\Models\Pesanan::where('status', 'Selesai')->count();
                $notif_verifikasi = \App\Models\Pesanan::where('status', 'Verifikasi')->count();
                $notif_stok = \App\Models\BahanBaku::whereColumn('stok', '<=', 'minimum_stok')->count();
            @endphp

            {{-- Dashboard --}}
            <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-3 px-4 py-3 rounded-xl transition {{ request()->routeIs('admin.dashboard') ? 'bg-indigo-700 text-white' : 'hover:bg-indigo-800 text-indigo-100' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                <span class="font-medium">Dashboard</span>
            </a>

            {{-- Data Menu (Dropdown) --}}
            <div class="relative">
                <button @click="openData = !openData" class="w-full flex items-center justify-between px-4 py-3 rounded-xl hover:bg-indigo-800 text-indigo-100 transition group">
                    <div class="flex items-center space-x-3">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4"/></svg>
                        <span class="font-medium">Data Master</span>
                    </div>
                    <svg class="w-4 h-4 transition-transform duration-200" :class="openData ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </button>

                <div x-show="openData" x-collapse class="mt-1 space-y-1 bg-indigo-950/50 rounded-2xl p-2 border border-indigo-800">
                    @if(Auth::user()->isAdmin())
                    <a href="{{ route('admin.pegawai.index') }}" class="flex items-center space-x-2 px-4 py-2.5 text-xs font-bold text-indigo-200 hover:text-white hover:bg-indigo-800 rounded-lg transition uppercase tracking-wider">
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                        Data Pegawai
                    </a>
                    @endif
                    <a href="{{ route('admin.pelanggan.index') }}" class="flex items-center space-x-2 px-4 py-2.5 text-xs font-bold text-indigo-200 hover:text-white hover:bg-indigo-800 rounded-lg transition uppercase tracking-wider">
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        Data Pelanggan
                    </a>
                    <a href="{{ route('admin.supplier.index') }}" class="flex items-center space-x-2 px-4 py-2.5 text-xs font-bold text-indigo-200 hover:text-white hover:bg-indigo-800 rounded-lg transition uppercase tracking-wider">
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                        Data Supplier
                    </a>
                    <a href="{{ route('admin.produk.index') }}" class="flex items-center space-x-2 px-4 py-2.5 text-xs font-bold text-indigo-200 hover:text-white hover:bg-indigo-800 rounded-lg transition uppercase tracking-wider">
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                        Data Produk
                    </a>
                    <a href="{{ route('admin.bahan.index') }}" class="flex items-center space-x-2 px-4 py-2.5 text-xs font-bold text-indigo-200 hover:text-white hover:bg-indigo-800 rounded-lg transition uppercase tracking-wider">
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                        Data Bahan Baku
                    </a>
                </div>
            </div>

            {{-- Transaksi & Pergerakan --}}
            <p class="text-[10px] font-black text-indigo-400 uppercase px-2 mt-4 mb-2 tracking-widest">Transaksi & Gudang</p>

            <a href="{{ route('admin.transaksi.index') }}" class="flex items-center space-x-3 px-4 py-3 rounded-xl transition {{ request()->routeIs('admin.transaksi.*') ? 'bg-indigo-700 text-white' : 'hover:bg-indigo-800 text-indigo-100' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                <span class="font-medium">Data Transaksi</span>
            </a>

            <a href="{{ route('admin.bahan-masuk-keluar.index') }}" class="flex items-center space-x-3 px-4 py-3 rounded-xl transition {{ request()->routeIs('admin.bahan-masuk-keluar.*') ? 'bg-indigo-700 text-white' : 'hover:bg-indigo-800 text-indigo-100' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"/></svg>
                <span class="font-medium">Bahan Masuk/Keluar</span>
            </a>

            <a href="{{ route('admin.pengeluaran-operasional.index') }}" class="flex items-center space-x-3 px-4 py-3 rounded-xl transition {{ request()->routeIs('admin.pengeluaran-operasional.*') ? 'bg-indigo-700 text-white' : 'hover:bg-indigo-800 text-indigo-100' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                <span class="font-medium">Pengeluaran Operasional</span>
            </a>

            {{-- Pesanan --}}
            <p class="text-[10px] font-black text-indigo-400 uppercase px-2 mt-4 mb-2 tracking-widest">Pesanan</p>

            <a href="{{ route('admin.pesanan.index') }}" class="flex items-center justify-between space-x-3 px-4 py-3 rounded-xl transition {{ request()->routeIs('admin.pesanan.index') ? 'bg-indigo-700 text-white' : 'hover:bg-indigo-800 text-indigo-100' }}">
                <div class="flex items-center space-x-3">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span class="font-medium">Antrean Pesanan</span>
                </div>
                <div class="flex items-center space-x-1">
                    @if($notif_antrean > 0)
                        <span class="inline-flex items-center justify-center min-w-[22px] h-[22px] px-1.5 text-[10px] font-black bg-yellow-400 text-yellow-900 rounded-full">{{ $notif_antrean }}</span>
                    @endif
                    @if($notif_verifikasi > 0)
                        <span class="inline-flex items-center justify-center min-w-[22px] h-[22px] px-1.5 text-[10px] font-black bg-orange-400 text-orange-900 rounded-full animate-pulse">{{ $notif_verifikasi }}</span>
                    @endif
                </div>
            </a>

            <a href="{{ route('admin.pesanan.selesai') }}" class="flex items-center justify-between space-x-3 px-4 py-3 rounded-xl transition {{ request()->routeIs('admin.pesanan.selesai') ? 'bg-indigo-700 text-white' : 'hover:bg-indigo-800 text-indigo-100' }}">
                <div class="flex items-center space-x-3">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                    <span class="font-medium">Riwayat Selesai</span>
                </div>
                @if($notif_selesai > 0)
                    <span class="inline-flex items-center justify-center min-w-[22px] h-[22px] px-1.5 text-[10px] font-black bg-emerald-400 text-emerald-900 rounded-full">{{ $notif_selesai }}</span>
                @endif
            </a>

            {{-- Laporan --}}
            <p class="text-[10px] font-black text-indigo-400 uppercase px-2 mt-4 mb-2 tracking-widest">Laporan</p>

            <div class="relative">
                <button @click="openLaporan = !openLaporan" class="w-full flex items-center justify-between px-4 py-3 rounded-xl hover:bg-indigo-800 text-indigo-100 transition group">
                    <div class="flex items-center space-x-3">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        <span class="font-medium">Cetak Laporan</span>
                    </div>
                    <svg class="w-4 h-4 transition-transform duration-200" :class="openLaporan ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </button>

                <div x-show="openLaporan" x-collapse class="mt-1 space-y-1 bg-indigo-950/50 rounded-2xl p-2 border border-indigo-800">
                    <a href="{{ route('admin.laporan.penjualan') }}" target="_blank" class="block px-4 py-2 text-xs font-bold text-indigo-200 hover:text-white hover:bg-indigo-800 rounded-lg transition uppercase tracking-wider">1. Penjualan & Omzet</a>
                    <a href="{{ route('admin.laporan.bahan') }}" target="_blank" class="block px-4 py-2 text-xs font-bold text-indigo-200 hover:text-white hover:bg-indigo-800 rounded-lg transition uppercase tracking-wider">2. Pemakaian Bahan</a>
                    <a href="{{ route('admin.laporan.terlaris') }}" target="_blank" class="block px-4 py-2 text-xs font-bold text-indigo-200 hover:text-white hover:bg-indigo-800 rounded-lg transition uppercase tracking-wider">3. Produk Terlaris</a>
                    <a href="{{ route('admin.laporan.topPelanggan') }}" target="_blank" class="block px-4 py-2 text-xs font-bold text-indigo-200 hover:text-white hover:bg-indigo-800 rounded-lg transition uppercase tracking-wider">4. Top Pelanggan</a>
                    <a href="{{ route('admin.laporan.pembatalan') }}" target="_blank" class="block px-4 py-2 text-xs font-bold text-indigo-200 hover:text-white hover:bg-indigo-800 rounded-lg transition uppercase tracking-wider">5. Log Pembatalan</a>
                    <a href="{{ route('admin.laporan.stok') }}" target="_blank" class="block px-4 py-2 text-xs font-bold text-indigo-200 hover:text-white hover:bg-indigo-800 rounded-lg transition uppercase tracking-wider">6. Laporan Stok</a>
                    <a href="{{ route('admin.laporan.retur') }}" target="_blank" class="block px-4 py-2 text-xs font-bold text-indigo-200 hover:text-white hover:bg-indigo-800 rounded-lg transition uppercase tracking-wider">7. Laporan Retur</a>
                </div>
            </div>

            {{-- Notifikasi Stok --}}
            @if($notif_stok > 0)
            <a href="{{ route('admin.bahan.index') }}" class="flex items-center justify-between space-x-3 px-4 py-3 mt-2 rounded-xl bg-red-500/20 text-red-300 hover:bg-red-500 hover:text-white transition-all animate-pulse-slow">
                <div class="flex items-center space-x-3">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"/></svg>
                    <span class="font-medium">Stok Menipis!</span>
                </div>
                <span class="inline-flex items-center justify-center min-w-[22px] h-[22px] px-1.5 text-[10px] font-black bg-red-400 text-red-900 rounded-full">{{ $notif_stok }}</span>
            </a>
            @endif

        @else
            {{-- Menu Pelanggan --}}
            <p class="text-[10px] font-black text-indigo-400 uppercase px-2 mb-4 tracking-widest">Menu Pelanggan</p>

            <a href="{{ route('dashboard') }}" class="flex items-center space-x-3 px-4 py-3 rounded-xl transition {{ request()->routeIs('dashboard') ? 'bg-indigo-700 text-white' : 'hover:bg-indigo-800 text-indigo-100' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                <span class="font-medium">Dashboard Saya</span>
            </a>

            <a href="{{ route('katalog.index') }}" class="flex items-center space-x-3 px-4 py-3 rounded-xl hover:bg-indigo-800 text-indigo-100 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                <span class="font-medium">Pesan Produk</span>
            </a>

            <a href="{{ route('keranjang.index') }}" class="flex items-center space-x-3 px-4 py-3 rounded-xl transition {{ request()->routeIs('keranjang.index') ? 'bg-indigo-700 text-white' : 'hover:bg-indigo-800 text-indigo-100' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                <span class="font-medium">Keranjang Belanja</span>
            </a>

            <a href="{{ route('pesanan.riwayat') }}" class="flex items-center space-x-3 px-4 py-3 rounded-xl transition {{ request()->routeIs('pesanan.riwayat') ? 'bg-indigo-700 text-white' : 'hover:bg-indigo-800 text-indigo-100' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                <span class="font-medium">Riwayat Pesanan</span>
            </a>
        @endif
    </div>

    <div class="flex-none p-4 border-t border-indigo-800 bg-indigo-950">
        <a href="{{ route('profile.edit') }}" class="flex items-center space-x-3 px-2 py-2 mb-4 rounded-xl hover:bg-indigo-800/50 transition cursor-pointer group">
            @if(Auth::user()->foto)
                <div class="w-10 h-10 rounded-full overflow-hidden shadow-inner group-hover:scale-110 transition-transform">
                    <img src="{{ asset('storage/'.Auth::user()->foto) }}" class="w-full h-full object-cover">
                </div>
            @else
                <div class="w-10 h-10 rounded-full bg-indigo-500 flex items-center justify-center font-extrabold uppercase shadow-inner group-hover:scale-110 transition-transform">
                    {{ substr(Auth::user()->name, 0, 1) }}
                </div>
            @endif
            <div class="flex-1 overflow-hidden">
                <p class="text-sm font-bold truncate group-hover:text-indigo-200 transition-colors">{{ Auth::user()->name }}</p>
                <p class="text-[10px] uppercase font-bold text-indigo-400 tracking-widest group-hover:text-indigo-300">Edit Profil & Sandi</p>
            </div>
        </a>
        
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="w-full flex items-center space-x-3 px-4 py-2 rounded-lg bg-red-500/10 text-red-400 hover:bg-red-500 hover:text-white transition-all font-bold text-xs uppercase tracking-widest">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                <span>Log Out</span>
            </button>
        </form>
    </div>
</nav>

<style>
    .custom-scrollbar::-webkit-scrollbar {
        width: 4px;
    }
    .custom-scrollbar::-webkit-scrollbar-track {
        background: transparent;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: rgba(255, 255, 255, 0.1);
        border-radius: 10px;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background: rgba(255, 255, 255, 0.2);
    }
</style>
