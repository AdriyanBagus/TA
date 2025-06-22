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
        Schema::create('profil_tenaga_kependidikan', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')
                  ->references('id')
                  ->on('users') // Mengacu ke tabel users
                  ->onDelete('cascade'); // Jika user dihapus, data ini ikut terhapus
            $table->string('nama'); // Nama
            $table->string('nipy', 10); // NIPY, varchar(8)
            $table->string('kualifikasi_pendidikan')->nullable(); // Kualifikasi Pendidikan
            $table->string('jabatan'); // Jabatan
            $table->string('bidang_keahlian');
            $table->enum('kesesuaian_bidang_kerja', ['Ya', 'Tidak']); // Kesesuaian Bidang Kerja
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
        Schema::dropIfExists('profil_tenaga_kependidikan');
    }
};
