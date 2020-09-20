<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Currency;
use Illuminate\Support\Facades\DB;

class CurrencyController extends Controller
{

    public function index()
    {
        $currencies = Currency::all();
        return view('currencies.index' , compact('currencies'));
    }

    public function create()
    {
        return view('currencies.create');
    }

    public function edit($id)
    {
        $id = decrypt($id);
        $currency = Currency::find($id);
        return view('currencies.edit' , compact('currency'));
    }

    public function store(Request $request)
    {
        $this->validate(request() , [
            'name_ar' => 'required',
            'name_en' => 'required',
            'symbol' => 'required',
            'code' => 'required',
          ]);

        DB::table('currencies')->insert($request->except('_token'));
        flash(__('Created Successfully'))->success();
        return redirect()->route('currencies.index');
    }

    public function update($id , Request $request)
    {
        Currency::where('id' , $id)->update($request->except('_token'));
        flash(__('Updated Successfully'))->success();
        return back();

    }

    public function changeCurrency(Request $request)
    {
    	$request->session()->put('currency_code', $request->currency_code);
        $currency = Currency::where('code', $request->currency_code)->first();
    	flash(__('Currency changed to ').$currency->name)->success();
    }

    public function currency(Request $request)
    {
        $currencies = Currency::all();
        $active_currencies = Currency::where('status', 1)->get();
        return view('business_settings.currency', compact('currencies', 'active_currencies'));
    }

    public function updateCurrency(Request $request)
    {
        $currency = Currency::findOrFail($request->id);
        $currency->exchange_rate = $request->exchange_rate;
        $currency->status = $request->status;
        if($currency->save()){
            flash('Currency updated successfully')->success();
            return '1';
        }
        flash('Something went wrong')->error();
        return '0';
    }

    public function updateYourCurrency(Request $request)
    {
        $currency = Currency::findOrFail($request->id);
        $currency->name = $request->name;
        $currency->symbol = $request->symbol;
        $currency->code = $request->code;
        $currency->exchange_rate = $request->exchange_rate;
        $currency->status = $request->status;
        if($currency->save()){
            flash('Currency updated successfully')->success();
            return '1';
        }
        flash('Something went wrong')->error();
        return '0';
    }
    
    function get_currency(Request $request){
        
        if($request->has('currency_name')){
            $currency = Currency::where('name', $request->currency_name)->first();
            // return $currency ;
            if($currency){
                return response()->json(['status' => 200, 'data' => $currency]);
            }
        }

    }
}
