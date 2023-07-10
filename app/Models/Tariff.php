<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tariff extends Model
{
    use ModelCommonMethodTrait;
    protected $fillable = [
        'id',
        'place_id',
        'name',
        'type',
        'category_id',
        'start_date',
        'end_date',
        'min_amount',
        'amount',
        'status',
        'created_by',
        'modified_by'
    ];
    protected $guarded = [];

    public static function getCurrent($category_id, $place_id)
    {
        $currDate = date('Y-m-d H:i:s');
        return Tariff::where([
            ['end_date', '>=', $currDate],
            ['start_date', '<=', $currDate],
            ['category_id', '=', $category_id],
            ['status', '=', 1],
            ['place_id', '=', $place_id]
        ])->orderBy('id', 'DESC')->first();
    }

    public function category()
    {
        return $this->belongsTo('App\Models\Category');
    }

    public function place()
    {
        return $this->belongsTo('App\Models\Place');
    }
}
