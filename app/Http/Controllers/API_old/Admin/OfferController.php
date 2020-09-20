<?php

namespace App\Http\Controllers\API\Admin;

use App\Offer;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OfferController extends Controller
{
    public function index(Request $request)
    {
        $data = Offer::with('Meal')->where('start_date', '<=', Carbon::now()->toDateString())->where('end_date', '>=', Carbon::now()->toDateString())->latest()->paginate(20);
        if ($request->input('type') == 'not_available'){
            $data = Offer::with('Meal')->where('start_date', '>=', Carbon::now()->toDateString())->where('end_date', '<=', Carbon::now()->toDateString())->latest()->paginate(20);
        }
        return response()->json(['status' => 200 , 'data' => $data]);
    }
}
