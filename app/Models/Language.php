<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    use ModelCommonMethodTrait;
    protected $fillable = [
        'place_id',
        'name',
        'code',
        'flag',
        'country_id',
        'status'
    ];

    /**
     * This function 
     *
     * @author      Md. Al-Mahmud <mamun120520@gmail.com>
     * @version     1.0
     * @see         
     * @since       06/26/2022
     * Time         14:56:27
     * @param       
     * @return      
     */
    public function country()
    {
        # code...   
        return $this->belongsTo(Country::class, 'country_id', 'id');
    }
    #end

}
