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
        Schema::create('profil_dosen_tidak_tetap', function (Blueprint $table) {
            $table->id(); // Primary Key
            $table->unsignedBigInteger('user_id'); // Foreign Key mengacu ke tabel users
            $table->foreign('user_id')
                  ->references('id')
                  ->on('users') // Mengacu ke tabel users
                  ->onDelete('cascade'); // Jika user dihapus, data ini ikut terhapus
            $table->string('nama');
            $table->string('asal_instansi')->nullable();
            $table->string('kualifikasi_pendidikan')->nullable();
            $table->string('sertifikasi_pendidik_profesional')->nullable();
            $table->enum('status', ['Dosen Praktisi']);
            $table->string('bidang_keahlian')->nullable();
            $table->string('bidang_ilmu_prodi')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profil_dosen_tidak_tetap');
    }
};
