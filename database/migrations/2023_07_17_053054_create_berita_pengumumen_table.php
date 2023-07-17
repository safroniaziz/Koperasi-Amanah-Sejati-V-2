<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('berita_pengumumen', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->integer('anggota_id');
            $table->integer('jumlah_transaksi');
            $table->string('tanggal_transaksi');
            $table->string('bulan_transaksi');
            $table->string('tahun_transaksi');
            $table->integer('angsuran_ke');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('berita_pengumumen');
    }
};
