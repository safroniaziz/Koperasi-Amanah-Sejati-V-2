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
        Schema::create('transaksi_lainnyas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('transaksi_id');
            $table->unsignedBigInteger('jenis_transaksi_id');
            $table->unsignedBigInteger('anggota_id');
            $table->unsignedBigInteger('operator_id');
            $table->integer('jumlah_transaksi');
            $table->date('tanggal_transaksi');
            $table->string('bulan_transaksi');
            $table->string('tahun_transaksi');
            $table->string('kategori_transaksi');
            $table->text('keterangan')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('transaksi_id')->references('id')->on('transaksi_koperasis');
            $table->foreign('jenis_transaksi_id')->references('id')->on('jenis_transaksis');
            $table->foreign('anggota_id')->references('id')->on('users');
            $table->foreign('operator_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksi_lainnyas');
    }
};
