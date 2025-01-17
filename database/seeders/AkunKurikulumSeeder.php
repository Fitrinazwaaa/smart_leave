<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AkunKurikulumSeeder extends Seeder {
    /**
     * Jalankan seeder.
     */
    public function run(): void {
        DB::table('users')->insert([
            'username' => 'kurikulum',
            'password' => Hash::make('271006'), // Gunakan Hash untuk keamanan
        ]);
    }
}
