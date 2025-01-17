<?php

namespace App\Imports;

use App\Models\AkunSiswa;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SiswaImport implements ToModel, WithHeadingRow
{
    /**
     * Method untuk memetakan data dari setiap baris di file Excel ke model database.
     *
     * @param array $row
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        // Cari apakah data dengan NIS yang sama sudah ada di tabel akun_siswa
        $existingSiswa = AkunSiswa::where('nis', $row['nis'])->first();

        // Password dienkripsi
        $hashedPassword = Hash::make($row['password']);

        if ($existingSiswa) {
            // Jika data dengan NIS yang sama sudah ada, lakukan update di tabel akun_siswa
            $existingSiswa->update([
                'nama' => $row['nama'], // Nama
                'jk' => $row['jenis_kelamin'], // L atau P
                'program_keahlian' => $row['program_keahlian'], // Program Keahlian
                'tingkatan' => $row['tingkatan'], // Tingkatan
                'konsentrasi_keahlian' => $row['konsentrasi_keahlian'], // Konsentrasi Keahlian
                'password' => $hashedPassword, // Enkripsi Password
            ]);

            // Update atau tambahkan data ke tabel users
            DB::table('users')->updateOrInsert(
                ['nis' => $row['nis']], // Kondisi pencocokan
                [
                    'password' => $hashedPassword, // Enkripsi Password
                    'nip' => null, // Null karena bukan guru
                    'username' => null, // Null karena bukan akun kurikulum
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );

            // Return null karena data sudah diperbarui, tidak perlu membuat data baru
            return null;
        }

        // Jika data tidak ditemukan, buat data baru di tabel akun_siswa
        $newSiswa = new AkunSiswa([
            'nis' => $row['nis'], // NIS
            'nama' => $row['nama'], // Nama
            'jk' => $row['jenis_kelamin'], // L atau P
            'program_keahlian' => $row['program_keahlian'], // Program Keahlian
            'tingkatan' => $row['tingkatan'], // Tingkatan
            'konsentrasi_keahlian' => $row['konsentrasi_keahlian'], // Konsentrasi Keahlian
            'password' => $hashedPassword, // Enkripsi Password
        ]);

        // Tambahkan data ke tabel users
        DB::table('users')->insert([
            'nis' => $row['nis'], // NIS
            'password' => $hashedPassword, // Enkripsi Password
            'nip' => null, // Null karena bukan guru
            'username' => null, // Null karena bukan akun kurikulum
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return $newSiswa;
    }
}
