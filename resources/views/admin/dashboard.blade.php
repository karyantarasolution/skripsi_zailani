<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-black text-2xl text-gray-900 uppercase tracking-tight">
                Dashboard
            </h2>
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
                        Anda login sebagai <span class="text-white font-black uppercase bg-indigo-800 px-3 py-1 rounded-lg ml-1">{{ str_replace('_', ' ', Auth::user()->role) }}</span>. 
                        Berikut adalah ringkasan operasional toko hari ini.
                    </p>
                </div>
            </div>

            {{-- Stat Cards --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                {{-- Pesanan Aktif --}}
                <a href="{{ route('admin.pesanan.index') }}" class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100 flex items-center gap-6 transform hover:-translate-y-1 transition-all relative overflow-hidden group cursor-pointer">
                    @if($stats['pesanan_aktif'] > 0)
                        <div class="absolute top-0 right-0 w-2 h-full bg-blue-400 animate-pulse"></div>
                    @endif
                    <div class="w-16 h-16 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center group-hover:scale-110 transition-transform shrink-0">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                    </div>
                    <div class="flex-1">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Pesanan Aktif</p>
                                <h4 class="text-2xl font-black text-gray-950">{{ $stats['pesanan_aktif'] }} Pesanan</h4>
                            </div>
                            <span class="px-4 py-2 text-xs font-black uppercase bg-indigo-50 text-indigo-600 rounded-xl group-hover:bg-indigo-600 group-hover:text-white transition-all">Kelola &rarr;</span>
                        </div>
                    </div>
                </a>

                {{-- Pesanan Selesai --}}
                <a href="{{ route('admin.pesanan.selesai') }}" class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100 flex items-center gap-6 transform hover:-translate-y-1 transition-all relative overflow-hidden group cursor-pointer">
                    @if($stats['pesanan_selesai'] > 0)
                        <div class="absolute top-0 right-0 w-2 h-full bg-emerald-400 animate-pulse"></div>
                    @endif
                    <div class="w-16 h-16 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center group-hover:scale-110 transition-transform shrink-0">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div class="flex-1">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Pesanan Selesai</p>
                                <h4 class="text-2xl font-black text-gray-950">{{ $stats['pesanan_selesai'] }} Pesanan</h4>
                            </div>
                            <span class="px-4 py-2 text-xs font-black uppercase bg-emerald-50 text-emerald-600 rounded-xl group-hover:bg-emerald-600 group-hover:text-white transition-all">Lihat &rarr;</span>
                        </div>
                    </div>
                </a>

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

        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const omzetData = @json($stats['omzet_7_hari']);
            const statusData = @json($stats['status_counts']);

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
                'Verifikasi': '#f59e0b',
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
                    plugins: {
                        legend: { display: false }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(v) {
                                    return 'Rp' + v.toLocaleString('id-ID');
                                }
                            }
                        }
                    }
                }
            });

            new Chart(document.getElementById('statusChart'), {
                type: 'doughnut',
                data: {
                    labels: statusLabels,
                    datasets: [{
                        data: statusValues,
                        backgroundColor: statusColors,
                        borderWidth: 0,
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                font: { size: 11, weight: 'bold' },
                                padding: 12,
                            }
                        }
                    }
                }
            });
        });
    </script>
    @endpush
</x-app-layout>