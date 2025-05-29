<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notifikasi extends Model
{
    protected $table = 'notifikasi';
    protected $fillable = [
        'prodi_id',
        'user_id',
        'pesan',
        'nama_tabel',
        
    ];

    public function prodi()
    {
        return $this->belongsTo(User::class, 'prodi_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
