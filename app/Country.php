<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $fillable = [ 'name_ar' , 'name_en' , 'code' . 'icon' , 'currency_id'];

    public function Currency()
    {
        return $this->belongsTo(Currency::class , 'currency_id');
    }
    public function products()
    {
        return $this->belongsToMany(Product::class , 'product_countries')->where('published', 1);
    }
    public function deliveries()
    {
        return $this->belongsToMany(Delivery::class , 'delivery_countries');
    }
}
