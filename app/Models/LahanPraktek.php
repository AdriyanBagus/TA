<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LahanPraktek extends Model
{
    protected $table = 'lahan_praktek';

    protected $fillable = [
        'user_id',
        'lahan_praktek',
        'akreditasi',
        'kesesuaian_bidang_keilmuan',
        'jumlah_mahasiswa',
        'daya_tampung_mahasiswa',
        'kontribusi_lahan_praktek',
    ];
}
