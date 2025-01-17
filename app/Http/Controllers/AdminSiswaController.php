<?php
namespace App\Http\Controllers;
use App\Eksports\SiswaEksport; // Gantilah jika nama kelas berbeda

use App\Imports\SiswaImport;
use Illuminate\Http\Request;
use App\Models\AkunSiswa;
use App\Models\Kelas;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;

class AdminSiswaController extends Controller
{
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'nis' => 'required|string|unique:akun_siswa,nis|max:20',
            'nama' => 'required|string|max:100',
            'jk' => 'required|in:L,P',
            'program_keahlian' => 'required|string|max:100',
            'tingkatan' => 'required|string|max:10',
            'konsentrasi_keahlian' => 'required|string|max:100',
            'password' => 'required|string|min:6',
        ]);

        // Simpan data ke dalam tabel akun_siswa
        $siswa = AkunSiswa::create([
            'nis' => $request->nis,
            'nama' => $request->nama,
            'jk' => $request->jk,
            'program_keahlian' => $request->program_keahlian,
            'tingkatan' => $request->tingkatan,
            'konsentrasi_keahlian' => $request->konsentrasi_keahlian,
            'password' => Hash::make($request->password),
        ]);

        // Simpan data ke dalam tabel users (nis dan password)
        DB::table('users')->insert([
            'nis' => $request->nis,
            'password' => Hash::make($request->password), // Hash password untuk keamanan
            'nip' => null, // Null karena bukan guru
            'username' => null, // Null karena bukan akun kurikulum
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Redirect dengan pesan sukses
        return redirect()->back()->with('success', 'Akun siswa berhasil ditambahkan.');
    }

    public function indexSiswa()
    {
        // Ambil data program keahlian dari tabel kelas
        $programKeahlian = Kelas::select('program_keahlian')->distinct()->get();

        $dataPerTingkatan = DB::table('akun_siswa')
        ->select('tingkatan', 'nis', 'nama', 'tingkatan', 'konsentrasi_keahlian', 'program_keahlian', 'jk', 'password')
        ->get()
        ->map(function ($item) {
            return (array) $item;
        })
        ->groupBy('tingkatan')
        ->map(function ($group, $tingkatan) {
            return [
                'tingkatan' => $tingkatan,
                'data' => $group
            ];
        })
        ->values()
        ->toArray();    

        return view('admin.data_siswa', compact('programKeahlian', 'dataPerTingkatan'));
    }

    public function getKonsentrasi(Request $request)
    {
        // Ambil data konsentrasi keahlian berdasarkan program keahlian
        $konsentrasiKeahlian = Kelas::where('program_keahlian', $request->program_keahlian)->pluck('konsentrasi_keahlian');
        return response()->json($konsentrasiKeahlian);
    }

    public function export()
    {
        return Excel::download(new SiswaEksport, 'data_siswa.xlsx');
    }

    public function import(Request $request)
    {
        $request->validate([
            'excelFile' => 'required|mimes:xlsx,xls',
        ]);

        Excel::import(new SiswaImport, $request->file('excelFile'));

        return back()->with('success', 'Data berhasil diimport!');
    }
}