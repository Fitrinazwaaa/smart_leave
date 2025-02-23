<?php

namespace App\Http\Controllers;

use App\Models\AkunGuru;
use App\Models\AkunSiswa;
use App\Models\Dispensasi;
use App\Models\Konfirmasi;
use App\Models\PiketGuru;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SiswaKonfirmController extends Controller
{
    public function tungguKonfir()
    {
        $nis = auth()->user()->nis;
        $siswa = AkunSiswa::where('nis', $nis)->first();

        // Ambil hari ini dalam format nama hari
        Carbon::setLocale('id'); // Bahasa Indonesia
        $hariIni = Carbon::now()->translatedFormat('l'); // Nama hari dalam bahasa Indonesia

        // Ambil guru piket berdasarkan hari ini
        $guruPiketList = PiketGuru::where('hari_piket', $hariIni)
            ->where('aktif', 1)
            ->get();

        // Ambil dispensasi terbaru siswa
        $latestDispensasi = Dispensasi::where('nis', $nis)
            ->latest('id_dispen') // Urutkan berdasarkan yang terbaru
            ->first();

        $konfir = null;
        $guruPiket = null;
        $guruPengajar = null;
        $guruKurikulumList = collect(); // Default koleksi kosong
        $guruKurikulum = null;

        if ($latestDispensasi) {
            // Ambil konfirmasi terkait dengan dispensasi terbaru
            $konfir = Konfirmasi::where('id_dispen', $latestDispensasi->id_dispen)
            ->whereDate('created_at', Carbon::today()) // Hanya konfirmasi dari hari ini
            ->first();

            // Ambil guru piket berdasarkan konfirmasi_1 jika ada
            if ($konfir && $konfir->konfirmasi_1) {
                $guruPiket = AkunGuru::where('nip', $konfir->konfirmasi_1)
                    ->select('nip', 'nama', 'no_hp')
                    ->first();
            }

            // Ambil guru pengajar berdasarkan konfirmasi_2 atau NIP di dispensasi
            if ($konfir && $konfir->konfirmasi_2) {
                $guruPengajar = AkunGuru::where('nip', $konfir->konfirmasi_2)
                    ->select('nip', 'nama', 'no_hp')
                    ->first();
            } elseif ($latestDispensasi && $latestDispensasi->nip) {
                $guruPengajar = AkunGuru::where('nip', $latestDispensasi->nip)
                    ->select('nip', 'nama', 'no_hp')
                    ->first();
            }

            // Ambil guru kurikulum berdasarkan konfirmasi_3 atau daftar semua guru kurikulum
            if ($konfir && $konfir->konfirmasi_3) {
                $guruKurikulum = AkunGuru::where('nip', $konfir->konfirmasi_3)
                    ->select('nip', 'nama', 'no_hp')
                    ->first();
            } else {
                $guruKurikulumList = AkunGuru::where('jabatan', 'kurikulum')
                    ->select('nip', 'nama', 'no_hp')
                    ->get();
            }
        }

        // Kirim data ke Blade
        return view('siswa.tunggu_konfirmasi', compact(
            'siswa',
            'guruPiket',
            'guruPiketList',
            'guruPengajar',
            'guruKurikulum',
            'guruKurikulumList',
            'konfir',
    'latestDispensasi'
        ));
    }



    public function kirimChat(Request $request)
    {
        $nip = $request->nip;
        $kategori = $request->kategori;
        $namaSiswa = $request->nama_siswa;

        // Cari data guru berdasarkan NIP
        $guru = AkunGuru::where('nip', $nip)->first();

        if (!$guru || !$guru->no_hp) {
            return response()->json(['error' => 'Nomor WhatsApp guru tidak ditemukan.'], 404);
        }

        // Format nomor WhatsApp
        $nomorInternasional = $this->formatNomorWhatsApp($guru->no_hp);

        // Format pesan yang akan dikirim
        $message = "Halo Bapak/Ibu {$guru->nama},\n\n"
            . "Ada permintaan konfirmasi dispensasi siswa dengan rincian:\n"
            . "Nama Siswa: {$namaSiswa}\n"
            . "Kategori: {$kategori}\n\n"
            . "Silakan memproses permintaan ini melalui aplikasi.";

        // Buat URL WhatsApp
        // $whatsappUrl = "https://api.whatsapp.com/send?phone=" . $nomorInternasional . "&text=" . urlencode($message);
        $whatsappUrl = "https://wa.me/" . $nomorInternasional . "?text=" . urlencode($message);

        return response()->json(['whatsapp_url' => $whatsappUrl], 200);
    }

    // Fungsi untuk mengubah nomor ke format internasional
    private function formatNomorWhatsApp($nomor)
    {
        // Jika nomor dimulai dengan "0", ubah menjadi "+62"
        if (substr($nomor, 0, 1) === '0') {
            return '62' . substr($nomor, 1); // Hilangkan "0" dan tambahkan "62"
        }
        return $nomor; // Jika sudah dalam format internasional, biarkan apa adanya
    }
}
