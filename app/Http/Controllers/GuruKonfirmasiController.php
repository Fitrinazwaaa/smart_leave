<?php

namespace App\Http\Controllers;

use App\Models\Dispensasi;
use App\Models\Konfirmasi;
use App\Models\PiketGuru;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class GuruKonfirmasiController extends Controller
{
    public function konfirGuruPiket()
    {
        // Atur locale Carbon ke Bahasa Indonesia
        Carbon::setLocale('id');

        // Ambil data NIP guru yang sedang login
        $nip = auth()->user()->nip;

        // Ambil hari saat ini dalam format Bahasa Indonesia
        $hariIni = Carbon::now()->translatedFormat('l');

        // Cek apakah guru yang login sedang memiliki jadwal piket
        $jadwalPiket = PiketGuru::where('nip', $nip)
            ->where('hari_piket', $hariIni)
            ->where('aktif', 1)  // Pastikan hanya yang aktif yang dipilih
            ->first();  // Ambil data pertama yang ditemukan

        if (!$jadwalPiket) {
            return redirect()->route('dashboard.guru')->withErrors(['error' => 'Anda tidak memiliki jadwal piket hari ini.']);
        }

        // Ambil data dispensasi yang harus dikonfirmasi oleh guru piket
        $dispen = Dispensasi::whereHas('konfirmasi', function ($query) {
            $query->whereNull('konfirmasi_1'); // Hanya tampilkan data yang belum dikonfirmasi
        })->get();

        return view('guru.konfirmasi_guru_piket', compact('dispen'));
    }

    public function konfirmasiPiket(Request $request)
    {
        // Validasi input
        $request->validate([
            'id_dispen' => 'required|exists:dispensasi,id_dispen', // Memastikan id_dispen ada di tabel dispensasi
        ]);

        try {
            // Cari dispensasi yang sesuai
            $dispen = Dispensasi::findOrFail($request->id_dispen); // Menggunakan findOrFail untuk menangani jika tidak ditemukan

            // Cek apakah sudah ada konfirmasi yang diterima
            $konfirmasi = Konfirmasi::where('id_dispen', $request->id_dispen)
                ->whereNull('konfirmasi_1') // Pastikan belum ada konfirmasi 1
                ->first();

            if (!$konfirmasi) {
                return response()->json(['success' => false, 'message' => 'Konfirmasi tidak valid.']);
            }

            // Ambil nama pengguna yang sedang login
            $user = auth()->user();

            // Update konfirmasi_1 dengan nip pengguna yang mengonfirmasi
            $konfirmasi->konfirmasi_1 = $user->nip;  // Menyimpan NIP pengguna yang melakukan konfirmasi
            $konfirmasi->tahap_sekarang = 'guru_matapelajaran'; // Ubah tahap ke 'guru_matapelajaran'
            $konfirmasi->save();

            // Kembalikan ke halaman konfirmasi piket
            return redirect()->route('konfirGuruPiket')->with('success', 'Konfirmasi berhasil.');
        } catch (\Exception $e) {
            // Menangani error yang tidak terduga
            return response()->json(['success' => false, 'message' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }

    public function konfirmasiMataPelajaran(Request $request)
    {
        // Validasi input
        $request->validate([
            'id_dispen' => 'required|exists:dispensasi,id_dispen', // Memastikan id_dispen ada di tabel dispensasi
        ]);

        try {
            // Cari dispensasi yang sesuai
            $dispen = Dispensasi::findOrFail($request->id_dispen);

            // Cek apakah konfirmasi_1 sudah ada dan konfirmasi_2 masih null
            $konfirmasi = Konfirmasi::where('id_dispen', $request->id_dispen)
                ->whereNotNull('konfirmasi_1')
                ->whereNull('konfirmasi_2') // Pastikan konfirmasi_2 belum diisi
                ->first();

            if (!$konfirmasi) {
                return response()->json(['success' => false, 'message' => 'Konfirmasi tidak valid.']);
            }

            // Ambil NIP pengguna yang sedang login
            $user = auth()->user();

            // Pastikan hanya guru dengan NIP di tabel Dispensasi yang dapat mengonfirmasi
            if ($dispen->nip != $user->nip) {
                return response()->json(['success' => false, 'message' => 'Hanya guru yang memiliki NIP yang sesuai dengan data dispensasi yang dapat mengonfirmasi.']);
            }

            // Update konfirmasi_2 dengan nip pengguna yang mengonfirmasi
            $konfirmasi->konfirmasi_2 = $user->nip;
            $konfirmasi->save();

            // Kembalikan ke halaman konfirmasi mata pelajaran
            return redirect()->route('konfirGuruMataPelajaran')->with('success', 'Konfirmasi Mata Pelajaran berhasil.');
        } catch (\Exception $e) {
            // Menangani error yang tidak terduga
            return response()->json(['success' => false, 'message' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }

    public function konfirGuruMataPelajaran()
    {
        // Ambil data NIP guru yang sedang login
        $nip = auth()->user()->nip;

        // Ambil data dispensasi yang harus dikonfirmasi oleh guru mata pelajaran yang sesuai dengan NIP guru yang login
        $dispen = Dispensasi::whereHas('konfirmasi', function ($query) {
            $query->whereNotNull('konfirmasi_1')->whereNull('konfirmasi_2');
        })->where('nip', $nip) // Tambahkan filter NIP sesuai dengan guru yang login
            ->get();

        // Jika tidak ada data dispensasi yang ditemukan untuk guru ini, Anda bisa menambahkan pesan error
        if ($dispen->isEmpty()) {
            return redirect()->route('dashboard.guru')->withErrors(['error' => 'Tidak ada data dispensasi yang perlu dikonfirmasi.']);
        }

        // Return ke halaman konfirmasi guru pengajar dengan data yang sesuai
        return view('guru.konfirmasi_guru_pengajar', compact('dispen'));
    }


    public function konfirGuruKurikulum()
    {
        // Ambil NIP pengguna yang sedang login
        $nip = auth()->user()->nip;

        // Ambil data pengguna dari tabel akun_guru berdasarkan NIP
        $akunGuru = DB::table('akun_guru')->where('nip', $nip)->first();

        // Pastikan pengguna memiliki jabatan 'kurikulum'
        if (!$akunGuru || $akunGuru->jabatan !== 'kurikulum') {
            return redirect()->route('dashboard.guru')->withErrors(['error' => 'Hanya pengguna dengan jabatan Kurikulum yang dapat mengakses halaman ini.']);
        }

        // Ambil data dispensasi yang harus dikonfirmasi oleh kurikulum
        $dispen = Dispensasi::whereHas('konfirmasi', function ($query) {
            $query->whereNotNull('konfirmasi_1')
                ->whereNotNull('konfirmasi_2')
                ->whereNull('konfirmasi_3'); // Hanya yang belum dikonfirmasi_3
        })->get();

        return view('guru.konfirmasi_kurikulum', compact('dispen'));
    }

    public function konfirmasiKurikulum(Request $request)
    {
        // Validasi input
        $request->validate([
            'id_dispen' => 'required|exists:dispensasi,id_dispen', // Memastikan id_dispen ada di tabel dispensasi
        ]);

        try {
            // Ambil NIP pengguna yang sedang login
            $nip = auth()->user()->nip;

            // Ambil data pengguna dari tabel akun_guru berdasarkan NIP
            $akunGuru = DB::table('akun_guru')->where('nip', $nip)->first();

            // Pastikan pengguna memiliki jabatan 'kurikulum'
            if (!$akunGuru || $akunGuru->jabatan !== 'kurikulum') {
                return redirect()->route('konfirGuruKurikulum')->withErrors(['error' => 'Hanya pengguna dengan jabatan Kurikulum yang dapat mengonfirmasi.']);
            }

            // Cari dispensasi yang sesuai
            $dispen = Dispensasi::findOrFail($request->id_dispen);

            // Cek apakah konfirmasi_1 dan konfirmasi_2 sudah terisi, dan konfirmasi_3 belum diisi
            $konfirmasi = Konfirmasi::where('id_dispen', $request->id_dispen)
                ->whereNotNull('konfirmasi_1')
                ->whereNotNull('konfirmasi_2')
                ->whereNull('konfirmasi_3') // Pastikan konfirmasi_3 belum diisi
                ->first();

            if (!$konfirmasi) {
                return redirect()->route('konfirGuruKurikulum')->withErrors(['error' => 'Konfirmasi tidak valid.']);
            }

            // Update konfirmasi_3 dengan NIP pengguna yang sedang login
            $konfirmasi->konfirmasi_3 = $nip;
            $konfirmasi->save();

            return redirect()->route('konfirGuruKurikulum')->with('success', 'Konfirmasi berhasil.');
        } catch (\Exception $e) {
            return redirect()->route('konfirGuruKurikulum')->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }
}
