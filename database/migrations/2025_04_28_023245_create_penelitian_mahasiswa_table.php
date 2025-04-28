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
        Schema::create('penelitian_mahasiswa', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')
                  ->references('id')
                  ->on('users') // Mengacu ke tabel users
                  ->onDelete('cascade'); // Jika user dihapus, data ini ikut terhapus
            $table->string('judul_penelitian'); // Judul penelitian
            $table->string('nama_mahasiswa'); // Nama mahasiswa
            $table->string('nama_pembimbing')->nullable(); // Nama pembimbing (boleh null)
            $table->enum('tingkat', ['Internasional', 'Nasional', 'Lokal']); // Tingkat
            $table->string('sumber_dana'); // Sumber dana
            $table->enum('kesesuaian_roadmap', ['Sesuai', 'Kurang Sesuai', 'Tidak Sesuai']); // Kesesuaian roadmap
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penelitian_mahasiswa');
    }
};
