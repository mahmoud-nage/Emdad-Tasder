<?php

namespace App\Http\Controllers;

use App\City;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;


class CityController extends Controller
{
    public function index()
    {
        $cities = City::latest()->get();
        return view('cities.index', compact('cities'));
    }
    
    public function update_shipment_status(Request $request)
    {
        $this->validate(request() , [
            'status' => 'required',
            'id' => 'required',
          ]);

        $city = City::findOrFail($request->id);
        if($request->type == 'smsa'){
            $city->smsa = $request->status;
            $city->aramex = 0;
            
        }elseif($request->type == 'aramex'){
            $city->smsa = 0;
            $city->aramex = $request->status;
        }
        
        if($city->save()){
            flash(__('City Shipment status updated successfully'))->success();
            return 1;
        }
        return 0;
    }
    
      public function create()
    {
        $cities = City::all();
        return view('cities.create' , compact( 'cities'));
    }


    public function store(Request $request)
    {
        $this->validate(request(),[
           'name_ar' => 'required',
           'name_en' => 'required',
           'delivery_price' => 'required',
           'country_id' => 'required',
        ]);

        DB::table('cities')->insert([
            'name_ar' => $request->input('name_ar'),
            'name_en' => $request->input('name_en'),
            'delivery_price' => $request->input('delivery_price'),
            'country_id' => $request->input('country_id'),
        ]);
        return redirect()->route('cities.index');
    }
    
    public function edit($id)
    {
        $id = decrypt($id);
        $city = City::find($id);
        return view('cities.edit' , compact('city'));
    }
    
    
        public function update($id , Request $request)
    {
        $this->validate(request() , [
            'name_en' => 'unique:countries,name_en,'.$id,
          ]);

        $city = City::find($id);
        $city->name_ar = $request->name_ar;
        if($request->has('delivery_price') && $request->delivery_price != null){
            $city->delivery_price = $request->delivery_price;
        }
            
        $city->save();

        flash(__('Updated Successfully'))->success();
        return redirect()->route('cities.index');
    }
    
}
