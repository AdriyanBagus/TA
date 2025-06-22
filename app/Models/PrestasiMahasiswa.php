<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PrestasiMahasiswa extends Model
{
    protected $table = 'prestasi_mahasiswa';

    protected $fillable = [
        'user_id',
        'nama',
        'jenis_prestasi',
        'nama_prestasi',
        'tingkat',
        'tahun',
        'url',
        'tahun_akademik_id'
    ];
}
