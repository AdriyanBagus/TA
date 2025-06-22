<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RekognisiDosen extends Model
{
    protected $table = 'rekognisi_dosen';

    protected $fillable = [
        'user_id',
        'nama',
        'nidn',
        'nama_kegiatan_rekognisi',
        'tingkat',
        'bahan_ajar',
        'tahun_perolehan',
        'url',
        'tahun_akademik_id'
    ];
}
