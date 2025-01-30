<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PdfViewerController extends Controller
{
    public function showPdf(Request $request)
    {
        // Ambil parameter file dari query string
        $filePath = $request->query('file');

        // Validasi: Pastikan file ada dan berada dalam folder yang diizinkan
        if (!$filePath || !Storage::disk('public')->exists($filePath)) {
            abort(404, 'File tidak ditemukan.');
        }

        // Path lengkap file di storage
        $fullPath = Storage::disk('public')->url($filePath);

        return view('siswa.pdf_viewer', compact('fullPath'));
    }
}
