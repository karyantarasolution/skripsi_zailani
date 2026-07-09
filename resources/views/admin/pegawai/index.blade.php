<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-2xl text-gray-900 uppercase tracking-tight">Data Pegawai</h2>
    </x-slot>

    <div class="py-12" x-data="{ modalAdd: false, modalEdit: false, modalDetail: false, editData: {}, detailData: {} }">
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
                        <h3 class="font-black text-xl uppercase tracking-tighter">Daftar Pegawai</h3>
                        <p class="text-indigo-300 text-xs mt-1 font-medium">Kelola data diri pegawai Orbit Digital Printing.</p>
                    </div>
                    <button @click="modalAdd = true" class="px-6 py-3 bg-indigo-500 hover:bg-indigo-400 text-white font-black uppercase text-xs tracking-widest rounded-xl transition shadow-lg transform active:scale-95">
                        + Tambah Pegawai
                    </button>
                </div>

                <div class="p-4 border-b border-gray-100 bg-gray-50">
                    <div class="flex gap-3 items-center">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        <input type="text" id="searchPegawai" placeholder="Cari pegawai..." class="border-0 bg-transparent text-sm font-medium text-gray-600 placeholder-gray-400 focus:outline-none focus:ring-0 flex-1">
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse" id="pegawaiTable">
                        <thead>
                            <tr class="bg-gray-50 text-gray-400 text-[10px] uppercase tracking-widest">
                                <th class="p-5 font-black">Pegawai</th>
                                <th class="p-5 font-black">NIP</th>
                                <th class="p-5 font-black">Jabatan</th>
                                <th class="p-5 font-black">Kontak</th>
                                <th class="p-5 font-black">Role</th>
                                <th class="p-5 font-black text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($pegawai as $k)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="p-5">
                                    <div class="flex items-center gap-3">
                                        @if($k->foto)
                                            <div class="w-10 h-10 rounded-full overflow-hidden">
                                                <img src="{{ asset('storage/'.$k->foto) }}" class="w-full h-full object-cover">
                                            </div>
                                        @else
                                            <div class="w-10 h-10 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center font-black text-lg">
                                                {{ substr($k->name, 0, 1) }}
                                            </div>
                                        @endif
                                        <div>
                                            <span class="font-black text-gray-900 uppercase text-sm">{{ $k->name }}</span>
                                            <p class="text-[10px] text-gray-400 font-bold">{{ $k->email }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="p-5 font-bold text-gray-900 text-sm">{{ $k->nip ?? '-' }}</td>
                                <td class="p-5">
                                    <span class="font-bold text-xs text-indigo-600 bg-indigo-50 px-3 py-1 rounded-lg">{{ $k->jabatan ?? '-' }}</span>
                                </td>
                                <td class="p-5 text-sm text-gray-600">
                                    <p>{{ $k->telepon ?? '-' }}</p>
                                    <p class="text-[10px] text-gray-400">{{ $k->alamat ? \Illuminate\Support\Str::limit($k->alamat, 30) : '-' }}</p>
                                </td>
                                <td class="p-5">
                                    @if($k->role == 'admin')
                                        <span class="px-3 py-1 bg-red-100 text-red-700 text-[10px] font-black rounded-lg uppercase tracking-widest">Admin</span>
                                    @else
                                        <span class="px-3 py-1 bg-emerald-100 text-emerald-700 text-[10px] font-black rounded-lg uppercase tracking-widest">Pegawai</span>
                                    @endif
                                </td>
                                <td class="p-5 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <button @click="modalDetail = true; detailData = {{ $k->toJson() }}" class="p-2 bg-gray-50 text-gray-600 hover:bg-gray-900 hover:text-white rounded-xl transition" title="Detail">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                        </button>
                                        <button @click="modalEdit = true; editData = {{ $k->toJson() }}" class="p-2 bg-indigo-50 text-indigo-600 hover:bg-indigo-600 hover:text-white rounded-xl transition" title="Edit">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                                        </button>
                                        @if($k->id !== auth()->id())
                                        <form action="{{ route('admin.pegawai.destroy', $k->id) }}" method="POST" onsubmit="return confirm('Hapus pegawai ini?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="p-2 bg-red-50 text-red-600 hover:bg-red-600 hover:text-white rounded-xl transition" title="Hapus">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                            </button>
                                        </form>
                                        @endif
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
            <div @click.away="modalAdd = false" class="bg-white p-8 rounded-3xl shadow-2xl w-full max-w-2xl max-h-[90vh] overflow-y-auto">
                <h3 class="font-black text-gray-900 uppercase text-xl mb-6">Tambah Pegawai Baru</h3>
                <form action="{{ route('admin.pegawai.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Nama Lengkap *</label>
                            <input type="text" name="name" required class="w-full rounded-xl border-gray-200 focus:ring-indigo-500 font-bold">
                        </div>
                        <div>
                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">NIP</label>
                            <input type="text" name="nip" class="w-full rounded-xl border-gray-200 focus:ring-indigo-500 font-bold">
                        </div>
                        <div>
                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Username</label>
                            <input type="text" name="username" class="w-full rounded-xl border-gray-200 focus:ring-indigo-500 font-bold">
                        </div>
                        <div>
                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Email *</label>
                            <input type="email" name="email" required class="w-full rounded-xl border-gray-200 focus:ring-indigo-500 font-bold">
                        </div>
                        <div>
                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Password *</label>
                            <input type="password" name="password" required class="w-full rounded-xl border-gray-200 focus:ring-indigo-500 font-bold">
                        </div>
                        <div>
                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Role *</label>
                            <select name="role" required class="w-full rounded-xl border-gray-200 focus:ring-indigo-500 font-bold">
                                <option value="pegawai">Pegawai</option>
                                <option value="admin">Admin</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Jabatan</label>
                            <input type="text" name="jabatan" class="w-full rounded-xl border-gray-200 focus:ring-indigo-500 font-bold" placeholder="Kasir, Koki, Admin, dll">
                        </div>
                        <div>
                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Telepon</label>
                            <input type="text" name="telepon" class="w-full rounded-xl border-gray-200 focus:ring-indigo-500 font-bold">
                        </div>
                        <div>
                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Jenis Kelamin</label>
                            <select name="jenis_kelamin" class="w-full rounded-xl border-gray-200 focus:ring-indigo-500 font-bold">
                                <option value="">Pilih</option>
                                <option value="L">Laki-laki</option>
                                <option value="P">Perempuan</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Tanggal Lahir</label>
                            <input type="date" name="tanggal_lahir" class="w-full rounded-xl border-gray-200 focus:ring-indigo-500 font-bold">
                        </div>
                        <div class="col-span-2">
                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Alamat</label>
                            <textarea name="alamat" rows="2" class="w-full rounded-xl border-gray-200 focus:ring-indigo-500 font-bold text-sm"></textarea>
                        </div>
                        <div class="col-span-2">
                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Foto Profil</label>
                            <input type="file" name="foto" accept="image/*" class="w-full rounded-xl border-gray-200 focus:ring-indigo-500">
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
            <div @click.away="modalEdit = false" class="bg-white p-8 rounded-3xl shadow-2xl w-full max-w-2xl max-h-[90vh] overflow-y-auto">
                <h3 class="font-black text-gray-900 uppercase text-xl mb-6">Edit Pegawai</h3>
                <form :action="`{{ url('admin/pegawai') }}/${editData.id}`" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf @method('PUT')
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Nama Lengkap *</label>
                            <input type="text" name="name" x-model="editData.name" required class="w-full rounded-xl border-gray-200 focus:ring-indigo-500 font-bold">
                        </div>
                        <div>
                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">NIP</label>
                            <input type="text" name="nip" x-model="editData.nip" class="w-full rounded-xl border-gray-200 focus:ring-indigo-500 font-bold">
                        </div>
                        <div>
                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Username</label>
                            <input type="text" name="username" x-model="editData.username" class="w-full rounded-xl border-gray-200 focus:ring-indigo-500 font-bold">
                        </div>
                        <div>
                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Email *</label>
                            <input type="email" name="email" x-model="editData.email" required class="w-full rounded-xl border-gray-200 focus:ring-indigo-500 font-bold">
                        </div>
                        <div>
                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Password Baru</label>
                            <input type="password" name="password" class="w-full rounded-xl border-gray-200 focus:ring-indigo-500 font-bold" placeholder="Kosongkan jika tidak diubah">
                        </div>
                        <div>
                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Role *</label>
                            <select name="role" x-model="editData.role" required class="w-full rounded-xl border-gray-200 focus:ring-indigo-500 font-bold">
                                <option value="pegawai">Pegawai</option>
                                <option value="admin">Admin</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Jabatan</label>
                            <input type="text" name="jabatan" x-model="editData.jabatan" class="w-full rounded-xl border-gray-200 focus:ring-indigo-500 font-bold">
                        </div>
                        <div>
                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Telepon</label>
                            <input type="text" name="telepon" x-model="editData.telepon" class="w-full rounded-xl border-gray-200 focus:ring-indigo-500 font-bold">
                        </div>
                        <div>
                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Jenis Kelamin</label>
                            <select name="jenis_kelamin" x-model="editData.jenis_kelamin" class="w-full rounded-xl border-gray-200 focus:ring-indigo-500 font-bold">
                                <option value="">Pilih</option>
                                <option value="L">Laki-laki</option>
                                <option value="P">Perempuan</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Tanggal Lahir</label>
                            <input type="date" name="tanggal_lahir" x-model="editData.tanggal_lahir" class="w-full rounded-xl border-gray-200 focus:ring-indigo-500 font-bold">
                        </div>
                        <div class="col-span-2">
                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Alamat</label>
                            <textarea name="alamat" x-model="editData.alamat" rows="2" class="w-full rounded-xl border-gray-200 focus:ring-indigo-500 font-bold text-sm"></textarea>
                        </div>
                        <div class="col-span-2">
                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Foto Profil</label>
                            <input type="file" name="foto" accept="image/*" class="w-full rounded-xl border-gray-200 focus:ring-indigo-500">
                        </div>
                    </div>
                    <div class="pt-4 flex justify-end gap-3">
                        <button type="button" @click="modalEdit = false" class="px-5 py-2.5 bg-gray-100 text-gray-600 font-black rounded-xl uppercase text-xs">Batal</button>
                        <button type="submit" class="px-5 py-2.5 bg-indigo-600 text-white font-black rounded-xl uppercase text-xs">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Modal Detail --}}
        <div x-show="modalDetail" style="display: none;" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm">
            <div @click.away="modalDetail = false" class="bg-white rounded-3xl shadow-2xl w-full max-w-lg overflow-hidden">
                <div class="p-6 bg-indigo-950 text-white text-center">
                    <template x-if="detailData.foto">
                        <div class="w-20 h-20 rounded-full overflow-hidden mx-auto mb-3 border-4 border-indigo-400">
                            <img :src="'{{ asset('storage') }}/' + detailData.foto" class="w-full h-full object-cover">
                        </div>
                    </template>
                    <template x-if="!detailData.foto">
                        <div class="w-20 h-20 rounded-full bg-indigo-500 flex items-center justify-center font-black text-3xl mx-auto mb-3 border-4 border-indigo-400" x-text="detailData.name ? detailData.name.charAt(0).toUpperCase() : '?'"></div>
                    </template>
                    <h3 class="font-black text-xl uppercase" x-text="detailData.name"></h3>
                    <p class="text-indigo-300 text-sm font-medium" x-text="detailData.jabatan || '-'"></p>
                </div>
                <div class="p-6 space-y-3">
                    <div class="grid grid-cols-2 gap-4 text-sm">
                        <div>
                            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">NIP</p>
                            <p class="font-bold text-gray-900" x-text="detailData.nip || '-'"></p>
                        </div>
                        <div>
                            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Role</p>
                            <p class="font-bold text-gray-900" x-text="detailData.role"></p>
                        </div>
                        <div>
                            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Email</p>
                            <p class="font-bold text-gray-900" x-text="detailData.email"></p>
                        </div>
                        <div>
                            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Telepon</p>
                            <p class="font-bold text-gray-900" x-text="detailData.telepon || '-'"></p>
                        </div>
                        <div>
                            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Jenis Kelamin</p>
                            <p class="font-bold text-gray-900" x-text="detailData.jenis_kelamin == 'L' ? 'Laki-laki' : detailData.jenis_kelamin == 'P' ? 'Perempuan' : '-'"></p>
                        </div>
                        <div>
                            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Tanggal Lahir</p>
                            <p class="font-bold text-gray-900" x-text="detailData.tanggal_lahir || '-'"></p>
                        </div>
                        <div class="col-span-2">
                            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Alamat</p>
                            <p class="font-bold text-gray-900" x-text="detailData.alamat || '-'"></p>
                        </div>
                        <div class="col-span-2">
                            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Tanggal Bergabung</p>
                            <p class="font-bold text-gray-900" x-text="detailData.tanggal_bergabung || '-'"></p>
                        </div>
                    </div>
                    <div class="pt-4 text-center">
                        <button @click="modalDetail = false" class="px-6 py-2.5 bg-gray-100 text-gray-600 font-black rounded-xl uppercase text-xs">Tutup</button>
                    </div>
                </div>
            </div>
        </div>

    </div>

    @push('scripts')
    <script>
        document.getElementById('searchPegawai').addEventListener('keyup', function() {
            const value = this.value.toLowerCase();
            document.querySelectorAll('#pegawaiTable tbody tr').forEach(function(row) {
                row.style.display = row.textContent.toLowerCase().includes(value) ? '' : 'none';
            });
        });
    </script>
    @endpush
</x-app-layout>
