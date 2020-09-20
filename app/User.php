<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'birth_date', 'provider_id', 'avatar', 'avatar_original', 'address', 'birth_date', 'country',
        'city', 'area', 'zone', 'postal_code','user_type', 'reset_code', 'phone', 'balance', 'api_token','fcm_token','gender'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token'
    ];

    public function wishlists()
    {
        return $this->hasMany(Wishlist::class);
    }
    public function Complaints()
    {
        return $this->Complaint(Wishlist::class);
    }

    public function customer()
    {
        return $this->hasOne(Customer::class);
    }

    public function seller()
    {
        return $this->hasOne(Seller::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function shop()
    {
        return $this->hasOne(Shop::class);
    }

    public function Affiliate()
    {
        return $this->hasOne(Affiliate::class);
    }

    public function staff()
    {
        return $this->hasOne(Staff::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function wallets()
    {
        return $this->hasMany(Wallet::class)->orderBy('created_at', 'desc');
    }

    public function addresses()
    {
        return $this->hasMany(Address::class);
    }

    public function Country()
    {
        return $this->belongsTo(Country::class , 'country' , 'code');
    }

    public function City()
    {
        return $this->belongsTo(City::class , 'city');
    }

    public function Area()
    {
        return $this->belongsTo(Area::class , 'area');
    }

    public function Zone()
    {
        return $this->belongsTo(Zone::class , 'zone');
    }

    public function notifications()
    {
        return $this->belongsToMany(Notification::class, 'user_notifications');
    }


    public function productReviews()
    {
        return $this->hasMany(ProductReview::class)->with('product');
    }
        public function reviews()
    {
        return $this->hasMany(Review::class);
    }
    
        public function seller_payments()
    {
        return $this->hasMany(SellerPayment::class , 'seller_id','id');
    }
    
    

}
