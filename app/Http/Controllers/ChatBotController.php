<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ChatBotController extends Controller
{
    public function kirimNotifikasi(Request $request)
    {
        $noHp = $request->input('no_hp');

        if (!$noHp) {
            return response()->json(['success' => false, 'message' => 'Nomor HP tidak valid.'], 400);
        }

        // Format nomor HP agar sesuai dengan format WhatsApp
        $noHpFormatted = '62' . ltrim($noHp, '0'); // Menghapus 0 di depan nomor HP dan menggantinya dengan kode negara

        // Kirim pesan melalui API WhatsApp (sesuaikan dengan API yang Anda gunakan)
        try {
            $response = Http::post('https://api.whatsapp.com/send', [
                'phone' => $noHpFormatted,
                'message' => 'Butuh konfirmasi dispensasi dari Anda. Silakan cek sistem dispensasi SMK Negeri 1 Kawali.',
            ]);

            if ($response->successful()) {
                return response()->json(['success' => true, 'message' => 'Pesan berhasil dikirim.']);
            } else {
                return response()->json(['success' => false, 'message' => 'Gagal mengirim pesan.'], 500);
            }
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Terjadi kesalahan: ' . $e->getMessage()], 500);
        }
    }
}
