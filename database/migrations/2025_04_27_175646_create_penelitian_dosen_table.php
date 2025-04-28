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
        Schema::create('penelitian_dosen', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')
                  ->references('id')
                  ->on('users') // Mengacu ke tabel users
                  ->onDelete('cascade'); // Jika user dihapus, data ini ikut terhapus
            $table->string('judul_penelitian'); // Judul Penelitian
            $table->string('nama_dosen_peneliti'); // Nama Dosen Peneliti
            $table->string('nama_mahasiswa')->nullable(); // Nama Mahasiswa, boleh null
            $table->enum('tingkat', ['internasional', 'nasional', 'lokal']); // Tingkat (enum)
            $table->string('sumber_dana'); // Sumber Dana Penelitian
            $table->enum('kesesuaian_roadmap', ['sesuai', 'kurang sesuai', 'tidak sesuai']); // Kesesuaian Roadmap
            $table->string('bentuk_integrasi'); // Bentuk Integrasi (contohnya: penelitian-terapan ke kuliah)
            $table->string('mata_kuliah'); // Mata Kuliah terkait
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penelitian_dosen');
    }
};
