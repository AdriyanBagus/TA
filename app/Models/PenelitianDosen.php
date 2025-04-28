<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PenelitianDosen extends Model
{
    protected $table = 'penelitian_dosen';

    protected $fillable = [
        'user_id',
        'judul_penelitian',
        'nama_dosen_peneliti',
        'nama_mahasiswa',
        'tingkat',
        'sumber_dana',
        'kesesuaian_roadmap',
        'bentuk_integrasi',
        'mata_kuliah',
    ];
}
