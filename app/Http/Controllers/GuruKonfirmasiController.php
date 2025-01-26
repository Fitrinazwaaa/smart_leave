<?php

namespace App\Http\Controllers;

use App\Models\Dispensasi;
use Illuminate\Http\Request;

class GuruKonfirmasiController extends Controller
{
    public function konfirGuruPiket(){
        $dispen = Dispensasi::all();
        return view('guru.konfirmasi_guru_piket', compact('dispen'));
    }
}
