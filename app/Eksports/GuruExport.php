<?php

namespace App\Exports;

use App\Models\AkunGuru;
use Maatwebsite\Excel\Concerns\FromCollection;

class GuruExport implements FromCollection
{
    public function collection()
    {
        // Ambil data siswa berdasarkan tingkatan
        return AkunGuru::get([
                'nip', 
                'nama', 
                'jk', 
                'mata_pelajaran', 
                'tingkat', 
                'program_keahlian', 
                'hari_piket', 
                'password',
            ]);
    }

    public function headings(): array
    {
        return [
            'NIP', 
            'Nama', 
            'Jenis Kelamin', 
            'Mata Pelajaran', 
            'Tingkat', 
            'Program Keahlian', 
            'Hari Piket', 
            'Password',
        ];
    }
}
