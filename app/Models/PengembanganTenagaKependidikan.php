<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PengembanganTenagaKependidikan extends Model
{
    protected $table = 'pengembangan_tenaga_kependidikan';
    protected $fillable = [
        'user_id',
        'nama',
        'nipy',
        'nama_kegiatan',
        'waktu_pelaksanaan',
        'jenis_kegiatan',
        'url',
        'tahun_akademik_id',
    ];
}
