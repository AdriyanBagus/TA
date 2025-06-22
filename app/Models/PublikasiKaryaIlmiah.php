<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PublikasiKaryaIlmiah extends Model
{
    protected $table = 'publikasi_karya_ilmiah';
    protected $fillable = [
        'user_id',
        'judul_penelitian',
        'judul_publikasi',
        'nama_author',
        'nama_jurnal',
        'jenis',
        'tingkat',
        'url',
        'tahun_akademik_id'
    ];
}
