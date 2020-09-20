<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Affiliate extends Model
{
    protected $fillable = ['user_id' , 'is_approved' , 'SSN' , 'full_name' , 'facebook' , 'twitter' , 'youtube'];

    public function User()
    {
        return $this->belongsTo(User::class);
    }

    public function Coupon()
    {
        return $this->hasOne(CouponAffiliate::class);
    }
}
