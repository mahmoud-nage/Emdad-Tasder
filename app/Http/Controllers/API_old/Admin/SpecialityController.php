<?php

namespace App\Http\Controllers\API\Admin;

use App\Speciality;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SpecialityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $specialities = Speciality::with('getLogo');
        if ($request->input('name')) {
            $specialities = Speciality::where('name' , 'like' , '%'.$request->input('name').'%');
        }
        return response()->json(['status' => 200, 'data' => $specialities->latest()->get()] , 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateStatus(Request $request, $id)
    {
        $speciality = Speciality::find($id);
        if ($speciality->status == 0){
            Speciality::where('id' , $id)->update(['status' => 1]);
        }else{
            Speciality::where('id' , $id)->update(['status' => 0]);
        }
        return response()->json(['status' => 200 , 'message' => 'Updated Successfully'] , 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Speciality::where('id' , $id)->delete();
        return response()->json(['status' => 200 , 'message' => 'Deleted Successfully'] , 200);
    }
}
