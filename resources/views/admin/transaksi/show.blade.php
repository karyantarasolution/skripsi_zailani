<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-4">
                <a href="{{ route('admin.transaksi.index') }}" class="p-2 bg-gray-100 rounded-xl hover:bg-gray-200 transition">
                    <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                </a>
                <h2 class="font-black text-2xl text-white uppercase tracking-tight">Detail Transaksi</h2>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Nomor Invoice</p>
                        <h3 class="text-2xl font-black text-gray-900 font-mono">{{ $transaksi->nomor_invoice }}</h3>
                    </div>
                    @php
                        $statusClass = match($transaksi->status) {
                            'Selesai' => 'bg-emerald-100 text-emerald-700',
                            'Dibatalkan' => 'bg-red-100 text-red-700',
                            'Menunggu Pembayaran' => 'bg-yellow-100 text-yellow-700',
                            'Verifikasi' => 'bg-orange-100 text-orange-700',
                            default => 'bg-blue-100 text-blue-700',
                        };
                    @endphp
                    <span class="px-4 py-2 text-xs font-black rounded-xl uppercase {{ $statusClass }}">{{ $transaksi->status }}</span>
                </div>

                <div class="grid grid-cols-2 gap-6 mb-6 p-4 bg-gray-50 rounded-2xl">
                    <div>
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Pelanggan</p>
                        <p class="font-bold text-gray-900">{{ $transaksi->user->name }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Tanggal</p>
                        <p class="font-bold text-gray-900">{{ $transaksi->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Kontak</p>
                        <p class="font-bold text-gray-900">{{ $transaksi->user->telepon ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Metode Pengiriman</p>
                        <p class="font-bold text-gray-900">{{ $transaksi->metode_pengiriman ?? '-' }}</p>
                    </div>
                </div>

                <h4 class="font-black text-gray-950 uppercase tracking-tighter mb-4">Item Pesanan</h4>
                <table class="w-full text-left mb-6">
                    <thead>
                        <tr class="text-[10px] font-black text-gray-400 uppercase tracking-widest border-b border-gray-200">
                            <th class="pb-3">Produk</th>
                            <th class="pb-3 text-center">Ukuran</th>
                            <th class="pb-3 text-center">Qty</th>
                            <th class="pb-3 text-right">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($transaksi->detailPesanan as $item)
                        <tr class="text-sm">
                            <td class="py-3 font-bold text-gray-900">{{ $item->produk->nama_produk }}</td>
                            <td class="py-3 text-center text-gray-600">{{ $item->panjang }} x {{ $item->lebar }} {{ $item->produk->satuan }}</td>
                            <td class="py-3 text-center font-bold">{{ $item->jumlah }}</td>
                            <td class="py-3 text-right font-bold text-gray-900">Rp{{ number_format($item->subtotal, 0, ',', '.') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="font-black text-lg">
                            <td colspan="3" class="pt-4 text-right text-gray-600">Total Bayar</td>
                            <td class="pt-4 text-right text-gray-900">Rp{{ number_format($transaksi->total_bayar, 0, ',', '.') }}</td>
                        </tr>
                    </tfoot>
                </table>

                @if($transaksi->riwayatPesanan->isNotEmpty())
                <h4 class="font-black text-gray-950 uppercase tracking-tighter mb-4 mt-8">Riwayat Status</h4>
                <div class="space-y-2">
                    @foreach($transaksi->riwayatPesanan as $log)
                    <div class="flex items-center gap-3 text-sm p-3 bg-gray-50 rounded-xl">
                        <div class="w-2 h-2 rounded-full bg-indigo-500"></div>
                        <span class="font-bold text-gray-900">{{ $log->status_log }}</span>
                        <span class="text-gray-400">-</span>
                        <span class="text-gray-500 text-xs">{{ $log->created_at->format('d/m/Y H:i') }}</span>
                        @if($log->catatan)
                        <span class="text-gray-400 text-xs">({{ $log->catatan }})</span>
                        @endif
                    </div>
                    @endforeach
                </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
