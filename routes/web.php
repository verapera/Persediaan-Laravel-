<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\BarangMasukController;
use App\Http\Controllers\BarangKeluarController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('/auth/login');
});
Route::resource('/barang', BarangController::class);
Route::resource('/barangmasuk', BarangMasukController::class);
Route::resource('/barangkeluar', BarangKeluarController::class);
Route::get('pdf_barangmasuk', [LaporanController::class, 'laporan_barang_masuk']);
Route::get('pdf_barangkeluar', [LaporanController::class, 'laporan_barang_keluar']);
Route::post('excel_barang', [LaporanController::class, 'exportToExcel']);
Route::post('/exportToExcel', [BarangController::class, 'filter']);

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
