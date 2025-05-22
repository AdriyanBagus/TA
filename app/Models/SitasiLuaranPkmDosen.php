<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SitasiLuaranPkmDosen extends Model
{
    protected $table = 'sitasi_luaran_pkm_dosen';

    protected $fillable = [
        'user_id',
        'nama',
        'judul_artikel',
        'jumlah_sitasi',
        'link_sitasi',
    ];
}
