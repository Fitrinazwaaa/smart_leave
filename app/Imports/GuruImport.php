<?php

namespace App\Imports;

use App\Models\AkunGuru;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class GuruImport implements ToModel, WithHeadingRow
{
    /**
     * Method untuk memetakan data dari setiap baris di file Excel ke model database.
     *
     * @param array $row
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        // Cari apakah data dengan NIP yang sama sudah ada di tabel akun_Guru
        $existingGuru = AkunGuru::where('nip', $row['nip'])->first();
    
        // Password dienkripsi
        $hashedPassword = Hash::make($row['password']);
    
        if ($existingGuru) {
            // Jika data dengan NIP yang sama sudah ada, lakukan update di tabel akun_Guru
            $existingGuru->update([
                'nama' => $row['nama'],
                'jk' => $row['jenis_kelamin'], // L atau P
                'mata_pelajaran' => $row['mata_pelajaran'],
                'program_keahlian' => $row['program_keahlian'],
                'tingkat' => $row['tingkat'],
                'hari_piket' => $row['hari_piket'],
                'password' => $hashedPassword,
            ]);
    
            // Update atau tambahkan data ke tabel users
            DB::table('users')->updateOrInsert(
                ['nip' => $row['nip']], // Kondisi pencocokan
                [
                    'password' => $hashedPassword, // Enkripsi Password
                    'username' => null, // Null karena bukan akun kurikulum
                ]
            );
    
            // Return null karena data sudah diperbarui, tidak perlu membuat data baru
            return null;
        }
    
        // Jika data tidak ditemukan, buat data baru di tabel akun_Guru
        $newGuru = new AkunGuru([
            'nip' => $row['nip'],
            'nama' => $row['nama'],
            'jk' => $row['jenis_kelamin'], // L atau P
            'mata_pelajaran' => $row['mata_pelajaran'],
            'program_keahlian' => $row['program_keahlian'],
            'tingkat' => $row['tingkat'],
            'hari_piket' => $row['hari_piket'],
            'password' => $hashedPassword, // Enkripsi Password
        ]);
    
        // Tambahkan data ke tabel users
        DB::table('users')->insert([
            'nip' => $row['nip'], // nip
            'password' => $hashedPassword, // Enkripsi Password
            'username' => null, // Null karena bukan akun kurikulum
        ]);
    
        return $newGuru;
    }    
}
