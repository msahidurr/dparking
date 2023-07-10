<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;
    use ModelCommonMethodTrait;

    protected $fillable = [
        'name',
        'default',
        'short_code',
        'phone_code',
        'status',
    ];
}
