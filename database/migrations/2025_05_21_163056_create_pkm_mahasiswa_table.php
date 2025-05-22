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
        Schema::create('pkm_mahasiswa', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // Foreign Key mengacu ke tabel users
            $table->foreign('user_id')
                  ->references('id')
                  ->on('users') // Mengacu ke tabel users
                  ->onDelete('cascade'); // Jika user dihapus, data ini ikut terhapus
            $table->text('mahasiswa');
            $table->string('pembimbing');
            $table->text('judul_pkm');
            $table->enum('tingkat', ['internasional', 'nasional', 'lokal']);
            $table->string('sumber_dana');
            $table->enum('kesesuaian_roadmap', ['sesuai', 'kurang sesuai', 'tidak_sesuai']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pkm_mahasiswa');
    }
};
