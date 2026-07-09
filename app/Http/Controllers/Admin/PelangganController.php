<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class PelangganController extends Controller
{
    public function index()
    {
        $pelanggan = User::where('role', 'pelanggan')->withCount('pesanan')->latest()->get();
        return view('admin.pelanggan.index', compact('pelanggan'));
    }

    public function show($id)
    {
        $pelanggan = User::where('role', 'pelanggan')->with('pesanan.detailPesanan.produk')->findOrFail($id);
        return view('admin.pelanggan.show', compact('pelanggan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'telepon' => 'nullable|string|max:20',
            'alamat' => 'nullable|string',
            'jenis_kelamin' => 'nullable|in:L,P',
            'tanggal_lahir' => 'nullable|date',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = $request->except('foto');
        $data['password'] = Hash::make($request->password);
        $data['role'] = 'pelanggan';
        $data['tanggal_bergabung'] = now();

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('foto-pelanggan', 'public');
        }

        $user = User::create($data);

        return back()->with('success', 'Data pelanggan berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.$id,
            'telepon' => 'nullable|string|max:20',
            'alamat' => 'nullable|string',
            'jenis_kelamin' => 'nullable|in:L,P',
            'tanggal_lahir' => 'nullable|date',
            'poin' => 'nullable|integer|min:0',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ];

        if ($request->filled('password')) {
            $rules['password'] = 'string|min:8';
        }

        $request->validate($rules);

        $data = $request->except(['foto', 'password']);

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        if ($request->hasFile('foto')) {
            if ($user->foto) {
                Storage::disk('public')->delete($user->foto);
            }
            $data['foto'] = $request->file('foto')->store('foto-pelanggan', 'public');
        }

        $user->update($data);

        return back()->with('success', 'Data pelanggan berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        if ($user->foto) {
            Storage::disk('public')->delete($user->foto);
        }
        $user->delete();
        return back()->with('success', 'Data pelanggan berhasil dihapus!');
    }
}
