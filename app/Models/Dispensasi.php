<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dispensasi extends Model
{
    use HasFactory;

    protected $table = 'dispensasi';
    protected $guarded = [];

    protected $primaryKey = 'id_dispen'; // Pastikan primary key yang digunakan sesuai

    protected $fillable = [
        'nis',
        'nama',
        'tingkatan',
        'konsentrasi_keahlian',
        'program_keahlian',
        'jk',
        'kategori',
        'mata_pelajaran',
        'nip',
        'nama_pengajar',
        'waktu_keluar',
        'waktu_kembali',
        'alasan',
        'status',
        'bukti_foto'
    ];

    // Relasi Dispensasi ke Konfirmasi
    public function konfirmasi()
    {
        return $this->hasMany(Konfirmasi::class, 'id_dispen', 'id_dispen'); 
    }    
    // Relasi ke model PiketGuru jika diperlukan
    public function piketGuru()
    {
        return $this->belongsTo(PiketGuru::class, 'nip', 'nip');
    }
}
