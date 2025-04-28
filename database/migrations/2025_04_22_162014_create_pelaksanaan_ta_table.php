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
        Schema::create('pelaksanaan_ta', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // Foreign Key mengacu ke tabel users
            $table->foreign('user_id')
                  ->references('id')
                  ->on('users') // Mengacu ke tabel users
                  ->onDelete('cascade'); // Jika user dihapus, data ini ikut terhapus
            $table->string('nama'); // Nama Dosen
            $table->string('nidn', 10); // NIDN max 10 karakter
            $table->integer('bimbingan_mahasiswa_ps'); // Jumlah bimbingan mahasiswa di PS sendiri
            $table->integer('rata_rata_jumlah_bimbingan'); // Rata-rata jumlah bimbingan
            $table->integer('bimbingan_mahasiswa_ps_lain'); // Jumlah bimbingan mahasiswa di PS lain
            $table->integer('rata_rata_jumlah_bimbingan_seluruh_ps'); // Rata-rata keseluruhan
            $table->timestamps(); // created_at & updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pelaksanaan_ta');
    }
};
