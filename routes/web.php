<?php

use App\Models\TransaksiKoperasi;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\JabatanController;
use App\Http\Controllers\PinjamanController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SimpananWajibController;
use App\Http\Controllers\JenisTransaksiController;
use App\Http\Controllers\TransaksiKoperasiController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();


// Route::middleware('auth')->group(function(){
Route::get('/home', [DashboardController::class, 'dashboard'])->name('home');

Route::controller(JabatanController::class)->prefix('jabatan')->group(function () {
    Route::get('/', 'index')->name('jabatan');
    Route::post('/', 'store')->name('jabatan.store');
    Route::get('/{jabatan}/edit', 'edit')->name('jabatan.edit');
    Route::patch('/update', 'update')->name('jabatan.update');
    Route::delete('/{jabatan}/delete', 'delete')->name('jabatan.delete');
});

Route::controller(JenisTransaksiController::class)->prefix('jenis_transaksi')->group(function () {
    Route::get('/', 'index')->name('jenisTransaksi');
    Route::post('/', 'store')->name('jenisTransaksi.store');
    Route::get('/{jenisTransaksi}/edit', 'edit')->name('jenisTransaksi.edit');
    Route::patch('/update', 'update')->name('jenisTransaksi.update');
    Route::delete('/{jenisTransaksi}/delete', 'delete')->name('jenisTransaksi.delete');
});

Route::controller(SimpananWajibController::class)->prefix('simpanan_wajib')->group(function () {
    Route::get('/', 'index')->name('simpananWajib');
    Route::get('/create', 'create')->name('simpananWajib.create');
    Route::post('/', 'store')->name('simpananWajib.store');
    Route::get('/{simpananWajib}/edit', 'edit')->name('simpananWajib.edit');
    Route::patch('/update', 'update')->name('simpananWajib.update');
    Route::delete('/{simpananWajib}/delete', 'delete')->name('simpananWajib.delete');
});

Route::controller(PinjamanController::class)->prefix('pinjaman')->group(function () {
    Route::get('/', 'index')->name('pinjaman');
    Route::get('/create', 'create')->name('pinjaman.create');
    Route::post('/', 'store')->name('pinjaman.store');
    Route::get('/{pinjaman}/edit', 'edit')->name('pinjaman.edit');
    Route::patch('/update', 'update')->name('pinjaman.update');
    Route::delete('/{pinjaman}/delete', 'delete')->name('pinjaman.delete');
});

Route::controller(TransaksiKoperasiController::class)->prefix('transaksiKoperasi')->group(function () {
    Route::get('/', 'index')->name('transaksiKoperasi');
    Route::get('/create', 'create')->name('transaksiKoperasi.create');
    Route::post('/', 'store')->name('transaksiKoperasi.store');
    Route::get('/{transaksiKoperasi}/edit', 'edit')->name('transaksiKoperasi.edit');
    Route::patch('/update', 'update')->name('transaksiKoperasi.update');
    Route::delete('/{transaksiKoperasi}/delete', 'delete')->name('transaksiKoperasi.delete');
});

Route::controller(AnggotaController::class)->prefix('anggota')->group(function () {
    Route::get('/', 'index')->name('anggota');
    Route::get('/create', 'create')->name('anggota.create');
    Route::post('/', 'store')->name('anggota.store');
    Route::get('/{anggota}/edit', 'edit')->name('anggota.edit');
    Route::patch('/update', 'update')->name('anggota.update');
    Route::delete('/{anggota}/delete', 'delete')->name('anggota.delete');
});
// });