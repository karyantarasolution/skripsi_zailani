<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-2xl text-white uppercase tracking-tight">Data Supplier</h2>
    </x-slot>

    <div class="py-12" x-data="{ modalAdd: false, modalEdit: false, editData: {} }">
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

            <div class="bg-white rounded-[30px] shadow-xl border border-gray-100 overflow-hidden">
                <div class="p-8 border-b border-gray-100 flex justify-between items-center bg-indigo-950 text-white">
                    <div>
                        <h3 class="font-black text-xl uppercase tracking-tighter">Daftar Supplier</h3>
                        <p class="text-indigo-300 text-xs mt-1 font-medium">Kelola data pemasok bahan baku.</p>
                    </div>
                    <button @click="modalAdd = true" class="px-6 py-3 bg-indigo-500 hover:bg-indigo-400 text-white font-black uppercase text-xs tracking-widest rounded-xl transition shadow-lg transform active:scale-95">
                        + Tambah Supplier
                    </button>
                </div>

                <div class="p-4 border-b border-gray-100 bg-gray-50">
                    <div class="flex gap-3 items-center">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        <input type="text" id="searchSupplier" placeholder="Cari supplier..." class="border-0 bg-transparent text-sm font-medium text-gray-600 placeholder-gray-400 focus:outline-none focus:ring-0 flex-1">
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse" id="supplierTable">
                        <thead>
                            <tr class="bg-gray-50 text-gray-400 text-[10px] uppercase tracking-widest">
                                <th class="p-5 font-black">Nama Supplier</th>
                                <th class="p-5 font-black">Kontak Person</th>
                                <th class="p-5 font-black">Telepon</th>
                                <th class="p-5 font-black">Email</th>
                                <th class="p-5 font-black">Bank & Rekening</th>
                                <th class="p-5 font-black text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($suppliers as $s)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="p-5 font-black text-gray-900 uppercase text-sm">{{ $s->nama_supplier }}</td>
                                <td class="p-5 font-bold text-gray-700">{{ $s->kontak_person ?? '-' }}</td>
                                <td class="p-5 text-sm text-gray-600">{{ $s->telepon ?? '-' }}</td>
                                <td class="p-5 text-sm text-gray-600">{{ $s->email ?? '-' }}</td>
                                <td class="p-5 text-sm">
                                    @if($s->bank)
                                        <span class="font-bold text-gray-900">{{ $s->bank }}</span>
                                        <p class="text-[10px] text-gray-500 font-mono">{{ $s->nomor_rekening ?? '-' }}</p>
                                    @else
                                        <span class="text-gray-400">-</span>
                                    @endif
                                </td>
                                <td class="p-5 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <button @click="modalEdit = true; editData = { id: {{ $s->id }}, nama_supplier: '{{ $s->nama_supplier }}', kontak_person: '{{ $s->kontak_person }}', telepon: '{{ $s->telepon }}', email: '{{ $s->email }}', alamat: '{{ $s->alamat }}', bank: '{{ $s->bank }}', nomor_rekening: '{{ $s->nomor_rekening }}' }" class="p-2 bg-indigo-50 text-indigo-600 hover:bg-indigo-600 hover:text-white rounded-xl transition" title="Edit">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                                        </button>
                                        <form action="{{ route('admin.supplier.destroy', $s->id) }}" method="POST" onsubmit="return confirm('Hapus supplier ini?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="p-2 bg-red-50 text-red-600 hover:bg-red-600 hover:text-white rounded-xl transition" title="Hapus">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                            </button>
                                        </form>
                                        <button @click="showAlamat = true; alamatData = '{{ addslashes($s->alamat) }}'" class="p-2 bg-gray-50 text-gray-600 hover:bg-gray-900 hover:text-white rounded-xl transition" title="Alamat" onclick="alert('{{ addslashes($s->alamat) ?? 'Tidak ada alamat' }}')">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Modal Tambah --}}
        <div x-show="modalAdd" style="display: none;" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm">
            <div @click.away="modalAdd = false" class="bg-white p-8 rounded-3xl shadow-2xl w-full max-w-lg">
                <h3 class="font-black text-gray-900 uppercase text-xl mb-6">Tambah Supplier Baru</h3>
                <form action="{{ route('admin.supplier.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <div class="grid grid-cols-2 gap-4">
                        <div class="col-span-2">
                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Nama Supplier *</label>
                            <input type="text" name="nama_supplier" required class="w-full rounded-xl border-gray-200 focus:ring-indigo-500 font-bold uppercase">
                        </div>
                        <div>
                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Kontak Person</label>
                            <input type="text" name="kontak_person" class="w-full rounded-xl border-gray-200 focus:ring-indigo-500 font-bold">
                        </div>
                        <div>
                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Telepon</label>
                            <input type="text" name="telepon" class="w-full rounded-xl border-gray-200 focus:ring-indigo-500 font-bold">
                        </div>
                        <div class="col-span-2">
                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Email</label>
                            <input type="email" name="email" class="w-full rounded-xl border-gray-200 focus:ring-indigo-500 font-bold">
                        </div>
                        <div class="col-span-2">
                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Alamat</label>
                            <textarea name="alamat" rows="2" class="w-full rounded-xl border-gray-200 focus:ring-indigo-500 font-bold text-sm"></textarea>
                        </div>
                        <div>
                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Bank</label>
                            <input type="text" name="bank" class="w-full rounded-xl border-gray-200 focus:ring-indigo-500 font-bold" placeholder="BCA, Mandiri, dll">
                        </div>
                        <div>
                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Nomor Rekening</label>
                            <input type="text" name="nomor_rekening" class="w-full rounded-xl border-gray-200 focus:ring-indigo-500 font-bold font-mono">
                        </div>
                    </div>
                    <div class="pt-4 flex justify-end gap-3">
                        <button type="button" @click="modalAdd = false" class="px-5 py-2.5 bg-gray-100 text-gray-600 font-black rounded-xl uppercase text-xs">Batal</button>
                        <button type="submit" class="px-5 py-2.5 bg-indigo-600 text-white font-black rounded-xl uppercase text-xs">Simpan Data</button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Modal Edit --}}
        <div x-show="modalEdit" style="display: none;" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm">
            <div @click.away="modalEdit = false" class="bg-white p-8 rounded-3xl shadow-2xl w-full max-w-lg">
                <h3 class="font-black text-gray-900 uppercase text-xl mb-6">Edit Supplier</h3>
                <form :action="`{{ url('admin/supplier') }}/${editData.id}`" method="POST" class="space-y-4">
                    @csrf @method('PUT')
                    <div class="grid grid-cols-2 gap-4">
                        <div class="col-span-2">
                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Nama Supplier *</label>
                            <input type="text" name="nama_supplier" x-model="editData.nama_supplier" required class="w-full rounded-xl border-gray-200 focus:ring-indigo-500 font-bold uppercase">
                        </div>
                        <div>
                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Kontak Person</label>
                            <input type="text" name="kontak_person" x-model="editData.kontak_person" class="w-full rounded-xl border-gray-200 focus:ring-indigo-500 font-bold">
                        </div>
                        <div>
                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Telepon</label>
                            <input type="text" name="telepon" x-model="editData.telepon" class="w-full rounded-xl border-gray-200 focus:ring-indigo-500 font-bold">
                        </div>
                        <div class="col-span-2">
                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Email</label>
                            <input type="email" name="email" x-model="editData.email" class="w-full rounded-xl border-gray-200 focus:ring-indigo-500 font-bold">
                        </div>
                        <div class="col-span-2">
                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Alamat</label>
                            <textarea name="alamat" x-model="editData.alamat" rows="2" class="w-full rounded-xl border-gray-200 focus:ring-indigo-500 font-bold text-sm"></textarea>
                        </div>
                        <div>
                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Bank</label>
                            <input type="text" name="bank" x-model="editData.bank" class="w-full rounded-xl border-gray-200 focus:ring-indigo-500 font-bold">
                        </div>
                        <div>
                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Nomor Rekening</label>
                            <input type="text" name="nomor_rekening" x-model="editData.nomor_rekening" class="w-full rounded-xl border-gray-200 focus:ring-indigo-500 font-bold font-mono">
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

    @push('scripts')
    <script>
        document.getElementById('searchSupplier').addEventListener('keyup', function() {
            const value = this.value.toLowerCase();
            document.querySelectorAll('#supplierTable tbody tr').forEach(function(row) {
                row.style.display = row.textContent.toLowerCase().includes(value) ? '' : 'none';
            });
        });
    </script>
    @endpush
</x-app-layout>
