<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('akun_guru', function (Blueprint $table) {
            $table->engine = 'InnoDB';  // Menambahkan engine InnoDB untuk mendukung foreign key
            $table->string('nip')->primary(); // NIP as primary key
            $table->string('nama');
            $table->enum('jk', ['L', 'P']);
            $table->string('mata_pelajaran');
            $table->string('tingkat');
            $table->string('program_keahlian')->nullable();
            $table->string('no_hp');
            $table->string('jabatan')->nullable();
            $table->string('password');
            $table->timestamps();
        });
        
    }    
    public function down(): void
    {
        Schema::dropIfExists('akun_guru');
    }
};
