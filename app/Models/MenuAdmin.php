<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MenuAdmin extends Model
{
    protected $table = 'menuAdmin';

    protected $fillable = [
        'menu',
        'link',
    ];
}
