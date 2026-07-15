<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-2xl text-gray-900 uppercase tracking-tight italic">Finalisasi Pembayaran</h2>
    </x-slot>

    <div class="py-12" x-data="{ metode_pembayaran: 'Mandiri', metode_pengiriman: 'Ambil di Toko' }">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                
                <div class="space-y-6">
                    <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100">
                        <h3 class="font-black text-gray-950 uppercase mb-6 tracking-tighter">Rincian & Diskon</h3>
                        <div class="space-y-4">
                            
                            <div class="flex justify-between items-center pb-4 border-b border-gray-50">
                                <span class="text-sm font-bold text-gray-500">Total Item</span>
                                <span class="font-black text-gray-900">{{ $total_item }} Pcs</span>
                            </div>

                            <div class="flex justify-between items-center pb-4 border-b border-gray-50">
                                <span class="text-sm font-bold text-gray-500">Subtotal</span>
                                <span class="font-black text-gray-900">Rp {{ number_format($total_harga, 0, ',', '.') }}</span>
                            </div>

                            @if($potongan_diskon > 0)
                            <div class="flex justify-between items-center pb-4 border-b border-gray-50">
                                <span class="text-sm font-black text-emerald-500 uppercase">Diskon Grosir (10%)</span>
                                <span class="font-black text-emerald-600">- Rp {{ number_format($potongan_diskon, 0, ',', '.') }}</span>
                            </div>
                            @endif

                            <div class="flex justify-between items-center pb-4 border-b border-gray-50">
                                <span class="text-sm font-bold text-gray-500">Ongkos Kirim</span>
                                <template x-if="metode_pengiriman === 'Ambil di Toko'">
                                    <span class="font-black text-gray-900">Gratis</span>
                                </template>
                                <template x-if="metode_pengiriman === 'Kurir Lokal'">
                                    <span class="font-black text-orange-500">Ditentukan Admin</span>
                                </template>
                            </div>

                            <div class="p-4 bg-gray-50 rounded-2xl border border-gray-100 mt-4">
                                <p class="text-[10px] font-black text-gray-400 uppercase mb-1">Total yang harus dibayar</p>
                                <p class="font-black text-3xl text-gray-950 tracking-tighter">
                                    Rp {{ number_format($total_bayar, 0, ',', '.') }}
                                </p>
                            </div>

                        </div>
                    </div>

                    <div x-show="metode_pembayaran !== 'Cash'" class="bg-indigo-950 p-8 rounded-3xl shadow-sm text-white border border-indigo-900 transition-all">
                        <h3 class="font-black uppercase mb-4 tracking-tighter text-indigo-200">Instruksi Transfer</h3>
                        <p class="text-[10px] font-black uppercase mb-1 opacity-70" x-text="'Bank ' + metode_pembayaran"></p>
                        <p class="font-black text-2xl tracking-wider" x-text="
                            metode_pembayaran === 'Mandiri' ? '123-000-456-789' : 
                            (metode_pembayaran === 'BCA' ? '0987-6543-21' : 
                            (metode_pembayaran === 'BNI' ? '1122-3344-55' : '0011-2233-4455-667'))
                        "></p>
                        <p class="text-xs font-bold mt-1 uppercase opacity-90">A.N ORBIT DIGITAL PRINTING</p>
                    </div>

                    <div x-show="metode_pembayaran === 'Cash'" class="bg-indigo-950 p-8 rounded-3xl shadow-sm text-white border border-indigo-900 transition-all">
                        <h3 class="font-black uppercase mb-4 tracking-tighter text-indigo-200">Pembayaran Cash</h3>
                        <p class="text-sm font-bold opacity-90">Bayar langsung di kasir toko setelah pesanan diproses.</p>
                        <p class="text-[10px] font-black uppercase mt-4 opacity-70">Orbit Digital Printing - Banjarmasin</p>
                    </div>
                </div>

                <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100">
                    <h3 class="font-black text-gray-950 uppercase mb-6 tracking-tighter italic">Pengiriman & Pembayaran</h3>
                    
                    @if ($errors->any())
                        <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-700 rounded-2xl font-bold uppercase tracking-widest text-[10px]">
                            @foreach ($errors->all() as $error)
                                <p>⚠️ {{ $error }}</p>
                            @endforeach
                        </div>
                    @endif

                    <form action="{{ route('pesan.storeCheckout') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        
                        <div class="space-y-2">
                            <label class="block text-sm font-black text-gray-400 uppercase tracking-widest">Metode Pengiriman</label>
                            <select name="metode_pengiriman" required x-model="metode_pengiriman" class="w-full px-4 py-3 rounded-xl border-gray-200 focus:ring-4 focus:ring-emerald-50 focus:border-emerald-500 font-bold text-gray-700 transition">
                                <option value="Ambil di Toko">Ambil di Toko (Gratis)</option>
                                <option value="Kurir Lokal">Kurir Lokal (Banjarmasin)</option>
                            </select>
                            <p x-show="metode_pengiriman === 'Kurir Lokal'" x-transition class="text-[10px] font-black text-orange-500 uppercase tracking-widest mt-1">
                                *Ongkos kirim akan ditentukan oleh admin saat verifikasi pesanan
                            </p>
                        </div>

                        <div class="space-y-2">
                            <label class="block text-sm font-black text-gray-400 uppercase tracking-widest">Metode Pembayaran</label>
                            <div class="grid grid-cols-2 gap-3">
                                <label class="cursor-pointer">
                                    <input type="radio" name="metode_pembayaran" value="Mandiri" x-model="metode_pembayaran" class="peer sr-only" required>
                                    <div class="p-3 border-2 border-gray-100 rounded-xl peer-checked:border-emerald-500 peer-checked:bg-emerald-50 text-center transition">
                                        <span class="font-black text-gray-900 uppercase">Mandiri</span>
                                    </div>
                                </label>
                                <label class="cursor-pointer">
                                    <input type="radio" name="metode_pembayaran" value="BCA" x-model="metode_pembayaran" class="peer sr-only" required>
                                    <div class="p-3 border-2 border-gray-100 rounded-xl peer-checked:border-emerald-500 peer-checked:bg-emerald-50 text-center transition">
                                        <span class="font-black text-gray-900 uppercase">BCA</span>
                                    </div>
                                </label>
                                <label class="cursor-pointer">
                                    <input type="radio" name="metode_pembayaran" value="BNI" x-model="metode_pembayaran" class="peer sr-only" required>
                                    <div class="p-3 border-2 border-gray-100 rounded-xl peer-checked:border-emerald-500 peer-checked:bg-emerald-50 text-center transition">
                                        <span class="font-black text-gray-900 uppercase">BNI</span>
                                    </div>
                                </label>
                                <label class="cursor-pointer">
                                    <input type="radio" name="metode_pembayaran" value="BRI" x-model="metode_pembayaran" class="peer sr-only" required>
                                    <div class="p-3 border-2 border-gray-100 rounded-xl peer-checked:border-emerald-500 peer-checked:bg-emerald-50 text-center transition">
                                        <span class="font-black text-gray-900 uppercase">BRI</span>
                                    </div>
                                </label>
                                <label class="cursor-pointer md:col-span-2">
                                    <input type="radio" name="metode_pembayaran" value="Cash" x-model="metode_pembayaran" class="peer sr-only" required>
                                    <div class="p-3 border-2 border-gray-100 rounded-xl peer-checked:border-emerald-500 peer-checked:bg-emerald-50 text-center transition flex items-center justify-center gap-2">
                                        <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                                        <span class="font-black text-gray-900 uppercase">Cash (Bayar di Tempat)</span>
                                    </div>
                                </label>
                            </div>
                        </div>

                        <div x-show="metode_pembayaran !== 'Cash'" class="space-y-2">
                            <label class="block text-sm font-black text-gray-400 uppercase tracking-widest">Foto Struk / Screenshot</label>
                            <div class="border-2 border-dashed border-gray-200 rounded-2xl p-6 text-center hover:border-emerald-500 transition bg-gray-50/50">
                                <input type="file" name="bukti_bayar" accept="image/*" class="block w-full text-xs text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-black file:bg-emerald-500 file:text-white hover:file:bg-emerald-600 cursor-pointer">
                            </div>
                        </div>

                        <button type="submit" class="w-full py-4 bg-emerald-500 text-white font-black uppercase rounded-2xl shadow-xl shadow-emerald-200 hover:bg-emerald-600 transition-all transform active:scale-95">
                            Konfirmasi Transaksi
                        </button>
                    </form>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>