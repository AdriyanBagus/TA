<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class menuDosen extends Model
{
    protected $table = 'menudosen';

    protected $fillable = [
        'menu',
        'link',
    ];
}
