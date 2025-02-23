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
            ->where('aktif', 1)
            ->first();
    
        if (!$jadwalPiket) {
            return redirect()->route('dashboard.guru')->withErrors([
                'error' => 'Anda tidak memiliki jadwal piket hari ini.',
            ]);
        }
    
        // Ambil data dispensasi berdasarkan kategori dan status konfirmasi, hanya untuk data hari ini
        $dispenKeluar = Dispensasi::where('kategori', 'Keluar Lingkungan Sekolah')
            ->whereDate('created_at', Carbon::today())
            ->whereHas('konfirmasi', fn($query) => $query->whereNull('konfirmasi_1'))
            ->get();
    
        $dispenKegiatan = Dispensasi::where('kategori', 'Mengikuti Kegiatan')
            ->whereDate('created_at', Carbon::today())
            ->whereHas('konfirmasi', fn($query) => $query->whereNull('konfirmasi_1'))
            ->get();
    
        $dispen = Dispensasi::whereDate('created_at', Carbon::today())
            ->whereHas('konfirmasi', fn($query) => $query->whereNull('konfirmasi_1'))
            ->get();
    
        // Ambil data dari tabel dispensasi berdasarkan kriteria untuk konfirmasi foto
        $dispenSiswaKembali = Dispensasi::where('kategori', 'Keluar Lingkungan Sekolah')
            ->whereDate('created_at', Carbon::today())
            ->whereNotNull('bukti_foto') // Hanya data yang memiliki bukti foto
            ->whereHas('konfirmasi', function ($query) {
                $query->whereNotNull('konfirmasi_1') // Konfirmasi_1 bukan null
                      ->whereNull('konfirmasi_2'); // Hanya lanjutkan jika konfirmasi_2 belum diisi
            })
            ->get();
    
        return view('guru.konfirmasi_guru_piket', compact('dispen', 'dispenKeluar', 'dispenKegiatan', 'dispenSiswaKembali'));
    }
    

    public function konfirmasiPiket(Request $request)
    {
        // Validasi input
        $request->validate([
            'id_dispen' => 'required|exists:dispensasi,id_dispen',
        ]);

        try {
            // Ambil dispensasi berdasarkan ID
            $dispensasi = Dispensasi::findOrFail($request->id_dispen);

            // Ambil konfirmasi terkait
            $konfirmasi = Konfirmasi::where('id_dispen', $dispensasi->id_dispen)
                ->whereNull('konfirmasi_1')
                ->first();

            if (!$konfirmasi) {
                return redirect()->route('konfirGuruPiket')->withErrors([
                    'error' => 'Konfirmasi tidak valid atau sudah diproses.',
                ]);
            }

            // Update konfirmasi_1 dengan NIP guru yang login
            $konfirmasi->konfirmasi_1 = auth()->user()->nip;

            if ($dispensasi->kategori === 'Keluar Lingkungan Sekolah') {
                // Logika khusus untuk kategori "Keluar Lingkungan Sekolah"
                $dispensasi->status = 'disetujui';
            }

            // Simpan data konfirmasi dan dispensasi
            $konfirmasi->save();
            $dispensasi->save();

            return redirect()->route('konfirGuruPiket')->with('success', 'Konfirmasi berhasil diproses.');
        } catch (\Exception $e) {
            return redirect()->route('konfirGuruPiket')->withErrors([
                'error' => 'Terjadi kesalahan: ' . $e->getMessage(),
            ]);
        }
    }

    public function confirmPhoto(Request $request)
    {
        try {
            // Validasi input
            $request->validate([
                'id_dispen' => 'required|exists:dispensasi,id_dispen',
            ]);

            // Ambil data dispensasi berdasarkan ID
            $dispensasi = Dispensasi::findOrFail($request->id_dispen);

            // Ambil data konfirmasi terkait
            $konfirmasi = Konfirmasi::where('id_dispen', $dispensasi->id_dispen)
                ->whereNotNull('konfirmasi_1') // Pastikan sudah ada konfirmasi pertama
                ->whereNull('konfirmasi_2') // Hanya lanjutkan jika konfirmasi_2 belum diisi
                ->first();

            // Jika konfirmasi tidak ditemukan, tampilkan pesan error
            if (!$konfirmasi) {
                return redirect()->route('dashboard.guru')->withErrors([
                    'error' => 'Konfirmasi tidak ditemukan atau sudah selesai.',
                ]);
            }

            // Mulai transaksi
            DB::beginTransaction();

            // Update data konfirmasi (akhiri di konfirmasi_2)
            $konfirmasi->konfirmasi_2 = auth()->user()->nip; // NIP dari user yang login
            $konfirmasi->save();

            // Update data dispensasi (misalnya waktu kembali)
            $dispensasi->update([
                'waktu_kembali' => now(),
            ]);

            // Commit transaksi
            DB::commit();

            // Redirect dengan pesan sukses
            return redirect()->route('dashboard.guru')->with('success', 'Laporan berhasil dikonfirmasi.');
        } catch (\Exception $e) {
            // Rollback transaksi jika terjadi kesalahan
            DB::rollBack();

            // Redirect dengan pesan error
            return redirect()->route('dashboard.guru')->withErrors([
                'error' => 'Terjadi kesalahan saat memproses konfirmasi: ' . $e->getMessage(),
            ]);
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

            // Cek apakah konfirmasi_1 sudah ada, konfirmasi_2 masih null, dan kategori 'mengikuti kegiatan'
            $konfirmasi = Konfirmasi::where('id_dispen', $request->id_dispen)
                ->whereNotNull('konfirmasi_1') // konfirmasi_1 sudah diisi
                ->whereNull('konfirmasi_2') // konfirmasi_2 masih kosong
                ->whereHas('dispensasi', function ($query) {
                    $query->where('kategori', 'mengikuti kegiatan'); // Pastikan kategori adalah 'mengikuti kegiatan'
                })
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
            $query->whereNotNull('konfirmasi_1') // konfirmasi_1 sudah diisi
                ->whereNull('konfirmasi_2');  // konfirmasi_2 masih kosong
        })
            ->where('nip', $nip) // Filter berdasarkan NIP guru yang login
            ->where('kategori', 'mengikuti kegiatan') // Tambahkan filter kategori
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
        $dispen = Dispensasi::where('kategori', 'Mengikuti Kegiatan') // Tambahkan filter kategori
            ->whereHas('konfirmasi', function ($query) {
                $query->whereNotNull('konfirmasi_1') // Sudah dikonfirmasi oleh tahap 1
                    ->whereNotNull('konfirmasi_2') // Sudah dikonfirmasi oleh tahap 2
                    ->whereNull('konfirmasi_3');  // Belum dikonfirmasi oleh tahap 3
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
                ->where('kategori', 'Mengikuti Kegiatan') // Tambahkan filter kategori
                ->whereNotNull('konfirmasi_1') // Sudah dikonfirmasi tahap 1
                ->whereNotNull('konfirmasi_2') // Sudah dikonfirmasi tahap 2
                ->whereNull('konfirmasi_3')    // Belum dikonfirmasi tahap 3
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
    public function jadwal_piket()
    {
        return view('guru.jadwal_piket');
    }
    public function hapusSemuaData()
    {
        // Menghapus semua data dari tabel 'konfirmasi' terlebih dahulu
        Konfirmasi::query()->delete();
    
        // Menghapus semua data dari tabel 'dispensasi' setelahnya
        Dispensasi::query()->delete();
    
        // Redirect dengan pesan sukses
        return redirect()->route('historyAdmin')->with('success', 'Semua data dispensasi dan konfirmasi berhasil dihapus.');
    }
    

}
