<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'username', 'email', 'password', 'role', 'telepon', 'alamat', 'nip', 'jabatan', 'jenis_kelamin', 'tanggal_lahir', 'foto', 'poin', 'tanggal_bergabung'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'role',
        'telepon',
        'alamat',
        'nip',
        'jabatan',
        'jenis_kelamin',
        'tanggal_lahir',
        'foto',
        'poin',
        'tanggal_bergabung',
    ];

    public function pesanan()
    {
        return $this->hasMany(Pesanan::class);
    }

    public function pengeluaranOperasional()
    {
        return $this->hasMany(PengeluaranOperasional::class);
    }

    public function riwayatLogins()
    {
        return $this->hasMany(RiwayatLogin::class);
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isPegawai(): bool
    {
        return $this->role === 'pegawai';
    }

    public function isPelanggan(): bool
    {
        return $this->role === 'pelanggan';
    }

    public function isStaff(): bool
    {
        return in_array($this->role, ['admin', 'pegawai']);
    }

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'tanggal_lahir' => 'date',
            'tanggal_bergabung' => 'date',
        ];
    }
}
