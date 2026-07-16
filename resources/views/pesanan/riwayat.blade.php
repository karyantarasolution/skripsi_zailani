<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-2xl text-white uppercase tracking-tight italic">Riwayat <span class="gradient-text">Pesanan Saya</span></h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            @forelse($pesanan as $item)
                <div class="glass-card-static overflow-hidden">
                    
                    <div class="px-6 py-4 border-b border-white/[0.06] flex justify-between items-center">
                        <div class="flex items-center gap-3">
                            <span class="text-xs font-black text-white uppercase tracking-widest bg-white/[0.05] px-3 py-1 rounded-lg border border-white/[0.08]">
                                Orbit Print 
                            </span>
                            <span class="text-[10px] font-bold text-white/30 uppercase tracking-widest">{{ $item->created_at->format('d M Y') }}</span>
                        </div>
                        <div>
                            @if($item->status == 'Verifikasi')
                                <span class="text-yellow-400 text-xs font-black uppercase tracking-widest">Menunggu Verifikasi</span>
                            @elseif($item->status == 'Proses Cetak' || $item->status == 'Produksi')
                                <span class="text-blue-400 text-xs font-black uppercase tracking-widest">Sedang Diproses</span>
                            @elseif($item->status == 'Siap Ambil')
                                <span class="text-emerald-400 text-xs font-black uppercase tracking-widest">Siap Ambil</span>
                            @elseif($item->status == 'Sedang Dikirim')
                                <span class="text-cyan-400 text-xs font-black uppercase tracking-widest">Sedang Dikirim</span>
                            @elseif($item->status == 'Selesai')
                                <span class="text-emerald-400 text-xs font-black uppercase tracking-widest">Transaksi Selesai</span>
                            @else
                                <span class="text-white/50 text-xs font-black uppercase tracking-widest">{{ $item->status }}</span>
                            @endif
                        </div>
                    </div>

                    <div class="p-6">
                        @php $firstItem = $item->detailPesanan->first(); @endphp
                        
                        @if($firstItem && $firstItem->produk)
                        <div class="flex items-center gap-6">
                            <img src="{{ asset('storage/'.$firstItem->produk->gambar) }}" class="w-24 h-24 object-cover rounded-2xl border border-white/[0.08] shadow-sm">
                            <div class="flex-1">
                                <h3 class="font-black text-xl text-white uppercase tracking-tight">{{ $firstItem->produk->nama_produk }}</h3>
                                <p class="text-sm font-bold text-white/40 mt-1">Ukuran: {{ $firstItem->panjang }}{{ $firstItem->produk->satuan ?? 'm' }} x {{ $firstItem->lebar }}{{ $firstItem->produk->satuan ?? 'm' }}</p>
                                <p class="text-xs font-black text-white/30 mt-2 uppercase">Qty: {{ $firstItem->jumlah }} Pcs</p>
                            </div>
                            <div class="text-right">
                                <p class="font-black text-lg gradient-text">Rp {{ number_format($firstItem->subtotal, 0, ',', '.') }}</p>
                            </div>
                        </div>
                        @endif
                        
                        @if($item->detailPesanan->count() > 1)
                            <div class="mt-4 pt-4 border-t border-white/[0.06] text-center">
                                <p class="text-xs font-bold text-white/30 uppercase tracking-widest">Tampilkan {{ $item->detailPesanan->count() - 1 }} produk lainnya...</p>
                            </div>
                        @endif
                    </div>

                    <div class="p-6 border-t border-white/[0.06] flex flex-col md:flex-row justify-between items-center gap-4">
                        <div>
                            <p class="text-[10px] font-black text-white/30 uppercase tracking-widest mb-1">Total Pesanan</p>
                            
                            @if($item->potongan_diskon > 0)
                                <p class="text-xs font-bold text-white/30 line-through mb-1">Rp {{ number_format($item->total_harga, 0, ',', '.') }}</p>
                            @endif
                            
                            <div class="flex items-end gap-3">
                                <p class="font-black text-2xl text-white tracking-tighter">Rp {{ number_format($item->total_bayar, 0, ',', '.') }}</p>
                                
                                @if($item->potongan_diskon > 0)
                                    <span class="mb-1 px-2 py-1 bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 rounded-lg text-[10px] font-black uppercase tracking-widest">
                                        Diskon Grosir Diterapkan
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="flex gap-3 w-full md:w-auto">
                            <a href="{{ route('pesanan.detail', $item->id) }}" class="w-full md:w-auto text-center px-8 py-3 cosmic-btn rounded-xl transform active:scale-95">
                                Cek Detail Invoice
                            </a>
                        </div>
                    </div>

                </div>
            @empty
                <div class="glass-card-static p-12 text-center border-2 border-dashed border-white/10">
                    <p class="text-white/30 font-bold uppercase tracking-widest italic">Belum ada riwayat pesanan.</p>
                </div>
            @endforelse

        </div>
    </div>
</x-app-layout>
