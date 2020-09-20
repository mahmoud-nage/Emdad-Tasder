<?php

namespace App\Http\Controllers\API\Admin;

use App\PromoCode;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PromoCodeController extends Controller
{
    public function index()
    {
        $promos = PromoCode::latest()->paginate(30);
        return response()->json(['status' => 200 , 'data' => $promos]);
    }

    public function destroy($id)
    {
        PromoCode::where('id', $id)->delete();
        return response()->json(['status' => 200, 'message' => 'تم المسح بنجاح'], 200);
    }
}
