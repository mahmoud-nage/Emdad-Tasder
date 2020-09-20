<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    protected $table = "packges";
    protected $fillable = ['name','image'];
}
