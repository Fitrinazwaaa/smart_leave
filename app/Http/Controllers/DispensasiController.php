<?php

namespace App\Http\Controllers;

use App\Models\Dispensasi;
use App\Models\Konfirmasi;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Milon\Barcode\Facades\DNS2DFacade;

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

    public function history_admin(Request $request)
    {
 // Ambil data dari input filter
 $filter_waktu = $request->input('waktu', 'semua');
 $filter_kelas = $request->input('kelas', null);
 $filter_jk = $request->input('jenis_kelamin', null);
 $filter_nama = $request->input('nama', null);
 $filter_nis = $request->input('nis', null);

 // Ambil daftar kelas unik dari tabel Dispensasi
 $daftar_kelas = Dispensasi::select('tingkatan', 'konsentrasi_keahlian')
     ->distinct()
     ->orderBy('tingkatan')
     ->get()
     ->map(function ($item) {
         return $item->tingkatan . ' ' . $item->konsentrasi_keahlian;
     });

 // Buat query builder untuk kedua kategori
 $query_keluar_sekolah = Dispensasi::with('konfirmasi')->where('kategori', 'keluar lingkungan sekolah');
 $query_mengikuti_kegiatan = Dispensasi::where('kategori', 'mengikuti kegiatan');

 // Waktu filter
 if ($filter_waktu !== 'semua') {
     $now = Carbon::now();
     switch ($filter_waktu) {
         case 'kemarin':
             $query_keluar_sekolah->whereDate('created_at', $now->subDay()->toDateString());
             $query_mengikuti_kegiatan->whereDate('created_at', $now->toDateString());
             break;
         case '1 minggu':
             $query_keluar_sekolah->where('created_at', '>=', $now->subWeek());
             $query_mengikuti_kegiatan->where('created_at', '>=', $now->subWeek());
             break;
         case '1 bulan':
             $query_keluar_sekolah->where('created_at', '>=', $now->subMonth());
             $query_mengikuti_kegiatan->where('created_at', '>=', $now->subMonth());
             break;
         case '1 tahun':
             $query_keluar_sekolah->where('created_at', '>=', $now->subYear());
             $query_mengikuti_kegiatan->where('created_at', '>=', $now->subYear());
             break;
     }
 }

 // Filter kelas
 if ($filter_kelas) {
     $query_keluar_sekolah->whereRaw("CONCAT(tingkatan, ' ', konsentrasi_keahlian) LIKE ?", ["%{$filter_kelas}%"]);
     $query_mengikuti_kegiatan->whereRaw("CONCAT(tingkatan, ' ', konsentrasi_keahlian) LIKE ?", ["%{$filter_kelas}%"]);
 }

 // Filter jenis kelamin
 if ($filter_jk) {
     $query_keluar_sekolah->where('jk', $filter_jk);
     $query_mengikuti_kegiatan->where('jk', $filter_jk);
 }

 // Filter nama
 if ($filter_nama) {
     $query_keluar_sekolah->where('nama', 'LIKE', "%{$filter_nama}%");
     $query_mengikuti_kegiatan->where('nama', 'LIKE', "%{$filter_nama}%");
 }

 // Filter NIS
 if ($filter_nis) {
     $query_keluar_sekolah->where('nis', $filter_nis);
     $query_mengikuti_kegiatan->where('nis', $filter_nis);
 }

 // Eksekusi query setelah semua filter selesai
 $keluar_sekolah = $query_keluar_sekolah->get();
 $mengikuti_kegiatan = $query_mengikuti_kegiatan->get();
        return view('admin.history_dispen', compact('keluar_sekolah', 'mengikuti_kegiatan', 'daftar_kelas'));
    }
    public function history_guru(Request $request)
    {
        // Ambil data dari input filter
        $filter_waktu = $request->input('waktu', 'semua');
        $filter_kelas = $request->input('kelas', null);
        $filter_jk = $request->input('jenis_kelamin', null);
        $filter_nama = $request->input('nama', null);
        $filter_nis = $request->input('nis', null);

        // Ambil daftar kelas unik dari tabel Dispensasi
        $daftar_kelas = Dispensasi::select('tingkatan', 'konsentrasi_keahlian')
            ->distinct()
            ->orderBy('tingkatan')
            ->get()
            ->map(function ($item) {
                return $item->tingkatan . ' ' . $item->konsentrasi_keahlian;
            });

        // Buat query builder untuk kedua kategori
        $query_keluar_sekolah = Dispensasi::with('konfirmasi')->where('kategori', 'keluar lingkungan sekolah');
        $query_mengikuti_kegiatan = Dispensasi::where('kategori', 'mengikuti kegiatan');

        // Waktu filter
        if ($filter_waktu !== 'semua') {
            $now = Carbon::now();
            switch ($filter_waktu) {
                case 'kemarin':
                    $query_keluar_sekolah->whereDate('created_at', $now->subDay()->toDateString());
                    $query_mengikuti_kegiatan->whereDate('created_at', $now->toDateString());
                    break;
                case '1 minggu':
                    $query_keluar_sekolah->where('created_at', '>=', $now->subWeek());
                    $query_mengikuti_kegiatan->where('created_at', '>=', $now->subWeek());
                    break;
                case '1 bulan':
                    $query_keluar_sekolah->where('created_at', '>=', $now->subMonth());
                    $query_mengikuti_kegiatan->where('created_at', '>=', $now->subMonth());
                    break;
                case '1 tahun':
                    $query_keluar_sekolah->where('created_at', '>=', $now->subYear());
                    $query_mengikuti_kegiatan->where('created_at', '>=', $now->subYear());
                    break;
            }
        }

        // Filter kelas
        if ($filter_kelas) {
            $query_keluar_sekolah->whereRaw("CONCAT(tingkatan, ' ', konsentrasi_keahlian) LIKE ?", ["%{$filter_kelas}%"]);
            $query_mengikuti_kegiatan->whereRaw("CONCAT(tingkatan, ' ', konsentrasi_keahlian) LIKE ?", ["%{$filter_kelas}%"]);
        }

        // Filter jenis kelamin
        if ($filter_jk) {
            $query_keluar_sekolah->where('jk', $filter_jk);
            $query_mengikuti_kegiatan->where('jk', $filter_jk);
        }

        // Filter nama
        if ($filter_nama) {
            $query_keluar_sekolah->where('nama', 'LIKE', "%{$filter_nama}%");
            $query_mengikuti_kegiatan->where('nama', 'LIKE', "%{$filter_nama}%");
        }

        // Filter NIS
        if ($filter_nis) {
            $query_keluar_sekolah->where('nis', $filter_nis);
            $query_mengikuti_kegiatan->where('nis', $filter_nis);
        }

        // Eksekusi query setelah semua filter selesai
        $keluar_sekolah = $query_keluar_sekolah->get();
        $mengikuti_kegiatan = $query_mengikuti_kegiatan->get();

        return view('guru.history_dispen', compact('keluar_sekolah', 'mengikuti_kegiatan', 'daftar_kelas'));
    }
}
