<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LuaranPkm extends Model
{
    protected $table = 'luaran_pkm';

    protected $fillable = [
        'user_id',
        'judul_pkm',
        'judul_karya',
        'pencipta_utama',
        'jenis',
        'nomor_karya',
        'url',
        'tahun_akademik_id',
        'parent_id'
    ];
}
