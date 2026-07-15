<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-2xl text-gray-900 uppercase tracking-tight">Katalog Produk & Formula</h2>
    </x-slot>

    <div class="py-12" x-data="{ modalAdd: false, modalEdit: false, modalFormula: false, editData: {}, formulaData: [] }">
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

            <div class="flex justify-end mb-6">
                <a href="{{ route('admin.produk.create') }}" class="px-6 py-4 bg-indigo-600 hover:bg-indigo-500 text-white font-black uppercase text-xs tracking-widest rounded-2xl shadow-xl transition transform active:scale-95">
                    + Tambah Produk Baru
                </a>
            </div>

            <div class="bg-white rounded-3xl shadow-xl border border-gray-100 overflow-hidden">
                <div class="p-8 border-b border-gray-100 flex justify-between items-center bg-indigo-950 text-white">
                    <div>
                        <h3 class="font-black text-xl uppercase">Daftar Produk</h3>
                        <p class="text-xs text-indigo-300 mt-1">Atur harga dasar dan formula bahan untuk kalkulasi otomatis.</p>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50 text-gray-400 text-[10px] uppercase tracking-widest">
                                <th class="p-5 font-black">Produk</th>
                                <th class="p-5 font-black">Bahan Baku</th>
                                <th class="p-5 font-black">Harga Dasar</th>
                                <th class="p-5 font-black text-center">Formula</th>
                                <th class="p-5 font-black text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($produk as $p)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="p-5">
                                    <div class="flex items-center gap-3">
                                        @if($p->gambar)
                                            <img src="{{ asset('storage/'.$p->gambar) }}" class="w-12 h-12 rounded-xl object-cover border border-gray-100">
                                        @endif
                                        <div>
                                            <p class="font-black text-gray-950 uppercase">{{ $p->nama_produk }}</p>
                                            <p class="text-[10px] font-bold text-gray-400 mt-1">{{ Str::limit($p->deskripsi, 50) }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="p-5">
                                    <span class="font-bold text-xs text-indigo-600 bg-indigo-50 px-3 py-1 rounded-lg">
                                        {{ $p->bahanBaku->pluck('nama_bahan')->implode(', ') ?: '-' }}
                                    </span>
                                </td>
                                <td class="p-5 font-black text-gray-900">
                                    Rp {{ number_format($p->harga_dasar, 0, ',', '.') }}
                                </td>
                                <td class="p-5 text-center">
                                    <button @click="modalFormula = true; editData = { id: {{ $p->id }}, nama: '{{ $p->nama_produk }}' }; formulaData = {{ $p->bahanBaku->pluck('id') }}" class="p-2 bg-indigo-50 text-indigo-600 hover:bg-indigo-600 hover:text-white rounded-xl transition" title="Setting Formula Bahan">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                    </button>
                                </td>
                                <td class="p-5 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="{{ route('admin.produk.edit', $p->id) }}" class="p-2 bg-gray-50 text-gray-600 hover:bg-gray-900 hover:text-white rounded-xl transition" title="Edit Produk">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                                        </a>
                                        <form action="{{ route('admin.produk.destroy', $p->id) }}" method="POST" onsubmit="return confirm('Hapus produk {{ $p->nama_produk }}?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="p-2 bg-red-50 text-red-600 hover:bg-red-600 hover:text-white rounded-xl transition" title="Hapus Produk">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                            </button>
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

        <div x-show="modalFormula" style="display: none;" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm">
            <div @click.away="modalFormula = false" class="bg-white p-8 rounded-3xl shadow-2xl w-full max-w-3xl overflow-hidden flex flex-col max-h-[90vh]">
                <h3 class="font-black text-gray-900 uppercase text-xl mb-2">Formula Komposisi Bahan</h3>
                <p class="text-xs font-bold text-indigo-600 mb-6 bg-indigo-50 inline-block px-3 py-1 rounded-lg">Produk: <span x-text="editData.nama"></span></p>
                
                <form :action="`{{ url('admin/produk') }}/${editData.id}/formula`" method="POST" class="overflow-y-auto custom-scrollbar pr-2 space-y-4">
                    @csrf
                    
                    <div class="grid grid-cols-1 gap-4">
                        @foreach($semuaBahan as $b)
                        <div class="flex items-center gap-4 p-4 border border-gray-100 rounded-2xl bg-gray-50 hover:bg-white transition shadow-sm">
                            <div class="flex items-center h-5">
                                <input type="checkbox" name="is_used[{{ $b->id }}]" value="1" 
                                    class="w-5 h-5 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500"
                                    x-bind:checked="formulaData.includes({{ $b->id }})">
                            </div>
                            
                            <div class="flex-1">
                                <p class="font-black text-gray-900 uppercase text-sm">{{ $b->nama_bahan }}</p>
                                <p class="text-[10px] text-gray-500 font-bold uppercase tracking-widest">Sisa Gudang: {{ $b->stok }} {{ $b->satuan }}</p>
                            </div>

                            <div class="w-24">
                                <label class="block text-[9px] font-black text-gray-400 uppercase mb-1">Jumlah</label>
                                <input type="number" step="0.01" name="jumlah_digunakan[{{ $b->id }}]" class="w-full rounded-xl border-gray-200 text-sm font-bold p-2" placeholder="Cth: 1.0" value="1">
                            </div>

                            <div class="w-40">
                                <label class="block text-[9px] font-black text-gray-400 uppercase mb-1">Dikalikan Dengan</label>
                                <select name="tipe_pengurangan[{{ $b->id }}]" class="w-full rounded-xl border-gray-200 text-xs font-bold p-2 uppercase">
                                    <option value="per_meter">Luas (Meter Persegi)</option>
                                    <option value="per_pcs">Kuantitas (Qty Pcs)</option>
                                </select>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <div class="pt-6 pb-2 flex justify-end gap-3 sticky bottom-0 bg-white border-t border-gray-100 mt-4">
                        <button type="button" @click="modalFormula = false" class="px-5 py-2.5 bg-gray-100 text-gray-600 font-black rounded-xl uppercase text-xs">Tutup</button>
                        <button type="submit" class="px-5 py-2.5 bg-indigo-600 text-white font-black rounded-xl uppercase text-xs shadow-lg">Simpan Formula</button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</x-app-layout>