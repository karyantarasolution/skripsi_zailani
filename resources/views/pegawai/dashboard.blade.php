<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-black text-2xl text-gray-900 uppercase tracking-tight">
                Dashboard Pegawai
            </h2>
            <div class="flex items-center gap-3 text-sm">
                <span class="text-gray-500 font-medium">{{ now()->isoFormat('dddd, D MMMM Y') }}</span>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if(session('error'))
                <div class="p-5 bg-red-50 border-2 border-red-200 text-red-700 rounded-3xl font-black uppercase tracking-wider text-sm flex items-center gap-3">
                    <svg class="w-6 h-6 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            {{-- Welcome Banner --}}
            <div class="bg-indigo-950 rounded-3xl p-8 text-white shadow-xl relative overflow-hidden border border-indigo-900">
                <div class="absolute -top-24 -right-24 w-64 h-64 bg-indigo-600 rounded-full blur-3xl opacity-20"></div>
                <div class="relative z-10 flex items-center justify-between">
                    <div>
                        <h3 class="text-2xl font-black uppercase tracking-tighter mb-2">Selamat Datang, {{ $user->name }}!</h3>
                        <p class="text-indigo-300 font-medium text-sm">
                            Anda login sebagai <span class="text-white font-black uppercase bg-indigo-800 px-3 py-1 rounded-lg ml-1">Pegawai</span>.
                            Berikut ringkasan pekerjaan hari ini.
                        </p>
                    </div>
                    <a href="{{ route('profile.edit') }}" class="hidden md:flex items-center gap-2 px-5 py-3 bg-indigo-600 hover:bg-indigo-500 rounded-xl font-black text-xs uppercase tracking-widest transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        Lengkapi Profil
                    </a>
                </div>
            </div>

            {{-- Profile Completion --}}
            @if($stats['profile_completion'] < 100)
            <div class="bg-amber-50 border-2 border-amber-200 rounded-3xl p-6">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-amber-100 text-amber-600 flex items-center justify-center shrink-0">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"/></svg>
                    </div>
                    <div class="flex-1">
                        <p class="font-black text-sm text-amber-900 uppercase tracking-wider">Profil Belum Lengkap</p>
                        <p class="text-sm text-amber-700 mt-1">Lengkapi data diri Anda sesuai KTP agar informasi akun lebih lengkap.</p>
                        <div class="mt-2 w-full bg-amber-200 rounded-full h-2">
                            <div class="bg-amber-500 h-2 rounded-full transition-all" style="width: {{ $stats['profile_completion'] }}%"></div>
                        </div>
                        <p class="text-xs text-amber-600 mt-1 font-bold">{{ $stats['profile_completion'] }}% terisi</p>
                    </div>
                    <a href="{{ route('profile.edit') }}" class="px-4 py-2 bg-amber-500 text-white rounded-xl font-black text-xs uppercase tracking-wider hover:bg-amber-600 transition shrink-0">Lengkapi</a>
                </div>
            </div>
            @endif

            {{-- Stat Cards --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                    </div>
                    <div>
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Pesanan Aktif</p>
                        <p class="text-2xl font-black text-gray-950">{{ $stats['pesanan_aktif'] }}</p>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div>
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Selesai</p>
                        <p class="text-2xl font-black text-gray-950">{{ $stats['pesanan_selesai'] }}</p>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center shrink-0">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    </div>
                    <div>
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Pelanggan</p>
                        <p class="text-2xl font-black text-gray-950">{{ $stats['total_pelanggan'] }}</p>
                    </div>
                </div>
            </div>

            @if($stats['stok_menipis'] > 0)
            <div class="p-5 bg-amber-50 border-2 border-amber-200 text-amber-700 rounded-3xl flex items-center gap-3">
                <svg class="w-6 h-6 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"/></svg>
                <p class="font-bold text-sm">Terdapat {{ $stats['stok_menipis'] }} bahan baku yang stoknya menipis.</p>
            </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                {{-- Pesanan Terbaru --}}
                <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100">
                    <h4 class="font-black text-gray-950 uppercase tracking-tighter mb-6">Pesanan Terbaru (Perlu Diproses)</h4>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left">
                            <thead>
                                <tr class="text-[10px] font-black text-gray-400 uppercase tracking-widest">
                                    <th class="pb-3">Invoice</th>
                                    <th class="pb-3">Pelanggan</th>
                                    <th class="pb-3">Status</th>
                                    <th class="pb-3 text-right">Total</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse($stats['pesanan_terbaru'] as $p)
                                <tr class="text-sm">
                                    <td class="py-3 font-bold text-gray-900 font-mono text-xs">{{ $p->nomor_invoice }}</td>
                                    <td class="py-3 text-gray-600">{{ $p->user->name ?? '-' }}</td>
                                    <td class="py-3">
                                        @php
                                            $badgeClass = match($p->status) {
                                                'Menunggu Pembayaran' => 'bg-yellow-100 text-yellow-700',
                                                'Verifikasi' => 'bg-orange-100 text-orange-700',
                                                'Antrean Cetak' => 'bg-blue-100 text-blue-700',
                                                'Produksi' => 'bg-purple-100 text-purple-700',
                                                'Siap Ambil' => 'bg-emerald-100 text-emerald-700',
                                                'Sedang Dikirim' => 'bg-cyan-100 text-cyan-700',
                                                'Dibatalkan' => 'bg-red-100 text-red-700',
                                                default => 'bg-gray-100 text-gray-700',
                                            };
                                        @endphp
                                        <span class="px-2 py-1 text-[10px] font-black uppercase tracking-wider rounded-lg {{ $badgeClass }}">{{ $p->status }}</span>
                                    </td>
                                    <td class="py-3 text-right font-bold text-gray-900">Rp{{ number_format($p->total_bayar, 0, ',', '.') }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="py-8 text-center text-gray-400 font-medium text-sm">Tidak ada pesanan aktif.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- Pesanan Selesai --}}
                <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100">
                    <h4 class="font-black text-gray-950 uppercase tracking-tighter mb-6">Riwayat Pesanan Selesai</h4>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left">
                            <thead>
                                <tr class="text-[10px] font-black text-gray-400 uppercase tracking-widest">
                                    <th class="pb-3">Invoice</th>
                                    <th class="pb-3">Pelanggan</th>
                                    <th class="pb-3">Tanggal</th>
                                    <th class="pb-3 text-right">Total</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse($stats['pesanan_selesai_list'] as $p)
                                <tr class="text-sm">
                                    <td class="py-3 font-bold text-gray-900 font-mono text-xs">{{ $p->nomor_invoice }}</td>
                                    <td class="py-3 text-gray-600">{{ $p->user->name ?? '-' }}</td>
                                    <td class="py-3 text-gray-500 text-xs">{{ $p->updated_at->format('d/m/Y') }}</td>
                                    <td class="py-3 text-right font-bold text-gray-900">Rp{{ number_format($p->total_bayar, 0, ',', '.') }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="py-8 text-center text-gray-400 font-medium text-sm">Belum ada pesanan selesai.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- Quick Actions --}}
            <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100">
                <h4 class="font-black text-gray-950 uppercase tracking-tighter mb-6">Aksi Cepat</h4>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <a href="{{ route('admin.pesanan.index') }}" class="p-4 bg-blue-50 rounded-2xl border border-blue-100 hover:-translate-y-1 transition-all text-center group">
                        <div class="w-10 h-10 rounded-xl bg-blue-100 text-blue-600 flex items-center justify-center mx-auto mb-3 group-hover:scale-110 transition-transform">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                        </div>
                        <p class="text-xs font-black uppercase tracking-wider text-gray-700">Antrean Pesanan</p>
                    </a>
                    <a href="{{ route('admin.pesanan.selesai') }}" class="p-4 bg-emerald-50 rounded-2xl border border-emerald-100 hover:-translate-y-1 transition-all text-center group">
                        <div class="w-10 h-10 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center mx-auto mb-3 group-hover:scale-110 transition-transform">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <p class="text-xs font-black uppercase tracking-wider text-gray-700">Riwayat Selesai</p>
                    </a>
                    <a href="{{ route('admin.bahan.index') }}" class="p-4 bg-orange-50 rounded-2xl border border-orange-100 hover:-translate-y-1 transition-all text-center group">
                        <div class="w-10 h-10 rounded-xl bg-orange-100 text-orange-600 flex items-center justify-center mx-auto mb-3 group-hover:scale-110 transition-transform">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                        </div>
                        <p class="text-xs font-black uppercase tracking-wider text-gray-700">Data Bahan</p>
                    </a>
                    <a href="{{ route('profile.edit') }}" class="p-4 bg-purple-50 rounded-2xl border border-purple-100 hover:-translate-y-1 transition-all text-center group">
                        <div class="w-10 h-10 rounded-xl bg-purple-100 text-purple-600 flex items-center justify-center mx-auto mb-3 group-hover:scale-110 transition-transform">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        </div>
                        <p class="text-xs font-black uppercase tracking-wider text-gray-700">Edit Profil</p>
                    </a>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
