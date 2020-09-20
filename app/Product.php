<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function get_price($country_id)
    {
        $product = DB::table('product_countries')->where('product_id', $this->id)->where('country_id', $country_id)->first();
        if (isset($product) && !is_null($product)) {
            return $product->unit_price;
        } else {
            return 0.0;
        }
    }

    public function get_discount($country_id)
    {
        $prod = DB::table('product_countries')->where('product_id', $this->id)->where('country_id', $country_id)->first();

        if (isset($prod) && $prod->discount > 0) {
            $sym = $prod->discount_type == 'amount' ? single_price($prod->discount) : $prod->discount . '%';
            return __('general.discount') . ' ' . $sym;
        }
        return 0;
    }


    public function get_tax($country_id)
    {
        $prod = DB::table('product_countries')->where('product_id', $this->id)->where('country_id', $country_id)->first();
        return $prod->tax . ' ' . $prod->tax_type;
    }

    public function subcategory()
    {
        return $this->belongsTo(SubCategory::class);
    }

    public function subsubcategory()
    {
        return $this->belongsTo(SubSubCategory::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class);
    }

    public function countries()
    {
        return $this->belongsToMany(Country::class, 'product_countries');
    }

    public function choices()
    {
        return $this->hasMany(Choice::class)->with('options');
    }

    public function Variations()
    {
        return $this->hasMany(Variation::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class)->where('status', 1)->with('user');
    }

    public function productReviews()
    {
        return $this->hasMany(ProductReview::class)->with('user');
    }

    public function wishlists()
    {
        return $this->hasMany(Wishlist::class);
    }

    public function unit()
    {
        return $this->hasMany(Unit::class);
    }


}
