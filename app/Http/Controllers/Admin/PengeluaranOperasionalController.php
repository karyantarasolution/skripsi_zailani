<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PengeluaranOperasional;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PengeluaranOperasionalController extends Controller
{
    public function index(Request $request)
    {
        $query = PengeluaranOperasional::with('user');

        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        if ($request->filled('tanggal_mulai')) {
            $query->whereDate('tanggal', '>=', $request->tanggal_mulai);
        }

        if ($request->filled('tanggal_selesai')) {
            $query->whereDate('tanggal', '<=', $request->tanggal_selesai);
        }

        $pengeluaran = $query->latest()->paginate(15)->withQueryString();

        $totalBulanIni = PengeluaranOperasional::whereMonth('tanggal', date('m'))
            ->whereYear('tanggal', date('Y'))
            ->sum('jumlah');

        $totalKeseluruhan = PengeluaranOperasional::sum('jumlah');

        $kategoriList = PengeluaranOperasional::$kategoriList;

        // Data untuk grafik
        $grafikKategori = PengeluaranOperasional::whereMonth('tanggal', date('m'))
            ->whereYear('tanggal', date('Y'))
            ->selectRaw('kategori, SUM(jumlah) as total')
            ->groupBy('kategori')
            ->pluck('total', 'kategori');

        return view('admin.pengeluaran-operasional.index', compact(
            'pengeluaran', 'totalBulanIni', 'totalKeseluruhan', 'kategoriList', 'grafikKategori'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kategori' => 'required|string',
            'deskripsi' => 'nullable|string',
            'jumlah' => 'required|numeric|min:0',
            'tanggal' => 'required|date',
            'bukti' => 'nullable|image|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $data = $request->except('bukti');
        $data['user_id'] = Auth::id();

        if ($request->hasFile('bukti')) {
            $data['bukti'] = $request->file('bukti')->store('bukti-pengeluaran', 'public');
        }

        PengeluaranOperasional::create($data);

        return back()->with('success', 'Data pengeluaran berhasil dicatat!');
    }

    public function update(Request $request, $id)
    {
        $pengeluaran = PengeluaranOperasional::findOrFail($id);

        $request->validate([
            'kategori' => 'required|string',
            'deskripsi' => 'nullable|string',
            'jumlah' => 'required|numeric|min:0',
            'tanggal' => 'required|date',
            'bukti' => 'nullable|image|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $data = $request->except('bukti');

        if ($request->hasFile('bukti')) {
            if ($pengeluaran->bukti) {
                Storage::disk('public')->delete($pengeluaran->bukti);
            }
            $data['bukti'] = $request->file('bukti')->store('bukti-pengeluaran', 'public');
        }

        $pengeluaran->update($data);

        return back()->with('success', 'Data pengeluaran berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $pengeluaran = PengeluaranOperasional::findOrFail($id);
        if ($pengeluaran->bukti) {
            Storage::disk('public')->delete($pengeluaran->bukti);
        }
        $pengeluaran->delete();
        return back()->with('success', 'Data pengeluaran berhasil dihapus!');
    }
}
