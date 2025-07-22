<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MenuTendik extends Model
{
    protected $table = 'menutendik';

    protected $fillable = [
        'menu',
        'link',
    ];
}
