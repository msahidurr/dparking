<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [
        'logo',
        'site_title',
        'favicon',
        'login_image',
        'translation'
    ];
}
