<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-2xl text-gray-900 uppercase tracking-tight italic">{{ $detailKeranjang ? 'Edit: ' : 'Pesan: ' }}{{ $produk->nama_produk }}</h2>
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
            <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-gray-100">
                <div class="md:flex">
                    <div class="md:w-1/3 bg-gray-50 p-8 border-r border-gray-100 flex flex-col items-center justify-center text-center">
                        <img src="{{ asset('storage/'.$produk->gambar) }}" class="w-full rounded-2xl shadow-md mb-6 transform hover:scale-105 transition-transform">
                        <h3 class="font-black text-xl text-gray-950 uppercase leading-none">{{ $produk->nama_produk }}</h3>
                        <p class="text-[10px] font-black text-indigo-600 uppercase tracking-widest mt-3 px-3 py-1 bg-indigo-50 rounded-full inline-block">{{ $produk->bahanBaku->pluck('nama_bahan')->implode(', ') ?: 'Material Custom' }}</p>
                        
                        <div class="mt-8 w-full p-4 bg-white rounded-2xl border border-gray-100 shadow-sm">
                            <p class="text-[10px] font-black text-gray-400 uppercase tracking-tighter">Harga Estimasi Dasar</p>
                            <p class="text-2xl font-black text-gray-950">Rp {{ number_format($produk->harga_dasar, 0, ',', '.') }}<span class="text-xs text-gray-400 font-bold">/m²</span><br><span class="text-[9px] text-indigo-400 font-bold">(satuan: {{ $produk->satuan == 'cm' ? 'Centimeter' : ($produk->satuan == 'mm' ? 'Milimeter' : 'Meter') }})</span></p>
                        </div>

                        <div class="mt-4 w-full p-5 bg-indigo-600 rounded-2xl shadow-lg transform scale-105 border-2 border-indigo-400">
                            <p class="text-[10px] font-black text-indigo-200 uppercase tracking-widest mb-1">Total Sementara</p>
                            <p class="text-2xl font-black text-white">Rp <span x-text="new Intl.NumberFormat('id-ID').format(total)">0</span></p>
                        </div>
                    </div>

                    <div class="md:w-2/3 p-10">
                        @if($errors->any())
                            <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-700 rounded-2xl font-bold uppercase tracking-widest text-xs">
                                @foreach($errors->all() as $error)
                                    <p>✗ {{ $error }}</p>
                                @endforeach
                            </div>
                        @endif

                        @if(session('error'))
                            <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-700 rounded-2xl font-bold uppercase tracking-widest text-xs">
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
                                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Panjang ({{ $satuanLabel }})</label>
                                    <input type="number" step="{{ $step }}" name="panjang" x-model="panjang" required class="w-full rounded-2xl border-gray-200 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 font-black text-lg p-4 @error('panjang') border-red-300 bg-red-50 @enderror" placeholder="0.00">
                                    @error('panjang') <p class="text-red-600 text-xs font-bold mt-1">{{ $message }}</p> @enderror
                                </div>
                                <div>
                                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Lebar ({{ $satuanLabel }})</label>
                                    <input type="number" step="{{ $step }}" name="lebar" x-model="lebar" required class="w-full rounded-2xl border-gray-200 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 font-black text-lg p-4 @error('lebar') border-red-300 bg-red-50 @enderror" placeholder="0.00">
                                    @error('lebar') <p class="text-red-600 text-xs font-bold mt-1">{{ $message }}</p> @enderror
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Jumlah Cetak (QTY)</label>
                                    <input type="number" name="jumlah" x-model="jumlah" min="1" required class="w-full rounded-2xl border-gray-200 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 font-black text-lg p-4 @error('jumlah') border-red-300 bg-red-50 @enderror">
                                    @error('jumlah') <p class="text-red-600 text-xs font-bold mt-1">{{ $message }}</p> @enderror
                                </div>
                                <div>
                                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Upload Desain (Opsional)</label>
                                    <input type="file" name="file_desain" class="w-full text-sm text-gray-500 file:mr-4 file:py-3 file:px-4 file:rounded-xl file:border-0 file:text-[10px] file:font-black file:uppercase file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 transition">
                                    @error('file_desain') <p class="text-red-600 text-xs font-bold mt-1">{{ $message }}</p> @enderror
                                </div>
                            </div>

                            <div>
                                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Catatan Finishing / Instruksi</label>
                                <textarea name="catatan" rows="3" class="w-full rounded-2xl border-gray-200 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 font-bold p-4 text-sm" placeholder="Contoh: Mata ayam di setiap sudut, lipat press, dll.">{{ $detailKeranjang ? $detailKeranjang->catatan : '' }}</textarea>
                            </div>

                            <div class="pt-4 flex gap-3">
                                @if($detailKeranjang)
                                <a href="{{ route('keranjang.index') }}" class="py-5 px-8 bg-gray-100 text-gray-600 font-black uppercase rounded-2xl hover:bg-gray-200 transition flex items-center justify-center gap-3">
                                    Batal
                                </a>
                                @endif
                                <button type="submit" class="flex-1 py-5 bg-indigo-600 text-white font-black uppercase rounded-2xl shadow-xl shadow-indigo-100 hover:bg-indigo-700 transition transform active:scale-95 flex items-center justify-center gap-3">
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