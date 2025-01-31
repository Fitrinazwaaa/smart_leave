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
        Schema::create('piket_guru', function (Blueprint $table) {
            $table->id();
            $table->string('nip');  // Ubah menjadi string untuk mencocokkan tipe data dengan 'akun_guru'
            $table->string('nama');
            $table->string('hari_piket');
            $table->string('pekan');
            $table->string('aktif')->nullable();
            $table->timestamps();
    
            $table->foreign('nip')->references('nip')->on('akun_guru')->onDelete('cascade');
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('piket_guru');
    }
};
