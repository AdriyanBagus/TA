<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RekognisiTenagaKependidikan extends Model
{
    protected $table = 'rekognisi_tenaga_kependidikan';

    protected $fillable = [
        'user_id',
        'nama',
        'bidang_keahlian',
        'jenis_rekognisi',
        'tingkat',
        'tahun_perolehan',
    ];
}
