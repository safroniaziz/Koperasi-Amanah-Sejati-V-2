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
        Schema::table('simpanan_wajibs', function (Blueprint $table) {
            $table->unsignedBigInteger('operator_id')->nullable()->after('anggota_id');
            $table->integer('jumlah_transaksi')->after('operator_id');
            $table->timestamp('deleted_at')->after('updated_at')->nullable();

            // Menambahkan foreign key ke tabel users
            $table->foreign('operator_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('simpanan_wajibs', function (Blueprint $table) {
            // Menghapus foreign key jika diperlukan
            $table->dropForeign(['operator_id']);

            // Menghapus kolom operator_id
            $table->dropColumn('operator_id');
            $table->dropColumn('jumlah_transaksi');
            $table->dropColumn('deleted_at');
        });
    }
};
