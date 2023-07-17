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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('jabatan_id');
            $table->string('nama_anggota');
            $table->string('nik');
            $table->text('alamat');
            $table->string('tahun_keanggotaan');
            $table->integer('simpanan_pokok');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('image_path');
            $table->boolean('is_active');
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('jabatan_id')->references('id')->on('jabatans');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
