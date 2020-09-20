<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Shipper extends Model
{
        protected $fillable = [
        'name', 'contact_name', 'address', 'address2', 'city_id', 'country_id', 'phone', 'phone2','email'];
        
    public function country()
    {
        return $this->belongsTo(Country::class ,'id');
    }

    public function city()
    {
        return $this->belongsTo(City::class ,'city_id');
    }
}
