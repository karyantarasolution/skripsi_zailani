<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-4">
                <a href="{{ route('admin.pelanggan.index') }}" class="p-2 bg-gray-100 rounded-xl hover:bg-gray-200 transition">
                    <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                </a>
                <h2 class="font-black text-2xl text-gray-900 uppercase tracking-tight">Detail Pelanggan</h2>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8">
                <div class="flex items-start gap-6">
                    @if($pelanggan->foto)
                        <div class="w-24 h-24 rounded-full overflow-hidden shrink-0">
                            <img src="{{ asset('storage/'.$pelanggan->foto) }}" class="w-full h-full object-cover">
                        </div>
                    @else
                        <div class="w-24 h-24 rounded-full bg-purple-100 text-purple-600 flex items-center justify-center font-black text-4xl shrink-0">
                            {{ substr($pelanggan->name, 0, 1) }}
                        </div>
                    @endif
                    <div class="flex-1">
                        <h3 class="text-2xl font-black text-gray-900 uppercase">{{ $pelanggan->name }}</h3>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-4">
                            <div>
                                <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Email</p>
                                <p class="font-bold text-gray-900">{{ $pelanggan->email }}</p>
                            </div>
                            <div>
                                <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Telepon</p>
                                <p class="font-bold text-gray-900">{{ $pelanggan->telepon ?? '-' }}</p>
                            </div>
                            <div>
                                <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Poin</p>
                                <p class="font-bold text-amber-600 text-xl">{{ $pelanggan->poin }}</p>
                            </div>
                            <div>
                                <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Member Sejak</p>
                                <p class="font-bold text-gray-900">{{ $pelanggan->created_at->format('d/m/Y') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8">
                <h4 class="font-black text-gray-950 uppercase tracking-tighter mb-6">Riwayat Transaksi</h4>
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="text-[10px] font-black text-gray-400 uppercase tracking-widest">
                                <th class="pb-3">Invoice</th>
                                <th class="pb-3">Tanggal</th>
                                <th class="pb-3">Status</th>
                                <th class="pb-3 text-right">Total</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($pelanggan->pesanan as $psn)
                            <tr class="text-sm">
                                <td class="py-3 font-bold text-gray-900">{{ $psn->nomor_invoice }}</td>
                                <td class="py-3 text-gray-600">{{ $psn->created_at->format('d/m/Y H:i') }}</td>
                                <td class="py-3">
                                    <span class="px-2 py-1 text-[10px] font-black rounded-lg uppercase
                                        @if($psn->status == 'Selesai') bg-emerald-100 text-emerald-700
                                        @elseif($psn->status == 'Dibatalkan') bg-red-100 text-red-700
                                        @else bg-blue-100 text-blue-700
                                        @endif">{{ $psn->status }}</span>
                                </td>
                                <td class="py-3 text-right font-bold text-gray-900">Rp{{ number_format($psn->total_bayar, 0, ',', '.') }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="py-6 text-center text-gray-400 font-medium">Belum ada transaksi.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
