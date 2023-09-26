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
            $table->boolean('is_paid')->default(0)->after('pinjaman_ke');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pinjamen', function (Blueprint $table) {
            $table->dropColumn('is_paid');
        });
    }
};
