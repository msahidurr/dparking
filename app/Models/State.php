<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    use HasFactory;
    use ModelCommonMethodTrait;
    protected $fillable = [
        'name',
        'default',
        'code',
        'country_id',
        'status',
    ];
    public function country()
    {
        # code...   
        return $this->belongsTo(Country::class, 'country_id', 'id');
    }
}
