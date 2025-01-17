<?php

namespace App\Imports;

use App\Models\AkunGuru;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class GuruImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        // Cari apakah data dengan NIP yang sama sudah ada
        $existingGuru = AkunGuru::where('nip', $row['nip'])->first();

        if ($existingGuru) {
            // Jika data dengan NIP sudah ada, lakukan update
            $existingGuru->update([
                'nama' => $row['nama'],
                'jk' => $row['jk'], // L atau P
                'mata_pelajaran' => $row['mata_pelajaran'],
                'tingkat' => $row['tingkat'],
                'hari_piket' => $row['hari_piket'],
                'password' => Hash::make($row['password']),
            ]);
        } else {
            // Jika data tidak ditemukan, buat data baru
            AkunGuru::create([
                'nip' => $row['nip'],
                'nama' => $row['nama'],
                'jk' => $row['jk'], // L atau P
                'mata_pelajaran' => $row['mata_pelajaran'],
                'tingkat' => $row['tingkat'],
                'hari_piket' => $row['hari_piket'],
                'password' => Hash::make($row['password']),
            ]);
        }

        // Simpan data ke tabel users
        DB::table('users')->updateOrInsert(
            ['nip' => $row['nip']], // Kondisi untuk insert atau update
            [
                'password' => Hash::make($row['password']),
                'nis' => null,
                'username' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );
    }
}
