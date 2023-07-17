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
        Schema::create('transaksi_koperasis', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('jenis_transaksi_id');
            $table->unsignedBigInteger('anggota_id');
            $table->integer('jumlah_transaksi');
            $table->string('tanggal_transaksi');
            $table->string('bulan_transaksi');
            $table->string('tahun_transaksi');
            $table->string('angsuran_ke');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('jenis_transaksi_id')->references('id')->on('jenis_transaksis');
            $table->foreign('anggota_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksi_koperasis');
    }
};
