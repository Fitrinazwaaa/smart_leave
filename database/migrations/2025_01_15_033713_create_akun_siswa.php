<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('akun_siswa', function (Blueprint $table) {
            $table->string('nis')->primary(); // NIS as primary key
            $table->string('nama');
            $table->enum('jk', ['L', 'P']); // Gender (L for Male, P for Female)
            $table->string('program_keahlian');
            $table->string('tingkatan');
            $table->string('konsentrasi_keahlian');
            $table->string('password');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('akun_siswa');
    }
};
