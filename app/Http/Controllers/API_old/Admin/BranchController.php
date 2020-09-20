<?php

namespace App\Http\Controllers\API\Admin;

use App\Branch;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BranchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $branches = Branch::with('users');
        if ($request->input('name')) {
            $branches = $branches->where('name_ar',  'like' , '%'.$request->input('name').'%')
                ->orWhere('name_en' , '%'.$request->input('name').'%');
        }
        if ($request->input('address')) {
            $branches = $branches->where('address_ar',  'like' , '%'.$request->input('address').'%')
                ->orWhere('address_en' , '%'.$request->input('address').'%');
        }
        return response()->json(['status' => 200, 'data' => $branches->latest()->paginate(10)] , 200);
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
        Branch::where('id' , $id)->update(['status' => 1]);
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
        Branch::where('id' , $id)->delete();
        return response()->json(['status' => 200 , 'message' => 'Deleted Successfully'] , 200);
    }
}
