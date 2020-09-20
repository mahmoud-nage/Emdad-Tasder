<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    protected $fillable = ['name_en', 'name_ar', 'photos', 'desc_ar', 'desc_en', 'video_link'];
}
