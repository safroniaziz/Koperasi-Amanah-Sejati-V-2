<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'jabatan_id',
        'nama_lengkap',
        'nik',
        'alamat',
        'tahun_keanggotaan',
        'simpanan_pokok',
        'email',
        'email_verified_at',
        'password',
        'image_path',
        'is_active',
    ];

    public function scopeAnggota($query)
    {
        return $query->whereHas('roles', function ($query) {
            $query->where('name', 'Anggota');
        });
    }

    public function scopeOperator($query)
    {
        return $query->whereHas('roles', function ($query) {
            $query->where('name', 'Operator');
        });
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', 1);
    }

    public function simpananPokok(){
        return $this->hasMany(TransaksiKoperasi::class ,'anggota_id')->where('jenis_transaksi_id',6);
    }

    public function angsurans(){
        return $this->hasMany(AngsuranPinjaman::class ,'anggota_id');
    }

    public function jabatan()
    {
        return $this->belongsTo(Jabatan::class, 'jabatan_id');
    }

    public function simpananWajibs()
    {
        return $this->hasMany(SimpananWajib::class, 'anggota_id');
    }

    public function totalSimpananWajib()
    {
        return $this->simpananWajibs->count('jumlah_transaksi');
    }

    public function jumlahSimpananWajib()
    {
        return $this->simpananWajibs->sum('jumlah_transaksi');
    }

    public function jumlahSimpananWajibPerTahun()
    {
        return $this->simpananWajibs()
            ->orderBy('created_at', 'asc') // Urutkan berdasarkan tahun (created_at) secara menaik
            ->get()
            ->groupBy(function ($simpanan) {
                return $simpanan->created_at->format('Y');
            })
            ->map(function ($grouped) {
                return $grouped->sum('jumlah_transaksi');
            });
    }

    public function pinjamans()
    {
        return $this->hasMany(Pinjaman::class, 'anggota_id')->orderBy('created_at', 'asc');
    }

    public function totalPinjaman()
    {
        return $this->pinjamans->count('pinjaman_ke');
    }

    public function angsuranPinjaman()
    {
        return $this->hasMany(AngsuranPinjaman::class, 'jenis_transaksi_id');
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
}
