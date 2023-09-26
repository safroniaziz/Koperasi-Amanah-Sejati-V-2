<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransaksiKoperasi extends Model
{
    use HasFactory;

    protected $fillable = [
        'jenis_transaksi_id',
        'anggota_id',
        'operator_id',
        'kategori_transaksi',
        'jumlah_transaksi',
        'tanggal_transaksi',
        'bulan_transaksi',
        'tahun_transaksi',
    ];

    public function jenisTransaksi()
    {
        return $this->belongsTo(JenisTransaksi::class, 'jenis_transaksi_id');
    }

    public function anggota()
    {
        return $this->belongsTo(User::class, 'anggota_id');
    }
}
