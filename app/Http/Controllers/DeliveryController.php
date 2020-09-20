<?php

namespace App\Http\Controllers;

use App\Delivery;
use function Couchbase\defaultDecoder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DeliveryController extends Controller
{
    public function index()
    {
        $deliveries = Delivery::all();
        return view('deliveries.index' , compact('deliveries'));
    }

    public function create()
    {
        return view('deliveries.create');
    }

    public function edit($id)
    {
        $id = decrypt($id);
        $delivery = Delivery::find($id);
        return view('deliveries.edit' , compact('delivery'));
    }

    public function store(Request $request)
    {
        $delivery = Delivery::create($request->except('_token' , 'countries'));
        foreach ($request->country as $key => $country) {
            $delivery->countries()->attach($country , ['price' => $request->prices[$key]]);
        }
        flash(__('Created Successfully'))->success();
        return redirect()->route('deliveries.index');
    }

    public function update($id , Request $request)
    {
        $delivery = Delivery::find($id);
        Delivery::where('id' , $id)->update($request->except('_token' , 'country' , 'prices'));
        foreach ($request->country as $key => $country) {
            $delivery_country = DB::table('delivery_countries')->where('delivery_id' , $delivery->id)->where('country_id' , $country)->first();
            if (isset($delivery_country)){
                DB::table('delivery_countries')->where('delivery_id' , $delivery->id)->where('country_id' , $country)->update([
                    'price' => $request->prices[$key],
                ]);
            }else{
                $delivery->countries()->attach($country , ['price' => $request->prices[$key]]);
            }
        }
        flash(__('Updated Successfully'))->success();
        return back();
    }
    public function destroy($id , Request $request)
    {
        Delivery::where('id' , $id)->delete();
        flash(__('Deleted Successfully'))->success();
        return back();
    }
}
