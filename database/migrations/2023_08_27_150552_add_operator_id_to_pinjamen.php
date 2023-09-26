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
        Schema::table('pinjamen', function (Blueprint $table) {
            $table->unsignedBigInteger('operator_id')->nullable()->after('anggota_id');

            // Menambahkan foreign key ke tabel users
            $table->foreign('operator_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pinjamen', function (Blueprint $table) {
            $table->dropForeign(['operator_id']);

            // Menghapus kolom operator_id
            $table->dropColumn('operator_id');
        });
    }
};
