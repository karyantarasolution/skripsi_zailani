<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-2xl text-white uppercase tracking-tight">Manajemen Karyawan & Akses</h2>
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
                        <h3 class="font-black text-xl uppercase tracking-tighter">Daftar Staf Orbit Print</h3>
                        <p class="text-indigo-300 text-xs mt-1 font-medium">Hanya Super Admin yang dapat mengelola data ini.</p>
                    </div>
                    <button @click="modalAdd = true" class="px-6 py-3 bg-indigo-500 hover:bg-indigo-400 text-white font-black uppercase text-xs tracking-widest rounded-xl transition shadow-lg transform active:scale-95">
                        + Tambah Karyawan
                    </button>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50 text-gray-400 text-[10px] uppercase tracking-widest">
                                <th class="p-5 font-black">Nama Karyawan</th>
                                <th class="p-5 font-black">Kontak & Email</th>
                                <th class="p-5 font-black">Posisi (Role)</th>
                                <th class="p-5 font-black text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($karyawan as $k)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="p-5">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center font-black text-lg">
                                            {{ substr($k->name, 0, 1) }}
                                        </div>
                                        <span class="font-black text-gray-900 uppercase text-sm">{{ $k->name }}</span>
                                    </div>
                                </td>
                                <td class="p-5">
                                    <p class="font-bold text-gray-900 text-xs">{{ $k->email }}</p>
                                    <p class="text-xs text-gray-500 mt-1">{{ $k->telepon ?? '-' }}</p>
                                </td>
                                <td class="p-5">
                                    @if($k->role == 'super_admin')
                                        <span class="px-3 py-1 bg-red-100 text-red-700 text-[10px] font-black rounded-lg uppercase tracking-widest">Super Admin</span>
                                    @elseif($k->role == 'admin_kantor')
                                        <span class="px-3 py-1 bg-indigo-100 text-indigo-700 text-[10px] font-black rounded-lg uppercase tracking-widest">Admin Kantor</span>
                                    @else
                                        <span class="px-3 py-1 bg-emerald-100 text-emerald-700 text-[10px] font-black rounded-lg uppercase tracking-widest">Kasir Depan</span>
                                    @endif
                                </td>
                                <td class="p-5 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <button @click="modalEdit = true; editData = { id: {{ $k->id }}, name: '{{ $k->name }}', email: '{{ $k->email }}', role: '{{ $k->role }}' }" class="px-3 py-2 bg-indigo-50 text-indigo-600 hover:bg-indigo-600 hover:text-white rounded-lg transition font-black text-[10px] uppercase tracking-widest">
                                            Edit
                                        </button>
                                        @if($k->id !== auth()->id())
                                        <form action="{{ route('admin.karyawan.destroy', $k->id) }}" method="POST" onsubmit="return confirm('Hapus karyawan ini?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="px-3 py-2 bg-red-50 text-red-600 hover:bg-red-600 hover:text-white rounded-lg transition font-black text-[10px] uppercase tracking-widest">Hapus</button>
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

        <div x-show="modalAdd" style="display: none;" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm">
            <div @click.away="modalAdd = false" class="bg-white p-8 rounded-3xl shadow-2xl w-full max-w-md">
                <h3 class="font-black text-gray-900 uppercase text-xl mb-6">Tambah Karyawan Baru</h3>
                <form action="{{ route('admin.karyawan.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Nama Lengkap</label>
                        <input type="text" name="name" required class="w-full rounded-xl border-gray-200 focus:ring-indigo-500 font-bold">
                    </div>
                    <div>
                        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Email</label>
                        <input type="email" name="email" required class="w-full rounded-xl border-gray-200 focus:ring-indigo-500 font-bold">
                    </div>
                    <div>
                        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Password Sementara</label>
                        <input type="password" name="password" required class="w-full rounded-xl border-gray-200 focus:ring-indigo-500 font-bold">
                    </div>
                    <div>
                        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Hak Akses (Role)</label>
                        <select name="role" required class="w-full rounded-xl border-gray-200 focus:ring-indigo-500 font-bold">
                            <option value="kasir">Kasir (Transaksi & Antrean)</option>
                            <option value="admin_kantor">Admin Kantor (Stok & Laporan)</option>
                            <option value="super_admin">Super Admin (Akses Penuh)</option>
                        </select>
                    </div>
                    <div class="pt-4 flex justify-end gap-3">
                        <button type="button" @click="modalAdd = false" class="px-5 py-2.5 bg-gray-100 text-gray-600 font-black rounded-xl uppercase text-xs">Batal</button>
                        <button type="submit" class="px-5 py-2.5 bg-indigo-600 text-white font-black rounded-xl uppercase text-xs">Simpan Data</button>
                    </div>
                </form>
            </div>
        </div>

        <div x-show="modalEdit" style="display: none;" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm">
            <div @click.away="modalEdit = false" class="bg-white p-8 rounded-3xl shadow-2xl w-full max-w-md">
                <h3 class="font-black text-gray-900 uppercase text-xl mb-6">Edit Karyawan</h3>
                <form :action="`{{ url('admin/karyawan') }}/${editData.id}`" method="POST" class="space-y-4">
                    @csrf @method('PUT')
                    <div>
                        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Nama Lengkap</label>
                        <input type="text" name="name" x-model="editData.name" required class="w-full rounded-xl border-gray-200 focus:ring-indigo-500 font-bold">
                    </div>
                    <div>
                        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Email</label>
                        <input type="email" name="email" x-model="editData.email" required class="w-full rounded-xl border-gray-200 focus:ring-indigo-500 font-bold">
                    </div>
                    <div>
                        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Reset Password (Kosongkan jika tidak ubah)</label>
                        <input type="password" name="password" class="w-full rounded-xl border-gray-200 focus:ring-indigo-500 font-bold">
                    </div>
                    <div>
                        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Hak Akses (Role)</label>
                        <select name="role" x-model="editData.role" required class="w-full rounded-xl border-gray-200 focus:ring-indigo-500 font-bold">
                            <option value="kasir">Kasir</option>
                            <option value="admin_kantor">Admin Kantor</option>
                            <option value="super_admin">Super Admin</option>
                        </select>
                    </div>
                    <div class="pt-4 flex justify-end gap-3">
                        <button type="button" @click="modalEdit = false" class="px-5 py-2.5 bg-gray-100 text-gray-600 font-black rounded-xl uppercase text-xs">Batal</button>
                        <button type="submit" class="px-5 py-2.5 bg-indigo-600 text-white font-black rounded-xl uppercase text-xs">Update Data</button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</x-app-layout>