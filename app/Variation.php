<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Variation extends Model
{
    protected $fillable = ['choices_values' , 'sku' , 'qty' , 'price' , 'product_id' , 'product_country_id', 'status'];

    protected $casts =['choices_values' => 'array'];

    public function getChoice()
    {
        $data = '';
        // dd(json_decode($this->choices_values));
        foreach (json_decode($this->choices_values) as $key =>  $choices_value) {
            $option = Option::find($choices_value);
            $val = $option->is_color == 1 ? $option->Color->name : $option['value_'.app()->getLocale()];
            $title = $option->Choice['name_'.app()->getLocale()];
            $data .= $key > 0 ? ' ,'.$title.' : '.$val : $title.' : '.$val;
        }
        return $data;
    }
}
