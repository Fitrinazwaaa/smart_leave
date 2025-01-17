<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AkunSiswa extends Model
{
    use HasFactory;

    protected $table = 'akun_siswa';
    protected $guarded=[];

    protected $primaryKey = 'nis';
    protected $keyType = 'string';
    public $incrementing = false;

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
