<?php

namespace App\Http\Controllers\API;

use App\Address;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AddressController extends Controller
{
    public function index(Request $request)
    {
        $addresses = Address::with('City', 'Area', 'Zone')
            ->where('user_id', $request->input('user_id'))
            ->latest()->get();
        $data = array();
        foreach ($addresses as $address) {
            $data[] = [
                'address_id' => $address->id,
                'name' => $address->name,
                'building_no' => $address->building_no,
                'floor_no' => $address->building_no,
                'apartment_no' => $address->building_no,
                'address_details' => $address->address_details,
                'special_mark' => $address->special_mark,
                'phone' => $address->phone,
                'user_id' => $address->user_id,
                'city_id' => $address->city_id,
                'city_name_ar' => isset($address->City) ? $address->City->name_ar : null,
                'city_name_en' => isset($address->City) ? $address->City->name_en : null,
                'area_id' => $address->area_id,
                'area_name_ar' => isset($address->Area) ? $address->Area->name_ar : null,
                'area_name_en' => isset($address->Area) ? $address->Area->name_en : null,
                'delivery_fees' => isset($address->Area) ? $address->Area->delivery_price : null,
                'delivery_time' => isset($address->Area) ? $address->Area->delivery_time : null,
                'zone_id' => $address->zone_id,
                'zone_name_ar' => isset($address->Zone) ? $address->Zone->name_ar : null,
                'zone_name_en' => isset($address->Zone) ? $address->Zone->name_en : null,
            ];
        }
        return response()->json(['status' => 200, 'data' => $data]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'area_id' => 'required',
            'address_details' => 'required',
            'phone' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 500, 'message' => $validator->errors()->messages()], 500);
        }
        $address = Address::create([
            'area_id' => $request->input('area_id'),
            'user_id' => $request->input('user_id'),
            'zone_id' => $request->input('zone_id'),
            'address_details' => $request->input('address_details'),
            'building_no' => $request->input('building_no'),
            'floor_no' => $request->input('floor_no'),
            'apartment_no' => $request->input('apartment_no'),
            'special_mark' => $request->input('special_mark'),
            'phone' => $request->input('phone'),
            'city_id' => $request->input('city_id'),
            'name' => $request->input('name'),
        ]);
        return response()->json(['status' => 200, 'message' => 'Created Successfully']);
    }

    public function destroy(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'api_token' => 'required',
            'user_id' => 'required|exists:users,id',
            'address_id' => 'required|exists:addresses,id',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 500, 'message' => $validator->errors()->messages()], 500);
        }
        Address::where('id', $request->input('address_id'))->delete();
        return response()->json(['status' => 200, 'message' => 'Deleted Successfully']);
    }
}
