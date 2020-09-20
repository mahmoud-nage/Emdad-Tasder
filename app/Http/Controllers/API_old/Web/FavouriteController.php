<?php

namespace App\Http\Controllers\API\Web;

use App\Favourite;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FavouriteController extends Controller
{
    public function index(Request $request)
    {
        $data = User::find($request->input('user_id'))->favourites;
        return response()->json(['status' => 200 , 'data' => $data]);

    }
    public function store(Request $request)
    {
        $favourite = Favourite::where('meal_id' , $request->input('meal_id'))->where('user_id' , $request->input('user_id'))->first();
        if (isset($favourite)){
            Favourite::where('id' , $favourite->id)->delete();
            $message = 'This meal has been removed from favourites';
        } else {
            $favourite = Favourite::create([
                'meal_id' => $request->input('meal_id'),
                'user_id' => $request->input('user_id'),
            ]);
            $message = 'This meal has been added to favourites';
        }
        return response()->json(['status' => 200 , 'message' => $message]);
    }
}
