<?php

namespace App\Http\Controllers;

use App\Models\AkunSiswa;
use Illuminate\Http\Request;

class SiswaController extends Controller
{
    public function dashboard($nis)
    {
        // Ambil data siswa berdasarkan NIS
        $siswa = AkunSiswa::where('nis', $nis)->first();
    
        if (!$siswa) {
            return redirect('/')->withErrors(['error' => 'Siswa tidak ditemukan.']);
        }
    
        // Kirim data siswa ke tampilan
        return view('siswa.dashboard', compact('siswa'));
    }
    
}
