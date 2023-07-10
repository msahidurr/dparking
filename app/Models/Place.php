<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Place extends Model
{
    use ModelCommonMethodTrait;
    protected $fillable = [
        'id',
        'name',
        'description',
        'status',
        'created_by',
        'modified_by'
    ];

    public function categories()
    {
        return $this->hasMany('App\Models\Category');
    }
   
}
