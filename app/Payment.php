<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = ['seller_id' , 'affiliate_id' , 'amount' , 'payment_details' , 'payment_method' , 'status', 'type'];

    public function Affiliate()
    {
        return $this->belongsTo(Affiliate::class , 'affiliate_id')->with('User');
    }
}
