<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-2xl text-gray-900 uppercase tracking-tight">Data Transaksi</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Stat --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div>
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Total Omzet</p>
                        <p class="text-xl font-black text-emerald-700">Rp{{ number_format($totalOmzet, 0, ',', '.') }}</p>
                    </div>
                </div>
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-yellow-50 text-amber-600 flex items-center justify-center shrink-0">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div>
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Pending</p>
                        <p class="text-xl font-black text-amber-700">{{ $totalPending }}</p>
                    </div>
                </div>
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                    </div>
                    <div>
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Total Transaksi</p>
                        <p class="text-xl font-black text-blue-700">{{ $transaksi->total() }}</p>
                    </div>
                </div>
            </div>

            {{-- Filter --}}
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6">
                <form method="GET" class="flex flex-wrap items-end gap-3">
                    <div>
                        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Cari</label>
                        <input type="text" name="cari" value="{{ request('cari') }}" placeholder="Invoice / Pelanggan" class="rounded-xl border-gray-200 text-sm font-bold w-48">
                    </div>
                    <div>
                        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Status</label>
                        <select name="status" class="rounded-xl border-gray-200 text-sm font-bold">
                            <option value="">Semua</option>
                            @foreach(['Menunggu Pembayaran','Verifikasi','Antrean Cetak','Produksi','Siap Ambil','Sedang Dikirim','Selesai','Dibatalkan'] as $s)
                                <option value="{{ $s }}" {{ request('status') == $s ? 'selected' : '' }}>{{ $s }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Dari</label>
                        <input type="date" name="tanggal_mulai" value="{{ request('tanggal_mulai') }}" class="rounded-xl border-gray-200 text-sm font-bold">
                    </div>
                    <div>
                        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Sampai</label>
                        <input type="date" name="tanggal_selesai" value="{{ request('tanggal_selesai') }}" class="rounded-xl border-gray-200 text-sm font-bold">
                    </div>
                    <button type="submit" class="px-4 py-2.5 bg-indigo-600 text-white font-black rounded-xl text-xs uppercase tracking-widest hover:bg-indigo-500 transition">Filter</button>
                    @if(request()->anyFilled(['cari', 'status', 'tanggal_mulai', 'tanggal_selesai']))
                        <a href="{{ route('admin.transaksi.index') }}" class="px-4 py-2.5 bg-gray-100 text-gray-600 font-black rounded-xl text-xs uppercase tracking-widest hover:bg-gray-200 transition">Reset</a>
                    @endif
                </form>
            </div>

            {{-- Table --}}
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50 text-gray-400 text-[10px] uppercase tracking-widest">
                                <th class="p-5 font-black">Invoice</th>
                                <th class="p-5 font-black">Pelanggan</th>
                                <th class="p-5 font-black">Tanggal</th>
                                <th class="p-5 font-black">Status</th>
                                <th class="p-5 font-black text-right">Total</th>
                                <th class="p-5 font-black text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($transaksi as $t)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="p-5 font-black text-gray-900 font-mono text-sm">{{ $t->nomor_invoice }}</td>
                                <td class="p-5 font-bold text-gray-900">{{ $t->user->name }}</td>
                                <td class="p-5 text-sm text-gray-600">{{ $t->created_at->format('d/m/Y H:i') }}</td>
                                <td class="p-5">
                                    @php
                                        $statusClass = match($t->status) {
                                            'Selesai' => 'bg-emerald-100 text-emerald-700',
                                            'Dibatalkan' => 'bg-red-100 text-red-700',
                                            'Menunggu Pembayaran' => 'bg-yellow-100 text-yellow-700',
                                            'Verifikasi' => 'bg-orange-100 text-orange-700',
                                            default => 'bg-blue-100 text-blue-700',
                                        };
                                    @endphp
                                    <span class="px-2 py-1 text-[10px] font-black rounded-lg uppercase {{ $statusClass }}">{{ $t->status }}</span>
                                </td>
                                <td class="p-5 text-right font-black text-gray-900">Rp{{ number_format($t->total_bayar, 0, ',', '.') }}</td>
                                <td class="p-5 text-center">
                                    <a href="{{ route('admin.transaksi.show', $t->id) }}" class="px-3 py-1.5 bg-indigo-50 text-indigo-600 hover:bg-indigo-600 hover:text-white rounded-lg font-black text-[10px] uppercase tracking-widest transition">Detail</a>
                                </td>
                            </tr>
                            @endforeach
                            @if($transaksi->isEmpty())
                            <tr>
                                <td colspan="6" class="p-8 text-center text-gray-400 font-medium">Belum ada transaksi.</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
                <div class="p-4">
                    {{ $transaksi->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
