<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SitasiLuaranPenelitianDosen extends Model
{
    protected $table = 'sitasi_luaran_penelitian_dosen';
    protected $fillable = [
        'user_id',
        'nama',
        'judul_artikel',
        'jumlah_sitasi',
        'link_sitasi',
    ];
}
