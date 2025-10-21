<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BimbinganTaDosen extends Model
{
    protected $table = 'bimbingan_ta_dosen';
    protected $fillable = [
        'user_id',
        'tahun_akademik_id',
        'nama_mahasiswa',
        'prodi_mahasiswa',
        'posisi_dosen', // Dospem 1 atau Dospem 2
        'parent_id', // ID dari bimbingan TA yang terkait
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
}
}
