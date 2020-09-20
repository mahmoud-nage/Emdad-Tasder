<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{
    protected $fillable = ['user_id','type' , 'title', 'body'];

    public function User()
    {
        return $this->belongsTo(User::class);
    }
}
