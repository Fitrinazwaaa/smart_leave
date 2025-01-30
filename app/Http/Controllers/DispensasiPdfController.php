<?php

namespace App\Http\Controllers;

use App\Models\AkunGuru;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Dispensasi;
use Illuminate\Support\Facades\Auth;

class DispensasiPdfController extends Controller
{
    public function generatePdf()
    {
        // Ambil data dispensasi berdasarkan siswa yang login
        $nis = Auth::user()->nis;
        $dispensasi = Dispensasi::where('nis', $nis)->get();
    
        // Jika tidak ada data dispensasi, tampilkan pesan atau redirect
        if ($dispensasi->isEmpty()) {
            return redirect()->back()->with('error', 'Tidak ada data dispensasi.');
        }
    
        // Ambil nama-nama guru berdasarkan NIP
        foreach ($dispensasi as $data) {
            foreach ($data->konfirmasi as $konfirm) {
                // Cari nama guru berdasarkan NIP konfirmasi_1, konfirmasi_2, dan konfirmasi_3
                $namaPetugas = AkunGuru::where('nip', $konfirm->konfirmasi_1)->first()->nama ?? 'Nama tidak ditemukan';
                $namaGuru = AkunGuru::where('nip', $konfirm->konfirmasi_2)->first()->nama ?? 'Nama tidak ditemukan';
                $namaWakabid = AkunGuru::where('nip', $konfirm->konfirmasi_3)->first()->nama ?? 'Nama tidak ditemukan';
    
                // Set nama-nama tersebut untuk digunakan di view
                $konfirm->nama_wakabid = $namaWakabid;
                $konfirm->nama_guru = $namaGuru;
                $konfirm->nama_petugas = $namaPetugas;
            }
        }
    
        // Load view untuk PDF, dan kirim data dispensasi serta nama guru ke view
        $pdf = Pdf::loadView('siswa.pdfDispensasi', compact('dispensasi'));
    
        // Tampilkan langsung di browser
        return $pdf->stream('dispensasi.pdf');
    }
    
    public function downloadPdf()
{
    $nis = Auth::user()->nis;
    $dispensasi = Dispensasi::where('nis', $nis)->get();

    if ($dispensasi->isEmpty()) {
        return redirect()->back()->with('error', 'Tidak ada data dispensasi.');
    }

    // Load view dengan data dispensasi
    $pdf = Pdf::loadView('siswa.pdfDispensasi', compact('dispensasi'));

    // Mengunduh PDF dengan nama file dispensasi_{nis}.pdf
    return $pdf->download('dispensasi_' . $nis . '.pdf');
}

}
