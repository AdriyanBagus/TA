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
            $table->string('lahan_praktek'); // Nama lahan praktek
            $table->string('akreditasi'); // Status akreditasi
            $table->string('kesesuaian_bidang_keilmuan'); // Kesesuaian bidang keilmuan
            $table->integer('jumlah_mahasiswa'); // Jumlah mahasiswa yang diterima
            $table->integer('daya_tampung_mahasiswa'); // Daya tampung maksimal mahasiswa
            $table->string('kontribusi_lahan_praktek'); // Kontribusi lahan praktek terhadap pembelajaran
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
