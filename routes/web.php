<?php

use App\Models\TransaksiKoperasi;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\AngsuranPinjamanController;
use App\Http\Controllers\BukuKasPembantuController;
use App\Http\Controllers\JabatanController;
use App\Http\Controllers\PinjamanController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SimpananWajibController;
use App\Http\Controllers\JenisTransaksiController;
use App\Http\Controllers\KartuPinjamanAnggotaController;
use App\Http\Controllers\ModalAwalController;
use App\Http\Controllers\OperatorController;
use App\Http\Controllers\PermissionsController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\ShuAnggotaController;
use App\Http\Controllers\TabelarisKeluarController;
use App\Http\Controllers\TabelarisMasukController;
use App\Http\Controllers\TransaksiKoperasiController;
use App\Http\Controllers\TransaksiLainnyaController;

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
})->name('welcome');

Auth::routes();


Route::middleware('auth')->group(function(){
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
        Route::get('/anggota', 'simpananWajibAnggota')->name('simpananWajibAnggota');
        Route::get('/{anggota}/detail', 'detail')->name('simpananWajib.detail');
        Route::get('/create', 'create')->name('simpananWajib.create');
        Route::post('{anggota}/', 'store')->name('simpananWajib.store');
        Route::get('/{simpananWajib}/edit', 'edit')->name('simpananWajib.edit');
        Route::patch('{anggota}/update', 'update')->name('simpananWajib.update');
        Route::delete('/{simpananWajib}/delete', 'delete')->name('simpananWajib.delete');
    });

    Route::controller(PinjamanController::class)->prefix('pinjaman')->group(function () {
        Route::get('/', 'index')->name('pinjaman');
        Route::get('/{anggota}/detail', 'detail')->name('pinjaman.detail');
        Route::get('{anggota}/create', 'create')->name('pinjaman.create');
        Route::post('{anggota}/store', 'store')->name('pinjaman.store');
        Route::get('{anggota}/detail/{pinjaman}/edit', 'edit')->name('pinjaman.edit');
        Route::patch('{anggota}/detail/{pinjaman}/update', 'update')->name('pinjaman.update');
        Route::delete('{anggota}/detail/{pinjaman}/delete', 'delete')->name('pinjaman.delete');
    });

    Route::controller(AngsuranPinjamanController::class)->prefix('pinjaman')->group(function () {
        Route::get('/{anggota}/detail/{pinjaman}/angsuran', 'angsuran')->name('angsuran');
        Route::post('{anggota}/detail/{pinjaman}/store', 'store')->name('angsuran.store');
        Route::get('/{angsuran}/edit', 'edit')->name('angsuran.edit');
        Route::patch('{anggota}/detail/{pinjaman}/update_angsuran', 'update')->name('angsuran.update');
        Route::delete('/{angsuran}/delete', 'delete')->name('angsuran.delete');
    });

    Route::controller(TransaksiLainnyaController::class)->prefix('transaksiKoperasi')->group(function () {
        Route::get('/', 'index')->name('transaksiKoperasi');
        Route::get('/create', 'create')->name('transaksiKoperasi.create');
        Route::post('/', 'store')->name('transaksiKoperasi.store');
        Route::get('/{transaksiKoperasi}/edit', 'edit')->name('transaksiKoperasi.edit');
        Route::patch('{transaksiKoperasi}/update', 'update')->name('transaksiKoperasi.update');
        Route::delete('/{transaksiKoperasi}/delete', 'delete')->name('transaksiKoperasi.delete');
    });

    Route::controller(ModalAwalController::class)->prefix('modal_awal')->group(function () {
        Route::get('/', 'index')->name('modalAwal');
        Route::get('/create', 'create')->name('modalAwal.create');
        Route::post('/', 'store')->name('modalAwal.store');
        Route::get('/{modalAwal}/edit', 'edit')->name('modalAwal.edit');
        Route::patch('/update', 'update')->name('modalAwal.update');
        Route::delete('/{modalAwal}/delete', 'delete')->name('modalAwal.delete');
    });

    Route::controller(BukuKasPembantuController::class)->prefix('buku_kas_pembantu')->group(function () {
        Route::get('/', 'index')->name('kasPembantu');
        Route::get('/cari', 'cariBukuKas')->name('kasPembantu.cariBukuKas');
        Route::get('/export_data', 'exportData')->name('kasPembantu.exportData');
    });

    Route::controller(KartuPinjamanAnggotaController::class)->prefix('kartu_pinjaman')->group(function () {
        Route::get('/', 'index')->name('kartuPinjaman');
        Route::get('/anggota', 'kartuPinjamanAnggota')->name('kartuPinjaman.anggota');
        Route::get('{anggota}/detail', 'detail')->name('kartuPinjaman.detail');
        Route::get('{anggota}/detail/{pinjaman}/cetak', 'cetak')->name('kartuPinjaman.cetak');
    });

    Route::controller(TabelarisMasukController::class)->prefix('tabelaris_kas_masuk')->group(function () {
        Route::get('/', 'index')->name('tabelarisMasuk');
        Route::get('/cari', 'cari')->name('tabelarisMasuk.cari');
        Route::get('/export', 'pdf')->name('tabelarisMasuk.pdf');
        Route::post('/', 'modalAwalPost')->name('tabelarisMasuk.modalAwalPost');
        Route::get('/export_data', 'exportData')->name('tabelarisMasuk.exportData');

    });

    Route::controller(TabelarisKeluarController::class)->prefix('tabelaris_kas_keluar')->group(function () {
        Route::get('/', 'index')->name('tabelarisKeluar');
        Route::get('/cari', 'cari')->name('tabelarisKeluar.cari');
        Route::get('/export', 'pdf')->name('tabelarisKeluar.pdf');
        Route::get('/export_data', 'exportData')->name('tabelarisKeluar.exportData');
    });

    Route::controller(ShuAnggotaController::class)->prefix('sisa_hasil_usaha')->group(function () {
        Route::get('/', 'index')->name('shu');
        Route::get('/anggota', 'shuAnggota')->name('shu.anggota');
        Route::get('/{anggota}/detail', 'detail')->name('shu.detail');
        Route::get('/{shu}/edit', 'edit')->name('shu.edit');
        Route::post('/{anggota}/store', 'store')->name('shu.store');
        Route::patch('/{anggota}/update', 'update')->name('shu.update');
        Route::delete('/{anggota}/delete/{shu}', 'delete')->name('shu.delete');
    });

    Route::controller(PermissionsController::class)->group(function () {
        Route::get('/permissions', 'index')->name('permissions');
        Route::post('/permissions', 'store')->name('permissions.store');
        Route::get('/permissions/{permission}/edit', 'edit')->name('permissions.edit');
        Route::patch('/permissions/update', 'update')->name('permissions.update');
        Route::delete('/permissions/{permission}/delete', 'delete')->name('permissions.delete');
    });

    Route::controller(RolesController::class)->group(function () {
        Route::get('/roles', 'index')->name('roles');
        Route::post('/roles', 'store')->name('roles.store');
        Route::get('/roles/{role}/edit', 'edit')->name('roles.edit');
        Route::patch('/roles/update', 'update')->name('roles.update');
        Route::get('/roles/{role}/detail', 'detail')->name('roles.detail');
        Route::delete('/roles/{role}/delete', 'delete')->name('roles.delete');
        Route::delete('/roles/{role}/revoke/{permission}', 'revoke')->name('roles.revoke');
        Route::post('/roles/{role}/assign/', 'assign')->name('roles.assign');
    });

    Route::controller(AnggotaController::class)->prefix('anggota')->group(function () {
        Route::get('/', 'index')->name('anggota');
        Route::get('/create', 'create')->name('anggota.create');
        Route::post('/', 'store')->name('anggota.store');
        Route::get('/{anggota}/edit', 'edit')->name('anggota.edit');
        Route::patch('/update', 'update')->name('anggota.update');
        Route::delete('/{anggota}/delete', 'delete')->name('anggota.delete');
        Route::patch('/update_password', 'updatePassword')->name('anggota.update_password');

    });

    // Route::controller(AnggotaController::class)->prefix('anggota')->group(function () {
    //     Route::get('/', 'index')->name('anggota');
    //     Route::get('/create', 'create')->name('anggota.create');
    //     Route::post('/', 'store')->name('anggota.store');
    //     Route::get('/{anggota}/edit', 'edit')->name('anggota.edit');
    //     Route::patch('/update', 'update')->name('anggota.update');
    //     Route::delete('/{anggota}/delete', 'delete')->name('anggota.delete');
    // });

    Route::controller(OperatorController::class)->prefix('operator')->group(function () {
        Route::get('/', 'index')->name('operator');
        Route::get('/create', 'create')->name('operator.create');
        Route::post('/', 'store')->name('operator.store');
        Route::get('/{operator}/edit', 'edit')->name('operator.edit');
        Route::patch('/update', 'update')->name('operator.update');
        Route::delete('/{operator}/delete', 'delete')->name('operator.delete');
        Route::patch('/update_password', 'updatePassword')->name('operator.update_password');
    });
});