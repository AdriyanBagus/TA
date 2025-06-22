<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProfilDosenTidakTetap extends Model
{
    protected $table = 'profil_dosen_tidak_tetap';

    protected $fillable = [
        'user_id',
        'nama',
        'asal_instansi',
        'kualifikasi_pendidikan',
        'sertifikasi_pendidik_profesional',
        'status',
        'bidang_keahlian',
        'bidang_ilmu_prodi',
    ];
}
