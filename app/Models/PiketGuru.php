<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PiketGuru extends Model
{
    use HasFactory;

    protected $table = 'piket_guru';
    protected $guarded = [];
    protected $fillable = [
        'nip',
        'nama',
        'jk',
        'hari_piket',
    ];
    // Relasi jika diperlukan
    public function dispensasi()
    {
        return $this->hasMany(Dispensasi::class, 'nip', 'nip');
    }
}
