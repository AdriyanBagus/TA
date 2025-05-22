<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kerjasama extends Model
{
    protected $table = 'kerjasama';
    protected $fillable = [
        'user_id', 
        'lembaga_mitra',
        'jenis_kerjasama', 
        'tingkat', 
        'judul_kerjasama', 
        'waktu_durasi',
        'realisasi_kerjasama', 
        'spk'
    ];
}
