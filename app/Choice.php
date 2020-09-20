<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Choice extends Model
{
    protected $fillable = ['name_ar', 'name_en', 'product_id', 'is_color', 'product_country_id'];

    public function options()
    {
        return $this->hasMany(Option::class);
    }
}
