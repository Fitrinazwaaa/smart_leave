<?php

namespace App\Http\Controllers;

use App\Models\AkunGuru;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Dispensasi;
use Illuminate\Support\Facades\Auth;

class DispensasiPdfController extends Controller
{
    
    public function downloadPdf()
    {
        $nis = Auth::user()->nis;
    
        // Ambil dispensasi terbaru berdasarkan id_dispen
        $latestDispensasi = Dispensasi::where('nis', $nis)
            ->latest('id_dispen') // Urutkan berdasarkan id_dispen terbaru
            ->first();
    
        if (!$latestDispensasi) {
            return redirect()->back()->with('error', 'Tidak ada data dispensasi.');
        }
    
        // Load view dengan data dispensasi terbaru
        $pdf = Pdf::loadView('siswa.pdfDispensasi', ['dispensasi' => $latestDispensasi]);
    
        // Mengunduh PDF dengan nama file dispensasi_{nis}.pdf
        return $pdf->download('dispensasi_' . $nis . '.pdf');
    }
    
    
}
