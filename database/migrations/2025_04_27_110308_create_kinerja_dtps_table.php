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
        Schema::create('kinerja_dtps', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')
                  ->references('id')
                  ->on('users') // Mengacu ke tabel users
                  ->onDelete('cascade'); // Jika user dihapus, data ini ikut terhapus
            $table->string('nama_dosen'); // Nama Dosen
            $table->string('nidn', 10); // NIDN maksimal 10 karakter
            $table->string('jenis_rekognisi'); // Jenis rekognisi yang diterima
            $table->string('nama_kegiatan'); // Nama kegiatan rekognisi
            $table->enum('tingkat', ['internasional', 'nasional', 'lokal']); // Tingkat: Internasional, Nasional, Lokal
            $table->string('tahun_perolehan'); // Tahun perolehan
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kinerja_dtps');
    }
};
