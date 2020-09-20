<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CouponUrl extends Model
{
    protected $fillable =['type' ,'url' ,'visits', 'tag1' ,'tag2', 'tag3' ,'tag4', 'tag5' , 'orders_pend','orders_complete', 'coupon_affiliate_id','affiliate_id'];

    public function CouponAffiliate()
    {
        return $this->belongsTo(CouponAffiliate::class , 'coupon_affiliate_id');
    }
}
