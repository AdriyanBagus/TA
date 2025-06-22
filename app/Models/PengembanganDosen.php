<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PengembanganDosen extends Model
{
    protected $table = 'pengembangan_dosen';
    protected $fillable = [
        'user_id',
        'nama_dosen',
        'nidn',
        'nama_kegiatan',
        'waktu_pelaksanaan',
        'jenis_kegiatan',
        'url',
        'tahun_akademik_id',
    ];
}
