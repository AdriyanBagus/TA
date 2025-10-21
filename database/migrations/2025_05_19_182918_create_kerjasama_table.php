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
        Schema::create('kerjasama', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // Foreign Key mengacu ke tabel users
            $table->foreign('user_id')
                  ->references('id')
                  ->on('users') // Mengacu ke tabel users
                  ->onDelete('cascade'); // Jika user dihapus, data ini ikut terhapus
            
            $table->text('lembaga_mitra'); // Lembaga Mitra
            $table->enum('jenis_kerjasama', ['pendidikan', 'penelitian', 'pengabdian kepada masyarakat']); // Jenis Kerjasama
            $table->enum('tingkat', ['internasional', 'nasional', 'lokal']); // Tingkat Kerjasama
            $table->text('judul_kerjasama'); // Judul Kerjasama
            $table->text('waktu_durasi'); // Waktu & Durasi Kerjasama
            $table->text('realisasi_kerjasama'); // Realisasi Kerjasama
            $table->boolean('spk', ['ya', 'tidak']); // SPK (1 = Ya, 0 = Tidak)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kerjasama');
    }
};
