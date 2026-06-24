<x-app-layout>
    <x-slot name="header">
        <h2 class="font-extrabold text-2xl text-gray-950 tracking-tight">Tambah Produk Baru</h2>
        <p class="text-gray-500 text-sm mt-1">Pastikan informasi produk dan bahan baku sudah sesuai.</p>
    </x-slot>

    <div class="py-6">
        <form action="{{ route('admin.produk.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <div class="lg:col-span-2 space-y-6">
                    <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100">
                        <div class="space-y-6">
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">Nama Produk</label>
                                <input type="text" name="nama_produk" required class="w-full px-4 py-3 rounded-xl border-gray-200 focus:border-indigo-600 focus:ring-4 focus:ring-indigo-50 transition-all shadow-sm" placeholder="Contoh: Cetak Spanduk High-Res">
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">Deskripsi Produk</label>
                                <textarea name="deskripsi" rows="4" class="w-full px-4 py-3 rounded-xl border-gray-200 focus:border-indigo-600 focus:ring-4 focus:ring-indigo-50 transition-all shadow-sm" placeholder="Jelaskan detail layanan cetak..."></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="space-y-6">
                    <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100">
                        <div class="space-y-6">
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">Pilih Bahan Baku</label>
                                <select name="bahan_baku_id" required class="w-full px-4 py-3 rounded-xl border-gray-200 focus:border-indigo-600 focus:ring-4 focus:ring-indigo-50 transition-all shadow-sm">
                                    @foreach($bahan as $b)
                                        <option value="{{ $b->id }}">{{ $b->nama_bahan }} ({{ $b->satuan }})</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">Harga Dasar (m2/Pcs)</label>
                                <div class="relative">
                                    <span class="absolute left-4 top-1/2 -translate-y-1/2 font-bold text-gray-400">Rp</span>
                                    <input type="number" name="harga_dasar" required class="w-full pl-12 pr-4 py-3 rounded-xl border-gray-200 focus:border-indigo-600 focus:ring-4 focus:ring-indigo-50 transition-all shadow-sm">
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">Satuan Ukuran</label>
                                    <select name="satuan" required class="w-full px-4 py-3 rounded-xl border-gray-200 focus:border-indigo-600 focus:ring-4 focus:ring-indigo-50 transition-all shadow-sm">
                                        <option value="m">Meter (m)</option>
                                        <option value="cm">Centimeter (cm)</option>
                                        <option value="mm">Milimeter (mm)</option>
                                    </select>
                                <p class="text-[10px] text-gray-400 mt-1 font-bold italic">Pelanggan akan memasukkan dimensi dalam satuan ini.</p>
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">Foto Produk</label>
                                <input type="file" name="gambar" class="block w-full text-xs text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-bold file:bg-indigo-50 file:text-indigo-600 hover:file:bg-indigo-100 transition-all">
                            </div>
                            <button type="submit" class="w-full py-4 bg-indigo-600 hover:bg-indigo-700 text-white font-extrabold rounded-2xl shadow-lg shadow-indigo-100 transition-all transform active:scale-[0.98]">
                                Simpan Produk
                            </button>
                            <a href="{{ route('admin.produk.index') }}" class="block text-center text-sm font-bold text-gray-400 hover:text-gray-600 transition-colors">Batal & Kembali</a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</x-app-layout>