<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-2xl text-white uppercase tracking-tight italic">{{ $detailKeranjang ? 'Edit: ' : 'Pesan: ' }}<span class="gradient-text">{{ $produk->nama_produk }}</span></h2>
    </x-slot>

    @php
        $editPanjang = $detailKeranjang ? $detailKeranjang->panjang : '';
        $editLebar = $detailKeranjang ? $detailKeranjang->lebar : '';
        $editJumlah = $detailKeranjang ? $detailKeranjang->jumlah : 1;
    @endphp
    <div class="py-12" x-data="{ 
        panjang: '{{ $editPanjang }}', 
        lebar: '{{ $editLebar }}', 
        jumlah: {{ $editJumlah }}, 
        hargaDasar: {{ $produk->harga_dasar }},
        get total() {
            let p = parseFloat(this.panjang) || 0;
            let l = parseFloat(this.lebar) || 0;
            let j = parseInt(this.jumlah) || 1;
            return p * l * this.hargaDasar * j;
        }
    }">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="glass-card-static overflow-hidden">
                <div class="md:flex">
                    <div class="md:w-1/3 p-8 border-r border-white/[0.06] flex flex-col items-center justify-center text-center bg-white/[0.02]">
                        <img src="{{ asset('storage/'.$produk->gambar) }}" class="w-full rounded-2xl shadow-md mb-6 border border-white/[0.08] transform hover:scale-105 transition-transform">
                        <h3 class="font-black text-xl text-white uppercase leading-none">{{ $produk->nama_produk }}</h3>
                        <p class="text-[10px] font-black text-purple-300 uppercase tracking-widest mt-3 px-3 py-1 bg-purple-500/15 rounded-full inline-block border border-purple-500/20">{{ $produk->bahanBaku->pluck('nama_bahan')->implode(', ') ?: 'Material Custom' }}</p>
                        
                        <div class="mt-8 w-full p-4 bg-white/[0.04] rounded-2xl border border-white/[0.08]">
                            <p class="text-[10px] font-black text-white/30 uppercase tracking-tighter">Harga Estimasi Dasar</p>
                            <p class="text-2xl font-black text-white">Rp {{ number_format($produk->harga_dasar, 0, ',', '.') }}<span class="text-xs text-white/30 font-bold">/m²</span><br><span class="text-[9px] text-purple-400 font-bold">(satuan: {{ $produk->satuan == 'cm' ? 'Centimeter' : ($produk->satuan == 'mm' ? 'Milimeter' : 'Meter') }})</span></p>
                        </div>

                        <div class="mt-4 w-full p-5 bg-gradient-to-br from-purple-600/40 to-cyan-600/20 rounded-2xl shadow-lg border border-purple-500/30">
                            <p class="text-[10px] font-black text-purple-200/60 uppercase tracking-widest mb-1">Total Sementara</p>
                            <p class="text-2xl font-black text-white">Rp <span x-text="new Intl.NumberFormat('id-ID').format(total)">0</span></p>
                        </div>
                    </div>

                    <div class="md:w-2/3 p-10">
                        @if($errors->any())
                            <div class="mb-6 p-4 bg-red-500/10 border border-red-500/30 text-red-300 rounded-2xl font-bold uppercase tracking-widest text-xs">
                                @foreach($errors->all() as $error)
                                    <p>✗ {{ $error }}</p>
                                @endforeach
                            </div>
                        @endif

                        @if(session('error'))
                            <div class="mb-6 p-4 bg-red-500/10 border border-red-500/30 text-red-300 rounded-2xl font-bold uppercase tracking-widest text-xs">
                                ✗ {{ session('error') }}
                            </div>
                        @endif

                        <form action="{{ $detailKeranjang ? route('keranjang.update', $detailKeranjang->id) : route('pesan.cart', $produk->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                            @csrf
                            @if($detailKeranjang) @method('PUT') @endif
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                @php
                                    $satuanLabel = match($produk->satuan) { 'cm' => 'Centimeter', 'mm' => 'Milimeter', default => 'Meter' };
                                    $step = $produk->satuan == 'mm' ? '1' : '0.01';
                                @endphp
                                <div>
                                    <label class="block text-[10px] font-black text-white/30 uppercase tracking-widest mb-2">Panjang ({{ $satuanLabel }})</label>
                                    <input type="number" step="{{ $step }}" name="panjang" x-model="panjang" required class="glass-input w-full p-4 text-lg font-black @error('panjang') border-red-500/50 @enderror" placeholder="0.00">
                                    @error('panjang') <p class="text-red-400 text-xs font-bold mt-1">{{ $message }}</p> @enderror
                                </div>
                                <div>
                                    <label class="block text-[10px] font-black text-white/30 uppercase tracking-widest mb-2">Lebar ({{ $satuanLabel }})</label>
                                    <input type="number" step="{{ $step }}" name="lebar" x-model="lebar" required class="glass-input w-full p-4 text-lg font-black @error('lebar') border-red-500/50 @enderror" placeholder="0.00">
                                    @error('lebar') <p class="text-red-400 text-xs font-bold mt-1">{{ $message }}</p> @enderror
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-[10px] font-black text-white/30 uppercase tracking-widest mb-2">Jumlah Cetak (QTY)</label>
                                    <input type="number" name="jumlah" x-model="jumlah" min="1" required class="glass-input w-full p-4 text-lg font-black @error('jumlah') border-red-500/50 @enderror">
                                    @error('jumlah') <p class="text-red-400 text-xs font-bold mt-1">{{ $message }}</p> @enderror
                                </div>
                                <div>
                                    <label class="block text-[10px] font-black text-white/30 uppercase tracking-widest mb-2">Upload Desain (Opsional)</label>
                                    <input type="file" name="file_desain" class="cosmic-file-input w-full">
                                    @error('file_desain') <p class="text-red-400 text-xs font-bold mt-1">{{ $message }}</p> @enderror
                                </div>
                            </div>

                            <div>
                                <label class="block text-[10px] font-black text-white/30 uppercase tracking-widest mb-2">Catatan Finishing / Instruksi</label>
                                <textarea name="catatan" rows="3" class="cosmic-textarea w-full" placeholder="Contoh: Mata ayam di setiap sudut, lipat press, dll.">{{ $detailKeranjang ? $detailKeranjang->catatan : '' }}</textarea>
                            </div>

                            <div class="pt-4 flex gap-3">
                                @if($detailKeranjang)
                                <a href="{{ route('keranjang.index') }}" class="py-5 px-8 bg-white/[0.05] text-white/60 font-black uppercase rounded-2xl hover:bg-white/[0.08] transition border border-white/[0.08] flex items-center justify-center gap-3">
                                    Batal
                                </a>
                                @endif
                                <button type="submit" class="flex-1 py-5 cosmic-btn rounded-2xl flex items-center justify-center gap-3">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                                    {{ $detailKeranjang ? 'Update Keranjang' : 'Masukkan Ke Keranjang' }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
