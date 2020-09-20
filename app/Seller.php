<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Seller extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
        public function payment_methods()
    {
        return $this->hasMany(PaymentMethod::class, 'seller_id','id');
    }
    
}
