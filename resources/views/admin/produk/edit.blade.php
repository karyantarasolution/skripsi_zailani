<x-app-layout>
    <x-slot name="header">
        <h2 class="font-extrabold text-2xl text-gray-950 tracking-tight">Edit Produk</h2>
        <p class="text-gray-500 text-sm mt-1">Perbarui informasi layanan cetak Orbit Print.</p>
    </x-slot>

    <div class="py-6">
        <form action="{{ route('admin.produk.update', $produk->id) }}" method="POST" enctype="multipart/form-data">
            @csrf @method('PUT')
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <div class="lg:col-span-2 space-y-6">
                    <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100">
                        <div class="space-y-6">
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">Nama Produk</label>
                                <input type="text" name="nama_produk" value="{{ $produk->nama_produk }}" required class="w-full px-4 py-3 rounded-xl border-gray-200 focus:border-indigo-600 focus:ring-4 focus:ring-indigo-50 transition-all shadow-sm">
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">Deskripsi Produk</label>
                                <textarea name="deskripsi" rows="4" class="w-full px-4 py-3 rounded-xl border-gray-200 focus:border-indigo-600 focus:ring-4 focus:ring-indigo-50 transition-all shadow-sm">{{ $produk->deskripsi }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="space-y-6">
                    <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100">
                        <div class="space-y-6">
                            <div class="flex justify-center">
                                @if($produk->gambar)
                                    <div class="relative group w-full">
                                        <img src="{{ asset('storage/'.$produk->gambar) }}" class="w-full h-48 object-cover rounded-2xl border-4 border-gray-50 shadow-inner">
                                        <div class="absolute inset-0 bg-black/40 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                            <span class="text-white text-xs font-bold uppercase tracking-widest">Ganti Gambar</span>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">Pilih Bahan Baku</label>
                                <select name="bahan_baku_id" required class="w-full px-4 py-3 rounded-xl border-gray-200 focus:border-indigo-600 focus:ring-4 focus:ring-indigo-50 transition-all shadow-sm">
                                    @foreach($bahan as $b)
                                        <option value="{{ $b->id }}" {{ $produk->bahan_baku_id == $b->id ? 'selected' : '' }}>{{ $b->nama_bahan }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">Harga Dasar</label>
                                <div class="relative">
                                    <span class="absolute left-4 top-1/2 -translate-y-1/2 font-bold text-gray-400">Rp</span>
                                    <input type="number" name="harga_dasar" value="{{ intval($produk->harga_dasar) }}" required class="w-full pl-12 pr-4 py-3 rounded-xl border-gray-200 focus:border-indigo-600 focus:ring-4 focus:ring-indigo-50 transition-all shadow-sm">
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">Satuan Ukuran</label>
                                    <select name="satuan" required class="w-full px-4 py-3 rounded-xl border-gray-200 focus:border-indigo-600 focus:ring-4 focus:ring-indigo-50 transition-all shadow-sm">
                                        <option value="m" {{ $produk->satuan == 'm' ? 'selected' : '' }}>Meter (m)</option>
                                        <option value="cm" {{ $produk->satuan == 'cm' ? 'selected' : '' }}>Centimeter (cm)</option>
                                        <option value="mm" {{ $produk->satuan == 'mm' ? 'selected' : '' }}>Milimeter (mm)</option>
                                    </select>
                                <p class="text-[10px] text-gray-400 mt-1 font-bold italic">Pelanggan akan memasukkan dimensi dalam satuan ini.</p>
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">Upload Baru</label>
                                <input type="file" name="gambar" class="block w-full text-xs text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-bold file:bg-indigo-50 file:text-indigo-600 hover:file:bg-indigo-100 transition-all">
                            </div>
                            <button type="submit" class="w-full py-4 bg-indigo-600 hover:bg-indigo-700 text-white font-extrabold rounded-2xl shadow-lg shadow-indigo-100 transition-all transform active:scale-[0.98]">
                                Update Produk
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</x-app-layout>