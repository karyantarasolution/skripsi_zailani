<x-app-layout>
    <x-slot name="header">
                <h2 class="font-black text-2xl text-white uppercase tracking-tight italic">Detail Pesanan: <span class="gradient-text">{{ $pesanan->nomor_invoice }}</span></h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <div class="flex justify-between items-center">
                <a href="{{ route('pesanan.riwayat') }}" class="text-xs font-black text-white/40 uppercase hover:text-purple-400 transition tracking-widest flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                    Kembali ke Riwayat
                </a>
                
                <a href="{{ route('pesanan.cetak', $pesanan->id) }}" target="_blank" class="px-6 py-2.5 bg-red-500/20 text-red-300 text-[10px] font-black uppercase rounded-xl hover:bg-red-500/30 transition border border-red-500/30 flex items-center gap-2 tracking-widest">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    Download Nota (PDF)
                </a>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                <div class="lg:col-span-2 space-y-6">
                    <div class="glass-card-static overflow-hidden">
                        <div class="p-8 border-b border-white/[0.06] flex flex-col sm:flex-row justify-between items-start sm:items-center gap-6">
                            <div class="flex items-center gap-4">
                                <div class="p-3 bg-gradient-to-br from-purple-500/30 to-cyan-500/20 rounded-2xl text-purple-300 border border-purple-500/20">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                                </div>
                                <div>
                                    <p class="text-[10px] font-black text-white/30 uppercase tracking-widest mb-0.5">Status Pesanan</p>
                                    <h3 class="font-black text-2xl gradient-text uppercase tracking-tight leading-none">{{ $pesanan->status }}</h3>
                                </div>
                            </div>
                            <div class="sm:text-right">
                                <p class="text-[10px] font-black text-white/30 uppercase tracking-widest mb-1">Tanggal Transaksi</p>
                                <h3 class="font-bold text-white/80">{{ \Carbon\Carbon::parse($pesanan->created_at)->translatedFormat('d F Y, H:i') }} WITA</h3>
                            </div>
                        </div>

                        <div class="p-8 space-y-6">
                            <div class="flex items-center gap-3 mb-2">
                                <h4 class="font-black text-white uppercase tracking-tighter text-lg">Rincian Produk</h4>
                                <div class="h-px flex-1 bg-white/[0.06]"></div>
                            </div>
                            
                            @foreach($pesanan->detailPesanan as $detail)
                            <div class="group flex flex-col sm:flex-row items-start sm:items-center gap-6 p-5 rounded-2xl border border-white/[0.06] bg-white/[0.03] hover:border-purple-500/20 hover:bg-white/[0.05] transition-all backdrop-blur-sm">
                                <img src="{{ asset('storage/'.$detail->produk->gambar) }}" class="w-20 h-20 object-cover rounded-2xl shadow-sm group-hover:scale-105 transition-transform border border-white/[0.08]">
                                <div class="flex-1">
                                    <h5 class="font-black text-lg text-white uppercase leading-tight">{{ $detail->produk->nama_produk }}</h5>
                                    <div class="flex flex-wrap gap-x-4 gap-y-1 mt-1">
                                        <p class="text-xs font-bold text-white/40 italic">Dimensi: {{ $detail->panjang }}{{ $detail->produk->satuan ?? 'm' }} x {{ $detail->lebar }}{{ $detail->produk->satuan ?? 'm' }}</p>
                                        <p class="text-xs font-black text-purple-300 uppercase tracking-wider">Qty: {{ $detail->jumlah }} Pcs</p>
                                    </div>
                                    @if($detail->finishing)
                                        <div class="mt-3 flex items-start gap-2 p-2 bg-purple-500/10 rounded-xl border border-purple-500/15">
                                            <svg class="w-3.5 h-3.5 text-purple-400 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            <p class="text-[11px] font-bold text-purple-300/80 leading-relaxed uppercase tracking-tighter italic">Catatan: {{ $detail->finishing }}</p>
                                        </div>
                                    @endif
                                </div>
                                <div class="sm:text-right w-full sm:w-auto mt-2 sm:mt-0 pt-4 sm:pt-0 border-t sm:border-0 border-white/[0.06]">
                                    <p class="text-[10px] font-black text-white/30 uppercase tracking-widest mb-0.5">Subtotal</p>
                                    <p class="font-black text-xl text-white">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</p>
                                </div>
                            </div>
                            @endforeach
                        </div>

                        @php
                            $sudahUlas = \App\Models\Ulasan::where('pesanan_id', $pesanan->id)->first();
                        @endphp

                        @if($pesanan->status == 'Selesai')
                            <div class="px-8 py-8 bg-purple-500/5 border-t border-purple-500/10">
                                @if(!$sudahUlas)
                                    <div class="max-w-2xl mx-auto text-center space-y-4" x-data="{ rating: 0 }">
                                        <h4 class="font-black text-purple-300 uppercase tracking-tight italic text-lg text-center">Bagaimana Hasil Cetakan Kami?</h4>
                                        <form action="{{ route('ulasan.store', $pesanan->id) }}" method="POST" class="space-y-4">
                                            @csrf
                                            <div class="flex justify-center gap-2">
                                                @foreach(range(1, 5) as $i)
                                                    <button type="button" @click="rating = {{ $i }}" class="focus:outline-none transition transform hover:scale-125">
                                                        <svg class="w-10 h-10" :class="rating >= {{ $i }} ? 'text-yellow-400 fill-current' : 'text-white/20'" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.175 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                                                        </svg>
                                                    </button>
                                                @endforeach
                                            </div>
                                            <input type="hidden" name="rating" x-model="rating" required>
                                            <textarea name="komentar" rows="3" class="cosmic-textarea w-full" placeholder="Tuliskan kepuasan Anda di sini..." required></textarea>
                                            <button type="submit" class="w-full py-3 cosmic-btn rounded-xl">Kirim Ulasan</button>
                                        </form>
                                    </div>
                                @else
                                    <div class="text-center space-y-2">
                                        <p class="text-[10px] font-black text-white/30 uppercase tracking-widest">Ulasan Anda Telah Terkirim</p>
                                        <div class="flex justify-center gap-1">
                                            @foreach(range(1, $sudahUlas->rating) as $star)
                                                <svg class="w-5 h-5 text-yellow-400 fill-current" viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                                            @endforeach
                                        </div>
                                        <p class="font-black text-white/70 italic text-lg">"{{ $sudahUlas->komentar }}"</p>
                                    </div>
                                @endif
                            </div>
                        @endif

                        <div class="px-8 py-6 border-t border-white/[0.06] space-y-4">
                            <div class="flex justify-between items-center text-white/50">
                                <span class="text-xs font-black uppercase tracking-widest">Subtotal Harga</span>
                                <span class="font-bold text-white">Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}</span>
                            </div>
                            
                            @if($pesanan->potongan_diskon > 0)
                            <div class="flex justify-between items-center bg-emerald-500/10 p-3 rounded-xl border border-emerald-500/20">
                                <div class="flex items-center gap-2">
                                    <div class="p-1 bg-emerald-500/30 rounded-lg text-emerald-300">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12z"></path></svg>
                                    </div>
                                    <span class="text-xs font-black text-emerald-300 uppercase tracking-widest">Diskon Grosir (10%)</span>
                                </div>
                                <span class="font-black text-emerald-400 text-lg">- Rp {{ number_format($pesanan->potongan_diskon, 0, ',', '.') }}</span>
                            </div>
                            @endif

                            @if(explode(' | ', $pesanan->metode_pengiriman)[0] === 'Kurir Lokal')
                            <div class="flex justify-between items-center text-white/50">
                                <span class="text-xs font-black uppercase tracking-widest">Ongkos Kirim</span>
                                @if($pesanan->ongkir > 0)
                                    <span class="font-bold text-orange-400">Rp {{ number_format($pesanan->ongkir, 0, ',', '.') }}</span>
                                @else
                                    <span class="font-bold text-white/30 italic">Menunggu admin</span>
                                @endif
                            </div>
                            @endif
                        </div>

                        <div class="p-8 bg-gradient-to-r from-purple-900/40 to-cyan-900/20 text-white flex flex-col sm:flex-row justify-between items-start sm:items-center gap-6 border-t border-purple-500/10">
                            <div class="flex items-center gap-4">
                                <div class="p-3 bg-white/[0.06] rounded-2xl border border-white/[0.08]">
                                    <svg class="w-6 h-6 text-purple-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                </div>
                                <div>
                                    <p class="text-[10px] font-black text-white/30 uppercase tracking-widest mb-0.5">Metode Pengiriman</p>
                                    <p class="font-black text-lg text-white uppercase tracking-tight">{{ explode(' | ', $pesanan->metode_pengiriman)[0] }}</p>
                                </div>
                            </div>
                            <div class="sm:text-right w-full sm:w-auto">
                                <p class="text-[10px] font-black text-purple-300/70 uppercase tracking-widest mb-1">Total Pembayaran</p>
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
                    <div class="p-8 rounded-3xl text-white border border-white/10 backdrop-blur-xl bg-white/[0.04] shadow-2xl shadow-purple-900/20 sticky top-6">
                        <div class="flex items-center gap-3 mb-8">
                            <div class="p-2.5 rounded-xl bg-gradient-to-br from-purple-500/30 to-cyan-500/20 border border-purple-400/20">
                                <svg class="w-5 h-5 text-purple-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                            </div>
                            <h3 class="font-black text-lg uppercase tracking-tight gradient-text">Status Pesanan</h3>
                        </div>
                        
                        @if($pesanan->status == 'Dibatalkan')
                            <div class="p-6 bg-red-500/10 border border-red-500/30 rounded-2xl text-center backdrop-blur-sm">
                                <svg class="w-14 h-14 text-red-400 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                <h4 class="font-black uppercase text-red-400 text-sm">Pesanan Dibatalkan</h4>
                                <p class="text-[10px] text-red-300/60 mt-2 font-bold">Harap hubungi Admin jika ada kendala.</p>
                            </div>
                        @else
                            @php
                                $steps = ['Verifikasi', 'Antrean Cetak', 'Produksi', 'Siap Ambil', 'Selesai'];
                                $currentIdx = array_search($pesanan->status, $steps);
                                if ($currentIdx === false) {
                                    if ($pesanan->status === 'Sedang Dikirim') $currentIdx = 3;
                                    else $currentIdx = 0;
                                }
                            @endphp
                            <div class="relative space-y-5">
                                
                                {{-- Step 1: Verifikasi --}}
                                @php $active1 = $currentIdx >= 0; @endphp
                                <div class="relative flex items-start gap-4 group">
                                    {{-- Circle --}}
                                    <div class="flex items-center justify-center w-10 h-10 rounded-full shrink-0 z-10 transition-all duration-500 {{ $active1 ? 'bg-gradient-to-br from-blue-500 to-blue-600 shadow-lg shadow-blue-500/50 border-2 border-blue-300/40' : 'bg-white/[0.06] border-2 border-dashed border-white/20' }}">
                                        @if($active1)
                                            <svg class="w-4 h-4 text-white drop-shadow-lg" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        @else
                                            <span class="text-[10px] font-black text-white/50">1</span>
                                        @endif
                                    </div>
                                    @php
                                        $isCash = str_contains($pesanan->metode_pengiriman, 'Cash');
                                    @endphp
                                    {{-- Card --}}
                                    <div class="flex-1 p-4 rounded-xl transition-all duration-500 {{ $active1 ? 'bg-blue-500/15 border border-blue-400/30 shadow-lg shadow-blue-500/10' : 'bg-white/[0.05] border border-white/[0.1]' }}">
                                        <h4 class="font-black text-sm uppercase {{ $active1 ? 'text-blue-300' : 'text-white/60' }}">Verifikasi Kasir</h4>
                                        <p class="text-[10px] mt-1 {{ $active1 ? 'text-blue-200/70' : 'text-white/40' }}">{{ $isCash ? 'Pesanan langsung diproses (Cash).' : 'Mengecek bukti transfer Anda.' }}</p>
                                    </div>
                                </div>

                                {{-- Step 2: Job Masuk --}}
                                @php $active2 = $currentIdx >= 1; @endphp
                                <div class="relative flex items-start gap-4 group">
                                    <div class="flex items-center justify-center w-10 h-10 rounded-full shrink-0 z-10 transition-all duration-500 {{ $active2 ? 'bg-gradient-to-br from-amber-500 to-amber-600 shadow-lg shadow-amber-500/50 border-2 border-amber-300/40' : 'bg-white/[0.06] border-2 border-dashed border-white/20' }}">
                                        @if($active2)
                                            <svg class="w-4 h-4 text-white drop-shadow-lg" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        @else
                                            <span class="text-[10px] font-black text-white/50">2</span>
                                        @endif
                                    </div>
                                    <div class="flex-1 p-4 rounded-xl transition-all duration-500 {{ $active2 ? 'bg-amber-500/15 border border-amber-400/30 shadow-lg shadow-amber-500/10' : 'bg-white/[0.05] border border-white/[0.1]' }}">
                                        <h4 class="font-black text-sm uppercase {{ $active2 ? 'text-amber-300' : 'text-white/60' }}">Job Masuk</h4>
                                        <p class="text-[10px] mt-1 {{ $active2 ? 'text-amber-200/70' : 'text-white/40' }}">Masuk antrean mesin cetak.</p>
                                    </div>
                                </div>

                                {{-- Step 3: Diproduksi --}}
                                @php $active3 = $currentIdx >= 2; @endphp
                                <div class="relative flex items-start gap-4 group">
                                    <div class="flex items-center justify-center w-10 h-10 rounded-full shrink-0 z-10 transition-all duration-500 {{ $active3 ? 'bg-gradient-to-br from-orange-500 to-orange-600 shadow-lg shadow-orange-500/50 border-2 border-orange-300/40' : 'bg-white/[0.06] border-2 border-dashed border-white/20' }}">
                                        @if($active3)
                                            <svg class="w-4 h-4 text-white drop-shadow-lg" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        @else
                                            <span class="text-[10px] font-black text-white/50">3</span>
                                        @endif
                                    </div>
                                    <div class="flex-1 p-4 rounded-xl transition-all duration-500 {{ $active3 ? 'bg-orange-500/15 border border-orange-400/30 shadow-lg shadow-orange-500/10' : 'bg-white/[0.05] border border-white/[0.1]' }}">
                                        <h4 class="font-black text-sm uppercase {{ $active3 ? 'text-orange-300' : 'text-white/60' }}">Diproduksi</h4>
                                        <p class="text-[10px] mt-1 {{ $active3 ? 'text-orange-200/70' : 'text-white/40' }}">Sedang dicetak & finishing.</p>
                                    </div>
                                </div>

                                {{-- Step 4: Siap Ambil / Dikirim --}}
                                @php $active4 = $currentIdx >= 3; @endphp
                                <div class="relative flex items-start gap-4 group">
                                    <div class="flex items-center justify-center w-10 h-10 rounded-full shrink-0 z-10 transition-all duration-500 {{ $active4 ? 'bg-gradient-to-br from-cyan-500 to-cyan-600 shadow-lg shadow-cyan-500/50 border-2 border-cyan-300/40' : 'bg-white/[0.06] border-2 border-dashed border-white/20' }}">
                                        @if($active4)
                                            <svg class="w-4 h-4 text-white drop-shadow-lg" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                        @else
                                            <span class="text-[10px] font-black text-white/50">4</span>
                                        @endif
                                    </div>
                                    <div class="flex-1 p-4 rounded-xl transition-all duration-500 {{ $active4 ? 'bg-cyan-500/15 border border-cyan-400/30 shadow-lg shadow-cyan-500/10' : 'bg-white/[0.05] border border-white/[0.1]' }}">
                                        <h4 class="font-black text-sm uppercase {{ $active4 ? 'text-cyan-300' : 'text-white/60' }}">Siap Ambil / Dikirim</h4>
                                        <p class="text-[10px] mt-1 {{ $active4 ? 'text-cyan-200/70' : 'text-white/40' }}">
                                            @if($pesanan->status == 'Siap Ambil')
                                                Pesanan siap diambil di toko.
                                            @elseif($pesanan->status == 'Sedang Dikirim')
                                                Paket sedang dalam perjalanan.
                                            @else
                                                Pesanan akan siap.
                                            @endif
                                        </p>

                                        @php
                                            $isAmbilToko = str_contains($pesanan->metode_pengiriman, 'Ambil di Toko');
                                        @endphp
                                        @if(in_array($pesanan->status, ['Siap Ambil', 'Sedang Dikirim']) && !$pesanan->konfirmasi_pelanggan && !$isAmbilToko)
                                            <form action="{{ route('pesanan.konfirmasi', $pesanan->id) }}" method="POST" enctype="multipart/form-data" class="mt-4 space-y-3" x-data="{ uploading: false }" @submit="uploading = true">
                                                @csrf
                                                <div class="p-3 bg-cyan-500/10 rounded-xl border border-cyan-400/20">
                                                    <label class="block text-[10px] font-black text-cyan-300 uppercase tracking-widest mb-2">Upload Bukti Pengambilan/Penerimaan</label>
                                                    <input type="file" name="bukti_konfirmasi" accept="image/*" required
                                                        class="block w-full text-xs text-cyan-200 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-[10px] file:font-black file:uppercase file:bg-cyan-500/30 file:text-cyan-300 hover:file:bg-cyan-500/40 file:cursor-pointer file:transition">
                                                </div>
                                                <button type="submit" :disabled="uploading" class="w-full py-2.5 bg-gradient-to-r from-cyan-500 to-cyan-600 text-white text-[10px] font-black uppercase rounded-xl hover:from-cyan-400 hover:to-cyan-500 transition shadow-lg shadow-cyan-500/30 disabled:opacity-50 flex items-center justify-center gap-2">
                                                    <span x-show="!uploading" class="flex items-center gap-2">
                                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                                        Konfirmasi Sudah Diambil/Diterima
                                                    </span>
                                                    <span x-show="uploading" x-cloak class="flex items-center gap-2">
                                                        <svg class="animate-spin h-3.5 w-3.5" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path></svg>
                                                        Mengirim...
                                                    </span>
                                                </button>
                                            </form>
                                        @elseif($pesanan->konfirmasi_pelanggan)
                                            <div class="mt-3 p-3 bg-emerald-500/10 rounded-xl border border-emerald-400/20 text-center">
                                                <svg class="w-6 h-6 text-emerald-400 mx-auto mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                                <p class="text-[10px] font-black text-emerald-300 uppercase tracking-widest">Terkonfirmasi oleh Pelanggan</p>
                                            </div>
                                            @if($pesanan->bukti_konfirmasi)
                                                <div class="mt-2">
                                                    <p class="text-[10px] font-black text-white/30 uppercase tracking-widest mb-1">Bukti Pengambilan</p>
                                                    <img src="{{ asset('storage/'.$pesanan->bukti_konfirmasi) }}" class="w-full rounded-xl border border-white/10">
                                                </div>
                                            @endif
                                        @endif
                                    </div>
                                </div>

                                {{-- Step 5: Selesai --}}
                                @php $active5 = $currentIdx >= 4; @endphp
                                <div class="relative flex items-start gap-4 group">
                                    <div class="flex items-center justify-center w-10 h-10 rounded-full shrink-0 z-10 transition-all duration-500 {{ $active5 ? 'bg-gradient-to-br from-emerald-500 to-emerald-600 shadow-lg shadow-emerald-500/50 border-2 border-emerald-300/40' : 'bg-white/[0.06] border-2 border-dashed border-white/20' }}">
                                        @if($active5)
                                            <svg class="w-4 h-4 text-white drop-shadow-lg" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        @else
                                            <span class="text-[10px] font-black text-white/50">5</span>
                                        @endif
                                    </div>
                                    <div class="flex-1 p-4 rounded-xl transition-all duration-500 {{ $active5 ? 'bg-emerald-500/15 border border-emerald-400/30 shadow-lg shadow-emerald-500/10' : 'bg-white/[0.05] border border-white/[0.1]' }}">
                                        <h4 class="font-black text-sm uppercase {{ $active5 ? 'text-emerald-300' : 'text-white/60' }}">Transaksi Selesai</h4>
                                        <p class="text-[10px] mt-1 {{ $active5 ? 'text-emerald-200/70' : 'text-white/40' }}">
                                            @if($active5)
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

                    @php
                        $waMessage = "Halo Orbit Digital Printing, saya ingin bertanya tentang pesanan saya dengan invoice *" . $pesanan->nomor_invoice . "*.";
                        $waAdmin = $adminPhone ? \App\Services\WhatsAppService::waLink($adminPhone, $waMessage) : null;
                    @endphp
                    @if($waAdmin)
                        <a href="{{ $waAdmin }}" target="_blank" class="w-full flex items-center justify-center gap-2 px-6 py-3.5 bg-gradient-to-r from-emerald-500 to-emerald-600 text-white text-xs font-black uppercase rounded-2xl hover:from-emerald-400 hover:to-emerald-500 transition shadow-lg shadow-emerald-500/30">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12.04 2a9.9 9.9 0 00-8.4 15.17L2 22l4.96-1.6A9.9 9.9 0 1012.04 2zm5.8 14.06c-.24.68-1.4 1.3-1.94 1.34-.5.04-1.13.21-3.8-.8-3.22-1.23-5.26-4.46-5.42-4.67-.16-.21-1.3-1.72-1.3-3.29 0-1.56.82-2.33 1.11-2.65.3-.32.64-.4.85-.4.21 0 .43 0 .61.01.2.01.46-.07.72.55.26.64.9 2.2.98 2.36.08.16.13.35.03.56-.1.21-.15.34-.3.53-.15.19-.32.42-.46.56-.15.15-.3.31-.13.61.17.3.76 1.25 1.63 2.03 1.12 1 2.06 1.31 2.35 1.46.29.15.46.13.63-.07.17-.21.72-.84.92-1.13.2-.29.39-.24.66-.14.26.09 1.68.79 1.97.94.29.14.48.21.55.33.07.11.07.65-.17 1.33z"/></svg>
                            Chat Admin via WhatsApp
                        </a>
                    @endif
                </div>

            </div>

            <p class="text-center text-[10px] font-black text-white/20 uppercase tracking-[0.2em]">Orbit Digital Printing &copy; {{ date('Y') }} - Banjarmasin Smart City</p>
        </div>
    </div>
</x-app-layout>