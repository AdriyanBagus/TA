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
        Schema::create('luaran_karya_ilmiah_pkm', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // Foreign Key mengacu ke tabel users
            $table->foreign('user_id')
                  ->references('id')
                  ->on('users') // Mengacu ke tabel users
                  ->onDelete('cascade'); // Jika user dihapus, data ini ikut terhapus
            $table->text('judul_kegiatan_pkm');
            $table->text('judul_karya');
            $table->string('dosen')->nullable();
            $table->string('mahasiswa')->nullable();
            $table->enum('penyusun_utama', ['dosen', 'mahasiswa']);
            $table->string('jenis')->nullable();
            $table->string('nomor_karya')->nullable();
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('luaran_karya_ilmiah_pkm');
    }
};
