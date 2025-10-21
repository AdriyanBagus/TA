<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TahunAkademik extends Model
{
    protected $table = 'tahun_akademik';
    
    protected $fillable = ['tahun','tanggal_mulai', 'tanggal_batas_pengisian', 'is_active'];
}
