<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisTransaksi extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_jenis_transaksi',
        'kategori_transaksi',
    ];

    public function simpananWajib()
    {
        return $this->hasMany(SimpananWajib::class, 'jenis_transaksi_id');
    }

    public function pinjaman()
    {
        return $this->hasMany(Pinjaman::class, 'jenis_transaksi_id');
    }

    public function angsuranPinjaman()
    {
        return $this->hasMany(AngsuranPinjaman::class, 'jenis_transaksi_id');
    }
}
