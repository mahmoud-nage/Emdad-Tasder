<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Seller;
use App\User;

class ReportController extends Controller
{
    public function stock_report(Request $request)
    {
        $cat = 0;
        if($request->has('category_id')){
            $cat = $request->category_id;
            $products = Product::where('category_id', $request->category_id)->get();
        }
        else{
            $products = Product::all();
        }
        return view('reports.stock_report', compact('products', 'cat'));
    }

    public function in_house_sale_report(Request $request)
    {
        $cat = 0;
        if($request->has('category_id')){
            $cat = $request->category_id;
            $products = Product::where('category_id', $request->category_id)->orderBy('num_of_sale', 'desc')->get();
        }
        else{
            $products = Product::orderBy('num_of_sale', 'desc')->get();
        }
        return view('reports.in_house_sale_report', compact('products', 'cat'));
    }

    public function seller_report(Request $request)
    {
        $status = 2;
        if($request->has('verification_status')){
            $status = $request->verification_status;
            $sellers = Seller::where('verification_status', $request->verification_status)->get();
        }
        else{
            $sellers = Seller::all();
        }
        return view('reports.seller_report', compact('sellers', 'status'));
    }

    public function seller_sale_report(Request $request)
    {
        $status = 2;
        if($request->has('verification_status')){
            $status = $request->verification_status;
            $sellers = Seller::where('verification_status', $request->verification_status)->get();
        }
        else{
            $sellers = Seller::all();
        }
        return view('reports.seller_sale_report', compact('sellers', 'status'));
    }

    public function wish_report(Request $request)
    {
        $cat = 0;
        if($request->has('category_id')){
            $cat = $request->category_id;
            $products = Product::where('category_id', $request->category_id)->get();
        }
        else{
            $products = Product::all();
        }
        return view('reports.wish_report', compact('products', 'cat'));
    }
}
