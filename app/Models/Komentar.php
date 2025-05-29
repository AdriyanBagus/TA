<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Komentar extends Model
{
    protected $table = 'komentar';
    
    protected $fillable = [
        'prodi_id',
        'nama_tabel',
        'komentar',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'prodi_id', 'id');
    }

}
