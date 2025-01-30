<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    use HasFactory;

    protected $table = 'users';
    protected $guarded = [];

    protected $fillable = [
        'nis',
        'nip',
        'username',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Relasi dengan AkunGuru (bila pengguna adalah guru)
    public function akunGuru()
    {
        return $this->hasOne(AkunGuru::class, 'nip', 'nip');
    }
}
