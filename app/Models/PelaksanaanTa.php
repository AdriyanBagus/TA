<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PelaksanaanTa extends Model
{
    protected $table = 'pelaksanaan_ta';

    protected $fillable = [
        'user_id',
        'nama',
        'nidn',
        'bimbingan_mahasiswa_ps_sendiri',
        'rata_rata_jumlah_bimbingan_ps_sendiri',
        'bimbingan_mahasiswa_ps_lain',
        'rata_rata_jumlah_bimbingan_ps_lain',
        'rata_rata_jumlah_bimbingan_seluruh_ps',
        'tahun_akademik_id',
        'parent_id'
    ];
}
