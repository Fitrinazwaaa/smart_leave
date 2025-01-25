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
            $table->string('nip');
            $table->string('nama');
            $table->enum('jk', ['L', 'P']);
            $table->string('hari_piket');
            $table->timestamps();
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
