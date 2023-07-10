<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;
    use ModelCommonMethodTrait;

    protected $fillable = [
        'name',
        'default',
        'state_id',
        'code'
    ];
    

    public function state()
    {
        # code...   
        return $this->belongsTo(State::class, 'state_id', 'id');
    }
}
