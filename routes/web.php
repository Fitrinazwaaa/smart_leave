<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\AdminSiswaController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminKelasController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\AdminGuruController;


Route::middleware(['guest'])->group(function () {
    Route::get('/', [AuthController::class, 'index_login'])->name('login');
    Route::post('/login/siswa', [AuthController::class, 'loginSiswa'])->name('login.siswa');
    Route::post('/login/guru', [AuthController::class, 'loginGuru'])->name('login.guru');
    Route::post('/login/kurikulum', [AuthController::class, 'loginKurikulum'])->name('login.kurikulum');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/siswa/dashboard', function () {
        if (Auth::user()->nis) { // Hanya siswa yang memiliki NIS
            return view('siswa.dashboard');
        }
        return redirect('/')->withErrors(['error' => 'Akses ditolak.']);
    })->name('dashboard.siswa');

    Route::get('/guru/dashboard', function () {
        if (Auth::user()->nip) { // Hanya guru yang memiliki NIP
            return view('guru.dashboard');
        }
        return redirect('/')->withErrors(['error' => 'Akses ditolak.']);
    })->name('dashboard.guru');

    Route::get('/admin/dashboard', function () {
        if (Auth::user()->username) { // Hanya kurikulum yang memiliki username
            return view('admin.dashboard');
        }
        return redirect('/')->withErrors(['error' => 'Akses ditolak.']);
    })->name('dashboard.admin');
});



// Logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');



// Rute untuk manipulasi data siswa dan kelas di admin
Route::get('/admin/siswa', [AdminSiswaController::class, 'indexSiswa'])->name('kelasSiswa');
Route::post('/admin/siswa/store', [AdminSiswaController::class, 'store'])->name('akun-siswa.store');
Route::get('/get-konsentrasi', [AdminSiswaController::class, 'getKonsentrasi'])->name('get-konsentrasi');
Route::get('/export-siswa', [AdminSiswaController::class, 'export'])->name('export-siswa');
Route::post('/import-siswa', [AdminSiswaController::class, 'import'])->name('import-siswa');

// Rute untuk manajemen data guru
Route::prefix('admin/guru')->group(function () {
    Route::get('/', [AdminGuruController::class, 'indexGuru'])->name('admin.guru.index'); // Halaman daftar guru
    Route::post('/store', [AdminGuruController::class, 'store'])->name('admin.guru.store'); // Tambah data guru
    Route::post('/import', [AdminGuruController::class, 'import'])->name('admin.guru.import'); // Import data guru
    Route::get('/export', [AdminGuruController::class, 'export'])->name('admin.guru.export'); // Export data guru
});


// Rute untuk manipulasi kelas di admin
Route::get('/admin/siswa/kelas', [AdminKelasController::class, 'indexKelas'])->name('kelasKelas');
Route::post('/admin/siswa/kelas/store', [AdminKelasController::class, 'store'])->name('kelas.store');
