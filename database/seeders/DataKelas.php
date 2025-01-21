<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DataKelas extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('kelas')->insert([
            [
                'program_keahlian' => 'Pengembangan Perangkat Lunak dan Gim',
                'konsentrasi_keahlian' => 'RPL 1',
            ],
            [
                'program_keahlian' => 'Pengembangan Perangkat Lunak dan Gim',
                'konsentrasi_keahlian' => 'RPL 2',
            ],
            [
                'program_keahlian' => 'Pengembangan Perangkat Lunak dan Gim',
                'konsentrasi_keahlian' => 'RPL 3',
            ],
            [
                'program_keahlian' => 'Akuntansi dan Keuangan Lembaga',
                'konsentrasi_keahlian' => 'AK 1',
            ],
            [
                'program_keahlian' => 'Akuntansi dan Keuangan Lembaga',
                'konsentrasi_keahlian' => 'AK 2',
            ],
            [
                'program_keahlian' => 'Seni Pertunjukan',
                'konsentrasi_keahlian' => 'SK 1',
            ],
        ]);
    }
}
