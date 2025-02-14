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
        // Cari apakah data dengan NIP yang sama sudah ada di tabel akun_guru
        $existingGuru = AkunGuru::where('nip', $row['nip'])->first();

        // Password dienkripsi
        $hashedPassword = Hash::make($row['password']);

        // Pisahkan hari piket dan mata pelajaran
        $mataPelajaran = explode(',', $row['mata_pelajaran']);

        if ($existingGuru) {
            // Update data di tabel akun_guru
            $existingGuru->update([
                'nama' => $row['nama'],
                'jk' => $row['jenis_kelamin'], // L atau P
                'mata_pelajaran' => $row['mata_pelajaran'],
                'program_keahlian' => $row['program_keahlian'],
                'tingkat' => $row['tingkat'],
                'no_hp' => $row['telepon'],
                'jabatan' => $row['jabatan'],
                'password' => $hashedPassword,
            ]);

            // Update atau tambahkan data ke tabel users
            DB::table('users')->updateOrInsert(
                ['nip' => $row['nip']],
                [
                    'password' => $hashedPassword,
                    'username' => null,
                ]
            );

            // Update data di tabel matapelajaran_guru
            foreach ($mataPelajaran as $mapel) {
                DB::table('matapelajaran_guru')->updateOrInsert(
                    ['nip' => $row['nip'], 'mata_pelajaran' => trim($mapel)],
                    [
                        'nama' => $row['nama'],
                        'jk' => $row['jenis_kelamin'],
                        'program_keahlian' => $row['program_keahlian'],
                        'tingkat' => $row['tingkat'],
                    ]
                );
            }

            return null; // Data sudah diperbarui
        }

        // Jika data tidak ditemukan, buat data baru di tabel akun_guru
        $newGuru = new AkunGuru([
            'nip' => $row['nip'],
            'nama' => $row['nama'],
            'jk' => $row['jenis_kelamin'], // L atau P
            'mata_pelajaran' => $row['mata_pelajaran'],
            'program_keahlian' => $row['program_keahlian'],
            'tingkat' => $row['tingkat'],
            'no_hp' => $row['telepon'],
            'jabatan' => $row['jabatan'],
            'password' => $hashedPassword,
        ]);

        // Tambahkan data ke tabel users
        DB::table('users')->insert([
            'nip' => $row['nip'],
            'password' => $hashedPassword,
            'username' => null,
        ]);

        // Tambahkan data ke tabel matapelajaran_guru
        foreach ($mataPelajaran as $mapel) {
            DB::table('matapelajaran_guru')->insert([
                'nip' => $row['nip'],
                'nama' => $row['nama'],
                'jk' => $row['jenis_kelamin'],
                'program_keahlian' => $row['program_keahlian'],
                'tingkat' => $row['tingkat'],
                'mata_pelajaran' => trim($mapel),
            ]);
        }

        return $newGuru;
    }
}
