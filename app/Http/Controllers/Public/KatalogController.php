<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Produk;

class KatalogController extends Controller
{
    public function index()
    {
        $produk = Produk::with('bahanBaku')->latest()->get();
        return view('katalog.index', compact('produk'));
    }

    public function show(Produk $produk)
    {
        $produk->load('bahanBaku');
        $produkLain = Produk::with('bahanBaku')
            ->where('id', '!=', $produk->id)
            ->latest()
            ->take(4)
            ->get();

        return view('katalog.show', compact('produk', 'produkLain'));
    }
}