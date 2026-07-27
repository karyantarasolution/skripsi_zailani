<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-2xl text-gray-900 uppercase tracking-tight">Monitoring Pesanan</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="flex flex-wrap items-center justify-between gap-4">
                <a href="{{ route('admin.dashboard') }}" class="text-xs font-black text-gray-400 uppercase hover:text-indigo-600 transition tracking-widest">&larr; Kembali</a>
                <a href="{{ route('admin.laporan.retur.pdf') }}" target="_blank" class="px-6 py-3 bg-red-600 text-white font-black uppercase text-xs tracking-widest rounded-xl hover:bg-red-500 transition shadow-lg flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    Download PDF
                </a>
            </div>

            <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100">
                <div class="flex items-center gap-4 mb-6">
                    <img src="{{ asset('images/orbit.png') }}" class="h-10 w-10" alt="Logo">
                    <div>
                        <h3 class="font-black text-gray-950 uppercase tracking-tight">Orbit Digital Printing</h3>
                        <p class="text-xs font-bold text-gray-500">Monitoring Pesanan - Periode: {{ date('Y') }}</p>
                    </div>
                </div>

                {{-- Stat Cards --}}
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
                    <div class="p-6 bg-indigo-50 rounded-2xl border border-indigo-100 text-center">
                        <p class="text-[10px] font-black text-indigo-400 uppercase tracking-widest mb-1">Total Semua Order</p>
                        <p class="text-3xl font-black text-indigo-700">{{ $totalOrder }}</p>
                    </div>
                    <div class="p-6 bg-emerald-50 rounded-2xl border border-emerald-100 text-center">
                        <p class="text-[10px] font-black text-emerald-400 uppercase tracking-widest mb-1">Total Omzet Selesai</p>
                        <p class="text-3xl font-black text-emerald-700">Rp {{ number_format($totalOmzet, 0, ',', '.') }}</p>
                    </div>
                    <div class="p-6 bg-amber-50 rounded-2xl border border-amber-100 text-center">
                        <p class="text-[10px] font-black text-amber-400 uppercase tracking-widest mb-1">Sedang Diproses</p>
                        <p class="text-3xl font-black text-amber-700">{{ $orderAktif }}</p>
                    </div>
                </div>

                {{-- Status Pesanan --}}
                <h4 class="font-black text-gray-950 uppercase tracking-tighter mb-4">Status Pesanan Saat Ini</h4>
                @php
                    $statusColors = [
                        'Verifikasi' => ['bg-yellow-50', 'text-yellow-700'],
                        'Antrean Cetak' => ['bg-blue-50', 'text-blue-700'],
                        'Produksi' => ['bg-purple-50', 'text-purple-700'],
                        'Siap Ambil' => ['bg-emerald-50', 'text-emerald-700'],
                        'Sedang Dikirim' => ['bg-indigo-50', 'text-indigo-700'],
                        'Selesai' => ['bg-emerald-50', 'text-emerald-700'],
                        'Dibatalkan' => ['bg-red-50', 'text-red-700'],
                    ];
                @endphp
                <div class="overflow-x-auto mb-8">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50 text-gray-400 text-[10px] uppercase tracking-widest">
                                <th class="p-4 font-black">Status</th>
                                <th class="p-4 font-black text-right">Jumlah Order</th>
                                <th class="p-4 font-black text-right">Total Nilai</th>
                                <th class="p-4 font-black text-right">Persentase</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($perStatus as $status => $data)
                            @php $colors = $statusColors[$status] ?? ['bg-gray-50', 'text-gray-700']; @endphp
                            <tr class="hover:bg-gray-50 transition">
                                <td class="p-4"><span class="px-3 py-1 {{ $colors[0] }} {{ $colors[1] }} text-[10px] font-black rounded-lg uppercase">{{ $status }}</span></td>
                                <td class="p-4 text-right font-black text-gray-900">{{ $data['jumlah'] }}</td>
                                <td class="p-4 text-right font-bold text-gray-700">Rp {{ number_format($data['total'], 0, ',', '.') }}</td>
                                <td class="p-4 text-right font-bold text-gray-600">{{ $totalOrder > 0 ? round(($data['jumlah'] / $totalOrder) * 100, 1) : 0 }}%</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Tren 6 Bulan --}}
                <h4 class="font-black text-gray-950 uppercase tracking-tighter mb-4">Tren Pesanan 6 Bulan Terakhir</h4>
                <div class="overflow-x-auto mb-8">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50 text-gray-400 text-[10px] uppercase tracking-widest">
                                <th class="p-4 font-black">Bulan</th>
                                <th class="p-4 font-black text-right">Jumlah Order</th>
                                <th class="p-4 font-black text-right">Total Nilai</th>
                                <th class="p-4 font-black text-right">Rata-rata / Order</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($perBulan as $bulan)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="p-4 text-sm font-black text-gray-950">{{ $bulan['label'] }}</td>
                                <td class="p-4 text-right font-bold text-gray-700">{{ $bulan['jumlah'] }}</td>
                                <td class="p-4 text-right font-bold text-gray-700">Rp {{ number_format($bulan['total'], 0, ',', '.') }}</td>
                                <td class="p-4 text-right font-bold text-indigo-600">{{ $bulan['jumlah'] > 0 ? 'Rp ' . number_format($bulan['total'] / $bulan['jumlah'], 0, ',', '.') : '-' }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="p-8 text-center text-gray-400 font-medium">Belum ada data pesanan.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- 10 Pesanan Terbaru --}}
                <h4 class="font-black text-gray-950 uppercase tracking-tighter mb-4">10 Pesanan Terbaru</h4>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50 text-gray-400 text-[10px] uppercase tracking-widest">
                                <th class="p-4 font-black">No. Invoice</th>
                                <th class="p-4 font-black">Tanggal</th>
                                <th class="p-4 font-black">Pelanggan</th>
                                <th class="p-4 font-black text-right">Total Bayar</th>
                                <th class="p-4 font-black">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($pesananTerbaru as $p)
                            @php $colors = $statusColors[$p->status] ?? ['bg-gray-50', 'text-gray-700']; @endphp
                            <tr class="hover:bg-gray-50 transition">
                                <td class="p-4 text-sm font-black text-gray-950">{{ $p->nomor_invoice }}</td>
                                <td class="p-4 text-sm font-bold text-gray-700">{{ $p->created_at->format('d/m/Y') }}</td>
                                <td class="p-4 text-sm font-bold text-gray-700">{{ $p->user->name }}</td>
                                <td class="p-4 text-right font-black text-indigo-600">Rp {{ number_format($p->total_bayar, 0, ',', '.') }}</td>
                                <td class="p-4"><span class="px-3 py-1 {{ $colors[0] }} {{ $colors[1] }} text-[10px] font-black rounded-lg uppercase">{{ $p->status }}</span></td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="p-8 text-center text-gray-400 font-medium">Belum ada pesanan.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
