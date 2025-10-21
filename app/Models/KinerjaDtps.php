<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KinerjaDtps extends Model
{
    protected $table = 'kinerja_dtps';

    protected $fillable = [
        'user_id',
        'nama_dosen',
        'nidn',
        'jenis_rekognisi',
        'nama_kegiatan',
        'tingkat',
        'tahun_perolehan',
    ];
}
