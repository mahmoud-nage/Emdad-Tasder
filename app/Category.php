<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Product;

class Category extends Model
{
    public function subcategories(){
    	return $this->hasMany(SubCategory::class);
    }
    public function products(){
    	return $this->hasMany(Product::class);
    }
}
