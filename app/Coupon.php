<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $fillable = ['type', 'code', 'details', 'discount', 'discount_type', 'start_date', 'end_date', ];
}
