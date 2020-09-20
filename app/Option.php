<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    protected $fillable = ['image', 'value' ,'value_en','value_ar', 'choice_id', 'is_color'];

    public function Color()
    {
        return $this->belongsTo(Color::class , 'value_en' , 'code');
    }

    public function Choice()
    {
        return $this->belongsTo(Choice::class , 'choice_id' );
    }
}
