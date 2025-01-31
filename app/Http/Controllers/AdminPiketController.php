<?php

namespace App\Http\Controllers;

use App\Models\AkunGuru;
use Illuminate\Http\Request;
use App\Models\Piket;
use App\Models\Guru;
use App\Models\PiketGuru;

class AdminPiketController extends Controller
{
    // Menampilkan halaman piket
    public function index()
    {
        $piket = PiketGuru::all();
        return view('admin.piket', compact('piket'));
    }

    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'nip' => 'required',
            'hari_piket' => 'required|array',
            'nama' => 'required',
            'pekan' => 'required|array',
        ]);
    
        // Simpan data ke database
        $piket = new PiketGuru;
        $piket->nip = $validated['nip'];
        $piket->nama = $validated['nama'];
        $piket->hari_piket = implode(',', $validated['hari_piket']); // Simpan sebagai string, jika diperlukan
        $piket->pekan = implode(',', $validated['pekan']); // Simpan sebagai string, jika diperlukan
        $piket->save();
    
        // Redirect atau beri response
        return redirect()->route('admin.piket')->with('success', 'Piket berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $piket = PiketGuru::find($id);
        if (!$piket) {
            return response()->json(['success' => false, 'message' => 'Data tidak ditemukan!'], 404);
        }
    
        $validated = $request->validate([
            'nip' => 'required|string',
            'nama' => 'required|string',
            'hari_piket' => 'required|array|min:1',
            'pekan' => 'required|array|min:1',
        ]);
    
        try {
            $piket->update([
                'nip' => $validated['nip'],
                'nama' => $validated['nama'],
                'hari_piket' => implode(',', $validated['hari_piket']),
                'pekan' => implode(',', $validated['pekan']),
            ]);
    
            return response()->json(['success' => true, 'message' => 'Data piket berhasil diperbarui!']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Terjadi kesalahan: ' . $e->getMessage()], 500);
        }
    }
    

    // Menghapus data piket yang dipilih
    public function delete(Request $request)
    {
        PiketGuru::whereIn('id', $request->ids)->delete();
        return response()->json(['success' => true]);
    }

    // Mendapatkan daftar guru untuk dropdown
    public function getGuruList()
    {
        return AkunGuru::select('nip', 'nama')->get();
    }

    // Mendapatkan nama berdasarkan NIP
    public function getNamaByNip(Request $request)
    {
        $guru = AkunGuru::where('nip', $request->nip)->first();
        return response()->json(['nama' => $guru->nama ?? 'NIP tidak ditemukan']);
    }

    public function updatePekanStatus(Request $request)
    {
        // Validasi input
        $request->validate([
            'pekan' => 'required|in:ganjil,genap',
        ]);
    
        // Menentukan nilai aktif berdasarkan pekan yang dipilih
        $pekanDipilih = $request->pekan;
    
        // Perbarui semua data PiketGuru berdasarkan pekan yang dipilih
        if ($pekanDipilih == 'ganjil') {
            // Set aktif untuk pekan ganjil
            PiketGuru::where('pekan', 'ganjil')
                ->update(['aktif' => 1]); // Aktifkan pekan ganjil
    
            // Set nonaktif untuk pekan genap
            PiketGuru::where('pekan', 'genap')
                ->update(['aktif' => 0]); // Nonaktifkan pekan genap
        } else {
            // Set aktif untuk pekan genap
            PiketGuru::where('pekan', 'genap')
                ->update(['aktif' => 1]); // Aktifkan pekan genap
    
            // Set nonaktif untuk pekan ganjil
            PiketGuru::where('pekan', 'ganjil')
                ->update(['aktif' => 0]); // Nonaktifkan pekan ganjil
        }
    
        // Kembalikan respons
        return response()->json([
            'success' => true,
            'message' => 'Status pekan berhasil diperbarui!'
        ]);
    }
    
}
