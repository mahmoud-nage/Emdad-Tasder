<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CouponAffiliate extends Model
{
    protected $fillable = ['type', 'code', 'details', 'discount', 'discount_type','affiliate_id', 'start_date', 'end_date', ];
}
