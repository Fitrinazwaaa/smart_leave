<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dispensasi', function (Blueprint $table) {
            $table->id('id_dispen');
            $table->string('nis');
            $table->string('nama');
            $table->string('tingkatan');
            $table->string('konsentrasi_keahlian');
            $table->string('program_keahlian');
            $table->enum('jk', ['L', 'P']);
            $table->string('kategori');
            $table->string('mata_pelajaran');
            $table->string('nip');
            $table->string('nama_pengajar');
            $table->datetime('waktu_keluar');
            $table->datetime('waktu_kembali')->nullable();
            $table->text('alasan');
            $table->enum('status', ['pending', 'disetujui', 'ditolak'])->default('pending');
            $table->string('bukti_foto')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dispensasi');
    }
};