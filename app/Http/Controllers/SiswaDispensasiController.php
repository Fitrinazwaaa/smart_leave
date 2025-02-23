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
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

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


    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'nis' => 'required|string',
            'nama' => 'required|string',
            'tingkatan' => 'required|string',
            'konsentrasi_keahlian' => 'required|string',
            'program_keahlian' => 'required|string',
            'jk' => 'required|string',
            'mata_pelajaran' => 'nullable|string',
            'nama_pengajar' => 'nullable|string',
            'nip' => 'nullable|string',
            'kategori' => 'required|string',
            'waktu_keluar' => 'required|date',
            'alasan' => 'required|string',
            'bukti_foto' => 'nullable|mimes:jpeg,png,jpg,gif,bmp,svg,webp|max:5120',
        ]);

        // Handle upload bukti foto jika ada
        if ($request->hasFile('bukti_foto')) {
            $fileName = time() . '_' . uniqid() . '.' . $request->bukti_foto->extension();
            $filePath = $request->bukti_foto->storeAs('uploads/dispensasi', $fileName, 'public');
            $validated['bukti_foto'] = $filePath; // Simpan path relatif ke database
        }

        // Simpan data dispensasi
        $dispensasi = Dispensasi::create($validated);

        // Otomatis membuat data konfirmasi dengan kategori
        Konfirmasi::create([
            'id_dispen' => $dispensasi->id_dispen,
            'kategori' => $validated['kategori'],  // Tambahkan kategori ke tabel konfirmasi
            'konfirmasi_1' => null,
            'konfirmasi_2' => null,
            'konfirmasi_3' => null,
        ]);

        // Kirim notifikasi berdasarkan kategori
        if ($validated['kategori'] === 'keluar lingkungan sekolah') {
            // Notifikasi hanya untuk guru piket hari ini
            $hariIni = now()->format('l');  // Mendapatkan hari ini
            $guruPiket = PiketGuru::where('hari_piket', $hariIni)
                ->where('aktif', 1)  // Hanya yang aktif
                ->first();

            if ($guruPiket) {
                Notification::send($guruPiket, new KonfirmasiNotifikasi($dispensasi));
            }
        } elseif ($validated['kategori'] === 'mengikuti kegiatan') {
            // Notifikasi tetap mengikuti logika sebelumnya
            $hariIni = now()->format('l');
            $nip = auth()->user()->nip;  // NIP dari pengguna yang login
            $guruPiket = PiketGuru::where('nip', $nip)
                ->where('hari_piket', $hariIni)
                ->where('aktif', 1)
                ->first();

            if ($guruPiket) {
                Notification::send($guruPiket, new KonfirmasiNotifikasi($dispensasi));
            }
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

    // Menampilkan halaman kamera
    public function showCamera($nis)
    {
        // Cari dispensasi berdasarkan NIS dan pastikan waktu_kembali belum diisi
        $dispensasi = Dispensasi::where('nis', $nis)->whereNull('waktu_kembali')->first();

        // Jika tidak ada data yang valid, redirect ke dashboard siswa dengan pesan error
        if (!$dispensasi) {
            return redirect()->route('dashboard.siswa')->withErrors([
                'error' => 'Anda sudah mencatat waktu kembali. Tidak dapat mengakses fitur ini lagi.'
            ]);
        }

        // Kirim data dispensasi ke view untuk diproses lebih lanjut
        return view('siswa.camera', compact('dispensasi'));
    }
    public function submitPhoto(Request $request, $id)
    {
        // Validasi file foto
        $request->validate([
            'photo' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Cari data dispensasi berdasarkan ID
        $dispensasi = Dispensasi::findOrFail($id);

        // Periksa apakah waktu_kembali sudah diisi
        if ($dispensasi->waktu_kembali !== null) {
            return redirect()->route('dashboard.siswa')->withErrors([
                'error' => 'Waktu kembali sudah dicatat sebelumnya. Tidak dapat memperbarui data lagi.',
            ]);
        }

        // Simpan foto ke folder sementara di public/storage/dispensasi/temp
        $path = $request->file('photo')->store('dispensasi/temp', 'public');

        // Update data dispensasi untuk mengirim laporan (tandai foto sementara)
        $dispensasi->update([
            'bukti_foto' => $path, // Foto disimpan sementara
            'laporan_dikirim' => now(), // Timestamp laporan dikirim
        ]);

        // Kirim notifikasi ke guru piket (simulasi dengan flash message atau queue)
        // Logika ini bisa diganti dengan sistem notifikasi yang lebih kompleks.
        return redirect()->route('dashboard.siswa')
            ->with('success', 'Laporan telah dikirim ke guru piket. Tunggu konfirmasi.');
    }
    public function finalizeData($id)
    {
        // Cari data dispensasi berdasarkan ID
        $dispensasi = Dispensasi::findOrFail($id);

        // Periksa apakah sudah dikonfirmasi oleh guru piket
        if ($dispensasi->konfirmasi_1 === null) {
            return redirect()->route('dashboard.siswa')->withErrors([
                'error' => 'Data belum dikonfirmasi oleh guru piket. Tidak dapat menyimpan.',
            ]);
        }

        // Pindahkan foto dari folder sementara ke folder final
        $finalPath = str_replace('dispensasi/temp', 'dispensasi', $dispensasi->bukti_foto);
        Storage::move($dispensasi->bukti_foto, $finalPath);

        // Update kolom waktu_kembali dan foto ke lokasi final
        $dispensasi->update([
            'waktu_kembali' => now(),
            'bukti_foto' => $finalPath,
        ]);

        return redirect()->route('dashboard.siswa')
            ->with('success', 'Data telah disimpan setelah konfirmasi guru piket.');
    }
}
