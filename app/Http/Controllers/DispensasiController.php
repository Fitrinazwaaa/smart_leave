<?php
namespace App\Http\Controllers;

use App\Models\Dispensasi;
use App\Models\Konfirmasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DispensasiController extends Controller
{
    public function konfirmasi(Request $request, $id)
    {
        // Validasi ID dispensasi yang diterima
        $request->validate([
            'id' => 'required|integer|exists:dispensasi,id_dispen',
        ]);
        
        // Log input yang diterima
        Log::info("Menerima konfirmasi untuk ID: $id");

        // Cari data dispensasi berdasarkan ID
        $dispensasi = Dispensasi::find($id);

        if (!$dispensasi) {
            Log::error("Data tidak ditemukan untuk ID: $id");
            return response()->json(['success' => false, 'message' => 'Data tidak ditemukan.']);
        }

        try {
            // Ambil atau buat data konfirmasi terkait
            $konfirmasi = $dispensasi->konfirmasi ?: new Konfirmasi(['id_dispen' => $dispensasi->id_dispen]);

            // Update konfirmasi_1
            $konfirmasi->konfirmasi_1 = now(); // atau bisa nilai boolean (true)
            $konfirmasi->save();

            Log::info("Konfirmasi berhasil untuk ID: $id");
            return response()->json(['success' => true, 'message' => 'Konfirmasi berhasil.']);
        } catch (\Exception $e) {
            Log::error("Terjadi kesalahan: " . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Terjadi kesalahan saat menyimpan data.']);
        }
    }
}

