<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\JabatanController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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


Route::middleware('auth')->group(function(){
    Route::get('/home', [DashboardController::class, 'dashboard'])->name('home');

    Route::controller(JabatanController::class)->prefix('jabatan/')->group(function () {
        Route::get('/', 'index')->name('jabatan');
        Route::get('/create', 'create')->name('jabatan.create');
        Route::post('/', 'store')->name('jabatan.store');
        Route::get('/{jabatan}/edit', 'edit')->name('jabatan.edit');
        Route::patch('//update', 'update')->name('jabatan.update');
        Route::delete('/{jabatan}/delete', 'delete')->name('jabatan.delete');
    });
});