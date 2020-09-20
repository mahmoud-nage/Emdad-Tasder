<?php

namespace App;

use App\City;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Area extends Model
{
    protected $fillable = ['name_en' , 'name_ar', 'delivery_price', 'delivery_time', 'is_active', 'city_id'];

    public function City()
    {
        return $this->belongsTo(City::class, 'city_id');
    }
}
