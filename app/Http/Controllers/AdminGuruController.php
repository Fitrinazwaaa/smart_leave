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
            'hari_piket' => 'required|string|max:10',
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
            // Redirect dengan pesan sukses
            return redirect()->back()->with('success', 'Akun guru berhasil ditambahkan.');
        } catch (\Exception $e) {
            // Tangani error dan tampilkan pesan
            return redirect()->back()->with('error', 'Gagal menambahkan akun guru: ' . $e->getMessage());
        }
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
