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
        // Pastikan NIP tidak kosong
        if (empty($row['nip'])) {
            return null;
        }

        // Bersihkan nilai dari spasi ekstra
        $nip = trim($row['nip']);
        $nama = trim($row['nama']);
        $jenisKelamin = trim($row['jenis_kelamin']);
        $mataPelajaranRaw = trim($row['mata_pelajaran'] ?? '');
        $programKeahlian = trim($row['program_keahlian']);
        $tingkat = trim($row['tingkat']);
        $telepon = trim($row['telepon']);
        $jabatan = trim($row['jabatan']);
        $password = trim($row['password'] ?? 'smkn1kawali'); // Default jika kosong

        // Enkripsi password
        $hashedPassword = Hash::make($password);

        // Pisahkan mata pelajaran menjadi array
        $mataPelajaranList = array_map('trim', explode(',', $mataPelajaranRaw));

        DB::beginTransaction();
        try {
            // Cek apakah guru dengan NIP yang sama sudah ada
            $existingGuru = AkunGuru::where('nip', $nip)->first();

            if ($existingGuru) {
                // Jika sudah ada, update data
                $existingGuru->update([
                    'nama' => $nama,
                    'jk' => $jenisKelamin,
                    'mata_pelajaran' => $mataPelajaranRaw,
                    'program_keahlian' => $programKeahlian,
                    'tingkat' => $tingkat,
                    'no_hp' => $telepon,
                    'jabatan' => $jabatan,
                    'password' => $hashedPassword,
                ]);
            } else {
                // Jika tidak ada, buat data baru
                $existingGuru = AkunGuru::create([
                    'nip' => $nip,
                    'nama' => $nama,
                    'jk' => $jenisKelamin,
                    'mata_pelajaran' => $mataPelajaranRaw,
                    'program_keahlian' => $programKeahlian,
                    'tingkat' => $tingkat,
                    'no_hp' => $telepon,
                    'jabatan' => $jabatan,
                    'password' => $hashedPassword,
                ]);
            }

            // Tambahkan atau perbarui data ke tabel users
            DB::table('users')->updateOrInsert(
                ['nip' => $nip],
                ['password' => $hashedPassword, 'username' => null]
            );

            // Tambahkan atau update data di tabel matapelajaran_guru
            foreach ($mataPelajaranList as $mapel) {
                if (!empty($mapel)) {
                    DB::table('matapelajaran_guru')->updateOrInsert(
                        ['nip' => $nip, 'mata_pelajaran' => $mapel],
                        [
                            'nama' => $nama,
                            'jk' => $jenisKelamin,
                            'program_keahlian' => $programKeahlian,
                            'tingkat' => $tingkat,
                        ]
                    );
                }
            }

            DB::commit(); // Simpan perubahan ke database
            return $existingGuru;
        } catch (\Exception $e) {
            DB::rollBack(); // Batalkan transaksi jika ada error
            \Log::error("Error Import Guru: " . $e->getMessage()); // Simpan ke log
            return null;
        }
    }
}
