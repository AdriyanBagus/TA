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
            $table->string('nipy', 8); // NIPY, varchar(8)
            $table->string('kualifikasi_pendidikan'); // Kualifikasi Pendidikan
            $table->string('jabatan'); // Jabatan
            $table->enum('kesesuaian_bidang_kerja', ['ya', 'tidak']); // Kesesuaian Bidang Kerja
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
