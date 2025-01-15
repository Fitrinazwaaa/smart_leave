<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\AdminSiswaController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminKelasController;

Route::get('/guru/dashboard', [GuruController::class, 'dashboard'])->name('dashboardGuru');
Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('dashboardAdmin');
    Route::get('/admin/data-siswa', [AdminController::class, 'data_siswa'])->name('dataSiswa');

    Route::get('/admin/siswa', [AdminKelasController::class, 'indexSiswa'])->name('kelasSiswa');
    Route::get('/admin/siswa/kelas', [AdminKelasController::class, 'indexKelas'])->name('kelasKelas');
    Route::post('/admin/siswa/kelas/store', [AdminKelasController::class, 'store'])->name('kelas.store');