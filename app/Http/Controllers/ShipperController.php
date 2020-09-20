<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Shipper;
use Illuminate\Http\Request;

class ShipperController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $records = Shipper::orderBy('id', 'desc')->get();
        return view('shippers.index', compact('records'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('shippers.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate(request(), [
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required|min:10',
            'contact_name' => 'required',
            'country_id' => 'required|exists:countries,code',
            'city_id' => 'required',
            'address' => 'required',
        ]);

        $record = Shipper::create($request->all());
        if (isset($record)) {
            flash(__('Shipper has been inserted successfully'))->success();
            return redirect()->route('shippers.index');
        }

        flash(__('Something went wrong'))->error();
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $record = Shipper::findOrFail(decrypt($id));
        return view('shippers.edit', compact('record'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $record = Shipper::findOrFail($id);
        $update = $record->update($request->except('_method', '_token'));
        // dd($request->all(), $update, $record->city_id);
        if ($update) {
            flash(__('Shipper has been updated successfully'))->success();
            return redirect()->route('shippers.index');
        }

        flash(__('Something went wrong'))->error();
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $record = Shipper::find($id);
        if (Shipper::destroy($id)) {
            flash(__('Shipper has been deleted successfully'))->success();
            return redirect()->route('shippers.index');
        }
        flash(__('Something went wrong'))->error();
        return back();
    }
}
