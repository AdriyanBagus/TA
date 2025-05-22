<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BebanKinerjaDosen extends Model
{
    protected $table = 'beban_kinerja_dosen';
    protected $fillable = [
        'user_id','nama', 'nidn', 'ps_sendiri','ps_lain','ps_diluar_pt', 'penelitian', 'pkm', 'penunjang', 'jumlah_sks', 'rata_rata_sks'
    ];
}
