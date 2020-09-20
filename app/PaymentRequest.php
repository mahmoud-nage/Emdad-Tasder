<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaymentRequest extends Model
{

    protected $fillable = ["affiliate_id","amount","payment_method","name","national_id","bank_name","banck_account_number","paypal_email","order_ids"];

    public function Affiliate()
    {
        return $this->belongsTo(Affiliate::class , 'affiliate_id')->with('User');
    }
}
