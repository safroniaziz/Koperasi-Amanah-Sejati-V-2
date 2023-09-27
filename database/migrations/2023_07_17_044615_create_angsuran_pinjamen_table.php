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
        Schema::create('angsuran_pinjamen', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('transaksi_id')->nullable();
            $table->unsignedBigInteger('pinjaman_id');
            $table->unsignedBigInteger('anggota_id');
            $table->integer('angsuran_pokok');
            $table->integer('angsuran_jasa');
            $table->integer('tanggal_transaksi');
            $table->integer('bulan_transaksi');
            $table->string('tahun_transaksi');
            $table->integer('angsuran_ke');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('transaksi_id')->references('id')->on('transaksi_koperasis');
            $table->foreign('pinjaman_id')->references('id')->on('pinjamen');
            $table->foreign('anggota_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('angsuran_pinjamen');
    }
};
