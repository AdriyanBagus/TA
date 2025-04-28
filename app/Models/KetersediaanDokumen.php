<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KetersediaanDokumen extends Model
{
    protected $table = 'ketersediaan_dokumen';

    protected $fillable = [
        'user_id',
        'kegiatan',
        'ketersediaan_dokumen',
        'nomor_dokumen'
    ];
}
