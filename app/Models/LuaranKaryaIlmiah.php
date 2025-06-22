<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LuaranKaryaIlmiah extends Model
{
    protected $table = 'luaran_karya_ilmiah';

    protected $fillable = [
        'user_id',
        'judul_kegiatan',
        'judul_karya',
        'pencipta_utama',
        'jenis',
        'nomor_karya',
        'url',
        'tahun_akademik_id'
    ];
}
