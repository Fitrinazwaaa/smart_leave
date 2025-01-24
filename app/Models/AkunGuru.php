<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AkunGuru extends Model
{
    use HasFactory;

    protected $table = 'akun_guru'; // Nama tabel
    protected $primaryKey = 'nip'; // Primary key
    protected $guarded=[];
    public $incrementing = false; // Karena nip bukan auto-increment
    protected $keyType = 'string';

    protected $fillable = [
        'nip',
        'nama',
        'jk',
        'mata_pelajaran',
        'tingkat',
        'program_keahlian',
        'hari_piket',
        'password',
    ];
    protected $hidden = [
        'password',
    ];
}
