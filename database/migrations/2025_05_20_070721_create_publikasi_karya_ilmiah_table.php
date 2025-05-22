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
        Schema::create('publikasi_karya_ilmiah', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // Foreign Key mengacu ke tabel users
            $table->foreign('user_id')
                  ->references('id')
                  ->on('users') // Mengacu ke tabel users
                  ->onDelete('cascade'); // Jika user dihapus, data ini ikut terhapus
            $table->string('judul_penelitian');
            $table->string('judul_publikasi');
            $table->string('dosen');
            $table->string('mahasiswa');
            $table->string('dipublikasikan');
            $table->string('penerbit');
            $table->string('jenis');
            $table->string('tingkat');
            $table->enum('penyusun', ['dosen', 'mahasiswa']);
            $table->string('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('publikasi_karya_ilmiah');
    }
};
