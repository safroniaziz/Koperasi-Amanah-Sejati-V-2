<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pinjaman extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'transaksi_id',
        'jenis_transaksi_id',
        'anggota_id',
        'operator_id',
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
        'is_paid',
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

    public function transaksi()
    {
        return $this->belongsTo(TransaksiKoperasi::class, 'transaksi_id');
    }

    public function anggota()
    {
        return $this->belongsTo(User::class, 'anggota_id');
    }

    public function angsurans()
    {
        return $this->hasMany(AngsuranPinjaman::class, 'pinjaman_id')->orderBy('created_at', 'desc');;
    }

    public function jumlahAngsuran(){
        return $this->angsurans->count('angsuran_ke');
    }
}
