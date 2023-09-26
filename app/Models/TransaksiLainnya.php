<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TransaksiLainnya extends Model
{
    use HasFactory, SoftDeletes;

    protected $casts = [
        'tanggal_transaksi' => 'date',
    ];

    protected $fillable = [
        'transaksi_id',
        'jenis_transaksi_id',
        'anggota_id',
        'operator_id',
        'jumlah_transaksi',
        'tanggal_transaksi',
        'bulan_transaksi',
        'tahun_transaksi',
        'kategori_transaksi',
        'keterangan',
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
