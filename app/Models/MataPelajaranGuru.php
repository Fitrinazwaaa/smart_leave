<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MataPelajaranGuru extends Model
{
    use HasFactory;

    /**
     * Nama tabel yang terkait dengan model ini.
     *
     * @var string
     */
    protected $table = 'matapelajaran_guru';
    protected $guarded=[];

    /**
     * Atribut yang dapat diisi secara massal.
     *
     * @var array
     */
    protected $fillable = [
        'nip',
        'nama',
        'jk',
        'program_keahlian',
        'tingkat',
        'mata_pelajaran',
    ];
    public function siswa()
{
    return $this->hasMany(AkunSiswa::class, 'program_keahlian', 'program_keahlian');
}

}