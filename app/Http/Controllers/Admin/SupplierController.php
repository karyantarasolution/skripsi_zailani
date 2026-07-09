<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function index()
    {
        $suppliers = Supplier::latest()->get();
        return view('admin.supplier.index', compact('suppliers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_supplier' => 'required|string|max:255',
            'kontak_person' => 'nullable|string|max:255',
            'telepon' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'alamat' => 'nullable|string',
            'bank' => 'nullable|string',
            'nomor_rekening' => 'nullable|string',
        ]);

        Supplier::create($request->all());

        return back()->with('success', 'Data supplier berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $supplier = Supplier::findOrFail($id);

        $request->validate([
            'nama_supplier' => 'required|string|max:255',
            'kontak_person' => 'nullable|string|max:255',
            'telepon' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'alamat' => 'nullable|string',
            'bank' => 'nullable|string',
            'nomor_rekening' => 'nullable|string',
        ]);

        $supplier->update($request->all());

        return back()->with('success', 'Data supplier berhasil diperbarui!');
    }

    public function destroy($id)
    {
        Supplier::findOrFail($id)->delete();
        return back()->with('success', 'Data supplier berhasil dihapus!');
    }
}
