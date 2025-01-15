<?php 
// app/Models/Guru.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guru extends Model
{
    use HasFactory;

    protected $table = 'akun_guru';
    protected $primaryKey = 'nip';
    protected $fillable = ['nip', 'nama', 'jk', 'mata_pelajaran', 'hari_piket', 'password'];
    
    protected $hidden = [
        'password',
    ];
}
