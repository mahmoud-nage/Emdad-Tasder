<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use SoftDeletes;
    protected $fillable = ['name','city_id' ,'area_id' ,'building_no', 'zone_id' , 'address_details' , 'special_mark' , 'zone_id' , 'floor_no' , 'apartment_no' , 'phone' , 'user_id','postal_code','country_id'];

    public function Area()
    {
        return $this->belongsTo(Area::class , 'area_id');
    }

    public function City()
    {
        return $this->belongsTo(City::class , 'city_id');
    }

    public function Zone()
    {
        return $this->belongsTo(Zone::class , 'zone_id');
    }
}
