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
        Schema::create('lahan_praktek', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // Foreign Key mengacu ke tabel users
            $table->foreign('user_id')
                  ->references('id')
                  ->on('users') // Mengacu ke tabel users
                  ->onDelete('cascade'); // Jika user dihapus, data ini ikut terhapus
            $table->text('lahan_praktek'); // Nama lahan praktek
            $table->string('akreditasi')->nullable(); // Status akreditasi
            $table->enum('kesesuaian_bidang_keilmuan', ['Sesuai', 'Tidak Sesuai'])->nullable(); // Kesesuaian bidang keilmuan
            $table->integer('jumlah_mahasiswa')->nullable(); // Jumlah mahasiswa yang diterima
            $table->integer('daya_tampung_mahasiswa')->nullable(); // Daya tampung maksimal mahasiswa
            $table->text('kontribusi_lahan_praktek')->nullable(); // Kontribusi lahan praktek terhadap pembelajaran
            $table->unsignedBigInteger('tahun_akademik_id'); // Foreign Key mengacu ke tabel tahun akademik id
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
        Schema::dropIfExists('lahan_praktek');
    }
};
