<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = ['name_ar', 'name_en', 'active', 'date', 'desc_ar', 'desc_en', 'photos'];
}
