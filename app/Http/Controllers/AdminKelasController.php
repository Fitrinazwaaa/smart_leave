<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


class AdminKelasController extends Controller
{
    public function indexSiswa()
    {
        // Ambil semua data kelas dari database
        $kelas = Kelas::all(); // Pastikan model Kelas sudah ada dan terhubung dengan tabel kelas
    
        // Kirim data kelas ke view
        return view('admin.data_siswa', compact('kelas'));
    }

    public function indexKelas()
    {
        // Ambil semua data kelas dari database
        $kelas = Kelas::all(); // Pastikan model Kelas sudah ada dan terhubung dengan tabel kelas
    
        // Kirim data kelas ke view
        return view('admin.kelas', compact('kelas'));
    }
    
    public function store(Request $request)
    {
        try {
            Log::info('Request data:', $request->all()); // Log data yang diterima
            
            // Validasi input
            $request->validate([
                'program_keahlian' => 'required|string|max:255',
                'konsentrasi_keahlian' => 'required|array|min:1',
                'konsentrasi_keahlian.*' => 'required|string|max:255',
            ]);
    
            // Simpan Program Keahlian dan Konsentrasi Keahlian
            foreach ($request->konsentrasi_keahlian as $konsentrasi) {
                Kelas::create([
                    'program_keahlian' => $request->program_keahlian,
                    'konsentrasi_keahlian' => $konsentrasi,
                ]);
            }
            
            return response()->json([
                'success' => true,
                'message' => 'Kelas berhasil ditambahkan.',
            ]);
        } catch (\Exception $e) {
            Log::error('Error in store method:', ['exception' => $e->getMessage()]);
            return response()->json([
                'success' => false,
            ], 500);
        }
    }
}
