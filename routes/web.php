<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;

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
    return view('welcome');
});

Route::get('/firebase', [AdminController::class, 'index']);
Route::post('/login', [AdminController::class, 'login'])->name('login');

Route::group(['middleware' => 'myauth'], function() {
    Route::get('/logout', [AdminController::class, 'logout']);
    Route::get('/dashboard-admin', [AdminController::class, 'showDashboardAdminPage']);
    Route::get('/daftar-admin', [AdminController::class, 'showDaftarAdminPage']);
    Route::post('/tambah-admin', [AdminController::class, 'tambahAdmin'])->name('tambah-admin');
    Route::post('/edit-admin', [AdminController::class, 'editAdmin'])->name('edit-admin');
    Route::post('/hapus-admin', [AdminController::class, 'deleteAdmin'])->name('hapus-admin');
    Route::get('/daftar-pedagang', [AdminController::class, 'showDaftarPedagangPage']);
    Route::post('/tambah-pedagang', [AdminController::class, 'tambahPedagang'])->name('tambah-pedagang');
    Route::post('/edit-pedagang', [AdminController::class, 'editPedagang'])->name('edit-pedagang');
    Route::post('/hapus-pedagang', [AdminController::class, 'deletePedagang'])->name('hapus-pedagang');
    Route::get('/daftar-pembeli', [AdminController::class, 'showDaftarPembeliPage']);
    Route::post('/tambah-pembeli', [AdminController::class, 'tambahPembeli'])->name('tambah-pembeli');
    Route::post('/edit-pembeli', [AdminController::class, 'editPembeli'])->name('edit-pembeli');
    Route::post('/hapus-pembeli', [AdminController::class, 'deletePembeli'])->name('hapus-pembeli');
    Route::get('/daftar-barang-sistem', [AdminController::class, 'showDaftarBarangSistemPage']);
    Route::post('/tambah-barang-sistem', [AdminController::class, 'tambahBarangSistem'])->name('tambah-barang-sistem');
    Route::post('/edit-barang-sistem', [AdminController::class, 'editBarangSistem'])->name('edit-barang-sistem');
    Route::post('/hapus-barang-sistem', [AdminController::class, 'deleteBarangSistem'])->name('hapus-barang-sistem');
    Route::get('/daftar-pembeli-nonaktif', [AdminController::class, 'showVerifikasiPembeliPage'])->name('read-pembeli-nonaktif');
    Route::post('/verifikasi-pembeli', [AdminController::class, 'verifikasiPembeli'])->name('verifikasi-pembeli');
});

