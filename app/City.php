<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $fillable = ['name_ar' , 'name_en' ,'country_id','delivery_price'];
    
        public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }
    
}
