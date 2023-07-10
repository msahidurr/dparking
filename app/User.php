<?php

namespace App;

use App\Models\Language;
use App\Models\ModelCommonMethodTrait;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Auth\MustVerifyEmail as MustVerifyEmailTrait;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable, MustVerifyEmailTrait, ModelCommonMethodTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'place_id', 'language_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function roles()
    {
        return $this->belongsToMany('App\Models\Role');
    }

    public function hasRole($roles)
    {
        if (!is_array($roles)) {
            $roles = [$roles];
        }

        return (bool) $this->roles()->whereIn('name', $roles)->first();
    }

    /**
     * This function 
     *
     * @author      Md. Al-Mahmud <mamun120520@gmail.com>
     * @version     1.0
     * @see         
     * @since       06/30/2022
     * Time         12:29:19
     * @param       
     * @return      
     */
    public function language()
    {
        # code...   
        return $this->belongsTo(Language::class, 'language_id', 'id');
    }
    #end


}
