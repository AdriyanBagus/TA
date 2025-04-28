<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProfilDosen extends Model
{
    protected $table = 'profil_dosen';

    protected $fillable = [
        'user_id',
        'nama',
        'nidn',
        'kualifikasi_pendidikan',
        'sertifikasi_pendidik_profesional',
        'bidang_keahlian',
        'bidang_ilmu_prodi',
    ];
}
