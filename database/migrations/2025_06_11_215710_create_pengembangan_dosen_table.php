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
        Schema::create('pengembangan_dosen', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // Foreign Key mengacu ke tabel users
            $table->foreign('user_id')
                  ->references('id')
                  ->on('users') // Mengacu ke tabel users
                  ->onDelete('cascade'); // Jika user dihapus, data ini ikut terhapus
            $table->string('nama_dosen');
            $table->string('nidn', 10);
            $table->text('nama_kegiatan');
            $table->string('waktu_pelaksanaan')->nullable();
            $table->enum('jenis_kegiatan', ['Studi', 'Pelatihan', 'Seminar', 'Workshop']);
            $table->text('url')->nullable(); // URL atau link terkait kegiatan
            $table->unsignedBigInteger('tahun_akademik_id'); // Foreign Key mengacu ke tabel users
            $table->foreign('tahun_akademik_id')
                  ->references('id')
                  ->on('tahun_akademik') // Mengacu ke tabel users
                  ->onDelete('cascade'); // Jika user dihapus, data ini ikut terhapus
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengembangan_dosen');
    }
};
