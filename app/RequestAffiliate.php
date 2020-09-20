<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RequestAffiliate extends Model
{
    protected $fillable = ['affiliate_id' , 'amount' , 'status'];

    public function Affiliate()
    {
        return $this->belongsTo(Affiliate::class);
    }
}
