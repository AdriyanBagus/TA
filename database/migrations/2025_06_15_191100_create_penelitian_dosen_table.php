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
            $table->text('judul_penelitian'); // Judul Penelitian
            $table->text('nama_dosen_peneliti'); // Nama Dosen Peneliti
            $table->text('nama_mahasiswa')->nullable(); // Nama Mahasiswa, boleh null
            $table->enum('tingkat', ['Internasional', 'Nasional', 'Lokal']); // Tingkat (enum)
            $table->string('sumber_dana')->nullable(); // Sumber Dana Penelitian
            $table->enum('bentuk_dana', ['Inkind', 'Cash']);
            $table->string('jumlah_dana')->nullable(); // Jumlah Dana
            $table->enum('kesesuaian_roadmap', ['sesuai', 'kurang sesuai', 'tidak sesuai']); // Kesesuaian Roadmap
            $table->string('bentuk_integrasi')->nullable(); // Bentuk Integrasi (contohnya: penelitian-terapan ke kuliah)
            $table->text('mata_kuliah')->nullable(); // Mata Kuliah terkait
            $table->unsignedBigInteger('tahun_akademik_id')->nullable(); // Foreign Key mengacu ke tabel tahun akademik id
            $table->foreign('tahun_akademik_id')
                  ->references('id')
                  ->on('tahun_akademik') // Mengacu ke tabel tahun akademik
                  ->onDelete('cascade'); // Jika user dihapus, data ini ikut terhapus
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
