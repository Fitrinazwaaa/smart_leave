<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('konfirmasi', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_dispen');
            $table->string('kategori');
            $table->string('konfirmasi_1')->nullable();
            $table->string('konfirmasi_2')->nullable();
            $table->string('konfirmasi_3')->nullable();
            $table->timestamps();

            $table->foreign('id_dispen')->references('id_dispen')->on('dispensasi')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('konfirmasi');
    }
};
