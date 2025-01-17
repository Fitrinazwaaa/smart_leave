<?php
namespace App\Eksports;

use App\Models\AkunSiswa;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class SiswaPerTingkatanEksport implements FromCollection, WithHeadings, WithTitle
{
    private $tingkatan;

    public function __construct($tingkatan)
    {
        $this->tingkatan = $tingkatan;
    }

    public function collection()
    {
        // Ambil data siswa berdasarkan tingkatan
        return AkunSiswa::where('tingkatan', $this->tingkatan)
            ->get([
                'nis', 
                'nama', 
                'tingkatan', 
                'konsentrasi_keahlian', 
                'program_keahlian', 
                'jk', 
                'password',
                'created_at', 
                'updated_at'
            ]);
    }

    public function headings(): array
    {
        return [
            'NIS', 
            'Nama', 
            'Tingkatan',
            'Konsentrasi Keahlian', 
            'Program Keahlian', 
            'Jenis Kelamin', 
            'Password',
            'Dibuat (kosongkan)',
            'Diperbaharui (kosongkan)',
        ];
    }

    public function title(): string
    {
        return 'Tingkatan ' . $this->tingkatan;
    }
}
