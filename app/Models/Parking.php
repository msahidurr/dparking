<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\ModelCommonMethodTrait;
use Carbon\Carbon;

class Parking extends Model
{
	use ModelCommonMethodTrait;

	protected $with = ['tariff'];

	protected $appends = ['tariff_start_at', 'tariff_end_at'];

	protected $fillable = [
		'id',
		'place_id',
		'slot_id',
		'category_id',
		'vehicle_no',
		'rfid_no',
		'barcode',
		'driver_id',
		'driver_mobile',
		'in_time',
		'out_time',
		'amount',
		'paid',
		'status',
		'tariff_id',
		'created_by',
		'modified_by',
		'owner_id',
		'id_number',
		'fine_amount',
	];
	
	protected $guarded = [];

	protected $casts = [
		'in_time' => 'datetime:m-d-Y H:i:s',
		'out_time' => 'datetime:m-d-Y H:i:s',
	];

	public function getTariffStartAtAttribute()
	{
		if($this->in_time) {
			return Carbon::parse($this->in_time)->format(env('DATE_FORMAT','m-d-Y h:i A'));
		}
		return "";
	}

	public function getTariffEndAtAttribute()
	{
		if(isset($this->tariff->type)) {
			return Carbon::parse($this->in_time)->addDays($this->tariff->type)->format(env('DATE_FORMAT','m-d-Y h:i A'));
		}

		return "";
	}

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

	public function slot()
	{
		return $this->belongsTo('App\Models\CategoryWiseFloorSlot','slot_id');
	}
	public function tariff()
	{
		return $this->belongsTo('App\Models\Tariff','tariff_id');
	}
	
	public function place()
	{
		return $this->belongsTo('App\Models\Place');
	}

	public function rfid_entry()
	{
		return $this->hasOne('App\Models\RfidDeviceEntry');
	}
}
