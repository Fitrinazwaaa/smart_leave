<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB; // Menggunakan DB dari facade
use Illuminate\Support\Facades\Hash;

class SyncSiswaToUsersSeeder extends Seeder
{
    /**
     * Menjalankan seeder untuk menyalin data.
     */
    public function run(): void
    {
        // Ambil semua data dari tabel akun_siswa
        $siswa = DB::table('akun_siswa')->get();

        foreach ($siswa as $s) {
            // Menyalin data nis sebagai username dan password
            DB::table('users')->insert([
                'username' => $s->nis,
                'password' => Hash::make($s->password), // Mengenkripsi password
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
