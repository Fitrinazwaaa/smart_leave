<?php

namespace App\Http\Controllers;

use App\Models\MataPelajaranGuru;
use App\Models\PiketGuru;
use App\Models\User;
use Illuminate\Http\Request;

class SiswaKonfirmController extends Controller
{
    public function tungguKonfir(){
        // Menampilkan hanya 1 data guru piket
        $guruPiket = PiketGuru::take(1)->get();
        // Menampilkan hanya 1 data guru pengajar
        $guruPengajar = MataPelajaranGuru::take(1)->get();
        // Menampilkan hanya 1 data kurikulum
        $kurikulum = User::take(1)->get();
    
        return view('siswa.tunggu_konfirmasi', compact('guruPiket', 'guruPengajar', 'kurikulum'));
    }
    
}
