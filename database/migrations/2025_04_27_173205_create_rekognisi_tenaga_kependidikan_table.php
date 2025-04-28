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
            $table->string('nama'); // Nama tenaga kependidikan
            $table->string('bidang_keahlian'); // Bidang Keahlian
            $table->string('jenis_rekognisi'); // Jenis Rekognisi
            $table->string('tingkat'); // Tingkat Rekognisi (bisa diisi misal Nasional, Internasional, dll)
            $table->string('tahun_perolehan'); // Tahun perolehan
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
