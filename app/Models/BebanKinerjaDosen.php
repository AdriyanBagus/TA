<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BebanKinerjaDosen extends Model
{
    protected $table = 'beban_kinerja_dosen';
    protected $fillable = ['nama', 'nidn', 'pengajaran', 'penelitian', 'pkm', 'penunjang', 'jumlah_sks', 'rata_rata_sks'];
}
