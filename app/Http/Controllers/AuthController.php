<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\User; // Pastikan model User digunakan di sini

class AuthController extends Controller
{
    public function index_login()
    {
        return view('login');
    }

    public function loginSiswa(Request $request)
    {
        // Validasi kredensial login siswa
        $credentials = $request->validate([
            'nis' => 'required',
            'password' => 'required',
        ]);
    
        // Cek apakah siswa ada
        if (Auth::attempt($credentials)) {
            $nis = Auth::user()->nis;  // Ambil NIS dari user yang login
            return redirect()->route('dashboard.siswa', ['nis' => $nis]);  // Arahkan ke dashboard siswa dengan NIS
        }
    
        // Jika login gagal
        return back()->withErrors(['error' => 'NIS atau password salah.']);
    }
    

    public function loginGuru(Request $request)
    {
        $request->validate([
            'nip' => 'required|string|max:20',
            'password' => 'required|string|min:6',
        ]);
        // Cek kredensial login guru
        if (Auth::attempt(['nip' => $request->nip, 'password' => $request->password])) {
            return redirect()->route('dashboard.guru'); // Redirect ke dashboard guru
        }
        // Jika login gagal
        return redirect()->back()->withErrors(['error' => 'NIP atau password salah.'])->withInput();
    }

    public function loginKurikulum(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:255',
            'password' => 'required|string|min:6',
        ]);
        // Cek kredensial login kurikulum
        if (Auth::attempt(['username' => $request->username, 'password' => $request->password])) {
            return redirect()->route('dashboard.admin'); // Redirect ke dashboard kurikulum
        }
        // Jika login gagal
        return redirect()->back()->withErrors(['error' => 'Username atau password salah.'])->withInput();
    }
    
    public function logout()
    {
        Auth::logout();
        return redirect('/')->with('success', 'Anda telah berhasil logout.');
    }
}
