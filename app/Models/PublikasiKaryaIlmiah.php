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
        'dosen',
        'mahasiswa',
        'dipublikasikan',
        'penerbit',
        'jenis',
        'tingkat',
        'penyusun',
        'status'
    ];
}
