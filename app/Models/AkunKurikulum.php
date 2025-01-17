<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class AkunKurikulum extends Model
{
    use HasFactory;

    // Nama tabel yang digunakan di database
    protected $table = 'akun_kurikulum';
    protected $guarded=[];
    protected $fillable = ['username', 'password'];
    protected $hidden = [
        'password',
    ];
        // Menambahkan event created
        protected static function booted()
        {
            static::created(function ($akunKurikulum) {
                // Menambahkan data ke tabel users
                DB::table('users')->insert([
                    'username' => $akunKurikulum->username,
                    'password' => $akunKurikulum->password,
                    'nis' => null,  // Nilai null karena bukan siswa
                    'nip' => null,  // Nilai null karena bukan guru
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            });
        }
}
