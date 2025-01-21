<?php

namespace App\Eksports;

use App\Models\Kelas;
use Maatwebsite\Excel\Concerns\FromCollection;

class KelasEksport implements FromCollection
{
    public function collection()
    {
        return Kelas::get(['program_keahlian', 'konsentrasi_keahlian']);
    }

    public function headings(): array
    {
        return [
            'Program Keahlian',
            'Konsentrasi Keahlian',
        ];
    }
}
