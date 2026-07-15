<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-2xl text-gray-900 uppercase tracking-tight">Bahan Masuk & Bahan Keluar</h2>
    </x-slot>

    <div class="py-12" x-data="{ modalAdd: false }">
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

            {{-- Stat Cards --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12"/></svg>
                    </div>
                    <div>
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Total Bahan Masuk</p>
                        <p class="text-2xl font-black text-emerald-700">{{ $totalMasuk }}</p>
                    </div>
                </div>
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-red-50 text-red-600 flex items-center justify-center shrink-0">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 13l-5 5m0 0l-5-5m5 5V6"/></svg>
                    </div>
                    <div>
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Total Bahan Keluar</p>
                        <p class="text-2xl font-black text-red-700">{{ $totalKeluar }}</p>
                    </div>
                </div>
            </div>

            {{-- Filter & Add --}}
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6 mb-6">
                <div class="flex flex-wrap items-center justify-between gap-4">
                    <form method="GET" class="flex flex-wrap items-end gap-3">
                        <div>
                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Jenis</label>
                            <select name="jenis" class="rounded-xl border-gray-200 text-sm font-bold" onchange="this.form.submit()">
                                <option value="">Semua</option>
                                <option value="masuk" {{ request('jenis') == 'masuk' ? 'selected' : '' }}>Bahan Masuk</option>
                                <option value="keluar" {{ request('jenis') == 'keluar' ? 'selected' : '' }}>Bahan Keluar</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Bahan</label>
                            <select name="bahan_id" class="rounded-xl border-gray-200 text-sm font-bold" onchange="this.form.submit()">
                                <option value="">Semua Bahan</option>
                                @foreach($bahanList as $b)
                                    <option value="{{ $b->id }}" {{ request('bahan_id') == $b->id ? 'selected' : '' }}>{{ $b->nama_bahan }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Dari</label>
                            <input type="date" name="tanggal_mulai" value="{{ request('tanggal_mulai') }}" class="rounded-xl border-gray-200 text-sm font-bold">
                        </div>
                        <div>
                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Sampai</label>
                            <input type="date" name="tanggal_selesai" value="{{ request('tanggal_selesai') }}" class="rounded-xl border-gray-200 text-sm font-bold">
                        </div>
                        <button type="submit" class="px-4 py-2.5 bg-indigo-600 text-white font-black rounded-xl text-xs uppercase tracking-widest hover:bg-indigo-500 transition">Filter</button>
                        @if(request()->anyFilled(['jenis', 'bahan_id', 'tanggal_mulai', 'tanggal_selesai']))
                            <a href="{{ route('admin.bahan-masuk-keluar.index') }}" class="px-4 py-2.5 bg-gray-100 text-gray-600 font-black rounded-xl text-xs uppercase tracking-widest hover:bg-gray-200 transition">Reset</a>
                        @endif
                    </form>
                    <button @click="modalAdd = true" class="px-6 py-3 bg-emerald-600 hover:bg-emerald-500 text-white font-black uppercase text-xs tracking-widest rounded-xl transition shadow-lg transform active:scale-95">
                        + Catat Pergerakan
                    </button>
                </div>
            </div>

            {{-- Table --}}
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50 text-gray-400 text-[10px] uppercase tracking-widest">
                                <th class="p-5 font-black">Waktu</th>
                                <th class="p-5 font-black">Bahan</th>
                                <th class="p-5 font-black">Jenis</th>
                                <th class="p-5 font-black text-center">Jumlah</th>
                                <th class="p-5 font-black text-right">Stok Awal</th>
                                <th class="p-5 font-black text-right">Stok Akhir</th>
                                <th class="p-5 font-black">Keterangan</th>
                                <th class="p-5 font-black">Oleh</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($riwayat as $r)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="p-5 text-xs font-bold text-gray-600">{{ $r->created_at->format('d/m/Y H:i') }}</td>
                                <td class="p-5 font-black text-gray-900 uppercase text-sm">{{ $r->bahanBaku?->nama_bahan ?? 'Dihapus' }}</td>
                                <td class="p-5">
                                    @if($r->jenis == 'masuk')
                                        <span class="px-3 py-1 bg-emerald-100 text-emerald-700 text-[10px] font-black rounded-lg uppercase">Masuk</span>
                                    @elseif($r->jenis == 'keluar')
                                        <span class="px-3 py-1 bg-red-100 text-red-700 text-[10px] font-black rounded-lg uppercase">Keluar</span>
                                    @else
                                        <span class="px-3 py-1 bg-orange-100 text-orange-700 text-[10px] font-black rounded-lg uppercase">{{ $r->jenis }}</span>
                                    @endif
                                </td>
                                <td class="p-5 text-center font-black text-lg {{ $r->jenis == 'masuk' ? 'text-emerald-600' : 'text-red-600' }}">
                                    {{ $r->jenis == 'masuk' ? '+' : '-' }}{{ $r->jumlah }}
                                </td>
                                <td class="p-5 text-right font-bold text-gray-600">{{ $r->stok_sebelum }}</td>
                                <td class="p-5 text-right font-bold text-gray-900">{{ $r->stok_sesudah }}</td>
                                <td class="p-5 text-xs text-gray-500 max-w-[200px] truncate">{{ $r->keterangan ?? '-' }}</td>
                                <td class="p-5 text-xs font-bold text-gray-600">{{ $r->user?->name ?? 'Sistem' }}</td>
                            </tr>
                            @endforeach
                            @if($riwayat->isEmpty())
                            <tr>
                                <td colspan="8" class="p-8 text-center text-gray-400 font-medium">Belum ada pergerakan stok.</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
                <div class="p-4">
                    {{ $riwayat->links() }}
                </div>
            </div>
        </div>

        {{-- Modal Tambah Pergerakan --}}
        <div x-show="modalAdd" style="display: none;" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm">
            <div @click.away="modalAdd = false" class="bg-white p-8 rounded-3xl shadow-2xl w-full max-w-md">
                <h3 class="font-black text-gray-900 uppercase text-xl mb-6">Catat Pergerakan Stok</h3>
                <form action="{{ route('admin.bahan-masuk-keluar.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Pilih Bahan *</label>
                        <select name="bahan_baku_id" required class="w-full rounded-xl border-gray-200 focus:ring-indigo-500 font-bold">
                            <option value="">Pilih Bahan</option>
                            @foreach($bahanList as $b)
                                <option value="{{ $b->id }}">{{ $b->nama_bahan }} (Stok: {{ $b->stok }} {{ $b->satuan }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Jenis Pergerakan *</label>
                        <select name="jenis" required class="w-full rounded-xl border-gray-200 focus:ring-indigo-500 font-bold">
                            <option value="masuk">Bahan Masuk (Restock)</option>
                            <option value="keluar">Bahan Keluar (Pemakaian/Rusak)</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Jumlah *</label>
                        <input type="number" name="jumlah" required min="1" class="w-full rounded-xl border-gray-200 focus:ring-indigo-500 font-black text-xl">
                    </div>
                    <div>
                        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Keterangan</label>
                        <input type="text" name="keterangan" class="w-full rounded-xl border-gray-200 focus:ring-indigo-500 font-bold text-sm" placeholder="Contoh: Pembelian dari supplier / Pemakaian produksi">
                    </div>
                    <div class="pt-4 flex justify-end gap-3">
                        <button type="button" @click="modalAdd = false" class="px-5 py-2.5 bg-gray-100 text-gray-600 font-black rounded-xl uppercase text-xs">Batal</button>
                        <button type="submit" class="px-5 py-2.5 bg-emerald-600 text-white font-black rounded-xl uppercase text-xs">Simpan</button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</x-app-layout>
