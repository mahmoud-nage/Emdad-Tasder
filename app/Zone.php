<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Zone extends Model
{
    use SoftDeletes;
    protected $fillable = ['name_en' , 'name_ar' , 'area_id' , 'delivery_price', 'is_active'];

    public function Area()
    {
        return $this->belongsTo(Area::class , 'area_id');
    }
}
