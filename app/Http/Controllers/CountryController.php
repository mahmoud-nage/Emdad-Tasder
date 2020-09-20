<?php

namespace App\Http\Controllers;

use App\Country;
use App\Currency;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\AramexShipmentController;


class CountryController extends Controller
{
    public function index()
    {
        $countries = Country::all();
        return view('countries.index' , compact('countries'));
    }

    public function create()
    {
        $currencies = Currency::all();
        return view('countries.create' , compact( 'currencies'));
    }


    public function store(Request $request)
    {
        $this->validate(request(),[
           'name_ar' => 'required',
           'name_en' => 'required|unique:countries',
           'code' => 'required|unique:countries',
           'icon' => 'required|mimes:jpg,jpeg,png,tiff,webp,gif',
           'currency_id' => 'required',
        ]);
        $path = 'uploads/countries/icons';
        $name = resizeUploadImage($request->icon, $path, $resize_width = 24, $resize_height = 16);
        DB::table('countries')->insert([
            'name_ar' => $request->input('name_ar'),
            'name_en' => $request->input('name_en'),
            'code' => $request->input('code'),
            'icon' => $name,
            'currency_id' => $request->input('currency_id'),
        ]);
        if(\App\BusinessSetting::where('type', 'shipment_aramex')->first()->value == 1 ){
            $aramex = new AramexShipmentController;
            $aramex->fetchCities($request->input('code'));
        }
        
        return redirect()->route('countries.index');
    }

    public function edit($id)
    {
        $id = decrypt($id);
        $country = Country::find($id);
        $currencies = Currency::all();
        return view('countries.edit' , compact('country', 'currencies'));
    }
    public function choose($code,Request $request)
    {
        $country = Country::where('code' ,$code)->first();
        Session::put('country' , $country);

        return redirect()->route('home' , $country->code);
    }

    public function update($id , Request $request)
    {
        $this->validate(request() , [
            'icon' => 'required_without:previous_icon|mimes:jpg,jpeg,png,tiff,webp,gif',
            'name_en' => 'unique:countries,name_en,'.$id,
            'code' => 'unique:countries,code,'.$id,
          ]);

        $country = Country::find($id);
        Country::where('id' , $id)->update($request->except('_token' , 'icon', 'previous_icon'));
        if($request->hasFile('icon')){
            $old_logo = $country->icon;
            $path = 'uploads/countries/icons';
            $name = resizeUploadImage($request->icon, $path, $resize_width = 24, $resize_height = 16);
            $country->icon = $name;
            deleteImage($old_logo);
            $country->update();
        }
        flash(__('Updated Successfully'))->success();
        return redirect()->route('countries.index');
    }

    public function updatePaymentMethod(Request $request)
    {
        $this->validate(request() , [
            'type' => 'required',
            'id' => 'required',
            'status' => 'required',
          ]);

        $type = $request->type;
        $country = Country::findOrFail($request->id);
        $country->$type = $request->status;
        if ($country->save()) {
            return 1;
        }
        return 0;
    }
    
    
    public function updatestatus(Request $request)
    {
        $this->validate(request() , [
            'id' => 'required',
            'status' => 'required',
          ]);

        $country = Country::findOrFail($request->id);
        $country->status = $request->status;
        if ($country->save()) {
            return 1;
        }
        return 0;
    }
    
public function update_default(Request $request)
    {
                $this->validate(request() , [
            'id' => 'required',
            'status' => 'required',
          ]);
          
        foreach (Country::all() as $key => $country) {
            $country->default = 0;
            $country->save();
        }
        $country = Country::findOrFail($request->id);
        $country->default = 1;
        if($country->save()){
            flash(__('Country Default updated successfully'))->success();
            return 1;
        }
        return 0;
    }
    
}
