<?php

namespace App;

use App\Models\CategoryWiseFloorSlot;
use App\Models\Language;
use App\Models\ModelCommonMethodTrait;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Auth\MustVerifyEmail as MustVerifyEmailTrait;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable, MustVerifyEmailTrait, ModelCommonMethodTrait,HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'place_id', 'language_id',
        'floor_id',
        'category_wise_floor_slot_id',
        'country_id',
        'state_id',
        'city_id',
        'address',
        'phone_number',
        'role_id',
        'id_number',
        'vehicle_no',
        'driver_owner_id',
        'owner_phone_no',
        'category_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    // public function roles()
    // {
    //     return $this->belongsToMany('App\Models\Role');
    // }

    // public function hasRole($roles)
    // {
    //     if (!is_array($roles)) {
    //         $roles = [$roles];
    //     }

    //     return (bool) $this->roles()->whereIn('name', $roles)->first();
    // }

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
    public function place()
    {
        # code...   
        return $this->belongsTo(Place::class, 'place_id', 'id');
    }

    public function floot()
    {
        # code...   
        return $this->belongsTo(Floor::class, 'floot_id', 'id');
    }

    public function slot()
    {
        # code...   
        return $this->belongsTo(CategoryWiseFloorSlot::class, 'category_wise_floor_slot_id', 'id');
    }

    public function country()
    {
        # code...   
        return $this->belongsTo(Country::class, 'country_id', 'id');
    }

    public function state()
    {
        # code...   
        return $this->belongsTo(State::class, 'state_id', 'id');
    }

    public function city()
    {
        # code...   
        return $this->belongsTo(City::class, 'city_id', 'id');
    }

}
