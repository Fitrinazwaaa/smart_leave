<?php

namespace App\Http\Controllers;

use App\Models\AkunSiswa;
use App\Models\Dispensasi;
use App\Models\Konfirmasi;
use App\Models\AkunGuru;
use App\Models\PiketGuru;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use App\Notifications\KonfirmasiNotifikasi;

class SiswaDispensasiController extends Controller
{
    // Menampilkan formulir pengajuan dispensasi
    public function create()
    {
        $nis = auth()->user()->nis; // Ambil NIS siswa yang login
        $siswa = AkunSiswa::where('nis', $nis)->first();

        if (!$siswa) {
            return redirect()->route('dashboard.siswa')->withErrors(['error' => 'Siswa tidak ditemukan.']);
        }

        return view('dispensasi.create', compact('siswa'));
    }

    // Menyimpan pengajuan dispensasi baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nis' => 'required|string',
            'nama' => 'required|string',
            'tingkatan' => 'required|string',
            'konsentrasi_keahlian' => 'required|string',
            'program_keahlian' => 'required|string',
            'jk' => 'required|string',
            'mata_pelajaran' => 'nullable|string',
            'nama_pengajar' => 'nullable|string',
            'nip' => 'nullable|string',  // Validasi untuk nip
            'kategori' => 'required|string',
            'waktu_keluar' => 'required|date',
            'alasan' => 'required|string',
            'bukti_foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('bukti_foto')) {
            $fileName = time() . '.' . $request->bukti_foto->extension();
            $request->bukti_foto->move(public_path('uploads'), $fileName);
            $validated['bukti_foto'] = $fileName;
        }

        $dispensasi = Dispensasi::create($validated);

        // Otomatis membuat data konfirmasi
        Konfirmasi::create([
            'id_dispen' => $dispensasi->id_dispen,
            'konfirmasi_1' => null,
            'konfirmasi_2' => null,
            'konfirmasi_3' => null,
        ]);

        // Kirim notifikasi ke guru piket
        $hariIni = now()->format('l');  // Mendapatkan hari ini (misalnya 'Monday', 'Tuesday', dll)
        $nip = auth()->user()->nip;  // Mendapatkan NIP dari pengguna yang sedang login

        // Mencari guru piket yang bertugas hari ini dengan status aktif = 1
        $guruPiket = PiketGuru::where('nip', $nip)
            ->where('hari_piket', $hariIni)
            ->where('aktif', 1)  // Pastikan hanya yang aktif yang dipilih
            ->first();  // Ambil data pertama yang ditemukan

        if ($guruPiket) {
            // Kirim notifikasi jika guru piket ditemukan
            Notification::send($guruPiket, new KonfirmasiNotifikasi($dispensasi));
        }


        return redirect()->route('dashboard.siswa')->with('success', 'Pengajuan dispensasi berhasil dibuat.');
    }

    // Menampilkan daftar dispensasi
    public function index()
    {
        // Mendapatkan NIS dari user yang sedang login
        $nis = auth()->user()->nis;

        // Mengambil data siswa berdasarkan NIS
        $siswa = AkunSiswa::where('nis', $nis)->first();

        $mataPelajaran = DB::table('matapelajaran_guru')->select('mata_pelajaran')->distinct()->get();

        // Mengambil data dispensasi untuk siswa tersebut
        $dispensasi = Dispensasi::where('nis', $nis)->get();
        if ($siswa) {
            // Menampilkan formulir dispensasi
            return view('siswa.formulir', compact('dispensasi', 'siswa', 'mataPelajaran'));
        }
    }

    public function getPengajar($mataPelajaran)
    {
        // Mengambil data nama pengajar berdasarkan mata pelajaran yang dipilih
        $pengajar = DB::table('matapelajaran_guru')
            ->where('mata_pelajaran', $mataPelajaran)
            ->select('nama', 'nip')
            ->get();

        return response()->json($pengajar);
    }

    // Proses konfirmasi bertahap (guru piket, pengajar, kurikulum)
    public function konfirmasi(Request $request, $id)
    {
        $konfirmasi = Konfirmasi::where('id_dispen', $id)->first();

        if (!$konfirmasi) {
            return redirect()->back()->withErrors(['error' => 'Data konfirmasi tidak ditemukan.']);
        }

        if (!$konfirmasi->konfirmasi_1) {
            $konfirmasi->update(['konfirmasi_1' => true]);
            return redirect()->back()->with('success', 'Konfirmasi oleh guru piket berhasil.');
        } elseif (!$konfirmasi->konfirmasi_2) {
            $konfirmasi->update(['konfirmasi_2' => true]);
            return redirect()->back()->with('success', 'Konfirmasi oleh guru pengajar berhasil.');
        } elseif (!$konfirmasi->konfirmasi_3) {
            $konfirmasi->update(['konfirmasi_3' => true]);
            return redirect()->back()->with('success', 'Konfirmasi oleh kurikulum berhasil.');
        }

        return redirect()->back()->withErrors(['error' => 'Semua tahap konfirmasi telah selesai.']);
    }

    // Menampilkan formulir pelaporan kembali
    public function showReturnForm($id)
    {
        $dispensasi = Dispensasi::findOrFail($id);

        if (!$dispensasi) {
            return redirect()->back()->withErrors(['error' => 'Data dispensasi tidak ditemukan.']);
        }

        return view('dispensasi.returnForm', compact('dispensasi'));
    }

    // Menyimpan waktu kembali
    public function storeReturn(Request $request, $id)
    {
        $validated = $request->validate([
            'waktu_kembali' => 'required|date',
        ]);

        $dispensasi = Dispensasi::findOrFail($id);
        $dispensasi->update(['waktu_kembali' => $validated['waktu_kembali']]);

        return redirect()->route('dashboard.siswa')->with('success', 'Waktu kembali berhasil dilaporkan.');
    }
}
