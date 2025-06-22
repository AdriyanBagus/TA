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
        Schema::create('rekognisi_tenaga_kependidikan', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')
                  ->references('id')
                  ->on('users') // Mengacu ke tabel users
                  ->onDelete('cascade'); // Jika user dihapus, data ini ikut terhapus
            $table->string('nama'); // Nama Tendik
            $table->text('nama_kegiatan_rekognisi');
            $table->enum('tingkat', ['Internasional', 'Nasional', 'Lokal']); // Tingkat
            $table->enum('bahan_ajar', ['PPT', 'Modul Praktikum', 'Monograf', 'Diktat', 'Buku Ajar', 'Modul Pembelajaran']); // Bahan Ajar
            $table->string('tahun_perolehan'); // Tahun perolehan
            $table->string('url'); 
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
        Schema::dropIfExists('rekognisi_tenaga_kependidikan');
    }
};
