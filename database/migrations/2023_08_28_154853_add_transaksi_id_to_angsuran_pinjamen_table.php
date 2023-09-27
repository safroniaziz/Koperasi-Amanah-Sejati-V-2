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
        Schema::table('angsuran_pinjamen', function (Blueprint $table) {
            $table->date('tanggal_transaksi')->change();
            $table->string('bulan_transaksi')->change();

            $table->dropForeign(['jenis_transaksi_id']);
            $table->dropColumn('jenis_transaksi_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('angsuran_pinjamen', function (Blueprint $table) {
            $table->dropForeign(['transaksi_id']);
            $table->dropColumn('transaksi_id');

            $table->integer('tanggal_transaksi')->change();
            $table->integer('bulan_transaksi')->change();

            $table->unsignedBigInteger('jenis_transaksi_id');
            $table->foreign('jenis_transaksi_id')->references('id')->on('jenis_transaksis');

        });
    }
};
