<?php

use App\Models\Pelanggan;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MerekController;
use App\Http\Controllers\MotorController;
use App\Http\Controllers\RiwayatController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\PenyewaanController;
use App\Http\Controllers\PengembalianController;
use App\Http\Controllers\utamaController;

Route::get('/', [utamaController::class, 'index'])->name('index');
//merek
Route::get('/merek', [MerekController::class, 'index'])->name('indexMerek');
Route::post('/tambah', [MerekController::class, 'tambahMerek'])->name('tambahMerek');
Route::put('/update/{id}', [MerekController::class, 'update'])->name('update');
Route::delete('/delete/{id}', [MerekController::class, 'delete'])->name('delete');

//motor
Route::get('/motor', [MotorController::class, 'index'])->name('motor');
Route::post('/tambahMotor', [MotorController::class, 'tambah'])->name('tambahMotor');
Route::put('updateMotor/{id}', [MotorController::class, 'update'])->name('updateMotor');
Route::delete('/deleteMotor/{id}', [MotorController::class, 'delete'])->name('deleteMotor');

// pelanggan
Route::get('/pelanggan', [PelangganController::class, 'index'])->name('indexPelanggan');
Route::post('/tambahPelanggan', [PelangganController::class, 'tambahPelanggan'])->name('tambahPelanggan');
Route::put('/updatePelanggan/{id}', [PelangganController::class, 'updatePelanggan'])->name('updatePelanggan');
Route::delete('/deletePelanggan/{id}', [PelangganController::class, 'deletePelanggan'])->name('hapusPelanggan');

//sewa
Route::get('/sewa/penyewaan', [PenyewaanController::class, 'index'])->name('penyewaan');
Route::post('/sewa/tambah', [PenyewaanController::class, 'Tambah'])->name('tambahSewa');
Route::put('/sewa/update/{id}', [PenyewaanController::class, 'update'])->name('updateSewa');
Route::delete('/sewa/delete/{id}', [PenyewaanController::class, 'delete'])->name('deleteSewa');


//pengembalian
Route::get('/sewa/pengembalian', [PengembalianController::class, 'index'])->name('pengembalian');
Route::post('/sewa/pengembalian/kembali/{id}', [PengembalianController::class, 'kembali'])->name('kembali');

//riwayat
Route::get('/sewa/riwayat', [RiwayatController::class, 'index'])->name('riwayat');

