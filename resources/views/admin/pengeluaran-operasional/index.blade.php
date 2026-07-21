<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-2xl text-gray-900 uppercase tracking-tight">Pengeluaran Operasional</h2>
    </x-slot>

    <div class="py-12" x-data="{ modalAdd: false, modalEdit: false, modalDetail: false, editData: {}, detailData: {} }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if(session('success'))
                <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-2xl font-bold uppercase tracking-widest text-xs">
                    ✓ {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="p-4 bg-red-50 border border-red-200 text-red-700 rounded-2xl font-bold uppercase tracking-widest text-xs">
                    ⚠️ {{ session('error') }}
                </div>
            @endif

            {{-- Stat --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-red-50 text-red-600 flex items-center justify-center shrink-0">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    </div>
                    <div>
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Bulan Ini</p>
                        <p class="text-xl font-black text-red-700">Rp{{ number_format($totalBulanIni, 0, ',', '.') }}</p>
                    </div>
                </div>
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-gray-50 text-gray-600 flex items-center justify-center shrink-0">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div>
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Total Keseluruhan</p>
                        <p class="text-xl font-black text-gray-950">Rp{{ number_format($totalKeseluruhan, 0, ',', '.') }}</p>
                    </div>
                </div>
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-orange-50 text-orange-600 flex items-center justify-center shrink-0">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                    </div>
                    <div>
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Grafik Kategori</p>
                        <p class="text-xs font-bold text-gray-500 mt-1">{{ $grafikKategori->count() }} kategori aktif bulan ini</p>
                    </div>
                </div>
            </div>

            {{-- Grafik Pengeluaran per Kategori --}}
            @if(count($grafikKategori) > 0)
            <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100">
                <h4 class="font-black text-gray-950 uppercase tracking-tighter mb-4">Pengeluaran per Kategori (Bulan Ini)</h4>
                <canvas id="grafikKategori" height="150"></canvas>
                <div class="flex flex-wrap gap-3 mt-4 pt-4 border-t border-gray-100">
                    @php $colors = ['#ef4444','#f97316','#f59e0b','#10b981','#06b6d4','#3b82f6','#8b5cf6','#ec4899','#6366f1','#6b7280']; @endphp
                    @foreach($grafikKategori as $kategori => $total)
                        <div class="flex items-center gap-2 px-3 py-1.5 bg-gray-50 rounded-lg">
                            <div class="w-3 h-3 rounded-sm shrink-0" style="background: {{ $colors[$loop->index % count($colors)] }}"></div>
                            <span class="text-xs font-bold text-gray-700">{{ $kategori }}</span>
                            <span class="text-[10px] font-black text-gray-400">Rp{{ number_format($total, 0, ',', '.') }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- Filter & Add --}}
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6">
                <div class="flex flex-wrap items-center justify-between gap-4">
                    <form method="GET" class="flex flex-wrap items-end gap-3">
                        <div>
                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Kategori</label>
                            <select name="kategori" class="rounded-xl border-gray-200 text-sm font-bold" onchange="this.form.submit()">
                                <option value="">Semua</option>
                                @foreach($kategoriList as $kat)
                                    <option value="{{ $kat }}" {{ request('kategori') == $kat ? 'selected' : '' }}>{{ $kat }}</option>
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
                        @if(request()->anyFilled(['kategori', 'tanggal_mulai', 'tanggal_selesai']))
                            <a href="{{ route('admin.pengeluaran-operasional.index') }}" class="px-4 py-2.5 bg-gray-100 text-gray-600 font-black rounded-xl text-xs uppercase tracking-widest hover:bg-gray-200 transition">Reset</a>
                        @endif
                    </form>
                    <button @click="modalAdd = true" class="px-6 py-3 bg-red-600 hover:bg-red-500 text-white font-black uppercase text-xs tracking-widest rounded-xl transition shadow-lg transform active:scale-95">
                        + Catat Pengeluaran
                    </button>
                </div>
            </div>

            {{-- Table --}}
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50 text-gray-400 text-[10px] uppercase tracking-widest">
                                <th class="p-5 font-black">Tanggal</th>
                                <th class="p-5 font-black">Kategori</th>
                                <th class="p-5 font-black">Deskripsi</th>
                                <th class="p-5 font-black text-right">Jumlah</th>
                                <th class="p-5 font-black">Dicatat Oleh</th>
                                <th class="p-5 font-black text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($pengeluaran as $p)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="p-5 text-sm font-bold text-gray-900">{{ $p->tanggal->format('d/m/Y') }}</td>
                                <td class="p-5">
                                    <span class="px-3 py-1 bg-red-50 text-red-700 text-[10px] font-black rounded-lg uppercase">{{ $p->kategori }}</span>
                                </td>
                                <td class="p-5 text-sm text-gray-600 max-w-[250px] truncate">{{ $p->deskripsi ?? '-' }}</td>
                                <td class="p-5 text-right font-black text-red-600 text-lg">Rp{{ number_format($p->jumlah, 0, ',', '.') }}</td>
                                <td class="p-5 text-xs font-bold text-gray-600">{{ $p->user->name }}</td>
                                <td class="p-5 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <button @click="modalDetail = true; detailData = {{ $p->toJson() }}" class="p-2 bg-gray-50 text-gray-600 hover:bg-gray-900 hover:text-white rounded-xl transition" title="Detail">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                        </button>
                                        <button @click="modalEdit = true; editData = {{ $p->toJson() }}" class="p-2 bg-indigo-50 text-indigo-600 hover:bg-indigo-600 hover:text-white rounded-xl transition" title="Edit">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                                        </button>
                                        <form action="{{ route('admin.pengeluaran-operasional.destroy', $p->id) }}" method="POST" onsubmit="return confirm('Hapus pengeluaran ini?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="p-2 bg-red-50 text-red-600 hover:bg-red-600 hover:text-white rounded-xl transition" title="Hapus">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                            @if($pengeluaran->isEmpty())
                            <tr>
                                <td colspan="6" class="p-8 text-center text-gray-400 font-medium">Belum ada data pengeluaran.</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
                <div class="p-4">
                    {{ $pengeluaran->links() }}
                </div>
            </div>
        </div>

        {{-- Modal Tambah --}}
        <div x-show="modalAdd" style="display: none;" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm">
            <div @click.away="modalAdd = false" class="bg-white p-8 rounded-3xl shadow-2xl w-full max-w-lg">
                <h3 class="font-black text-gray-900 uppercase text-xl mb-6">Catat Pengeluaran Baru</h3>
                <form action="{{ route('admin.pengeluaran-operasional.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Kategori *</label>
                        <select name="kategori" required class="w-full rounded-xl border-gray-200 focus:ring-indigo-500 font-bold">
                            <option value="">Pilih Kategori</option>
                            @foreach($kategoriList as $kat)
                                <option value="{{ $kat }}">{{ $kat }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Deskripsi</label>
                        <textarea name="deskripsi" rows="2" class="w-full rounded-xl border-gray-200 focus:ring-indigo-500 font-bold text-sm" placeholder="Contoh: Tagihan listrik bulan Juni"></textarea>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Jumlah (Rp) *</label>
                            <input type="number" name="jumlah" required min="0" step="0.01" class="w-full rounded-xl border-gray-200 focus:ring-indigo-500 font-black text-xl">
                        </div>
                        <div>
                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Tanggal *</label>
                            <input type="date" name="tanggal" required value="{{ date('Y-m-d') }}" class="w-full rounded-xl border-gray-200 focus:ring-indigo-500 font-bold">
                        </div>
                    </div>
                    <div>
                        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Bukti / Nota (Foto/PDF)</label>
                        <input type="file" name="bukti" accept="image/*,.pdf" class="w-full rounded-xl border-gray-200 focus:ring-indigo-500">
                    </div>
                    <div class="pt-4 flex justify-end gap-3">
                        <button type="button" @click="modalAdd = false" class="px-5 py-2.5 bg-gray-100 text-gray-600 font-black rounded-xl uppercase text-xs">Batal</button>
                        <button type="submit" class="px-5 py-2.5 bg-red-600 text-white font-black rounded-xl uppercase text-xs">Simpan</button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Modal Edit --}}
        <div x-show="modalEdit" style="display: none;" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm">
            <div @click.away="modalEdit = false" class="bg-white p-8 rounded-3xl shadow-2xl w-full max-w-lg">
                <h3 class="font-black text-gray-900 uppercase text-xl mb-6">Edit Pengeluaran</h3>
                <form :action="`{{ url('admin/pengeluaran-operasional') }}/${editData.id}`" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf @method('PUT')
                    <div>
                        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Kategori *</label>
                        <select name="kategori" x-model="editData.kategori" required class="w-full rounded-xl border-gray-200 focus:ring-indigo-500 font-bold">
                            <option value="">Pilih</option>
                            @foreach($kategoriList as $kat)
                                <option value="{{ $kat }}">{{ $kat }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Deskripsi</label>
                        <textarea name="deskripsi" x-model="editData.deskripsi" rows="2" class="w-full rounded-xl border-gray-200 focus:ring-indigo-500 font-bold text-sm"></textarea>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Jumlah (Rp) *</label>
                            <input type="number" name="jumlah" x-model.number="editData.jumlah" required min="0" step="0.01" class="w-full rounded-xl border-gray-200 focus:ring-indigo-500 font-black text-xl">
                        </div>
                        <div>
                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Tanggal *</label>
                            <input type="date" name="tanggal" x-model="editData.tanggal" required class="w-full rounded-xl border-gray-200 focus:ring-indigo-500 font-bold">
                        </div>
                    </div>
                    <div>
                        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Bukti Baru</label>
                        <input type="file" name="bukti" accept="image/*,.pdf" class="w-full rounded-xl border-gray-200 focus:ring-indigo-500">
                    </div>
                    <div class="pt-4 flex justify-end gap-3">
                        <button type="button" @click="modalEdit = false" class="px-5 py-2.5 bg-gray-100 text-gray-600 font-black rounded-xl uppercase text-xs">Batal</button>
                        <button type="submit" class="px-5 py-2.5 bg-red-600 text-white font-black rounded-xl uppercase text-xs">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Modal Detail --}}
        <div x-show="modalDetail" style="display: none;" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm">
            <div @click.away="modalDetail = false" class="bg-white p-8 rounded-3xl shadow-2xl w-full max-w-md">
                <h3 class="font-black text-gray-900 uppercase text-xl mb-6">Detail Pengeluaran</h3>
                <div class="space-y-3 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-500 font-bold">Kategori</span>
                        <span class="font-black text-gray-900" x-text="detailData.kategori"></span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500 font-bold">Jumlah</span>
                        <span class="font-black text-red-600 text-lg" x-text="'Rp' + Number(detailData.jumlah).toLocaleString('id-ID')"></span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500 font-bold">Tanggal</span>
                        <span class="font-bold text-gray-900" x-text="detailData.tanggal"></span>
                    </div>
                    <div>
                        <span class="text-gray-500 font-bold block mb-1">Deskripsi</span>
                        <p class="font-bold text-gray-900" x-text="detailData.deskripsi || '-'"></p>
                    </div>
                    <div>
                        <span class="text-gray-500 font-bold block mb-1">Dicatat Oleh</span>
                        <p class="font-bold text-gray-900" x-text="detailData.user ? detailData.user.name : '-'"></p>
                    </div>
                    <template x-if="detailData.bukti">
                        <div>
                            <span class="text-gray-500 font-bold block mb-1">Bukti</span>
                            <template x-if="detailData.bukti.match(/\.(jpg|jpeg|png|gif|webp)$/i)">
                                <a :href="'{{ asset('storage') }}/' + detailData.bukti" target="_blank">
                                    <img :src="'{{ asset('storage') }}/' + detailData.bukti" class="w-full rounded-xl border border-gray-200 shadow-sm mt-1">
                                </a>
                            </template>
                            <template x-if="!detailData.bukti.match(/\.(jpg|jpeg|png|gif|webp)$/i)">
                                <a :href="'{{ asset('storage') }}/' + detailData.bukti" target="_blank" class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-50 text-indigo-700 font-bold rounded-xl text-sm hover:bg-indigo-100 transition mt-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                    Lihat PDF
                                </a>
                            </template>
                        </div>
                    </template>
                </div>
                <div class="pt-6 text-center">
                    <button @click="modalDetail = false" class="px-6 py-2.5 bg-gray-100 text-gray-600 font-black rounded-xl uppercase text-xs">Tutup</button>
                </div>
            </div>
        </div>

    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const grafikData = @json($grafikKategori);
            const labels = Object.keys(grafikData);
            const values = Object.values(grafikData);
            const colors = ['#ef4444','#f97316','#f59e0b','#10b981','#06b6d4','#3b82f6','#8b5cf6','#ec4899','#6366f1','#6b7280'];

            if (labels.length > 0 && document.getElementById('grafikKategori')) {
                new Chart(document.getElementById('grafikKategori'), {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Total Pengeluaran (Rp)',
                            data: values,
                            backgroundColor: colors.slice(0, labels.length),
                            borderRadius: 6,
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: { legend: { display: false } },
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    callback: function(v) { return 'Rp' + v.toLocaleString('id-ID'); }
                                }
                            }
                        }
                    }
                });
            }
        });
    </script>
    @endpush
</x-app-layout>
