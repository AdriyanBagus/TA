<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PkmMahasiswa extends Model
{
    protected $table = 'pkm_mahasiswa';
    protected $fillable = [
        'user_id',
        'mahasiswa',
        'pembimbing',
        'judul_pkm',
        'tingkat',
        'sumber_dana',
        'kesesuaian_roadmap',
    ];

}
