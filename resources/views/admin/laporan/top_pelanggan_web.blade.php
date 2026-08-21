<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-2xl text-white uppercase tracking-tight">Laporan Top Pelanggan</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="flex flex-wrap items-center justify-between gap-4">
                <a href="{{ route('admin.dashboard') }}" class="text-xs font-black text-gray-400 uppercase hover:text-indigo-600 transition tracking-widest">&larr; Kembali</a>
                <a href="{{ route('admin.laporan.topPelanggan.pdf') }}" target="_blank" class="px-6 py-3 bg-red-600 text-white font-black uppercase text-xs tracking-widest rounded-xl hover:bg-red-500 transition shadow-lg flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    Download PDF
                </a>
            </div>

            <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100">
                <div class="flex items-center gap-4 mb-6">
                    <img src="{{ asset('images/orbit.png') }}" class="h-10 w-10" alt="Logo">
                    <div>
                        <h3 class="font-black text-gray-950 uppercase tracking-tight">Orbit Digital Printing</h3>
                        <p class="text-xs font-bold text-gray-500">Analisis Loyalitas Pelanggan (Top Spenders) - Periode: Tahun {{ date('Y') }}</p>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50 text-gray-400 text-[10px] uppercase tracking-widest">
                                <th class="p-4 font-black text-center">No</th>
                                <th class="p-4 font-black">Nama Pelanggan</th>
                                <th class="p-4 font-black">Email / Kontak</th>
                                <th class="p-4 font-black text-center">Total Transaksi</th>
                                <th class="p-4 font-black text-right">Total Belanja</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($topUsers as $index => $user)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="p-4 text-center">
                                    <span class="inline-flex items-center justify-center w-8 h-8 rounded-full {{ $index < 3 ? 'bg-indigo-600 text-white' : 'bg-gray-100 text-gray-600' }} font-black text-sm">{{ $index + 1 }}</span>
                                </td>
                                <td class="p-4 text-sm font-black text-gray-950 uppercase">{{ $user->name }}</td>
                                <td class="p-4 text-sm font-bold text-gray-700">{{ $user->email }}</td>
                                <td class="p-4 text-center text-sm font-bold text-gray-600">{{ $user->pesanan_count }} Pesanan Selesai</td>
                                <td class="p-4 text-right font-black text-indigo-600">Rp {{ number_format($user->pesanan_sum_total_bayar ?? 0, 0, ',', '.') }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="p-8 text-center text-gray-400 font-medium">Belum ada data pelanggan yang menyelesaikan transaksi.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
