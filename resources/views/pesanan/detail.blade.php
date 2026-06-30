<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-2xl text-gray-900 uppercase tracking-tight italic">Detail Pesanan: {{ $pesanan->nomor_invoice }}</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <div class="flex justify-between items-center">
                <a href="{{ route('pesanan.riwayat') }}" class="text-xs font-black text-gray-400 uppercase hover:text-indigo-600 transition tracking-widest flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                    Kembali ke Riwayat
                </a>
                
                <a href="{{ route('pesanan.cetak', $pesanan->id) }}" target="_blank" class="px-6 py-2.5 bg-red-600 text-white text-[10px] font-black uppercase rounded-xl hover:bg-red-700 transition shadow-lg shadow-red-100 flex items-center gap-2 tracking-widest">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    Download Nota (PDF)
                </a>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                <div class="lg:col-span-2 space-y-6">
                    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="p-8 border-b border-gray-50 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-6 bg-gray-50/30">
                            <div class="flex items-center gap-4">
                                <div class="p-3 bg-indigo-600 rounded-2xl text-white shadow-lg shadow-indigo-100">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                                </div>
                                <div>
                                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-0.5">Status Pesanan</p>
                                    <h3 class="font-black text-2xl text-indigo-600 uppercase tracking-tight leading-none">{{ $pesanan->status }}</h3>
                                </div>
                            </div>
                            <div class="sm:text-right">
                                <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Tanggal Transaksi</p>
                                <h3 class="font-bold text-gray-950">{{ \Carbon\Carbon::parse($pesanan->created_at)->translatedFormat('d F Y, H:i') }} WITA</h3>
                            </div>
                        </div>

                        <div class="p-8 space-y-6">
                            <div class="flex items-center gap-3 mb-2">
                                <h4 class="font-black text-gray-950 uppercase tracking-tighter text-lg">Rincian Produk</h4>
                                <div class="h-px flex-1 bg-gray-100"></div>
                            </div>
                            
                            @foreach($pesanan->detailPesanan as $detail)
                            <div class="group flex flex-col sm:flex-row items-start sm:items-center gap-6 p-5 bg-white rounded-2xl border border-gray-100 hover:border-indigo-200 hover:shadow-md transition-all">
                                <img src="{{ asset('storage/'.$detail->produk->gambar) }}" class="w-20 h-20 object-cover rounded-2xl shadow-sm group-hover:scale-105 transition-transform">
                                <div class="flex-1">
                                    <h5 class="font-black text-lg text-gray-950 uppercase leading-tight">{{ $detail->produk->nama_produk }}</h5>
                                    <div class="flex flex-wrap gap-x-4 gap-y-1 mt-1">
                                        <p class="text-xs font-bold text-gray-500 italic">Dimensi: {{ $detail->panjang }}{{ $detail->produk->satuan ?? 'm' }} x {{ $detail->lebar }}{{ $detail->produk->satuan ?? 'm' }}</p>
                                        <p class="text-xs font-black text-indigo-600 uppercase tracking-wider">Qty: {{ $detail->jumlah }} Pcs</p>
                                    </div>
                                    @if($detail->finishing)
                                        <div class="mt-3 flex items-start gap-2 p-2 bg-indigo-50/50 rounded-xl border border-indigo-100/50">
                                            <svg class="w-3.5 h-3.5 text-indigo-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            <p class="text-[11px] font-bold text-indigo-700 leading-relaxed uppercase tracking-tighter italic">Catatan: {{ $detail->finishing }}</p>
                                        </div>
                                    @endif
                                </div>
                                <div class="sm:text-right w-full sm:w-auto mt-2 sm:mt-0 pt-4 sm:pt-0 border-t sm:border-0 border-gray-50">
                                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-0.5">Subtotal</p>
                                    <p class="font-black text-xl text-gray-950">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</p>
                                </div>
                            </div>
                            @endforeach
                        </div>

                        @php
                            $sudahUlas = \App\Models\Ulasan::where('pesanan_id', $pesanan->id)->first();
                        @endphp

                        @if($pesanan->status == 'Selesai')
                            <div class="px-8 py-8 bg-indigo-50/50 border-t border-indigo-100">
                                @if(!$sudahUlas)
                                    <div class="max-w-2xl mx-auto text-center space-y-4" x-data="{ rating: 0 }">
                                        <h4 class="font-black text-indigo-900 uppercase tracking-tight italic text-lg text-center">Bagaimana Hasil Cetakan Kami? ⭐</h4>
                                        <form action="{{ route('ulasan.store', $pesanan->id) }}" method="POST" class="space-y-4">
                                            @csrf
                                            <div class="flex justify-center gap-2">
                                                @foreach(range(1, 5) as $i)
                                                    <button type="button" @click="rating = {{ $i }}" class="focus:outline-none transition transform hover:scale-125">
                                                        <svg class="w-10 h-10" :class="rating >= {{ $i }} ? 'text-yellow-400 fill-current' : 'text-gray-300'" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.175 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                                                        </svg>
                                                    </button>
                                                @endforeach
                                            </div>
                                            <input type="hidden" name="rating" x-model="rating" required>
                                            <textarea name="komentar" rows="3" class="w-full rounded-2xl border-indigo-200 focus:ring-4 focus:ring-indigo-200 font-bold placeholder-indigo-300/50" placeholder="Tuliskan kepuasan Anda di sini..." required></textarea>
                                            <button type="submit" class="w-full py-3 bg-indigo-600 text-white font-black uppercase rounded-xl shadow-lg shadow-indigo-200 hover:bg-indigo-700 transition transform active:scale-95">Kirim Ulasan</button>
                                        </form>
                                    </div>
                                @else
                                    <div class="text-center space-y-2">
                                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Ulasan Anda Telah Terkirim</p>
                                        <div class="flex justify-center gap-1">
                                            @foreach(range(1, $sudahUlas->rating) as $star)
                                                <svg class="w-5 h-5 text-yellow-400 fill-current" viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                                            @endforeach
                                        </div>
                                        <p class="font-black text-gray-700 italic text-lg">"{{ $sudahUlas->komentar }}"</p>
                                    </div>
                                @endif
                            </div>
                        @endif

                        <div class="px-8 py-6 border-t border-gray-100 bg-gray-50/20 space-y-4">
                            <div class="flex justify-between items-center text-gray-500">
                                <span class="text-xs font-black uppercase tracking-widest">Subtotal Harga</span>
                                <span class="font-bold text-gray-950">Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}</span>
                            </div>
                            
                            @if($pesanan->potongan_diskon > 0)
                            <div class="flex justify-between items-center bg-emerald-50 p-3 rounded-xl border border-emerald-100">
                                <div class="flex items-center gap-2">
                                    <div class="p-1 bg-emerald-500 rounded-lg text-white">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12z"></path></svg>
                                    </div>
                                    <span class="text-xs font-black text-emerald-700 uppercase tracking-widest">Diskon Grosir (10%)</span>
                                </div>
                                <span class="font-black text-emerald-600 text-lg">- Rp {{ number_format($pesanan->potongan_diskon, 0, ',', '.') }}</span>
                            </div>
                            @endif
                        </div>

                        <div class="p-8 bg-gray-950 text-white flex flex-col sm:flex-row justify-between items-start sm:items-center gap-6">
                            <div class="flex items-center gap-4">
                                <div class="p-3 bg-gray-800 rounded-2xl border border-gray-700">
                                    <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                </div>
                                <div>
                                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-0.5">Metode Pengiriman</p>
                                    <p class="font-black text-lg text-white uppercase tracking-tight">{{ explode(' | ', $pesanan->metode_pengiriman)[0] }}</p>
                                </div>
                            </div>
                            <div class="sm:text-right w-full sm:w-auto">
                                <p class="text-[10px] font-black text-indigo-400 uppercase tracking-widest mb-1">Total Pembayaran</p>
                                <div class="flex items-center sm:justify-end gap-3">
                                     <h2 class="font-black text-4xl text-white tracking-tighter leading-none">Rp {{ number_format($pesanan->total_bayar, 0, ',', '.') }}</h2>
                                     <div class="hidden sm:block p-1.5 bg-emerald-500 rounded-full">
                                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                     </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="space-y-6">
                    <div class="bg-indigo-950 p-8 rounded-3xl shadow-sm text-white border border-indigo-900 sticky top-6">
                        <h3 class="font-black text-xl uppercase mb-6 tracking-tighter">Status Pesanan</h3>
                        
                        @if($pesanan->status == 'Dibatalkan')
                            <div class="p-4 bg-red-500/20 border border-red-500/50 rounded-2xl text-center">
                                <svg class="w-12 h-12 text-red-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                <h4 class="font-black uppercase text-red-400">Pesanan Dibatalkan</h4>
                                <p class="text-[10px] text-red-200 mt-1 font-bold">Harap hubungi Admin jika ada kendala.</p>
                            </div>
                        @else
                            <div class="relative space-y-6 before:absolute before:inset-0 before:ml-5 before:-translate-x-px md:before:mx-auto md:before:translate-x-0 before:h-full before:w-0.5 before:bg-gradient-to-b before:from-transparent before:via-indigo-800 before:to-transparent">
                                
                                <div class="relative flex items-center justify-between md:justify-normal md:odd:flex-row-reverse group is-active">
                                    <div class="flex items-center justify-center w-10 h-10 rounded-full border-4 border-indigo-950 bg-indigo-500 text-white shadow shrink-0 md:order-1 md:group-odd:-translate-x-1/2 md:group-even:translate-x-1/2 z-10">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    </div>
                                    @php
                                        $isCash = str_contains($pesanan->metode_pengiriman, 'Cash');
                                    @endphp
                                    <div class="w-[calc(100%-4rem)] md:w-[calc(50%-2.5rem)] p-4 rounded-xl border {{ in_array($pesanan->status, ['Verifikasi', 'Antrean Cetak', 'Produksi', 'Selesai']) ? 'bg-indigo-600 border-indigo-500 shadow-lg shadow-indigo-900/50' : 'bg-indigo-900/50 border-indigo-800 opacity-50' }}">
                                        <h4 class="font-black text-sm uppercase">Verifikasi Kasir</h4>
                                        <p class="text-[10px] text-indigo-200 mt-1">{{ $isCash ? 'Pesanan langsung diproses (Cash).' : 'Mengecek bukti transfer Anda.' }}</p>
                                    </div>
                                </div>

                                <div class="relative flex items-center justify-between md:justify-normal md:odd:flex-row-reverse group is-active">
                                    <div class="flex items-center justify-center w-10 h-10 rounded-full border-4 border-indigo-950 {{ in_array($pesanan->status, ['Antrean Cetak', 'Produksi', 'Selesai']) ? 'bg-indigo-500' : 'bg-indigo-900' }} text-white shadow shrink-0 md:order-1 md:group-odd:-translate-x-1/2 md:group-even:translate-x-1/2 z-10 transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                                    </div>
                                    <div class="w-[calc(100%-4rem)] md:w-[calc(50%-2.5rem)] p-4 rounded-xl border {{ in_array($pesanan->status, ['Antrean Cetak', 'Produksi', 'Selesai']) ? 'bg-indigo-600 border-indigo-500 shadow-lg shadow-indigo-900/50' : 'bg-indigo-900/50 border-indigo-800 opacity-50' }} transition-all">
                                        <h4 class="font-black text-sm uppercase">Job Masuk</h4>
                                        <p class="text-[10px] text-indigo-200 mt-1">Masuk antrean mesin cetak.</p>
                                    </div>
                                </div>

                                <div class="relative flex items-center justify-between md:justify-normal md:odd:flex-row-reverse group is-active">
                                    <div class="flex items-center justify-center w-10 h-10 rounded-full border-4 border-indigo-950 {{ in_array($pesanan->status, ['Produksi', 'Selesai']) ? 'bg-indigo-500' : 'bg-indigo-900' }} text-white shadow shrink-0 md:order-1 md:group-odd:-translate-x-1/2 md:group-even:translate-x-1/2 z-10 transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                    </div>
                                    <div class="w-[calc(100%-4rem)] md:w-[calc(50%-2.5rem)] p-4 rounded-xl border {{ in_array($pesanan->status, ['Produksi', 'Selesai']) ? 'bg-indigo-600 border-indigo-500 shadow-lg shadow-indigo-900/50' : 'bg-indigo-900/50 border-indigo-800 opacity-50' }} transition-all">
                                        <h4 class="font-black text-sm uppercase">Diproduksi</h4>
                                        <p class="text-[10px] text-indigo-200 mt-1">Sedang dicetak & finishing.</p>
                                    </div>
                                </div>

                                <div class="relative flex items-center justify-between md:justify-normal md:odd:flex-row-reverse group is-active">
                                    <div class="flex items-center justify-center w-10 h-10 rounded-full border-4 border-indigo-950 {{ in_array($pesanan->status, ['Siap Ambil', 'Sedang Dikirim']) ? 'bg-emerald-500' : 'bg-indigo-900' }} text-white shadow shrink-0 md:order-1 md:group-odd:-translate-x-1/2 md:group-even:translate-x-1/2 z-10 transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                    </div>
                                    <div class="w-[calc(100%-4rem)] md:w-[calc(50%-2.5rem)] p-4 rounded-xl border {{ in_array($pesanan->status, ['Siap Ambil', 'Sedang Dikirim']) ? 'bg-emerald-500 border-emerald-400 shadow-lg shadow-emerald-900/50' : 'bg-indigo-900/50 border-indigo-800 opacity-50' }} transition-all">
                                        <h4 class="font-black text-sm uppercase">Siap Ambil / Dikirim</h4>
                                        <p class="text-[10px] text-indigo-100 mt-1">
                                            @if($pesanan->status == 'Siap Ambil')
                                                Pesanan siap diambil di toko.
                                            @elseif($pesanan->status == 'Sedang Dikirim')
                                                Paket sedang dalam perjalanan.
                                            @else
                                                Pesanan akan siap.
                                            @endif
                                        </p>
                                    </div>
                                </div>

                                <div class="relative flex items-center justify-between md:justify-normal md:odd:flex-row-reverse group is-active">
                                    <div class="flex items-center justify-center w-10 h-10 rounded-full border-4 border-indigo-950 {{ $pesanan->status == 'Selesai' ? 'bg-emerald-500' : 'bg-indigo-900' }} text-white shadow shrink-0 md:order-1 md:group-odd:-translate-x-1/2 md:group-even:translate-x-1/2 z-10 transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    </div>
                                    <div class="w-[calc(100%-4rem)] md:w-[calc(50%-2.5rem)] p-4 rounded-xl border {{ $pesanan->status == 'Selesai' ? 'bg-emerald-500 border-emerald-400 shadow-lg shadow-emerald-900/50' : 'bg-indigo-900/50 border-indigo-800 opacity-50' }} transition-all">
                                        <h4 class="font-black text-sm uppercase">Transaksi Selesai</h4>
                                        <p class="text-[10px] text-indigo-100 mt-1">
                                            @if($pesanan->status == 'Selesai')
                                                Terima kasih! Pesanan sudah selesai.
                                            @else
                                                Menunggu penyelesaian.
                                            @endif
                                        </p>
                                    </div>
                                </div>

                            </div>
                        @endif
                    </div>
                </div>

            </div>

            <p class="text-center text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Orbit Digital Printing &copy; {{ date('Y') }} - Banjarmasin Smart City</p>
        </div>
    </div>
</x-app-layout>