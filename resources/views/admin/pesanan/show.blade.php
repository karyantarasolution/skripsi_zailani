<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-2xl text-gray-900 uppercase tracking-tight">Detail Pesanan: {{ $pesanan->nomor_invoice }}</h2>
    </x-slot>
<div class="flex flex-wrap gap-3 mt-4">
    <a href="{{ route('admin.pesanan.cetakSPK', $pesanan->id) }}" target="_blank" class="px-4 py-2 bg-gray-800 text-white text-xs font-black uppercase rounded-xl hover:bg-black transition">
        Cetak SPK Produksi
    </a>
    <a href="{{ route('admin.pesanan.cetakLabel', $pesanan->id) }}" target="_blank" class="px-4 py-2 bg-orange-500 text-white text-xs font-black uppercase rounded-xl hover:bg-orange-600 transition">
        Cetak Label Pengiriman
    </a>
</div>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <a href="{{ route('admin.pesanan.index') }}" class="text-xs font-black text-gray-400 uppercase hover:text-indigo-600 transition tracking-widest">&larr; Kembali ke Daftar</a>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div class="lg:col-span-2 space-y-6">
                    <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100">
                        <h3 class="font-black text-gray-950 uppercase mb-6 tracking-tighter">Item Dipesan</h3>
                        <div class="space-y-4">
                            @foreach($pesanan->detailPesanan as $detail)
                            <div class="flex items-center gap-6 p-4 bg-gray-50 rounded-2xl border border-gray-100">
                                @if($detail->produk->gambar)
                                    <img src="{{ asset('storage/'.$detail->produk->gambar) }}" class="w-16 h-16 object-cover rounded-xl shadow-sm">
                                @else
                                    <div class="w-16 h-16 rounded-xl bg-gray-200 flex items-center justify-center text-gray-400">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    </div>
                                @endif
                                <div class="flex-1">
                                    <h5 class="font-black text-gray-950 uppercase">{{ $detail->produk->nama_produk }}</h5>
                                    <p class="text-xs font-bold text-gray-500 mt-1">Ukuran: {{ $detail->panjang }}{{ $detail->produk->satuan ?? 'm' }} x {{ $detail->lebar }}{{ $detail->produk->satuan ?? 'm' }} | Jumlah: {{ $detail->jumlah }}</p>
                                    @if($detail->finishing)
                                        <p class="text-[10px] font-bold text-indigo-600 mt-2 uppercase tracking-widest">Catatan: {{ $detail->finishing }}</p>
                                    @endif
                                </div>
                                <div class="text-right">
                                    <p class="font-black text-gray-950">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</p>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100">
                        <h3 class="font-black text-gray-950 uppercase mb-6 tracking-tighter">Bukti Pembayaran</h3>
                        @if(str_contains($pesanan->metode_pengiriman, 'Cash'))
                            <div class="p-6 bg-emerald-50 border-2 border-emerald-200 rounded-2xl text-center">
                                <svg class="w-12 h-12 text-emerald-500 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                                <p class="font-black text-emerald-700 uppercase text-lg">Pembayaran Cash</p>
                                <p class="text-sm font-bold text-emerald-600 mt-1">Pelanggan akan membayar langsung di kasir</p>
                            </div>
                        @elseif($pesanan->bukti_bayar)
                            <img src="{{ asset('storage/'.$pesanan->bukti_bayar) }}" class="max-w-md w-full rounded-2xl border border-gray-200 shadow-sm">
                        @else
                            <p class="text-red-500 font-bold italic">Bukti bayar tidak ditemukan.</p>
                        @endif
                    </div>
                </div>

                <div class="lg:col-span-1 space-y-6">
                    <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100">
                        <h3 class="font-black text-gray-950 uppercase mb-6 tracking-tighter">Informasi Pelanggan</h3>
                        <div class="space-y-4">
                            <div>
                                <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Nama Lengkap</p>
                                <p class="font-bold text-gray-900">{{ $pesanan->user->name }}</p>
                            </div>
                            <div>
                                <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Email</p>
                                <p class="font-bold text-gray-900">{{ $pesanan->user->email }}</p>
                            </div>
                            <div>
                                <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Telepon</p>
                                <p class="font-bold text-gray-900">{{ $pesanan->user->telepon ?? 'Tidak ada' }}</p>
                            </div>
                            <div>
                                <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Alamat</p>
                                <p class="font-bold text-gray-900">{{ $pesanan->user->alamat ?? 'Ambil di Toko' }}</p>
                            </div>
                        </div>
                    </div>

                    @php
                        $paymentParts = explode(' | ', $pesanan->metode_pengiriman);
                        $shippingMethod = $paymentParts[0] ?? $pesanan->metode_pengiriman;
                        $paymentMethod = $paymentParts[1] ?? 'Tidak diketahui';
                    @endphp
                    <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100">
                        <h3 class="font-black text-gray-950 uppercase mb-6 tracking-tighter">Informasi Pembayaran</h3>
                        <div class="space-y-4">
                            <div>
                                <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Metode Pembayaran</p>
                                <p class="font-bold text-gray-900">{{ $paymentMethod }}</p>
                            </div>
                            <div>
                                <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Metode Pengiriman</p>
                                <p class="font-bold text-gray-900">{{ $shippingMethod }}</p>
                            </div>
                            @if(str_contains($shippingMethod, 'Kurir Lokal'))
                            <div>
                                <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Ongkos Kirim</p>
                                @if($pesanan->ongkir > 0)
                                    <p class="font-black text-orange-600">Rp {{ number_format($pesanan->ongkir, 0, ',', '.') }}</p>
                                @else
                                    <p class="font-bold text-gray-400 italic">Belum ditentukan</p>
                                @endif
                            </div>
                            @endif
                            <div>
                                <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Total Dibayar</p>
                                <p class="font-black text-2xl text-indigo-600">Rp {{ number_format($pesanan->total_bayar, 0, ',', '.') }}</p>
                            </div>
                        </div>
                    </div>

                    @if(in_array($pesanan->status, ['Siap Ambil', 'Sedang Dikirim']))
                    <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100">
                        <h3 class="font-black text-gray-950 uppercase mb-6 tracking-tighter">Konfirmasi Pelanggan</h3>
                        @if($pesanan->konfirmasi_pelanggan)
                            <div class="p-4 bg-emerald-50 border-2 border-emerald-200 rounded-2xl text-center mb-4">
                                <svg class="w-10 h-10 text-emerald-500 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                <p class="font-black text-emerald-700 uppercase">Sudah Dikonfirmasi</p>
                                <p class="text-sm font-bold text-emerald-600 mt-1">Pelanggan sudah mengambil/menerima pesanan</p>
                            </div>
                            @if($pesanan->bukti_konfirmasi)
                                <div>
                                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Bukti Pengambilan</p>
                                    <img src="{{ asset('storage/'.$pesanan->bukti_konfirmasi) }}" class="w-full rounded-2xl border border-gray-200 shadow-sm">
                                </div>
                            @endif
                        @else
                            <div class="p-4 bg-amber-50 border-2 border-amber-200 rounded-2xl text-center">
                                <svg class="w-10 h-10 text-amber-500 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                <p class="font-black text-amber-700 uppercase">Menunggu Konfirmasi</p>
                                <p class="text-sm font-bold text-amber-600 mt-1">Pelanggan belum mengkonfirmasi pengambilan/penerimaan</p>
                            </div>
                        @endif
                    </div>
                    @endif

                    <div class="bg-indigo-950 p-8 rounded-3xl shadow-xl">
                        <h3 class="font-black text-white uppercase mb-6 tracking-tighter">Update Status</h3>
                        
                        <form action="{{ route('admin.pesanan.updateStatus', $pesanan->id) }}" method="POST" class="space-y-4">
                            @csrf
                            @method('PATCH')

                            @if(str_contains($shippingMethod, 'Kurir Lokal'))
                            <div>
                                <label class="block text-[10px] font-black text-indigo-300 uppercase tracking-widest mb-2">Ongkos Kirim (Rp)</label>
                                <input type="number" name="ongkir" value="{{ $pesanan->ongkir }}" min="0" class="w-full px-4 py-3 rounded-xl border-0 focus:ring-4 focus:ring-indigo-500 font-bold bg-white text-gray-900" placeholder="Masukkan ongkir...">
                            </div>
                            @endif
                            
                            <select name="status" class="w-full px-4 py-3 rounded-xl border-0 focus:ring-4 focus:ring-indigo-500 font-bold bg-white text-gray-900">
                                <option value="Verifikasi" {{ $pesanan->status == 'Verifikasi' ? 'selected' : '' }}>Verifikasi Pembayaran</option>
                                <option value="Antrean Cetak" {{ $pesanan->status == 'Antrean Cetak' ? 'selected' : '' }}>Masuk Antrean Cetak</option>
                                <option value="Produksi" {{ $pesanan->status == 'Produksi' ? 'selected' : '' }}>Sedang Produksi (Dicetak)</option>
                                <option value="Siap Ambil" {{ $pesanan->status == 'Siap Ambil' ? 'selected' : '' }}>Siap Ambil di Toko</option>
                                <option value="Sedang Dikirim" {{ $pesanan->status == 'Sedang Dikirim' ? 'selected' : '' }}>Paket Sedang Dikirim</option>
                                @php
                                    $canFinish = !in_array($pesanan->status, ['Siap Ambil', 'Sedang Dikirim']) || $pesanan->konfirmasi_pelanggan;
                                @endphp
                                <option value="Selesai" {{ $pesanan->status == 'Selesai' ? 'selected' : '' }} {{ !$canFinish ? 'disabled' : '' }}>
                                    Transaksi Selesai {{ !$canFinish ? '(Menunggu Konfirmasi Pelanggan)' : '' }}
                                </option>
                                <option value="Dibatalkan" {{ $pesanan->status == 'Dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                            </select>

                            <button type="submit" class="w-full py-3 bg-indigo-600 text-white font-black uppercase rounded-xl hover:bg-indigo-500 transition shadow-lg mt-4">
                                Simpan Status
                            </button>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>