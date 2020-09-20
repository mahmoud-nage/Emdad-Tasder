<?php

namespace App\Http\Controllers\Affiliate;

use App\Product;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    public function index()
    {
        $country = auth()->user()->Country;
        $affiliate = auth()->user()->Affiliate;
        $products = $country->products()->where('is_affiliate' , 1)->paginate(30);
        return view('affiliate.products.index' , compact('products' , 'affiliate'));
    }

}
