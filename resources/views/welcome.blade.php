<?php

namespace App\Http\Controllers;

use App\Models\AkunGuru;
use App\Models\AkunSiswa;
use App\Models\Dispensasi;
use App\Models\Konfirmasi;
use Illuminate\Http\Request;

class SiswaKonfirmController extends Controller
{
    public function tungguKonfir(){
        $nis = auth()->user()->nis;
        $siswa = AkunSiswa::where('nis', $nis)->first();
        
        // Fetch the latest dispensasi and its corresponding confirmation
        $latestDispensasi = Dispensasi::where('nis', $nis)
                                      ->latest('id_dispen') // Order by the most recent
                                      ->first();
        
        if ($latestDispensasi) {
            // Retrieve confirmation related to the latest dispensasi
            $konfir = Konfirmasi::where('id_dispen', $latestDispensasi->id_dispen)->first();
            
            // Get the teacher's name based on nip for each confirmation
            $guruPiket = null;
            if ($konfir && $konfir->konfirmasi_1) {
                $guruPiket = AkunGuru::where('nip', $konfir->konfirmasi_1)->first();
            }
    
            $guruPengajar = null;
            if ($konfir && $konfir->konfirmasi_2) {
                $guruPengajar = AkunGuru::where('nip', $konfir->konfirmasi_2)->first();
            }
    
            $guruKurikulum = null;
            if ($konfir && $konfir->konfirmasi_3) {
                $guruKurikulum = AkunGuru::where('nip', $konfir->konfirmasi_3)->first();
            }
    
        } else {
            $konfir = null; // No dispensasi found
        }
    
        return view('siswa.tunggu_konfirmasi', compact('konfir', 'siswa', 'guruPiket', 'guruPengajar', 'guruKurikulum'));
    }
    
}