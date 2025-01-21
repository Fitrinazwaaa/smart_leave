<?php

namespace App\Imports;

use App\Models\Kelas;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class KelasImport implements ToModel, WithHeadingRow
{
    /**
     * Menerapkan setiap baris dari file Excel ke model.
     *
     * @param array $row Baris dari file Excel.
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        // Cari apakah data dengan program_keahlian yang sama sudah ada
        $existingKelas = Kelas::where('program_keahlian', $row['program_keahlian'])
            ->where('konsentrasi_keahlian', $row['konsentrasi_keahlian'])
            ->first();

        if ($existingKelas) {
            // Jika data sudah ada, update data
            $existingKelas->update([
                'program_keahlian' => $row['program_keahlian'],
                'konsentrasi_keahlian' => $row['konsentrasi_keahlian'],
            ]);
        } else {
            // Jika data tidak ada, buat data baru
            return new Kelas([
                'program_keahlian' => $row['program_keahlian'],
                'konsentrasi_keahlian' => $row['konsentrasi_keahlian'],
            ]);
        }
    }
}
