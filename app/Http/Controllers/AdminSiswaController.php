<?php

namespace App\Http\Controllers;

use App\Exports\SiswaEksport;
use App\Imports\SiswaImport;
use Illuminate\Http\Request;
use App\Models\AkunSiswa;
use App\Models\Dispensasi;
use App\Models\Kelas;
use App\Models\User;
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
        $request->validate([
            'program_keahlian' => 'required|string|exists:kelas,program_keahlian',
        ]);
    
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

    public function increaseTingkatan()
    {
        // Perbarui semua data siswa dengan menambah nilai tingkatan sebesar 1
        DB::table('akun_siswa')->increment('tingkatan', 1);
        // Redirect kembali ke halaman dengan pesan sukses
        return redirect()->route('kelasSiswa')->with('success', 'Tingkatan semua siswa berhasil ditambah.');
    }
    public function destroyMultiple(Request $request)
    {
        // Validasi input
        $request->validate([
            'hapus' => 'required|array|min:1',
            'hapus.*' => 'exists:akun_siswa,nis', // pastikan nis yang dipilih valid
        ]);
        // Hapus data poin pelajar dengan NIS yang sesuai
        User::whereIn('nis', $request->hapus)->delete();
        // Hapus entri siswa berdasarkan NIS yang dipilih
        AkunSiswa::whereIn('nis', $request->hapus)->delete();
        Dispensasi::whereIn('nis', $request->hapus)->delete();
        return redirect()->route('kelasSiswa')->with('success', 'Siswa yang dipilih beserta akunnya berhasil dihapus.');
    }

    // Fungsi untuk pencarian
    public function search(Request $request)
    {
        // Ambil input pencarian
        $search = $request->input('search');

        // Cari data berdasarkan tingkatan dan konsentrasi_keahlian
        $results = AkunSiswa::where(function($query) use ($search) {
            $query->where('tingkatan', 'like', '%'.$search.'%')
                  ->orWhere('konsentrasi_keahlian', 'like', '%'.$search.'%');
        })
        ->get();

        // Kirim hasil pencarian ke view
        return view('admin.data_siswa', compact('results'));
    }

}
