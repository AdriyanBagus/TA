<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        $tables = [
            'beban_kinerja_dosen',
            'evaluasi_pelaksanaan',
            'profil_dosen',
            'pelaksanaan_ta',
            'kinerja_dtps',
            'kerjasama',
            'ketersediaan_dokumen',
            'profil_dosen_tidak_tetap',
            'profil_tenaga_kependidikan',
            'penelitian_dosen',
            'penelitian_mahasiswa',
            'publikasi_karya_ilmiah',
            'publikasi_karya_ilmiah_pkm',
            'luaran_karya_ilmiah',
            'luaran_karya_ilmiah_pkm',
            'sitasi_luaran_penelitian_dosen',
            'sitasi_luaran_pkm_dosen',
            'pkm_dosen',
            'pkm_mahasiswa',
            'visi_misi',
            'lahan_praktek',
            'rekognisi_tenaga_kependidikan'
        ];

        foreach ($tables as $table) {
            Schema::table($table, function (Blueprint $table) {
                if (!Schema::hasColumn($table->getTable(), 'tahun_akademik_id')) {
                    $table->foreignId('tahun_akademik_id')->nullable()->constrained('tahun_akademik');
                }
            });
        }
    }

    public function down()
    {
        $tables = [
            'beban_kinerja_dosen',
            'evaluasi_pelaksanaan',
            'profil_dosen',
            'pelaksanaan_ta',
            'kinerja_dtps',
            'kerjasama',
            'kerjasama_pendidikan',
            'kerjasama_penelitian',
            'kerjasama_pengabdian_kepada_masyarakat',
            'ketersediaan_dokumen',
            'profil_dosen_tidak_tetap',
            'profil_tenaga_kependidikan',
            'penelitian_dosen',
            'penelitian_mahasiswa',
            'publikasi_karya_ilmiah',
            'publikasi_karya_ilmiah_pkm',
            'luaran_karya_ilmiah',
            'luaran_karya_ilmiah_pkm',
            'sitasi_luaran_penelitian_dosen',
            'sitasi_luaran_pkm_dosen',
            'pkm_dosen',
            'pkm_mahasiswa',
            'visi_misi',
            'lahan_praktek',
            'rekognisi_tenaga_kependidikan'
        ]; // ulangi daftar tabel di sini

        foreach ($tables as $table) {
            Schema::table($table, function (Blueprint $table) {
                if (Schema::hasColumn($table->getTable(), 'tahun_akademik_id')) {
                    $table->dropConstrainedForeignId('tahun_akademik_id');
                }
            });
        }
    }
};
