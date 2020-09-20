<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    protected $fillable = ["seller_id","bank_name","branch_name","client_name","phone","national_id","status"];
    protected $table = 'payment_methods';

    
    public function seller()
    {
        return $this->belongsTo(Seller::class ,'seller_id','id');
    }
}
