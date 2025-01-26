<?php

namespace App\Http\Controllers;

use App\Models\AkunSiswa;
use App\Models\Dispensasi;
use BaconQrCode\Encoder\QrCode;
use Illuminate\Http\Request;

class SiswaDispensasiController extends Controller
{
    // Menampilkan formulir pengajuan dispensasi
    public function create()
    {
        return view('dispensasi.create');
    }

    // Menyimpan pengajuan dispensasi
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nis' => 'required|string',
            'nama' => 'required|string',
            'tingkatan' => 'required|string',
            'konsentrasi_keahlian' => 'required|string',
            'program_keahlian' => 'required|string',
            'kategori' => 'required|string',
            'waktu_keluar' => 'required|date',
            'alasan' => 'required|string',
            'bukti_foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Menangani upload foto bukti jika ada
        if ($request->hasFile('bukti_foto')) {
            $fileName = time() . '.' . $request->bukti_foto->extension();
            $request->bukti_foto->move(public_path('uploads'), $fileName);
            $validated['bukti_foto'] = $fileName;
        }

        // Menyimpan pengajuan dispensasi
        Dispensasi::create($validated);

        return redirect()->route('dispensasi.index')->with('success', 'Pengajuan dispensasi berhasil dibuat.');
    }

    // Menampilkan daftar dispensasi
    public function index()
    {
        // Mendapatkan NIS dari user yang sedang login
        $nis = auth()->user()->nis;

        // Mengambil data siswa berdasarkan NIS
        $siswa = AkunSiswa::where('nis', $nis)->first();

        $dispensasi = Dispensasi::all();
        if ($siswa) {
            // return view('dispensasi.create', compact('siswa'));
            return view('siswa.formulir', compact('dispensasi', 'siswa'));
        }
    }

    // Menampilkan form untuk memperbarui status dispensasi
    public function edit(Dispensasi $dispensasi)
    {
        return view('dispensasi.edit', compact('dispensasi'));
    }

    // Memperbarui status dispensasi
    public function update(Request $request, Dispensasi $dispensasi)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,disetujui,ditolak',
        ]);

        $dispensasi->update($validated);

        return redirect()->route('dispensasi.index')->with('success', 'Status dispensasi berhasil diperbarui.');
    }

    public function generateQRCode($nis)
    {
        // Mencari data siswa berdasarkan nis
        $siswa = AkunSiswa::where('nis', $nis)->first();

        if (!$siswa) {
            // Jika siswa tidak ditemukan, arahkan ke halaman dashboard dengan pesan error
            return redirect()->route('dashboard.siswa', ['nis' => $nis])->withErrors(['error' => 'Siswa tidak ditemukan.']);
        }

        // Mencari dispensasi berdasarkan nis siswa
        $dispensasi = Dispensasi::where('nis', $nis)->first();

        if (!$dispensasi) {
            // Jika dispensasi tidak ditemukan, arahkan ke halaman dashboard dengan pesan error
            return redirect()->route('dashboard.siswa', ['nis' => $nis])->withErrors(['error' => 'Data dispensasi tidak ditemukan.']);
        }

        // Membuat QR Code yang mengarah ke halaman pelaporan kembali
        $qrCode = QrCode::size(200)->generate(route('dispensasi.reportReturn', $dispensasi->id));

        // Mengirimkan QR code ke tampilan
        return view('dispensasi.qrCode', compact('qrCode', 'dispensasi'));
    }

    // Menampilkan formulir pelaporan kembali
    public function showReturnForm($id)
    {
        $dispensasi = Dispensasi::findOrFail($id);
        return view('dispensasi.returnForm', compact('dispensasi'));
    }

    // Menyimpan waktu kembali siswa
    public function storeReturn(Request $request, $id)
    {
        $validated = $request->validate([
            'waktu_kembali' => 'required|date',
        ]);

        // Menyimpan waktu kembali pada dispensasi
        $dispensasi = Dispensasi::findOrFail($id);
        $dispensasi->update([
            'waktu_kembali' => $validated['waktu_kembali'],
        ]);

        return redirect()->route('dispensasi.index')->with('success', 'Siswa berhasil melaporkan kembali.');
    }
}
