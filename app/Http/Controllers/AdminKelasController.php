<?php

namespace App\Http\Controllers;

use App\Exports\KelasEksport;
use App\Imports\KelasImport;
use App\Models\Kelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

class AdminKelasController extends Controller
{
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

    public function import(Request $request)
    {
        // Validasi file
        $request->validate([
            'excelFile' => 'required|mimes:xlsx,csv',
        ]);
        // Lakukan import data
        Excel::import(new KelasImport, $request->file('excelFile'));
        // Redirect kembali dengan pesan sukses
        return redirect()->back()->with('success', 'Data kelas berhasil diimpor!');
    }

    public function export()
    {
        // Ekspor data guru ke file Excel
        return Excel::download(new KelasEksport, 'data_kelas.xlsx');
    }

    public function destroy(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:kelas,id',
        ]);

        Kelas::whereIn('id', $request->ids)->delete();

        return response()->json(['success' => true]);
    }
    
}
