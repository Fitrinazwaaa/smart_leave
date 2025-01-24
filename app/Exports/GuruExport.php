<?php

namespace App\Exports;

use App\Models\AkunGuru;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class GuruExport implements FromCollection, WithHeadings
{
    /**
     * Mengambil data untuk diekspor ke file Excel.
     *
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        // Ambil data guru dari database
        return AkunGuru::select([
            'nip', 
            'nama', 
            'jk', 
            'program_keahlian', 
            'tingkat', 
            'mata_pelajaran', 
            'hari_piket', 
            'password',
        ])->get();
    }

    /**
     * Menentukan header untuk file Excel.
     *
     * @return array
     */
    public function headings(): array
    {
        return [
            'NIP', 
            'NAMA', 
            'JENIS KELAMIN', 
            'PROGRAM KEAHLIAN', 
            'TINGKAT', 
            'MATA PELAJARAN', 
            'HARI PIKET', 
            'PASSWORD',
        ];
    }
}
