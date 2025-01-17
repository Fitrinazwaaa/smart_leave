<?php

// Pastikan nama namespace benar
namespace App\Eksports;

use App\Models\AkunSiswa;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class SiswaEksport implements WithMultipleSheets
{
    public function sheets(): array
    {
        $sheets = [];

        // Ambil semua tingkatan unik dari database
        $tingkatan = AkunSiswa::select('tingkatan')->distinct()->pluck('tingkatan');

        // Buat satu sheet untuk setiap tingkatan
        foreach ($tingkatan as $tingkat) {
            // Ganti dengan kelas yang menyesuaikan tingkatan
            $sheets[] = new SiswaPerTingkatanEksport($tingkat);
        }

        return $sheets;
    }
}
