<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-2xl text-gray-900 uppercase tracking-tight">Kelola Pesanan Masuk</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-4">
            <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-indigo-600 text-white text-xs font-black uppercase rounded-xl hover:bg-indigo-500 transition shadow-lg">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                Kembali ke Dashboard
            </a>
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-8 border-b border-gray-50 flex justify-between items-center bg-gray-50/50">
                    <h3 class="font-bold text-gray-950 uppercase tracking-tight">Daftar Transaksi Pelanggan</h3>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead class="bg-white border-b border-gray-100 text-[10px] font-black uppercase text-gray-400 tracking-widest">
                            <tr>
                                <th class="px-8 py-4">Invoice & Tanggal</th>
                                <th class="px-8 py-4">Pelanggan</th>
                                <th class="px-8 py-4">Total Bayar</th>
                                <th class="px-8 py-4">Status</th>
                                <th class="px-8 py-4 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @forelse($pesanan as $item)
                            <tr class="hover:bg-gray-50/50 transition">
                                <td class="px-8 py-6">
                                    <span class="block font-black text-gray-950">{{ $item->nomor_invoice }}</span>
                                    <span class="text-xs font-bold text-gray-400">{{ $item->created_at->format('d M Y H:i') }}</span>
                                </td>
                                <td class="px-8 py-6">
                                    <span class="block font-bold text-gray-700">{{ $item->user->name }}</span>
                                    <span class="text-xs text-gray-400">{{ $item->user->telepon ?? '-' }}</span>
                                </td>
                                <td class="px-8 py-6 font-black text-indigo-600">
                                    Rp {{ number_format($item->total_bayar, 0, ',', '.') }}
                                </td>
                                <td class="px-8 py-6">
                                    @if($item->status == 'Verifikasi')
                                        <span class="px-3 py-1 bg-yellow-100 text-yellow-700 rounded-lg text-[10px] font-black uppercase tracking-widest">Verifikasi</span>
                                    @elseif($item->status == 'Proses Cetak' || $item->status == 'Produksi')
                                        <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-lg text-[10px] font-black uppercase tracking-widest">Diproses</span>
                                    @elseif($item->status == 'Siap Ambil')
                                        <span class="px-3 py-1 bg-emerald-100 text-emerald-700 rounded-lg text-[10px] font-black uppercase tracking-widest">Siap Ambil</span>
                                    @elseif($item->status == 'Sedang Dikirim')
                                        <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-lg text-[10px] font-black uppercase tracking-widest">Sedang Dikirim</span>
                                    @elseif($item->status == 'Selesai')
                                        <span class="px-3 py-1 bg-emerald-100 text-emerald-700 rounded-lg text-[10px] font-black uppercase tracking-widest">Selesai</span>
                                    @else
                                        <span class="px-3 py-1 bg-gray-100 text-gray-700 rounded-lg text-[10px] font-black uppercase tracking-widest">{{ $item->status }}</span>
                                    @endif
                                </td>
                                <td class="px-8 py-6 text-center">
                                    <a href="{{ route('admin.pesanan.show', $item->id) }}" class="inline-block px-6 py-2 bg-gray-950 text-white text-xs font-black uppercase rounded-xl hover:bg-indigo-600 transition shadow-lg">
                                        Proses
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-8 py-16 text-center text-gray-400 font-bold uppercase tracking-widest italic">Belum ada pesanan masuk.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>