<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class PegawaiController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware(function ($request, $next) {
                if (auth()->user()->role !== 'admin') {
                    abort(403, 'Akses Ditolak. Hanya Admin yang diizinkan mengelola data pegawai.');
                }
                return $next($request);
            }),
        ];
    }

    public function index()
    {
        $pegawai = User::whereIn('role', ['admin', 'pegawai'])->latest()->get();
        return view('admin.pegawai.index', compact('pegawai'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'username' => 'nullable|string|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role' => 'required|in:admin,pegawai',
            'nip' => 'nullable|string|unique:users',
            'jabatan' => 'nullable|string|max:255',
            'telepon' => 'nullable|string|max:20',
            'alamat' => 'nullable|string',
            'jenis_kelamin' => 'nullable|in:L,P',
            'tanggal_lahir' => 'nullable|date',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = $request->except('foto');
        $data['password'] = Hash::make($request->password);
        $data['tanggal_bergabung'] = now();

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('foto-pegawai', 'public');
        }

        User::create($data);

        return back()->with('success', 'Data pegawai berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.$id,
            'username' => 'nullable|string|max:255|unique:users,username,'.$id,
            'role' => 'required|in:admin,pegawai',
            'nip' => 'nullable|string|unique:users,nip,'.$id,
            'jabatan' => 'nullable|string|max:255',
            'telepon' => 'nullable|string|max:20',
            'alamat' => 'nullable|string',
            'jenis_kelamin' => 'nullable|in:L,P',
            'tanggal_lahir' => 'nullable|date',
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
            $data['foto'] = $request->file('foto')->store('foto-pegawai', 'public');
        }

        $user->update($data);

        return back()->with('success', 'Data pegawai berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        if ($user->id === auth()->id()) {
            return back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri!');
        }

        if ($user->foto) {
            Storage::disk('public')->delete($user->foto);
        }

        $user->delete();
        return back()->with('success', 'Data pegawai berhasil dihapus!');
    }
}
