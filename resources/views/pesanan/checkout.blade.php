<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-2xl text-white uppercase tracking-tight italic">Finalisasi <span class="gradient-text">Pembayaran</span></h2>
    </x-slot>

    <div class="py-12" x-data="{ metode_pembayaran: 'Mandiri', metode_pengiriman: 'Ambil di Toko' }">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                
                <div class="space-y-6">
                    <div class="glass-card-static p-8">
                        <h3 class="font-black text-white uppercase mb-6 tracking-tighter">Rincian & Diskon</h3>
                        <div class="space-y-4">
                            
                            <div class="flex justify-between items-center pb-4 border-b border-white/[0.06]">
                                <span class="text-sm font-bold text-white/40">Total Item</span>
                                <span class="font-black text-white">{{ $total_item }} Pcs</span>
                            </div>

                            <div class="flex justify-between items-center pb-4 border-b border-white/[0.06]">
                                <span class="text-sm font-bold text-white/40">Subtotal</span>
                                <span class="font-black text-white">Rp {{ number_format($total_harga, 0, ',', '.') }}</span>
                            </div>

                            @if($potongan_diskon > 0)
                            <div class="flex justify-between items-center pb-4 border-b border-white/[0.06]">
                                <span class="text-sm font-black text-emerald-400 uppercase">Diskon Grosir (10%)</span>
                                <span class="font-black text-emerald-400">- Rp {{ number_format($potongan_diskon, 0, ',', '.') }}</span>
                            </div>
                            @endif

                            <div class="flex justify-between items-center pb-4 border-b border-white/[0.06]">
                                <span class="text-sm font-bold text-white/40">Ongkos Kirim</span>
                                <template x-if="metode_pengiriman === 'Ambil di Toko'">
                                    <span class="font-black text-white">Gratis</span>
                                </template>
                                <template x-if="metode_pengiriman === 'Kurir Lokal'">
                                    <span class="font-black text-orange-400">Ditentukan Admin</span>
                                </template>
                            </div>

                            <div class="p-4 bg-white/[0.04] rounded-2xl border border-white/[0.08] mt-4">
                                <p class="text-[10px] font-black text-white/30 uppercase mb-1">Total yang harus dibayar</p>
                                <p class="font-black text-3xl text-white tracking-tighter">
                                    Rp {{ number_format($total_bayar, 0, ',', '.') }}
                                </p>
                            </div>

                        </div>
                    </div>

                    <div x-show="metode_pembayaran !== 'Cash'" class="glass-card-static p-8 transition-all" x-transition>
                        <h3 class="font-black uppercase mb-4 tracking-tighter text-purple-300">Instruksi Transfer</h3>
                        <p class="text-[10px] font-black uppercase mb-1 text-white/40" x-text="'Bank ' + metode_pembayaran"></p>
                        <p class="font-black text-2xl tracking-wider text-white" x-text="
                            metode_pembayaran === 'Mandiri' ? '123-000-456-789' : 
                            (metode_pembayaran === 'BCA' ? '0987-6543-21' : 
                            (metode_pembayaran === 'BNI' ? '1122-3344-55' : '0011-2233-4455-667'))
                        "></p>
                        <p class="text-xs font-bold mt-1 uppercase text-white/60">A.N ORBIT DIGITAL PRINTING</p>
                    </div>

                    <div x-show="metode_pembayaran === 'Cash'" class="glass-card-static p-8 transition-all" x-transition>
                        <h3 class="font-black uppercase mb-4 tracking-tighter text-purple-300">Pembayaran Cash</h3>
                        <p class="text-sm font-bold text-white/60">Bayar langsung di kasir toko setelah pesanan diproses.</p>
                        <p class="text-[10px] font-black uppercase mt-4 text-white/30">Orbit Digital Printing - Banjarmasin</p>
                    </div>
                </div>

                <div class="glass-card-static p-8">
                    <h3 class="font-black text-white uppercase mb-6 tracking-tighter italic">Pengiriman & Pembayaran</h3>
                    
                    @if ($errors->any())
                        <div class="mb-6 p-4 bg-red-500/10 border border-red-500/30 text-red-300 rounded-2xl font-bold uppercase tracking-widest text-[10px]">
                            @foreach ($errors->all() as $error)
                                <p>⚠️ {{ $error }}</p>
                            @endforeach
                        </div>
                    @endif

                    <form action="{{ route('pesan.storeCheckout') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        
                        <div class="space-y-2">
                            <label class="block text-sm font-black text-white/40 uppercase tracking-widest">Metode Pengiriman</label>
                            <select name="metode_pengiriman" required x-model="metode_pengiriman" class="cosmic-select w-full">
                                <option value="Ambil di Toko">Ambil di Toko (Gratis)</option>
                                <option value="Kurir Lokal">Kurir Lokal (Banjarmasin)</option>
                            </select>
                            <p x-show="metode_pengiriman === 'Kurir Lokal'" x-transition class="text-[10px] font-black text-orange-400 uppercase tracking-widest mt-1">
                                *Ongkos kirim akan ditentukan oleh admin saat verifikasi pesanan
                            </p>
                        </div>

                        <div class="space-y-2">
                            <label class="block text-sm font-black text-white/40 uppercase tracking-widest">Metode Pembayaran</label>
                            <div class="grid grid-cols-2 gap-3">
                                <label class="cursor-pointer">
                                    <input type="radio" name="metode_pembayaran" value="Mandiri" x-model="metode_pembayaran" class="peer sr-only" required>
                                    <div class="p-3 border-2 border-white/[0.08] rounded-xl peer-checked:border-emerald-500/50 peer-checked:bg-emerald-500/10 text-center transition">
                                        <span class="font-black text-white uppercase">Mandiri</span>
                                    </div>
                                </label>
                                <label class="cursor-pointer">
                                    <input type="radio" name="metode_pembayaran" value="BCA" x-model="metode_pembayaran" class="peer sr-only" required>
                                    <div class="p-3 border-2 border-white/[0.08] rounded-xl peer-checked:border-emerald-500/50 peer-checked:bg-emerald-500/10 text-center transition">
                                        <span class="font-black text-white uppercase">BCA</span>
                                    </div>
                                </label>
                                <label class="cursor-pointer">
                                    <input type="radio" name="metode_pembayaran" value="BNI" x-model="metode_pembayaran" class="peer sr-only" required>
                                    <div class="p-3 border-2 border-white/[0.08] rounded-xl peer-checked:border-emerald-500/50 peer-checked:bg-emerald-500/10 text-center transition">
                                        <span class="font-black text-white uppercase">BNI</span>
                                    </div>
                                </label>
                                <label class="cursor-pointer">
                                    <input type="radio" name="metode_pembayaran" value="BRI" x-model="metode_pembayaran" class="peer sr-only" required>
                                    <div class="p-3 border-2 border-white/[0.08] rounded-xl peer-checked:border-emerald-500/50 peer-checked:bg-emerald-500/10 text-center transition">
                                        <span class="font-black text-white uppercase">BRI</span>
                                    </div>
                                </label>
                                <label class="cursor-pointer md:col-span-2">
                                    <input type="radio" name="metode_pembayaran" value="Cash" x-model="metode_pembayaran" class="peer sr-only" required>
                                    <div class="p-3 border-2 border-white/[0.08] rounded-xl peer-checked:border-emerald-500/50 peer-checked:bg-emerald-500/10 text-center transition flex items-center justify-center gap-2">
                                        <svg class="w-5 h-5 text-white/60" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                                        <span class="font-black text-white uppercase">Cash (Bayar di Tempat)</span>
                                    </div>
                                </label>
                            </div>
                        </div>

                        <div x-show="metode_pembayaran !== 'Cash'" class="space-y-2">
                            <label class="block text-sm font-black text-white/40 uppercase tracking-widest">Foto Struk / Screenshot</label>
                            <div class="border-2 border-dashed border-white/[0.1] rounded-2xl p-6 text-center hover:border-purple-500/30 transition bg-white/[0.02]">
                                <input type="file" name="bukti_bayar" accept="image/*" class="cosmic-file-input block w-full">
                            </div>
                        </div>

                        <button type="submit" class="w-full py-4 cosmic-btn cosmic-btn-success rounded-2xl">
                            Konfirmasi Transaksi
                        </button>
                    </form>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
