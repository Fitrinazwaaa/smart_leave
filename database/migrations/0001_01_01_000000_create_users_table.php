<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id(); // ID auto-increment untuk pengguna
            $table->string('nis')->nullable()->unique();   // NIS untuk siswa, nullable agar bisa berbeda dengan guru
            $table->string('nip')->nullable()->unique();   // NIP untuk guru, nullable agar bisa berbeda dengan siswa
            $table->string('username')->nullable()->unique(); // Username untuk kurikulum, nullable agar bisa berbeda dengan siswa dan guru
            $table->string('password')->nullable();  // Password untuk akun siswa, guru, atau kurikulum
            $table->timestamps();
        });
    
        // Tabel untuk reset password
        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('username')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });
    
        // Tabel sessions (default Laravel session)
        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index(); // Relasi dengan tabel users
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }    
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
