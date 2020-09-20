<?php

namespace App\Http\Controllers\API\Web;

use App\Address;
use App\Branch;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AddressController extends Controller
{
    public function index(Request $request)
    {
        $addresses = Address::with('City' , 'Area' ,'Zone')->where('user_id' , $request->input('user_id'))->latest()->get();
        return response()->json(['status' => 200 , 'data' => $addresses]);
    }
    public function show(Request $request)
    {
        $address = Address::with('City' , 'Area' ,'Zone')->where('id' , $request->input('address_id'))->first();
        return response()->json(['status' => 200 , 'data' => $address]);
    }
}
