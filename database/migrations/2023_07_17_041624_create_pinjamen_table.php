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
        Schema::create('pinjamen', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('jenis_transaksi_id');
            $table->unsignedBigInteger('anggota_id');
            $table->integer('jumlah_transaksi');
            $table->integer('presentase_jasa');
            $table->integer('angsuran_pokok');
            $table->integer('angsuran_jasa');
            $table->integer('jumlah_bulan');
            $table->string('bulan_mulai_angsuran');
            $table->string('tahun_mulai_angsuran');
            $table->string('bulan_selesai_angsuran');
            $table->string('tahun_selesai_angsuran');
            $table->string('pinjaman_ke');
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
        Schema::dropIfExists('pinjamen');
    }
};
