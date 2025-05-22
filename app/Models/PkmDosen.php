<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PkmDosen extends Model
{
    protected $table = 'pkm_dosen';
    protected $fillable = [
        'user_id',
        'judul_pkm',
        'dosen',
        'mahasiswa',
        'tingkat',
        'sumber_dana',
        'kesesuaian_roadmap',
        'bentuk_integrasi',
        'mata_kuliah',
    ];
}
