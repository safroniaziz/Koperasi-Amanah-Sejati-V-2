<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ModalAwal extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'modal_awals';

    protected $fillable = [
        'tahun',
        'bulan',
        'modal_awal',
    ];
}
