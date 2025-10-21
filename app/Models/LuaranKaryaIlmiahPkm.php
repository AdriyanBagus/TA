<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LuaranKaryaIlmiahPkm extends Model
{
    protected $table = 'luaran_karya_ilmiah_pkm';
    protected $fillable = [
        'user_id',
        'judul_kegiatan_pkm',
        'judul_karya',
        'dosen',
        'mahasiswa',
        'penyusun_utama',
        'jenis',
        'nomor_karya',
        'keterangan'
    ];
}
