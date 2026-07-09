<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-black text-2xl text-gray-900 uppercase tracking-tight">
                Dashboard
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

            @if(session('success'))
                <div class="p-5 bg-emerald-50 border-2 border-emerald-200 text-emerald-700 rounded-3xl font-black uppercase tracking-wider text-sm flex items-center gap-3">
                    <svg class="w-6 h-6 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span>{{ session('success') }}</span>
                </div>
            @endif
            
            <div class="bg-indigo-950 rounded-3xl p-8 text-white shadow-xl relative overflow-hidden border border-indigo-900">
                <div class="absolute -top-24 -right-24 w-64 h-64 bg-indigo-600 rounded-full blur-3xl opacity-20"></div>
                <div class="relative z-10">
                    <h3 class="text-2xl font-black uppercase tracking-tighter mb-2">Selamat Datang, {{ Auth::user()->name }}!</h3>
                    <p class="text-indigo-300 font-medium text-sm">
                        Anda login sebagai <span class="text-white font-black uppercase bg-indigo-800 px-3 py-1 rounded-lg ml-1">{{ Auth::user()->role == 'admin' ? 'Administrator' : 'Pegawai' }}</span>. 
                        Berikut adalah ringkasan operasional toko.
                    </p>
                </div>
            </div>

            {{-- Notifikasi Stok Menipis --}}
            @if($stats['total_stok_kritis'] > 0)
            <div class="p-5 bg-red-50 border-2 border-red-200 text-red-700 rounded-3xl">
                <div class="flex items-center gap-3">
                    <svg class="w-6 h-6 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"/></svg>
                    <div>
                        <p class="font-black uppercase tracking-wider text-sm">Stok Bahan Baku Menipis!</p>
                        <p class="text-sm font-medium mt-1">Terdapat {{ $stats['total_stok_kritis'] }} bahan yang stoknya di bawah batas minimum. Segera lakukan restock.</p>
                    </div>
                    <a href="{{ route('admin.bahan.index') }}" class="ml-auto px-4 py-2 bg-red-600 text-white rounded-xl font-black text-xs uppercase tracking-wider hover:bg-red-700 transition shrink-0">Lihat</a>
                </div>
            </div>
            @endif

            {{-- Stat Cards --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <a href="{{ route('admin.pesanan.index') }}" class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-4 hover:-translate-y-1 transition-all relative overflow-hidden group">
                    @if($stats['pesanan_aktif'] > 0)
                        <div class="absolute top-0 right-0 w-2 h-full bg-blue-400 animate-pulse"></div>
                    @endif
                    <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center group-hover:scale-110 transition-transform shrink-0">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                    </div>
                    <div>
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Pesanan Aktif</p>
                        <p class="text-2xl font-black text-gray-950">{{ $stats['pesanan_aktif'] }}</p>
                    </div>
                </a>

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

                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-orange-50 text-orange-600 flex items-center justify-center shrink-0">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div>
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Pengeluaran (Bln Ini)</p>
                        <p class="text-lg font-black text-gray-950">Rp{{ number_format($stats['pengeluaran_bulan_ini'], 0, ',', '.') }}</p>
                    </div>
                </div>
            </div>

            {{-- Grafik Section --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100">
                    <h4 class="font-black text-gray-950 uppercase tracking-tighter mb-6">Grafik Omzet 7 Hari Terakhir</h4>
                    <canvas id="omzetChart" height="200"></canvas>
                </div>
                <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100">
                    <h4 class="font-black text-gray-950 uppercase tracking-tighter mb-6">Grafik Status Pesanan</h4>
                    <canvas id="statusChart" height="200"></canvas>
                </div>
            </div>

            {{-- Grafik Pengeluaran --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100">
                    <h4 class="font-black text-gray-950 uppercase tracking-tighter mb-6">Pengeluaran per Kategori (Bulan Ini)</h4>
                    <canvas id="pengeluaranChart" height="200"></canvas>
                </div>
                <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100">
                    <h4 class="font-black text-gray-950 uppercase tracking-tighter mb-6">Pengeluaran 7 Hari Terakhir</h4>
                    <canvas id="pengeluaranLineChart" height="200"></canvas>
                </div>
            </div>

            {{-- Riwayat Login --}}
            @if(Auth::user()->isAdmin())
            <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100">
                <h4 class="font-black text-gray-950 uppercase tracking-tighter mb-6">Riwayat Login Staf</h4>
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="text-[10px] font-black text-gray-400 uppercase tracking-widest">
                                <th class="pb-3">Nama</th>
                                <th class="pb-3">Waktu Login</th>
                                <th class="pb-3">IP Address</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($stats['riwayat_login'] as $log)
                            <tr class="text-sm">
                                <td class="py-3 font-bold text-gray-900">{{ $log->user->name }}</td>
                                <td class="py-3 text-gray-600">{{ $log->created_at->diffForHumans() }}</td>
                                <td class="py-3 text-gray-500 font-mono text-xs">{{ $log->ip_address }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="py-6 text-center text-gray-400 font-medium">Belum ada riwayat login.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            @endif

            {{-- Stok Menipis --}}
            @if($stats['total_stok_kritis'] > 0)
            <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100">
                <h4 class="font-black text-gray-950 uppercase tracking-tighter mb-6">Bahan Baku Stok Menipis</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($stats['stok_menipis'] as $b)
                    <div class="p-4 bg-red-50 rounded-2xl border border-red-100">
                        <p class="font-black text-gray-900 uppercase text-sm">{{ $b->nama_bahan }}</p>
                        <p class="text-xs text-gray-500 mt-1">Stok: <span class="font-black text-red-600">{{ $b->stok }} {{ $b->satuan }}</span> (Min: {{ $b->minimum_stok }})</p>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const omzetData = @json($stats['omzet_7_hari']);
            const statusData = @json($stats['status_counts']);
            const pengeluaranKategori = @json($stats['pengeluaran_per_kategori']);
            const pengeluaran7Hari = @json($stats['pengeluaran_7_hari']);

            const labels7 = [];
            const values7 = [];
            const today = new Date();
            for (let i = 6; i >= 0; i--) {
                const d = new Date(today);
                d.setDate(d.getDate() - i);
                const key = d.toISOString().split('T')[0];
                const dayName = d.toLocaleDateString('id-ID', { weekday: 'short' });
                labels7.push(dayName);
                values7.push(omzetData[key] || 0);
            }

            const statusLabels = [];
            const statusValues = [];
            const statusColors = [];
            const colorMap = {
                'Menunggu Pembayaran': '#f59e0b',
                'Verifikasi': '#f97316',
                'Antrean Cetak': '#3b82f6',
                'Produksi': '#8b5cf6',
                'Siap Ambil': '#10b981',
                'Sedang Dikirim': '#06b6d4',
                'Selesai': '#059669',
                'Dibatalkan': '#ef4444',
            };
            for (const [k, v] of Object.entries(statusData)) {
                statusLabels.push(k);
                statusValues.push(v);
                statusColors.push(colorMap[k] || '#6b7280');
            }

            new Chart(document.getElementById('omzetChart'), {
                type: 'bar',
                data: {
                    labels: labels7,
                    datasets: [{
                        label: 'Omzet (Rp)',
                        data: values7,
                        backgroundColor: 'rgba(99, 102, 241, 0.7)',
                        borderColor: 'rgba(99, 102, 241, 1)',
                        borderWidth: 2,
                        borderRadius: 8,
                    }]
                },
                options: {
                    responsive: true,
                    plugins: { legend: { display: false } },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(v) { return 'Rp' + v.toLocaleString('id-ID'); }
                            }
                        }
                    }
                }
            });

            new Chart(document.getElementById('statusChart'), {
                type: 'doughnut',
                data: {
                    labels: statusLabels,
                    datasets: [{ data: statusValues, backgroundColor: statusColors, borderWidth: 0 }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: { font: { size: 11, weight: 'bold' }, padding: 12 }
                        }
                    }
                }
            });

            // Pengeluaran per kategori (pie)
            const pKategoriLabels = Object.keys(pengeluaranKategori);
            const pKategoriValues = Object.values(pengeluaranKategori);
            const warnaKategori = ['#ef4444', '#f97316', '#f59e0b', '#10b981', '#06b6d4', '#3b82f6', '#8b5cf6', '#ec4899', '#6366f1', '#6b7280'];

            new Chart(document.getElementById('pengeluaranChart'), {
                type: 'pie',
                data: {
                    labels: pKategoriLabels,
                    datasets: [{
                        data: pKategoriValues,
                        backgroundColor: warnaKategori.slice(0, pKategoriLabels.length),
                        borderWidth: 0,
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: { font: { size: 10, weight: 'bold' }, padding: 10 }
                        }
                    }
                }
            });

            // Pengeluaran 7 hari (line)
            const pLabels7 = [];
            const pValues7 = [];
            for (let i = 6; i >= 0; i--) {
                const d = new Date(today);
                d.setDate(d.getDate() - i);
                const key = d.toISOString().split('T')[0];
                const dayName = d.toLocaleDateString('id-ID', { weekday: 'short' });
                pLabels7.push(dayName);
                pValues7.push(pengeluaran7Hari[key] || 0);
            }

            new Chart(document.getElementById('pengeluaranLineChart'), {
                type: 'line',
                data: {
                    labels: pLabels7,
                    datasets: [{
                        label: 'Pengeluaran (Rp)',
                        data: pValues7,
                        borderColor: '#ef4444',
                        backgroundColor: 'rgba(239, 68, 68, 0.1)',
                        borderWidth: 2,
                        fill: true,
                        tension: 0.4,
                    }]
                },
                options: {
                    responsive: true,
                    plugins: { legend: { display: false } },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(v) { return 'Rp' + v.toLocaleString('id-ID'); }
                            }
                        }
                    }
                }
            });

        });
    </script>
    @endpush
</x-app-layout>
