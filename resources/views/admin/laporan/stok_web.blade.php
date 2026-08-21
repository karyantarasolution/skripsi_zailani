<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-2xl text-white uppercase tracking-tight">Laporan Stok Bahan Baku</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="flex flex-wrap items-center justify-between gap-4">
                <a href="{{ route('admin.dashboard') }}" class="text-xs font-black text-gray-400 uppercase hover:text-indigo-600 transition tracking-widest">&larr; Kembali</a>
                <a href="{{ route('admin.laporan.stok.pdf') }}" target="_blank" class="px-6 py-3 bg-red-600 text-white font-black uppercase text-xs tracking-widest rounded-xl hover:bg-red-500 transition shadow-lg flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    Download PDF
                </a>
            </div>

            <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100">
                <div class="flex items-center gap-4 mb-6">
                    <img src="{{ asset('images/orbit.png') }}" class="h-10 w-10" alt="Logo">
                    <div>
                        <h3 class="font-black text-gray-950 uppercase tracking-tight">Orbit Digital Printing</h3>
                        <p class="text-xs font-bold text-gray-500">Laporan Audit & Kontrol Stok Bahan Baku</p>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50 text-gray-400 text-[10px] uppercase tracking-widest">
                                <th class="p-4 font-black">No</th>
                                <th class="p-4 font-black">Nama Bahan Baku</th>
                                <th class="p-4 font-black text-right">Sisa Stok</th>
                                <th class="p-4 font-black text-right">Batas Minimum</th>
                                <th class="p-4 font-black">Satuan</th>
                                <th class="p-4 font-black">Status Audit</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($bahan as $b)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="p-4 text-sm font-bold text-gray-500">{{ $loop->iteration }}</td>
                                <td class="p-4 text-sm font-black text-gray-950">{{ $b->nama_bahan }}</td>
                                <td class="p-4 text-right font-black text-gray-900">{{ $b->stok }}</td>
                                <td class="p-4 text-right font-bold text-gray-600">{{ $b->minimum_stok }}</td>
                                <td class="p-4"><span class="px-3 py-1 bg-gray-100 text-gray-700 text-[10px] font-black rounded-lg uppercase">{{ $b->satuan }}</span></td>
                                <td class="p-4">
                                    @if($b->stok <= $b->minimum_stok)
                                        <span class="px-3 py-1 bg-red-50 text-red-700 text-[10px] font-black rounded-lg uppercase">Kritis</span>
                                    @else
                                        <span class="px-3 py-1 bg-emerald-50 text-emerald-700 text-[10px] font-black rounded-lg uppercase">Aman</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
