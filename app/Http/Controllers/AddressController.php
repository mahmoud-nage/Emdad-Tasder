<?php

namespace App\Http\Controllers;

use App\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AddressController extends Controller
{
    public function index()
    {
        $addresses = Address::where('user_id', auth()->user()->id)->get();
        return view('web.addresses.index', compact('addresses'));
    }

    public function store(Request $request)
    {
        $this->validate(request(), [
            'phone' => 'required|min:8',
            'city_id' => 'required|exists:cities,id',
            'country_id' => 'required|exists:countries,code',
            'address_details' => 'required',
            'building_no' => 'required',
            'floor_no' => 'required',
            'apartment_no' => 'required',
            'name' => 'required',
        ]);
        Address::create([
            'user_id' => auth()->user()->id,
            'name' => $request->input('name'),
            'country_id' => get_country()->id,
            'city_id' => $request->input('city_id'),
            'area_id' => $request->input('area_id'),
            'zone_id' => $request->input('zone_id'),
            'phone' => $request->input('phone'),
            'address_details' => $request->input('address_details'),
            'building_no' => $request->input('building_no'),
            'floor_no' => $request->input('floor_no'),
            'apartment_no' => $request->input('apartment_no'),
            'special_mark' => $request->input('special_mark'),
            'postal_code' => $request->input('postal_code'),
        ]);
        Session::flash('success', 'Added Successfully');
        return back();
    }

    public function edit($id)
    {
        $address = Address::find($id);
        return view('web.addresses.edit', compact('address'));
    }

    public function update($country,$id, Request $request)
    {
        $this->validate(request(), [
            'phone' => 'required|min:8',
            'country_id' => 'required|exists:countries,code',
            'city_id' => 'required|exists:cities,id',
            'address_details' => 'required',
            'building_no' => 'required',
            'floor_no' => 'required',
            'apartment_no' => 'required',
            'name' => 'required',
        ]);

        Address::where('id', $id)->update([
            'name' => $request->input('name'),
            'country_id' => get_country()->id,
            'city_id' => $request->input('city_id'),
            'area_id' => $request->input('area_id'),
            'zone_id' => $request->input('zone_id'),
            'phone' => $request->input('phone'),
            'address_details' => $request->input('address_details'),
            'building_no' => $request->input('building_no'),
            'floor_no' => $request->input('floor_no'),
            'apartment_no' => $request->input('apartment_no'),
            'special_mark' => $request->input('special_mark'),
            'postal_code' => $request->input('postal_code'),
        ]);

        Session::flash('success', 'Updated Successfully');
        return back();
    }

    public function destroy($id)
    {
        Address::where('id', $id)->delete();
        Session::flash('success', 'Deleted Successfully');
        return back();
    }
}
