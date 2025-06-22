<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PublikasiPkm extends Model
{
    protected $table = 'publikasi_pkm';
    protected $fillable = [
        'user_id',
        'judul_pkm',
        'judul_publikasi',
        'nama_author',
        'nama_jurnal',
        'jenis',
        'tingkat',
        'url',
        'tahun_akademik_id'
    ];
}
