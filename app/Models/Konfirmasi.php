<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Konfirmasi extends Model
{
    use HasFactory;

    protected $table = 'konfirmasi';

    // Kolom yang boleh diisi
    protected $fillable = ['id_dispen', 'konfirmasi_1', 'konfirmasi_2', 'konfirmasi_3'];

    // Relasi Konfirmasi ke Dispensasi
    public function dispensasi()
    {
        return $this->belongsTo(Dispensasi::class, 'id_dispen', 'id_dispen'); // Pastikan relasi ini menggunakan 'id_dispen' yang benar
    }
}
