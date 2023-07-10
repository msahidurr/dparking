<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RfidVehicle extends Model
{
    use HasFactory;
    use ModelCommonMethodTrait;
    protected $fillable = [
        'id',
        'category_id',
        'vehicle_no',
        'rfid_no',
        'driver_name',
        'driver_mobile',
        'status',
        'created_by',
        'modified_by'
    ];

    public function category()
    {
        return $this->belongsTo('App\Models\Category');
    }

    public function create_by()
    {
        return $this->belongsTo('App\User','created_by');
    }

    public function modified()
    {
        return $this->belongsTo('App\User','id','modified_by');
    }
}
