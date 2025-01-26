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
        Schema::create('dispensasi', function (Blueprint $table) {
            $table->id();
            $table->string('nis');
            $table->string('nama');
            $table->string('tingkatan'); // Kolom tingkatan
            $table->string('konsentrasi_keahlian'); // Kolom konsentrasi keahlian
            $table->string('program_keahlian'); // Kolom konsentrasi keahlian
            $table->enum('jk', ['L', 'P']); // Gender (L for Male, P for Female)
            $table->string('kategori'); // Masuk kelas, keluar sekolah, dll.
            $table->string('mata_pelajaran')->nullable(); // Optional, hanya untuk kategori masuk kelas
            $table->datetime('waktu_keluar');
            $table->datetime('waktu_kembali')->nullable();
            $table->text('alasan');
            $table->enum('status', ['pending', 'disetujui', 'ditolak'])->default('pending');
            $table->string('bukti_foto')->nullable(); // Opsional, untuk bukti foto
            $table->string('guru_piket')->nullable(); // Opsional, untuk bukti foto
            $table->string('guru_pelajaran')->nullable(); // Opsional, untuk bukti foto
            $table->string('kurikulum')->nullable(); // Opsional, untuk bukti foto
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dispensasi');
    }
};
