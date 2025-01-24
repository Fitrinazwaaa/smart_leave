<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function dashboard()
    {
        return view('admin.dashboard');
    }

    public function edit()
    {
        return view('admin.akun_kurikulum');
    }

    public function update(Request $request)
    {
        // Validasi data
        $request->validate([
            'id' => 'required|exists:users,id', // Pastikan ID ada di tabel users
            'username' => 'required|string|max:255',
            'password' => 'nullable|string|min:6|confirmed',
        ]);
    
        // Ambil user berdasarkan ID
        $user = User::findOrFail($request->id);
    
        // Update data user
        $user->username = $request->username;
    
        if ($request->password) {
            $user->password = Hash::make($request->password);
        }
    
        $user->save();
    
        // Jika password diubah, logout dan minta login ulang
        if ($request->password) {
            Auth::logout();
            return redirect('/')->with('info', 'Profil berhasil diperbarui. Silakan login kembali.');
        }
    
        return back()->with('success', 'Profil berhasil diperbarui!');
    }
    
}
