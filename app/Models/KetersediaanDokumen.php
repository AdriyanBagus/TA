<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KetersediaanDokumen extends Model
{
    protected $table = 'ketersediaan_dokumen';

    protected $fillable = [
        'user_id',
        'dokumen',
        'nomor_dokumen',
        'url',
        'tahun_akademik_id'
    ];
}
