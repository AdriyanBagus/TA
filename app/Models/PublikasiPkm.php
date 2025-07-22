<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PublikasiPkm extends Model
{
    protected $table = 'publikasi_pkm';
    protected $fillable = [
        'user_id',
        'tahun_akademik_id',
        'judul_pkm',
        'judul_publikasi',
        'nama_author',
        'jenis',
        'tingkat',
        'url',
        'detail_publikasi', // <-- DITAMBAHKAN
        'parent_id'
    ];

    protected $casts = [
        'detail_publikasi' => 'json',
    ];
}
