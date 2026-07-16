<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-2xl text-white uppercase tracking-tight italic">Keranjang <span class="gradient-text">Belanja</span></h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="glass-card-static overflow-hidden">
                <div class="p-8 border-b border-white/[0.06] flex justify-between items-center">
                    <h3 class="font-bold text-white uppercase tracking-tight">Daftar Item Cetak</h3>
                    <span class="text-xs font-black uppercase text-purple-300 bg-purple-500/15 px-4 py-1 rounded-full border border-purple-500/20">
                        {{ $keranjang ? $keranjang->detailKeranjang->count() : 0 }} Item
                    </span>
                </div>

                <div class="overflow-x-auto">
                    <table class="cosmic-table">
                        <thead>
                            <tr>
                                <th>Produk & Ukuran</th>
                                <th>Jumlah</th>
                                <th style="text-align: right">Subtotal</th>
                                <th style="text-align: center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($keranjang && $keranjang->detailKeranjang->count() > 0)
                                @foreach($keranjang->detailKeranjang as $detail)
                                <tr>
                                    <td>
                                        <div class="flex items-center gap-4">
                                            <img src="{{ asset('storage/'.$detail->produk->gambar) }}" class="w-16 h-16 rounded-xl object-cover border border-white/[0.08]">
                                            <div>
                                                <span class="block font-black text-white uppercase italic leading-tight">{{ $detail->produk->nama_produk }}</span>
                                                <span class="text-xs font-bold text-white/30 italic">Ukuran: {{ $detail->panjang }}{{ $detail->produk->satuan ?? 'm' }} x {{ $detail->lebar }}{{ $detail->produk->satuan ?? 'm' }}</span>
                                                @if($detail->catatan)
                                                    <span class="text-[10px] font-bold text-purple-300 block mt-1 italic">Catatan: {{ $detail->catatan }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td class="font-bold text-white/60">{{ $detail->jumlah }} Pcs</td>
                                    <td style="text-align: right" class="font-black text-white tracking-tight">
                                        Rp {{ number_format($detail->subtotal, 0, ',', '.') }}
                                    </td>
                                    <td style="text-align: center">
                                        <div class="flex items-center justify-center gap-2">
                                            <a href="{{ route('keranjang.edit', $detail->id) }}" class="p-2 bg-purple-500/15 text-purple-300 rounded-xl hover:bg-purple-500/25 transition border border-purple-500/20" title="Edit">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                            </a>
                                            <form action="{{ route('keranjang.destroy', $detail->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus item ini dari keranjang?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="p-2 bg-red-500/15 text-red-300 rounded-xl hover:bg-red-500/25 transition border border-red-500/20" title="Hapus">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="4" class="px-8 py-20 text-center text-white/30 italic font-bold uppercase tracking-widest">Keranjang kosong</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>

                @if($keranjang && $keranjang->detailKeranjang->count() > 0)
                <div class="p-8 border-t border-white/[0.06] flex flex-col md:flex-row justify-between items-center gap-6">
                    <div>
                        <p class="text-[10px] font-black text-white/30 uppercase tracking-widest">Total Belanja</p>
                        <h4 class="text-3xl font-black text-white tracking-tighter">
                            Rp {{ number_format($keranjang->detailKeranjang->sum('subtotal'), 0, ',', '.') }}
                        </h4>
                    </div>
                    <div class="flex gap-4">
                        <a href="{{ route('katalog.index') }}" class="px-8 py-4 text-sm font-black uppercase text-white/40 hover:text-white transition">Tambah Produk</a>
                        <a href="{{ route('pesan.checkout') }}" class="px-12 py-4 cosmic-btn cosmic-btn-success rounded-2xl inline-block text-center">
                            Lanjut Checkout &rarr;
                        </a>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
