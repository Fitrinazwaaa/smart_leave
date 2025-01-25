<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AkunGuru;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\GuruImport;
use App\Exports\GuruExport;
use App\Models\Kelas;
use App\Models\MataPelajaranGuru;
use App\Models\PiketGuru;
use App\Models\User;

class AdminGuruController extends Controller
{
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'nip' => 'required|string|unique:akun_guru,nip|max:20',
            'nama' => 'required|string|max:100',
            'jk' => 'required|in:L,P',
            'mata_pelajaran' => 'required|string|max:100',
            'tingkat' => 'required|string|max:10',
            'program_keahlian' => 'required|string|max:100',
            'hari_piket' => 'nullable|string|max:10',
            'password' => 'required|string|min:6',
        ]);

        try {
            // Simpan data ke dalam tabel akun_guru
            AkunGuru::create([
                'nip' => $request->nip,
                'nama' => $request->nama,
                'jk' => $request->jk,
                'mata_pelajaran' => $request->mata_pelajaran,
                'tingkat' => $request->tingkat,
                'program_keahlian' => $request->program_keahlian, // Pastikan ini sesuai
                'hari_piket' => $request->hari_piket,
                'password' => Hash::make($request->password),
            ]);

            // Simpan data ke dalam tabel users (nip dan password)
            DB::table('users')->insert([
                'nip' => $request->nip,
                'password' => Hash::make($request->password),
                'nis' => null, // Null karena bukan siswa
                'username' => null, // Null karena bukan akun kesiswaan
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Simpan data ke tabel piket_guru jika hari_piket valid (senin-jumat)
            $validDays = ['senin', 'selasa', 'rabu', 'kamis', 'jumat'];
            if (!is_null($request->hari_piket) && in_array(strtolower($request->hari_piket), $validDays)) {
                DB::table('piket_guru')->insert([
                    'nip' => $request->nip,
                    'nama' => $request->nama,
                    'jk' => $request->jk,
                    'hari_piket' => $request->hari_piket,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            // Simpan data ke tabel matapelajaran_guru
            DB::table('matapelajaran_guru')->insert([
                'nip' => $request->nip,
                'nama' => $request->nama,
                'jk' => $request->jk,
                'mata_pelajaran' => $request->mata_pelajaran,
                'tingkat' => $request->tingkat,
                'program_keahlian' => $request->program_keahlian,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Redirect dengan pesan sukses
            return redirect()->back()->with('success', 'Akun guru berhasil ditambahkan.');
        } catch (\Exception $e) {
            // Tangani error dan tampilkan pesan
            return redirect()->back()->with('error', 'Gagal menambahkan akun guru: ' . $e->getMessage());
        }
    }


    public function destroyMultiple(Request $request)
    {
        // Validasi input
        $request->validate([
            'hapus' => 'required|array|min:1',
            'hapus.*' => 'exists:akun_guru,nip', // pastikan nip yang dipilih valid
        ]);
        // Hapus data poin pelajar dengan nip yang sesuai
        User::whereIn('nip', $request->hapus)->delete();
        MataPelajaranGuru::whereIn('nip', $request->hapus)->delete();
        PiketGuru::whereIn('nip', $request->hapus)->delete();
        // Hapus entri guru berdasarkan nip yang dipilih
        AkunGuru::whereIn('nip', $request->hapus)->delete();
        return redirect()->route('admin.guru.index')->with('success', 'Guru yang dipilih beserta akunnya berhasil dihapus.');
    }

    public function indexGuru()
    {
        // Ambil data guru
        $dataGuru = AkunGuru::all();
        $programKeahlian = Kelas::select('program_keahlian')->distinct()->get();
        return view('admin.data_guru', compact('dataGuru', 'programKeahlian'));
    }

    public function export()
    {
        // Ekspor data guru ke file Excel
        return Excel::download(new GuruExport, 'data_guru.xlsx');
    }

    public function import(Request $request)
    {
        $request->validate([
            'excelFile' => 'required|mimes:xlsx,xls',
        ]);
        Excel::import(new GuruImport, $request->file('excelFile'));
        return back()->with('success', 'Data guru berhasil diimport!');
    }
}
