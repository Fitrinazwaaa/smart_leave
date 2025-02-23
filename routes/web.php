<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AdminSiswaController;
use App\Http\Controllers\AdminKelasController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminGuruController;
use App\Http\Controllers\AdminPiketController;
use App\Http\Controllers\DispensasiController;
use App\Http\Controllers\GuruKonfirmasiController;
use App\Http\Controllers\SiswaDispensasiController;
use App\Http\Controllers\SiswaKonfirmController;
use App\Http\Controllers\PdfViewerController;
use App\Http\Controllers\DispensasiPdfController;

Route::middleware(['guest'])->group(function () {
    Route::get('/', [AuthController::class, 'index_login'])->name('login');
    Route::post('/login/siswa', [AuthController::class, 'loginSiswa'])->name('login.siswa');
    Route::post('/login/guru', [AuthController::class, 'loginGuru'])->name('login.guru');
    Route::post('/login/kurikulum', [AuthController::class, 'loginKurikulum'])->name('login.kurikulum');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/siswa', function () {
        if (Auth::user()->nis) { // Hanya siswa yang memiliki NIS
            return view('siswa.dashboard');
        }
        return redirect('/')->withErrors(['error' => 'Akses ditolak.']);
    })->name('dashboard.siswa');

    Route::get('/guru', function () {
        if (Auth::user()->nip) { // Hanya guru yang memiliki NIP
            return view('guru.dashboard');
        }
        return redirect('/')->withErrors(['error' => 'Akses ditolak.']);
    })->name('dashboard.guru');

    Route::get('/admin', function () {
        if (Auth::user()->username) { // Hanya kurikulum yang memiliki username
            return view('admin.dashboard');
        }
        return redirect('/')->withErrors(['error' => 'Akses ditolak.']);
    })->name('dashboard.admin');
});

// Logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::prefix('admin/pengaturan')->group(function () {
    Route::get('/', [AdminController::class, 'edit'])->name('akun-kurikulum.index');
    Route::post('/update', [AdminController::class, 'update'])->name('akun-kurikulum.update');
});

// Rute untuk manajemen data guru
Route::prefix('admin/guru')->group(function () {
    Route::get('/', [AdminGuruController::class, 'indexGuru'])->name('admin.guru.index'); // Halaman daftar guru
    Route::post('/store', [AdminGuruController::class, 'store'])->name('admin.guru.store'); // Tambah data guru
    Route::post('/import', [AdminGuruController::class, 'import'])->name('admin.guru.import'); // Import data guru
    Route::get('/export', [AdminGuruController::class, 'export'])->name('admin.guru.export'); // Export data guru
    Route::delete('/hapus', [AdminGuruController::class, 'destroyMultiple'])->name('delete-guru');
});

Route::prefix('/admin/piket')->group(function () {
    Route::get('/', [AdminPiketController::class, 'index'])->name('admin.piket');
    Route::post('/store', [AdminPiketController::class, 'store'])->name('admin.piket.store');
    Route::post('/delete', [AdminPiketController::class, 'delete'])->name('admin.piket.delete');
    Route::post('/update/{id}', [AdminPiketController::class, 'update'])->name('admin.piket.update');
    Route::get('/get/guru/list', [AdminPiketController::class, 'getGuruList'])->name('get.guru.list');
    Route::get('/get/nama/by/nip', [AdminPiketController::class, 'getNamaByNip'])->name('get.nama.by.nip');
    Route::post('/update-pekan-status', [AdminPiketController::class, 'updatePekanStatus']);
});

Route::prefix('/admin')->group(function () {
    Route::get('/history', [DispensasiController::class, 'history_admin'])->name('historyAdmin');
    Route::post('/upload-bukti/{id}', [DispensasiController::class, 'uploadBuktiFoto'])->name('upload.bukti');
    Route::post('/upload-selfie/{id}', [DispensasiController::class, 'uploadFotoSelfie'])->name('upload.selfie');});

Route::prefix('admin/siswa')->group(function () {
    // Rute untuk manipulasi data siswa dan kelas di admin
    Route::get('/', [AdminSiswaController::class, 'indexSiswa'])->name('kelasSiswa');
    Route::post('/store', [AdminSiswaController::class, 'store'])->name('akun-siswa.store');
    Route::get('/get-konsentrasi', [AdminSiswaController::class, 'getKonsentrasi'])->name('get-konsentrasi');
    Route::get('/naik-tingkat', [AdminSiswaController::class, 'increaseTingkatan'])->name('increaseTingkatan');
    Route::delete('/hapus', [AdminSiswaController::class, 'destroyMultiple'])->name('delete-siswa');
    Route::get('/search', [AdminSiswaController::class, 'search'])->name('akun_siswa.search');
    Route::get('/export', [AdminSiswaController::class, 'export'])->name('export-siswa');
    Route::post('/import', [AdminSiswaController::class, 'import'])->name('import-siswa');

    // Rute untuk manipulasi kelas di admin
    Route::get('/kelas', [AdminKelasController::class, 'indexKelas'])->name('kelasKelas');
    Route::post('/kelas/store', [AdminKelasController::class, 'store'])->name('kelas.store');
    Route::post('/kelas/import', [AdminKelasController::class, 'import'])->name('admin.kelas.import');
    Route::get('/kelas/eksport', [AdminKelasController::class, 'export'])->name('admin.kelas.export'); // Export data kelas
    Route::post('/kelas/delete', [AdminKelasController::class, 'destroy'])->name('kelas.destroy');
});

Route::prefix('/siswa')->group(function () {
    Route::get('/dispensasi', [SiswaDispensasiController::class, 'index'])->name('dispensasi.index');
    Route::get('/dispensasi/create', [SiswaDispensasiController::class, 'create'])->name('dispensasi.create');
    Route::post('/dispensasi', [SiswaDispensasiController::class, 'store'])->name('dispensasi.store');
    Route::get('/dispensasi/{dispensasi}/edit', [SiswaDispensasiController::class, 'edit'])->name('dispensasi.edit');
    Route::put('/dispensasi/{dispensasi}', [SiswaDispensasiController::class, 'update'])->name('dispensasi.update');
    // Route::get('/dispensasi/qr-code', [SiswaDispensasiController::class, 'generateQRCode'])->name('dispensasi.qrCode');
    Route::get('/dispensasi/lapor-kembali', [SiswaDispensasiController::class, 'showReturnForm'])->name('dispensasi.reportReturn');
    Route::post('/dispensasi/lapor-kembali', [SiswaDispensasiController::class, 'storeReturn'])->name('dispensasi.storeReturn');
    Route::get('/get-pengajar/{mataPelajaranId}', [SiswaDispensasiController::class, 'getPengajar']);
    Route::post('/konfirmasi/{konfirmasi}', [SiswaDispensasiController::class, 'konfirmasi'])->name('konfirmasi.proses');
    Route::get('/konfirmasi', [SiswaKonfirmController::class, 'tungguKonfir'])->name('konfirm.index');
    // Route::post('/kirim-pesan', [SiswaController::class, 'kirimPesan'])->name('kirim.bot.chat');

});

Route::prefix('/guru')->group(function () {
    Route::get('/history', [DispensasiController::class, 'history_guru'])->name('historyGuru');
    Route::post('/hapus-semua-data', [GuruKonfirmasiController::class, 'hapusSemuaData'])->name('hapusSemuaData');
    Route::get('/jadwal_piket', [GuruKonfirmasiController::class, 'jadwal_piket'])->name('jadwal_piket');
    Route::get('/konfirmasi_piket', [GuruKonfirmasiController::class, 'konfirGuruPiket'])->name('konfirGuruPiket');
    Route::post('/konfirmasi_piket/proses', [GuruKonfirmasiController::class, 'konfirmasiPiket'])->name('konfirmasiPiket');
    Route::post('/konfirmasi_piket_kembali', [GuruKonfirmasiController::class, 'confirmPhoto'])->name('konfirKembali');
    Route::get('/konfirmasi_mata_pelajaran', [GuruKonfirmasiController::class, 'konfirGuruMataPelajaran'])->name('konfirGuruMataPelajaran');
    Route::post('/konfirmasi_mata_pelajaran/proses', [GuruKonfirmasiController::class, 'konfirmasiMataPelajaran'])->name('konfirmasiMataPelajaran');
    Route::get('/konfirmasi_kurikulum', [GuruKonfirmasiController::class, 'konfirGuruKurikulum'])->name('konfirGuruKurikulum');
    Route::post('/konfirmasi_kurikulum/proses', [GuruKonfirmasiController::class, 'konfirmasiKurikulum'])->name('konfirmasiKurikulum');
});

Route::get('/siswa/pdf-viewer', [PdfViewerController::class, 'showPdf'])->name('pdf.viewer');

Route::get('/siswa/dispensasi/pdf', [DispensasiPdfController::class, 'generatePdf'])->name('dispensasi.pdf');
Route::get('/siswa/dispensasi/pdf/download', [DispensasiPdfController::class, 'downloadPdf'])->name('dispensasi.pdfDownload');

Route::get('/dispensasi/camera/{nis}', [SiswaDispensasiController::class, 'showCamera'])->name('dispensasi.camera');
Route::post('/dispensasi/submit-photo/{id}', [SiswaDispensasiController::class, 'submitPhoto'])->name('dispensasi.submitPhoto');
// Route::post('/dispensasi/{id}/submit-photo', [DispensasiController::class, 'submitPhoto'])->name('dispensasi.submitPhoto');
// Route::post('/dispensasi/{id}/confirm-photo', [GuruKonfirmasiController::class, 'confirmPhoto'])->name('dispensasi.confirmPhoto');
Route::post('/dispensasi/{id}/finalize', [SiswaDispensasiController::class, 'finalizeData'])->name('dispensasi.finalize');
Route::post('/kirim-chat', [SiswaKonfirmController::class, 'kirimChat'])->name('kirim.chat');
