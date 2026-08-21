<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-2xl text-white uppercase tracking-tight">Manajemen Gudang & Stok</h2>
    </x-slot>

    <div class="py-12" x-data="{ modalAdd: false, modalEdit: false, modalRestock: false, modalRiwayat: false, editData: {}, riwayatData: [] }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-2xl font-bold uppercase tracking-widest text-xs">
                    ✓ {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-700 rounded-2xl font-bold uppercase tracking-widest text-xs">
                    ⚠️ {{ session('error') }}
                </div>
            @endif

            <div class="flex flex-wrap gap-4 mb-6 justify-between items-center">
                <div class="bg-indigo-950 px-6 py-3 rounded-2xl text-white shadow-lg flex items-center gap-3">
                    <svg class="w-6 h-6 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm14 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/></svg>
                  
                </div>
                <button @click="modalAdd = true" class="px-6 py-4 bg-indigo-600 hover:bg-indigo-500 text-white font-black uppercase text-xs tracking-widest rounded-2xl shadow-xl transition transform active:scale-95">
                    + Register Barang Baru
                </button>
            </div>

            <div class="bg-white rounded-3xl shadow-xl border border-gray-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50 text-gray-400 text-[10px] uppercase tracking-widest">
                                <th class="p-5 font-black">Kode/Barcode</th>
                                <th class="p-5 font-black">Identitas Bahan</th>
                                <th class="p-5 font-black">Supplier</th>
                                <th class="p-5 font-black text-center">Status Stok</th>
                                <th class="p-5 font-black text-center">Audit & Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($bahan as $b)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="p-5 font-black text-gray-900 tracking-wider">
                                    {{ $b->kode_barcode ?? 'N/A' }}
                                </td>
                                <td class="p-5">
                                    <p class="font-black text-gray-950 uppercase">{{ $b->nama_bahan }}</p>
                                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mt-1">Satuan: {{ $b->satuan }}</p>
                                </td>
                                <td class="p-5">
                                    <span class="font-bold text-xs text-indigo-600 bg-indigo-50 px-3 py-1 rounded-lg">{{ $b->supplier ?? 'Internal' }}</span>
                                </td>
                                <td class="p-5 text-center">
                                    @if($b->stok <= $b->minimum_stok)
                                        <div class="inline-block px-4 py-2 bg-red-100 rounded-xl border border-red-200 text-red-700">
                                            <p class="font-black text-xl leading-none">{{ $b->stok }}</p>
                                            <p class="text-[9px] font-black uppercase tracking-widest mt-1">Kritis (Min: {{ $b->minimum_stok }})</p>
                                        </div>
                                    @else
                                        <div class="inline-block px-4 py-2 bg-emerald-50 rounded-xl border border-emerald-100 text-emerald-700">
                                            <p class="font-black text-xl leading-none">{{ $b->stok }}</p>
                                            <p class="text-[9px] font-black uppercase tracking-widest mt-1">Aman</p>
                                        </div>
                                    @endif
                                </td>
                                <td class="p-5 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <button @click="modalRestock = true; editData = { id: {{ $b->id }}, nama: '{{ $b->nama_bahan }}', stok: {{ $b->stok }} }" class="p-2 bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white rounded-xl transition" title="Restock / Sesuaikan">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"/></svg>
                                        </button>
                                        
                                        <button @click="modalRiwayat = true; riwayatData = {{ json_encode($b->riwayatStok) }}; editData = { nama: '{{ $b->nama_bahan }}' }" class="p-2 bg-purple-50 text-purple-600 hover:bg-purple-600 hover:text-white rounded-xl transition" title="Log History">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                        </button>

                                        <button @click="modalEdit = true; editData = { id: {{ $b->id }}, nama: '{{ $b->nama_bahan }}', barcode: '{{ $b->kode_barcode }}', min: {{ $b->minimum_stok }}, satuan: '{{ $b->satuan }}', supplier: '{{ $b->supplier }}' }" class="p-2 bg-gray-50 text-gray-600 hover:bg-gray-900 hover:text-white rounded-xl transition">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                                        </button>

                                        <button onclick="if(confirm('Yakin ingin menghapus bahan baku {{ $b->nama_bahan }}? Semua data riwayat stok akan ikut terhapus.')) { document.getElementById('delete-form-{{ $b->id }}').submit(); }" class="p-2 bg-red-50 text-red-600 hover:bg-red-600 hover:text-white rounded-xl transition" title="Hapus">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        </button>
                                        <form id="delete-form-{{ $b->id }}" action="{{ route('admin.bahan.destroy', $b->id) }}" method="POST" class="hidden">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div x-show="modalAdd" style="display: none;" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm">
            <div @click.away="modalAdd = false" class="bg-white p-8 rounded-3xl shadow-2xl w-full max-w-lg">
                <h3 class="font-black text-gray-900 uppercase text-xl mb-6">Register Bahan Baku</h3>
                <form action="{{ route('admin.bahan.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <div class="grid grid-cols-2 gap-4">
                        <div class="col-span-2">
                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Kode Barcode (Opsional/Scan)</label>
                            <input type="text" name="kode_barcode" autofocus class="w-full rounded-xl border-gray-200 focus:ring-indigo-500 font-bold font-mono">
                        </div>
                        <div class="col-span-2">
                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Nama Barang</label>
                            <input type="text" name="nama_bahan" required class="w-full rounded-xl border-gray-200 focus:ring-indigo-500 font-bold uppercase">
                        </div>
                        <div>
                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Stok Awal</label>
                            <input type="number" name="stok" required min="0" class="w-full rounded-xl border-gray-200 focus:ring-indigo-500 font-bold">
                        </div>
                        <div>
                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Batas Minimum</label>
                            <input type="number" name="minimum_stok" required min="1" value="10" class="w-full rounded-xl border-red-200 focus:ring-red-500 font-bold">
                        </div>
                        <div>
                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Satuan (Pcs/Meter)</label>
                            <input type="text" name="satuan" required class="w-full rounded-xl border-gray-200 focus:ring-indigo-500 font-bold">
                        </div>
                        <div>
                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Nama Supplier</label>
                            <input type="text" name="supplier" class="w-full rounded-xl border-gray-200 focus:ring-indigo-500 font-bold">
                        </div>
                    </div>
                    <div class="pt-4 flex justify-end gap-3">
                        <button type="button" @click="modalAdd = false" class="px-5 py-2.5 bg-gray-100 text-gray-600 font-black rounded-xl uppercase text-xs">Batal</button>
                        <button type="submit" class="px-5 py-2.5 bg-indigo-600 text-white font-black rounded-xl uppercase text-xs">Simpan Data</button>
                    </div>
                </form>
            </div>
        </div>

        <div x-show="modalRestock" style="display: none;" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm">
            <div @click.away="modalRestock = false" class="bg-white p-8 rounded-3xl shadow-2xl w-full max-w-md">
                <div class="flex items-center gap-4 mb-6">
                    <div class="w-12 h-12 bg-blue-100 text-blue-600 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"/></svg>
                    </div>
                    <div>
                        <h3 class="font-black text-gray-900 uppercase text-xl" x-text="editData.nama"></h3>
                        <p class="text-xs font-bold text-gray-400">Stok Saat Ini: <span class="text-indigo-600" x-text="editData.stok"></span></p>
                    </div>
                </div>
                <form :action="`{{ url('admin/bahan') }}/${editData.id}/restock`" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Tipe Pergerakan</label>
                        <select name="jenis" required class="w-full rounded-xl border-gray-200 focus:ring-indigo-500 font-black uppercase text-xs">
                            <option value="masuk">Barang Masuk (Restock)</option>
                            <option value="keluar">Barang Keluar (Rusak/Manual)</option>
                            <option value="penyesuaian">Penyesuaian (Opname)</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Jumlah Item</label>
                        <input type="number" name="jumlah" required min="1" class="w-full rounded-xl border-gray-200 focus:ring-indigo-500 font-black text-xl">
                    </div>
                    <div>
                        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Keterangan / Nomor Nota</label>
                        <input type="text" name="keterangan" class="w-full rounded-xl border-gray-200 focus:ring-indigo-500 font-bold text-sm" placeholder="Contoh: Dari Supplier A Nota #123">
                    </div>
                    <div class="pt-4 flex justify-end gap-3">
                        <button type="button" @click="modalRestock = false" class="px-5 py-2.5 bg-gray-100 text-gray-600 font-black rounded-xl uppercase text-xs">Batal</button>
                        <button type="submit" class="px-5 py-2.5 bg-blue-600 text-white font-black rounded-xl uppercase text-xs">Update Stok</button>
                    </div>
                </form>
            </div>
        </div>

        <div x-show="modalRiwayat" style="display: none;" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm">
            <div @click.away="modalRiwayat = false" class="bg-white rounded-3xl shadow-2xl w-full max-w-2xl overflow-hidden flex flex-col max-h-[80vh]">
                <div class="p-6 bg-indigo-950 text-white flex justify-between items-center">
                    <div>
                        <h3 class="font-black uppercase text-lg">Log Audit Stok</h3>
                        <p class="text-indigo-300 text-xs font-bold mt-1" x-text="editData.nama"></p>
                    </div>
                    <button @click="modalRiwayat = false" class="text-white hover:text-red-400"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></button>
                </div>
                <div class="p-0 overflow-y-auto custom-scrollbar flex-1 bg-gray-50">
                    <template x-if="riwayatData.length === 0">
                        <div class="p-8 text-center text-gray-400 font-bold italic text-sm">Belum ada riwayat pergerakan stok.</div>
                    </template>
                    <div class="divide-y divide-gray-200">
                        <template x-for="log in riwayatData" :key="log.id">
                            <div class="p-5 flex items-center justify-between bg-white hover:bg-gray-50 transition">
                                <div>
                                    <div class="flex items-center gap-2 mb-1">
                                        <span class="px-2 py-0.5 rounded text-[9px] font-black uppercase tracking-widest"
                                            :class="{
                                                'bg-emerald-100 text-emerald-700': log.jenis === 'masuk',
                                                'bg-red-100 text-red-700': log.jenis === 'keluar',
                                                'bg-orange-100 text-orange-700': log.jenis === 'penyesuaian'
                                            }" x-text="log.jenis">
                                        </span>
                                        <span class="text-[10px] font-black text-gray-400" x-text="new Date(log.created_at).toLocaleString('id-ID')"></span>
                                    </div>
                                    <p class="text-sm font-bold text-gray-900" x-text="log.keterangan"></p>
                                    <p class="text-[10px] text-gray-500 font-bold uppercase mt-1">Oleh: <span x-text="log.user ? log.user.name : 'Sistem'"></span></p>
                                </div>
                                <div class="text-right">
                                    <p class="text-xl font-black" :class="log.jenis === 'masuk' ? 'text-emerald-600' : 'text-red-600'">
                                        <span x-text="log.jenis === 'masuk' ? '+' : '-'"></span><span x-text="log.jumlah"></span>
                                    </p>
                                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mt-1">Sisa: <span x-text="log.stok_sesudah"></span></p>
                                </div>
                            </div>
                        </template>
                </div>
            </div>
        </div>
        </div>
        
        <div x-show="modalEdit" style="display: none;" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm">
            <div @click.away="modalEdit = false" class="bg-white p-8 rounded-3xl shadow-2xl w-full max-w-lg">
                <div class="flex items-center gap-4 mb-6">
                    <div class="w-12 h-12 bg-gray-100 text-gray-600 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                    </div>
                    <div>
                        <h3 class="font-black text-gray-900 uppercase text-xl">Edit Bahan Baku</h3>
                        <p class="text-xs font-bold text-gray-400" x-text="editData.nama"></p>
                    </div>
                </div>
                <form :action="`{{ url('admin/bahan') }}/${editData.id}`" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')
                    <div class="grid grid-cols-2 gap-4">
                        <div class="col-span-2">
                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Kode Barcode</label>
                            <input type="text" name="kode_barcode" x-model="editData.barcode" class="w-full rounded-xl border-gray-200 focus:ring-indigo-500 font-bold font-mono">
                        </div>
                        <div class="col-span-2">
                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Nama Barang</label>
                            <input type="text" name="nama_bahan" x-model="editData.nama" required class="w-full rounded-xl border-gray-200 focus:ring-indigo-500 font-bold uppercase">
                        </div>
                        <div>
                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Batas Minimum Stok</label>
                            <input type="number" name="minimum_stok" x-model.number="editData.min" required min="1" class="w-full rounded-xl border-gray-200 focus:ring-indigo-500 font-bold">
                        </div>
                        <div>
                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Satuan (Pcs/Meter)</label>
                            <input type="text" name="satuan" x-model="editData.satuan" required class="w-full rounded-xl border-gray-200 focus:ring-indigo-500 font-bold">
                        </div>
                        <div class="col-span-2">
                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Nama Supplier</label>
                            <input type="text" name="supplier" x-model="editData.supplier" class="w-full rounded-xl border-gray-200 focus:ring-indigo-500 font-bold">
                        </div>
                    </div>
                    <div class="pt-4 flex justify-end gap-3">
                        <button type="button" @click="modalEdit = false" class="px-5 py-2.5 bg-gray-100 text-gray-600 font-black rounded-xl uppercase text-xs">Batal</button>
                        <button type="submit" class="px-5 py-2.5 bg-indigo-600 text-white font-black rounded-xl uppercase text-xs">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</x-app-layout>