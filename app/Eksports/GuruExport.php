<?php

namespace App\Exports;

use App\Models\AkunGuru;
use Maatwebsite\Excel\Concerns\FromCollection;

class GuruExport implements FromCollection
{
    public function collection()
    {
        return AkunGuru::all();
    }
}
