<?php

namespace App\Http\Controllers;

use App\Unit;
use Illuminate\Http\Request;

class UnitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $units = Unit::all();
        return view('units.index', compact('units'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('units.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate(request() , [
            'name_ar' => 'required',
            'name_en' => 'required',
        ]);
        $unit = new Unit;
        $unit->name_ar = $request->name_ar;
        $unit->name_en = $request->name_en;


        if ($unit->save()) {
            flash(__('Unit has been inserted successfully'))->success();
            return redirect()->route('units.index');
        } else {
            flash(__('Something went wrong'))->error();
            return back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $unit = Unit::findOrFail(decrypt($id));
        return view('units.edit', compact('unit'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate(request() , [
            'name_ar' => 'required',
            'name_en' => 'required',
        ]);

        $unit = Unit::findOrFail($id);


        $unit->name_ar = $request->name_ar;
        $unit->name_en = $request->name_en;

        if ($unit->save()) {
            flash(__('Unit has been updated successfully'))->success();
            return redirect()->route('units.index');
        } else {
            flash(__('Something went wrong'))->error();
            return back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $unit = Unit::findOrFail($id);

        if (Unit::destroy($id)) {
            flash(__('Unit has been deleted successfully'))->success();
            return redirect()->route('units.index');
        } else {
            flash(__('Something went wrong'))->error();
            return back();
        }
    }

    public function update_status(Request $request)
    {
        $unit = Unit::findOrFail($request->id);
        $unit->active = $request->status;
        if ($unit->save()) {
            return 1;
        }
        return 0;
    }

}
