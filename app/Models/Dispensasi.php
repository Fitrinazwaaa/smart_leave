<?php

// app/Models/Dispensasi.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dispensasi extends Model
{
    use HasFactory;
    protected $table = 'dispensasi';
    protected $guarded=[];

    protected $fillable = [
        'nis',
        'nama',
        'tingkatan',
        'konsentrasi_keahlian',
        'program_keahlian',
        'kategori',
        'mata_pelajaran',
        'waktu_keluar',
        'waktu_kembali',
        'alasan',
        'status',
        'bukti_foto',
        'guru_piket',
        'guru_pelajaran',
        'kurikulum',
    ];
}
