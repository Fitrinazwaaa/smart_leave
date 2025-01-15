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
        Schema::create('akun_guru', function (Blueprint $table) {
            $table->string('nip')->primary(); // NIP as primary key
            $table->string('nama');
            $table->enum('jk', ['L', 'P']); // Gender (L for Male, P for Female)
            $table->string('mata_pelajaran');
            $table->string('hari_piket');
            $table->string('password');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('akun_guru');
    }
};
