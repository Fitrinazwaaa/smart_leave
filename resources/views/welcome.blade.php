<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\AdminSiswaController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminKelasController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SiswaController;

// LOGIN
Route::middleware(['guest'])->group(function () {
    Route::get('/login', [AuthController::class, 'index_login'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::get('/home', function () {
    if (Auth::check()) {
        // Ambil pengguna yang sedang login
        $user = Auth::user();

        // Arahkan pengguna ke dashboard yang sesuai berdasarkan username, nis, atau nip
        if ($user->nis) {
            // Pengguna adalah siswa
            return redirect('/siswa/dashboard');
        } elseif ($user->nip) {
            // Pengguna adalah guru
            return redirect('/guru/dashboard');
        } elseif ($user->username) {
            // Pengguna adalah admin (dengan username)
            return redirect('/admin/dashboard');
        }
    }

    return redirect('/login'); // Jika tidak ada pengguna yang login, arahkan ke halaman login
});

// PUSAT ADMIN
Route::middleware(['auth'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('dashboardAdmin');
    Route::get('/guru/dashboard', [GuruController::class, 'dashboard'])->name('dashboardGuru');
    Route::get('/siswa/dashboard', [SiswaController::class, 'dashboard'])->name('dashboardSiswa');
});

// Rute untuk manipulasi data siswa dan kelas di admin
Route::get('/admin/siswa', [AdminSiswaController::class, 'indexSiswa'])->name('kelasSiswa');
Route::post('/admin/siswa/store', [AdminSiswaController::class, 'store'])->name('akun-siswa.store');
Route::get('/get-konsentrasi', [AdminSiswaController::class, 'getKonsentrasi'])->name('get-konsentrasi');
Route::get('/export-siswa', [AdminSiswaController::class, 'export'])->name('export-siswa');
Route::post('/import-siswa', [AdminSiswaController::class, 'import'])->name('import-siswa');

// Rute untuk manipulasi kelas di admin
Route::get('/admin/siswa/kelas', [AdminKelasController::class, 'indexKelas'])->name('kelasKelas');
Route::post('/admin/siswa/kelas/store', [AdminKelasController::class, 'store'])->name('kelas.store');

// Rute logout
Route::post('/logout', function () {
    Auth::logout();
    return redirect('/login'); // Pastikan ini mengarah ke rute login yang benar
})->name('logout');
