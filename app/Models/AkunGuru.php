<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AkunGuru extends Model
{
    use HasFactory;

    protected $table = 'akun_guru';
    protected $primaryKey = 'nip';
    protected $guarded = [];
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'nip',
        'nama',
        'jk',
        'mata_pelajaran',
        'tingkat',
        'program_keahlian',
        'hari_piket',
        'jabatan',
        'password',
    ];

    protected $hidden = [
        'password',
    ];

    // Relasi dengan model User (jika perlu, jika AkunGuru terhubung dengan User)
    public function user()
    {
        return $this->belongsTo(User::class, 'nip', 'nip');
    }

    // Fungsi pencarian guru piket berdasarkan hari
    public static function findGuruPiket($hari)
    {
        return self::where('hari_piket', $hari)->first();
    }

    // Fungsi pencarian guru berdasarkan mata pelajaran
    public static function findGuruMapel($tingkatan, $programKeahlian, $mataPelajaran)
    {
        return self::where('tingkatan', $tingkatan)
            ->where('program_keahlian', $programKeahlian)
            ->where('mata_pelajaran', $mataPelajaran)
            ->first();
    }

    // Fungsi pencarian guru kurikulum
    public static function findKurikulum()
    {
        return self::where('jabatan', 'kurikulum')->first();
    }
}
