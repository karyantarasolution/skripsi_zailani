<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-2xl text-gray-900 uppercase tracking-tight italic">Keranjang Belanja</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-8 border-b border-gray-50 flex justify-between items-center">
                    <h3 class="font-bold text-gray-950 uppercase tracking-tight">Daftar Item Cetak</h3>
                    <span class="text-xs font-black uppercase text-indigo-600 bg-indigo-50 px-4 py-1 rounded-full">
                        {{ $keranjang ? $keranjang->detailKeranjang->count() : 0 }} Item
                    </span>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead class="bg-gray-50/50 text-[10px] font-black uppercase text-gray-400 tracking-widest">
                            <tr>
                                <th class="px-8 py-4">Produk & Ukuran</th>
                                <th class="px-8 py-4">Jumlah</th>
                                <th class="px-8 py-4 text-right">Subtotal</th>
                                <th class="px-8 py-4 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @if($keranjang && $keranjang->detailKeranjang->count() > 0)
                                @foreach($keranjang->detailKeranjang as $detail)
                                <tr class="hover:bg-gray-50/50 transition">
                                    <td class="px-8 py-6">
                                        <div class="flex items-center gap-4">
                                            <img src="{{ asset('storage/'.$detail->produk->gambar) }}" class="w-16 h-16 rounded-xl object-cover">
                                            <div>
                                                <span class="block font-black text-gray-950 uppercase italic leading-tight">{{ $detail->produk->nama_produk }}</span>
                                                <span class="text-xs font-bold text-gray-400 italic">Ukuran: {{ $detail->panjang }}{{ $detail->produk->satuan ?? 'm' }} x {{ $detail->lebar }}{{ $detail->produk->satuan ?? 'm' }}</span>
                                                @if($detail->catatan)
                                                    <span class="text-[10px] font-bold text-indigo-500 block mt-1 italic">Catatan: {{ $detail->catatan }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-8 py-6 font-bold text-gray-700">{{ $detail->jumlah }} Pcs</td>
                                    <td class="px-8 py-6 text-right font-black text-gray-950 tracking-tight">
                                        Rp {{ number_format($detail->subtotal, 0, ',', '.') }}
                                    </td>
                                    <td class="px-8 py-6 text-center">
                                        <div class="flex items-center justify-center gap-2">
                                            <a href="{{ route('keranjang.edit', $detail->id) }}" class="p-2 bg-indigo-50 text-indigo-600 rounded-xl hover:bg-indigo-100 transition" title="Edit">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                            </a>
                                            <form action="{{ route('keranjang.destroy', $detail->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus item ini dari keranjang?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="p-2 bg-red-50 text-red-500 rounded-xl hover:bg-red-100 transition" title="Hapus">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="4" class="px-8 py-20 text-center text-gray-400 italic font-bold uppercase tracking-widest">Keranjang kosong</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>

                @if($keranjang && $keranjang->detailKeranjang->count() > 0)
                <div class="p-8 bg-gray-50 flex flex-col md:flex-row justify-between items-center gap-6">
                    <div>
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Total Belanja</p>
                        <h4 class="text-3xl font-black text-gray-950 tracking-tighter">
                            Rp {{ number_format($keranjang->detailKeranjang->sum('subtotal'), 0, ',', '.') }}
                        </h4>
                    </div>
                    <div class="flex gap-4">
                        <a href="{{ route('katalog.index') }}" class="px-8 py-4 text-sm font-black uppercase text-gray-500 hover:text-gray-950 transition">Tambah Produk</a>
                        <a href="{{ route('pesan.checkout') }}" class="px-12 py-4 bg-indigo-600 text-white font-black uppercase rounded-2xl shadow-xl shadow-indigo-100 hover:bg-indigo-700 transition transform active:scale-95 inline-block text-center">
                            Lanjut Checkout &rarr;
                        </a>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>