<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use SoftDeletes;
    protected $fillable = ['user_id' , 'message'];

    public function User()
    {
        return $this->belongsTo(User::class);
    }
}
