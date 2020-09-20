<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = [
        'title', 'body','user_id','appointment_id','seen','type','reservation_id','message_id','is_admin',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class , 'user_notifications');
    }
}
