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
        Schema::create('sitasi_luaran_pkm_dosen', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // Foreign Key mengacu ke tabel users
            $table->foreign('user_id')
                  ->references('id')
                  ->on('users') // Mengacu ke tabel users
                  ->onDelete('cascade'); // Jika user dihapus, data ini ikut terhapus
            $table->string('nama');
            $table->text('judul_artikel');
            $table->integer('jumlah_sitasi');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sitasi_luaran_pkm_dosen');
    }
};
