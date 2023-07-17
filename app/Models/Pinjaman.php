<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pinjaman extends Model
{
    use HasFactory;

    protected $fillable = [
        'jenis_transaksi_id',
        'anggota_id',
        'jumlah_transaksi',
        'presentase_jasa',
        'angsuran_pokok',
        'angsuran_jasa',
        'jumlah_bulan',
        'bulan_mulai_angsuran',
        'tahun_mulai_angsuran',
        'bulan_selesai_angsuran',
        'tahun_selesai_angsuran',
        'pinjaman_ke',
    ];

    /**
     * Get the user that owns the Pinjaman
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function jenisTransaksi()
    {
        return $this->belongsTo(JenisTransaksi::class, 'jenis_transaksi_id');
    }

    public function anggota()
    {
        return $this->belongsTo(User::class, 'anggota_id');
    }

    public function angsuranPinjaman()
    {
        return $this->hasMany(AngsuranPinjaman::class, 'jenis_transaksi_id');
    }
}
