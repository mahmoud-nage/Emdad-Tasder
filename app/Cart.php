<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $fillable = ['user_id','tax','price','variation_id', 'session_id' , 'product_id', 'options_id', 'amount'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

//    public function option()
//    {
//        return $this->belongsTo(Option::class, 'option_id', 'id');
//    }

}
