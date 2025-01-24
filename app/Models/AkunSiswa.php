<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AkunSiswa extends Model
{
    use HasFactory;

    protected $table = 'akun_siswa';
    protected $primaryKey = 'nis';
    protected $guarded=[];
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'nis',
        'nama',
        'jk',
        'program_keahlian',
        'tingkatan',
        'konsentrasi_keahlian',
        'password',
    ];
    protected $hidden = [
        'password',
    ];
}
