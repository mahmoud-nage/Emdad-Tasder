<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AramexPickup extends Model
{
    protected $fillable =['pickupId' ,'pickupGUID', 'shipment_count','status'];
}
