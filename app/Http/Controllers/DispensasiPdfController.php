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
        $dispensasi = Dispensasi::where('nis', $nis)->with('konfirmasi')->get();

        // Jika tidak ada data dispensasi, tampilkan pesan atau redirect
        if ($dispensasi->isEmpty()) {
            return redirect()->back()->with('error', 'Tidak ada data dispensasi.');
        }

        // Ambil nama-nama guru berdasarkan NIP untuk setiap konfirmasi
        foreach ($dispensasi as $data) {
            foreach ($data->konfirmasi as $konfirm) {
                $konfirm->nama_petugas = AkunGuru::where('nip', $konfirm->konfirmasi_1)->value('nama') ?? 'Nama tidak ditemukan';
                $konfirm->nama_guru = AkunGuru::where('nip', $konfirm->konfirmasi_2)->value('nama') ?? 'Nama tidak ditemukan';
                $konfirm->nama_wakabid = AkunGuru::where('nip', $konfirm->konfirmasi_3)->value('nama') ?? 'Nama tidak ditemukan';
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
