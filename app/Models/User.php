<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    use HasFactory;

    // Nama tabel yang digunakan di database
    protected $table = 'users';
    protected $guarded=[];

    protected $fillable = [
        'nis',
        'nip',
        'username',
        'password',
        'role', // siswa, guru, admin
    ];
    
    protected $hidden = [
        'password',
        'remember_token',
    ];
    
}
