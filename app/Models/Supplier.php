<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $fillable = [
        'nama_supplier',
        'kontak_person',
        'telepon',
        'email',
        'alamat',
        'bank',
        'nomor_rekening',
    ];

    public function bahanBaku()
    {
        return $this->hasMany(BahanBaku::class, 'supplier_id');
    }
}
