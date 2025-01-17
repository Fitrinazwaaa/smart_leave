<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Memanggil seeder lain
        $this->call([
            AkunKurikulumSeeder::class, // Seeder untuk akun kurikulum
        ]);

        // Contoh data pengguna tambahan (opsional)
        \App\Models\User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
    }
}
