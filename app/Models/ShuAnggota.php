<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ShuAnggota extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function anggota()
    {
        return $this->belongsTo(User::class, 'anggota_id');
    }

    public function getTotalShuSimpananAttribute()
    {
        return $this->attributes['total_shu_simpanan'] ?? $this->calculateTotalShuSimpanan();
    }

    protected function calculateTotalShuSimpanan()
    {
        return DB::table('shu_anggotas')
            ->where('anggota_id', $this->anggota_id)
            ->sum('shu_simpanan');
    }

    public function getTotalShuJasaAttribute()
    {
        return $this->attributes['total_shu_jasa'] ?? $this->calculateTotalShuJasa();
    }

    protected function calculateTotalShuJasa()
    {
        return DB::table('shu_anggotas')
            ->where('anggota_id', $this->anggota_id)
            ->sum('shu_jasa');
    }

    public function getTotalShuAttribute()
    {
        return $this->attributes['total_shu'] ?? $this->calculateTotalShu();
    }

    protected function calculateTotalShu()
    {
        $totalShuSimpanan = $this->attributes['total_shu_simpanan'] ?? $this->calculateTotalShuSimpanan();
        $totalShuJasa = $this->attributes['total_shu_jasa'] ?? $this->calculateTotalShuJasa();

        return $totalShuSimpanan + $totalShuJasa;
    }

}
