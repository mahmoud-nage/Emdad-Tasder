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
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'country_id' => 'required|exists:countries,id',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 500, 'message' => $validator->errors()->messages()], 500);
        }
        $addresses = Address::with('City', 'Area', 'Zone')
            ->where('user_id', $request->input('user_id'))
            ->where('country_id', $request->country_id)->latest()->get();
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
            ];
        }
        return response()->json(['status' => 200, 'data' => $data]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'api_token' => 'required|exists:users,api_token',
            'user_id' => 'required|exists:users,id',
            'phone' => 'required|min:8',
            'name' => 'required',
            'address_details' => 'required',
            'city_id' => 'required|exists:cities,id',
            'country_id' => 'required|exists:countries,id',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 500, 'message' => $validator->errors()->messages()], 500);
        }

        $address = Address::create([
            'phone' => $request->input('phone'),
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'user_id' => $request->input('user_id'),
            'address_details' => $request->input('address_details'),
            'city_id' => $request->input('city_id'),
            'country_id' => $request->input('country_id'),
            'area_id' => '',
            'zone_id' => '',
            'building_no' => $request->input('building_no'),
            'floor_no' => $request->input('floor_no'),
            'apartment_no' => $request->input('apartment_no'),
            'special_mark' => $request->input('special_mark'),
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

    public function show(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'address_id' => 'required|exists:addresses,id',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 500, 'message' => $validator->errors()->messages()], 500);
        }

        $address = Address::with('City', 'Area', 'Zone')->where('id', $request->input('address_id'))->first();
        return response()->json(['status' => 200, 'data' => $address]);
    }
}
