<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FormUserSetting extends Model
{
    protected $fillable = [
        'user_id',
        'form_name',
        'is_enable',
    ];
}
