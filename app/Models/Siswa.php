<?php
// app/Models/Siswa.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    use HasFactory;

    protected $table = 'akun_siswa';
    protected $primaryKey = 'nis';
    protected $fillable = ['nis', 'kelas', 'nama', 'jk', 'password'];
    
    protected $hidden = [
        'password',
    ];
}
