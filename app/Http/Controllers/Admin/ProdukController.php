<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Produk;
use App\Models\BahanBaku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProdukController extends Controller
{
    public function index()
    {
        $produk = Produk::with('bahanBaku')->latest()->get();
        $semuaBahan = BahanBaku::all(); 
        
        return view('admin.produk.index', compact('produk', 'semuaBahan'));
    }

    public function create()
    {
        $bahan = BahanBaku::all();
        return view('admin.produk.create', compact('bahan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_produk' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'bahan_baku_id' => 'required|exists:bahan_baku,id',
            'harga_dasar' => 'required|numeric|min:0',
            'satuan' => 'required|in:m,cm,mm',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $pathGambar = $request->hasFile('gambar') 
            ? $request->file('gambar')->store('produk', 'public') 
            : null;

        Produk::create([
            'bahan_baku_id' => $request->bahan_baku_id,
            'nama_produk' => $request->nama_produk,
            'deskripsi' => $request->deskripsi,
            'harga_dasar' => $request->harga_dasar,
            'satuan' => $request->satuan,
            'gambar' => $pathGambar,
        ]);

        return redirect()->route('admin.produk.index')->with('success', 'Produk berhasil ditambahkan!');
    }

    public function show(Produk $produk)
    {
        return redirect()->route('admin.produk.edit', $produk->id);
    }

    public function edit(Produk $produk)
    {
        $bahan = BahanBaku::all();
        return view('admin.produk.edit', compact('produk', 'bahan'));
    }

    public function update(Request $request, Produk $produk)
    {
        $request->validate([
            'nama_produk' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'bahan_baku_id' => 'required|exists:bahan_baku,id',
            'harga_dasar' => 'required|numeric|min:0',
            'satuan' => 'required|in:m,cm,mm',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->only(['bahan_baku_id', 'nama_produk', 'deskripsi', 'harga_dasar', 'satuan']);

        if ($request->hasFile('gambar')) {
            if ($produk->gambar) {
                Storage::disk('public')->delete('produk/' . $produk->gambar);
            }
            $data['gambar'] = $request->file('gambar')->store('produk', 'public');
        }

        $produk->update($data);

        return redirect()->route('admin.produk.index')->with('success', 'Produk berhasil diupdate!');
    }

    public function destroy(Produk $produk)
    {
        if ($produk->gambar) {
            Storage::disk('public')->delete('produk/' . $produk->gambar);
        }
        $produk->delete();

        return redirect()->route('admin.produk.index')->with('success', 'Produk berhasil dihapus!');
    }

    public function updateFormula(Request $request, $id)
    {
        $produk = Produk::findOrFail($id);
        
        $syncData = [];
        
        if($request->has('is_used')) {
            foreach($request->is_used as $bahanId => $value) {
                $syncData[$bahanId] = [
                    'jumlah_digunakan' => $request->jumlah_digunakan[$bahanId] ?? 1,
                    'tipe_pengurangan' => $request->tipe_pengurangan[$bahanId] ?? 'per_meter'
                ];
            }
        }
        
        $produk->bahanBaku()->sync($syncData);
        
        return back()->with('success', 'Formula Bahan Baku untuk produk ini berhasil diatur!');
    }
}