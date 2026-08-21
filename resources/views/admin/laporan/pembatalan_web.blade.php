<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-2xl text-white uppercase tracking-tight">Laporan Log Pembatalan</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="flex flex-wrap items-center justify-between gap-4">
                <a href="{{ route('admin.dashboard') }}" class="text-xs font-black text-gray-400 uppercase hover:text-indigo-600 transition tracking-widest">&larr; Kembali</a>
                <a href="{{ route('admin.laporan.pembatalan.pdf') }}" target="_blank" class="px-6 py-3 bg-red-600 text-white font-black uppercase text-xs tracking-widest rounded-xl hover:bg-red-500 transition shadow-lg flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    Download PDF
                </a>
            </div>

            <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100">
                <div class="flex items-center gap-4 mb-6">
                    <img src="{{ asset('images/orbit.png') }}" class="h-10 w-10" alt="Logo">
                    <div>
                        <h3 class="font-black text-gray-950 uppercase tracking-tight">Orbit Digital Printing</h3>
                        <p class="text-xs font-bold text-gray-500">Laporan Log Pembatalan & Retur Pesanan</p>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-red-50 text-red-400 text-[10px] uppercase tracking-widest">
                                <th class="p-4 font-black">No. Invoice</th>
                                <th class="p-4 font-black">Tanggal Order</th>
                                <th class="p-4 font-black">Pelanggan</th>
                                <th class="p-4 font-black text-right">Total Transaksi</th>
                                <th class="p-4 font-black">Alasan / Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($pembatalan as $p)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="p-4 text-sm font-black text-gray-950">{{ $p->nomor_invoice }}</td>
                                <td class="p-4 text-sm font-bold text-gray-700">{{ $p->created_at->format('d/m/Y H:i') }}</td>
                                <td class="p-4 text-sm font-bold text-gray-700">{{ $p->user->name }}</td>
                                <td class="p-4 text-right font-black text-red-600">Rp {{ number_format($p->total_bayar, 0, ',', '.') }}</td>
                                <td class="p-4"><span class="px-3 py-1 bg-red-50 text-red-700 text-[10px] font-black rounded-lg uppercase">Dibatalkan</span></td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="p-8 text-center text-gray-400 font-medium">Tidak ada riwayat pembatalan pesanan.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
