<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SellerPayment extends Model
{
    protected $fillable = ["seller_id","amount","payment_method","status","file","order_ids","seller_id"];
    protected $table = 'seller_payments';

    
    public function user()
    {
        return $this->belongsTo(User::class , 'Seller_id', 'id');
    }

}
