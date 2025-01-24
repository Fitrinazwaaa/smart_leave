<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AkunKurikulumSeeder extends Seeder
{
    /**
     * Jalankan seeder.
     */
    public function run(): void
    {
        DB::table('users')->updateOrInsert(
            ['username' => 'kurikulum'], // Cari berdasarkan username
            [
                'password' => Hash::make('271006'), // Hash password
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );
    }
}
