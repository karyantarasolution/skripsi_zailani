<nav x-data="{ open: false, openLaporan: false, openData: false }" class="sidebar-cosmic w-64 h-screen fixed left-0 top-0 hidden lg:flex flex-col z-50">
    <div class="p-6 border-b border-white/5 flex-none relative">
        <a href="{{ Auth::user()->isAdmin() ? route('admin.dashboard') : (Auth::user()->isPegawai() ? route('pegawai.dashboard') : route('dashboard')) }}" class="flex items-center space-x-3 group">
            <div class="bg-gradient-to-br from-purple-500/20 to-cyan-500/20 p-2.5 rounded-xl border border-purple-500/20 transform group-hover:rotate-12 transition-transform duration-300 shadow-lg shadow-purple-500/10">
                <img src="{{ asset('images/orbit.png') }}" class="h-8 w-8" alt="Logo">
            </div>
            <div>
                <span class="text-lg font-black tracking-wider uppercase gradient-text">Orbit</span>
                <span class="text-lg font-black tracking-wider uppercase text-white/80"> Digital</span>
            </div>
        </a>
    </div>

    <div class="flex-1 overflow-y-auto px-4 py-6 space-y-1.5">
        @if(Auth::user()->isAdmin())
            @php
                $notif_antrean = \App\Models\Pesanan::where('status', 'Antrean Cetak')->count();
                $notif_selesai = \App\Models\Pesanan::where('status', 'Selesai')->count();
                $notif_verifikasi = \App\Models\Pesanan::where('status', 'Verifikasi')->count();
                $notif_stok = \App\Models\BahanBaku::whereColumn('stok', '<=', 'minimum_stok')->count();
            @endphp

            <p class="section-title mb-3">Admin Panel</p>

            <a href="{{ route('admin.dashboard') }}" class="sidebar-item {{ request()->routeIs('admin.dashboard') ? 'sidebar-item-active' : '' }}">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                <span class="font-medium">Dashboard Admin</span>
            </a>

            <div class="relative">
                <button @click="openData = !openData" class="sidebar-item w-full justify-between">
                    <div class="flex items-center space-x-3">
                        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4"/></svg>
                        <span class="font-medium">Data Master</span>
                    </div>
                    <svg class="w-4 h-4 transition-transform duration-200" :class="openData ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </button>

                <div x-show="openData" x-collapse class="mt-1 space-y-1 ml-4 pl-3 border-l border-purple-500/20">
                    <a href="{{ route('admin.pegawai.index') }}" class="sidebar-item {{ request()->routeIs('admin.pegawai.*') ? 'sidebar-item-active' : '' }}">
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                        <span class="font-medium text-xs">Data Pegawai</span>
                    </a>
                    <a href="{{ route('admin.pelanggan.index') }}" class="sidebar-item {{ request()->routeIs('admin.pelanggan.*') ? 'sidebar-item-active' : '' }}">
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        <span class="font-medium text-xs">Data Pelanggan</span>
                    </a>
                    <a href="{{ route('admin.supplier.index') }}" class="sidebar-item {{ request()->routeIs('admin.supplier.*') ? 'sidebar-item-active' : '' }}">
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                        <span class="font-medium text-xs">Data Supplier</span>
                    </a>
                    <a href="{{ route('admin.produk.index') }}" class="sidebar-item {{ request()->routeIs('admin.produk.*') ? 'sidebar-item-active' : '' }}">
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                        <span class="font-medium text-xs">Data Produk</span>
                    </a>
                    <a href="{{ route('admin.bahan.index') }}" class="sidebar-item {{ request()->routeIs('admin.bahan.*') ? 'sidebar-item-active' : '' }}">
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                        <span class="font-medium text-xs">Data Bahan Baku</span>
                    </a>
                </div>
            </div>

            <p class="section-title mt-5 mb-3">Transaksi & Gudang</p>

            <a href="{{ route('admin.transaksi.index') }}" class="sidebar-item {{ request()->routeIs('admin.transaksi.*') ? 'sidebar-item-active' : '' }}">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                <span class="font-medium">Data Transaksi</span>
            </a>

            <a href="{{ route('admin.bahan-masuk-keluar.index') }}" class="sidebar-item {{ request()->routeIs('admin.bahan-masuk-keluar.*') ? 'sidebar-item-active' : '' }}">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"/></svg>
                <span class="font-medium">Bahan Masuk/Keluar</span>
            </a>

            <a href="{{ route('admin.pengeluaran-operasional.index') }}" class="sidebar-item {{ request()->routeIs('admin.pengeluaran-operasional.*') ? 'sidebar-item-active' : '' }}">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                <span class="font-medium">Pengeluaran</span>
            </a>

            <p class="section-title mt-5 mb-3">Pesanan</p>

            <a href="{{ route('admin.pesanan.index') }}" class="sidebar-item justify-between {{ request()->routeIs('admin.pesanan.index') ? 'sidebar-item-active' : '' }}">
                <div class="flex items-center space-x-3">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span class="font-medium">Antrean Pesanan</span>
                </div>
                <div class="flex items-center space-x-1">
                    @if($notif_antrean > 0)
                        <span class="inline-flex items-center justify-center min-w-[20px] h-5 px-1.5 text-[9px] font-black bg-yellow-400/90 text-yellow-900 rounded-full">{{ $notif_antrean }}</span>
                    @endif
                    @if($notif_verifikasi > 0)
                        <span class="inline-flex items-center justify-center min-w-[20px] h-5 px-1.5 text-[9px] font-black bg-orange-400/90 text-orange-900 rounded-full animate-pulse">{{ $notif_verifikasi }}</span>
                    @endif
                </div>
            </a>

            <a href="{{ route('admin.pesanan.selesai') }}" class="sidebar-item justify-between {{ request()->routeIs('admin.pesanan.selesai') ? 'sidebar-item-active' : '' }}">
                <div class="flex items-center space-x-3">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                    <span class="font-medium">Riwayat Selesai</span>
                </div>
                @if($notif_selesai > 0)
                    <span class="inline-flex items-center justify-center min-w-[20px] h-5 px-1.5 text-[9px] font-black bg-emerald-400/90 text-emerald-900 rounded-full">{{ $notif_selesai }}</span>
                @endif
            </a>

            <p class="section-title mt-5 mb-3">Laporan</p>

            <div class="relative">
                <button @click="openLaporan = !openLaporan" class="sidebar-item w-full justify-between">
                    <div class="flex items-center space-x-3">
                        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        <span class="font-medium">Cetak Laporan</span>
                    </div>
                    <svg class="w-4 h-4 transition-transform duration-200" :class="openLaporan ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </button>

                <div x-show="openLaporan" x-collapse class="mt-1 space-y-1 ml-4 pl-3 border-l border-purple-500/20">
                    <a href="{{ route('admin.laporan.penjualan') }}" target="_blank" class="sidebar-item text-xs">1. Penjualan & Omzet</a>
                    <a href="{{ route('admin.laporan.bahan') }}" target="_blank" class="sidebar-item text-xs">2. Pemakaian Bahan</a>
                    <a href="{{ route('admin.laporan.terlaris') }}" target="_blank" class="sidebar-item text-xs">3. Produk Terlaris</a>
                    <a href="{{ route('admin.laporan.topPelanggan') }}" target="_blank" class="sidebar-item text-xs">4. Top Pelanggan</a>
                    <a href="{{ route('admin.laporan.pembatalan') }}" target="_blank" class="sidebar-item text-xs">5. Log Pembatalan</a>
                    <a href="{{ route('admin.laporan.stok') }}" target="_blank" class="sidebar-item text-xs">6. Laporan Stok Bahan Baku</a>
                    <a href="{{ route('admin.laporan.stokBarang') }}" target="_blank" class="sidebar-item text-xs">7. Laporan Stok Barang</a>
                    <a href="{{ route('admin.laporan.retur') }}" target="_blank" class="sidebar-item text-xs">8. Laporan Retur</a>
                </div>
            </div>

            @if($notif_stok > 0)
            <a href="{{ route('admin.bahan.index') }}" class="sidebar-item mt-3 bg-red-500/10 text-red-300 border border-red-500/20 hover:bg-red-500/20 hover:text-red-200">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"/></svg>
                <span class="font-medium">Stok Menipis!</span>
                <span class="inline-flex items-center justify-center min-w-[20px] h-5 px-1.5 text-[9px] font-black bg-red-400 text-white rounded-full ml-auto">{{ $notif_stok }}</span>
            </a>
            @endif

        @elseif(Auth::user()->isPegawai())
            @php
                $notif_antrean = \App\Models\Pesanan::where('status', 'Antrean Cetak')->count();
                $notif_selesai = \App\Models\Pesanan::where('status', 'Selesai')->count();
                $notif_stok = \App\Models\BahanBaku::whereColumn('stok', '<=', 'minimum_stok')->count();
            @endphp

            <p class="section-title mb-3">Menu Pegawai</p>

            <a href="{{ route('pegawai.dashboard') }}" class="sidebar-item {{ request()->routeIs('pegawai.dashboard') ? 'sidebar-item-active' : '' }}">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                <span class="font-medium">Dashboard Saya</span>
            </a>

            <p class="section-title mt-5 mb-3">Pesanan</p>

            <a href="{{ route('admin.pesanan.index') }}" class="sidebar-item justify-between {{ request()->routeIs('admin.pesanan.index') ? 'sidebar-item-active' : '' }}">
                <div class="flex items-center space-x-3">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span class="font-medium">Antrean Pesanan</span>
                </div>
                @if($notif_antrean > 0)
                    <span class="inline-flex items-center justify-center min-w-[20px] h-5 px-1.5 text-[9px] font-black bg-yellow-400/90 text-yellow-900 rounded-full">{{ $notif_antrean }}</span>
                @endif
            </a>

            <a href="{{ route('admin.pesanan.selesai') }}" class="sidebar-item justify-between {{ request()->routeIs('admin.pesanan.selesai') ? 'sidebar-item-active' : '' }}">
                <div class="flex items-center space-x-3">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                    <span class="font-medium">Riwayat Selesai</span>
                </div>
                @if($notif_selesai > 0)
                    <span class="inline-flex items-center justify-center min-w-[20px] h-5 px-1.5 text-[9px] font-black bg-emerald-400/90 text-emerald-900 rounded-full">{{ $notif_selesai }}</span>
                @endif
            </a>

            <p class="section-title mt-5 mb-3">Persediaan</p>

            <a href="{{ route('admin.bahan.index') }}" class="sidebar-item justify-between {{ request()->routeIs('admin.bahan.*') ? 'sidebar-item-active' : '' }}">
                <div class="flex items-center space-x-3">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                    <span class="font-medium">Data Bahan Baku</span>
                </div>
                @if($notif_stok > 0)
                    <span class="inline-flex items-center justify-center min-w-[20px] h-5 px-1.5 text-[9px] font-black bg-red-400/90 text-white rounded-full">{{ $notif_stok }}</span>
                @endif
            </a>

            <a href="{{ route('admin.bahan-masuk-keluar.index') }}" class="sidebar-item {{ request()->routeIs('admin.bahan-masuk-keluar.*') ? 'sidebar-item-active' : '' }}">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"/></svg>
                <span class="font-medium">Bahan Masuk/Keluar</span>
            </a>

        @else
            <p class="section-title mb-3">Menu Pelanggan</p>

            <a href="{{ route('dashboard') }}" class="sidebar-item {{ request()->routeIs('dashboard') ? 'sidebar-item-active' : '' }}">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                <span class="font-medium">Dashboard Saya</span>
            </a>

            <a href="{{ route('katalog.index') }}" class="sidebar-item {{ request()->routeIs('katalog.*') ? 'sidebar-item-active' : '' }}">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                <span class="font-medium">Pesan Produk</span>
            </a>

            <a href="{{ route('keranjang.index') }}" class="sidebar-item {{ request()->routeIs('keranjang.index') ? 'sidebar-item-active' : '' }}">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                <span class="font-medium">Keranjang Belanja</span>
            </a>

            <a href="{{ route('pesanan.riwayat') }}" class="sidebar-item {{ request()->routeIs('pesanan.riwayat') ? 'sidebar-item-active' : '' }}">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                <span class="font-medium">Riwayat Pesanan</span>
            </a>
        @endif
    </div>

    <div class="flex-none p-4 border-t border-white/5">
        <a href="{{ route('profile.edit') }}" class="flex items-center space-x-3 px-2 py-2.5 rounded-xl hover:bg-white/5 transition group">
            @if(Auth::user()->foto)
                <div class="w-10 h-10 rounded-xl overflow-hidden border border-purple-500/30 group-hover:border-purple-400/50 transition-all group-hover:shadow-lg group-hover:shadow-purple-500/20">
                    <img src="{{ asset('storage/'.Auth::user()->foto) }}" class="w-full h-full object-cover">
                </div>
            @else
                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-purple-500/30 to-cyan-500/30 border border-purple-500/30 flex items-center justify-center font-extrabold uppercase text-purple-300 group-hover:shadow-lg group-hover:shadow-purple-500/20 transition-all">
                    {{ substr(Auth::user()->name, 0, 1) }}
                </div>
            @endif
            <div class="flex-1 overflow-hidden">
                <p class="text-sm font-bold truncate text-white/90 group-hover:text-white transition-colors">{{ Auth::user()->name }}</p>
                <p class="text-[10px] uppercase font-bold tracking-widest gradient-text group-hover:opacity-100 opacity-70 transition-opacity">
                    {{ Auth::user()->isAdmin() ? 'Administrator' : (Auth::user()->isPegawai() ? 'Pegawai' : 'Pelanggan') }}
                </p>
            </div>
        </a>
        
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="w-full flex items-center space-x-3 px-4 py-2.5 rounded-xl bg-red-500/10 text-red-400/80 hover:bg-red-500/20 hover:text-red-300 transition-all font-bold text-xs uppercase tracking-widest mt-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                <span>Log Out</span>
            </button>
        </form>
    </div>
</nav>

<style>
    .custom-scrollbar::-webkit-scrollbar { width: 4px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: rgba(168, 85, 247, 0.2); border-radius: 10px; }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: rgba(168, 85, 247, 0.4); }
</style>
