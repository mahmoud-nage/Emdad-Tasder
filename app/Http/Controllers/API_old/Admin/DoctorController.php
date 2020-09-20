<?php

namespace App\Http\Controllers\API\Admin;

use App\Branch;
use App\Doctor;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DoctorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = User::find($request->input('user_id'));
        $doctors = Doctor::with('specialities' , 'appointments' , 'reviews' , 'Avatar' , 'branches')->latest();
        if ($user->type == 'branch'){
            $branch = Branch::find($user->branch_id);
            $doctors = $doctors->doctors()->pluck('id')->toArray();
            $doctors = $doctors->whereIn('id' , $doctors);
        }
        if ($request->input('get_appointments') == 1) {
            return response()->json(['status' => 200, 'data' => $doctors->get()] , 200);
        }
        if ($request->input('name')) {
            $users = User::where('user_type_id', 2)->where('name' , 'like' , '%'.$request->input('name').'%')->pluck('id')->toArray();
            $doctors = $doctors->whereIn('id', $users);
        }
        if ($request->input('address')) {
            $doctors = $doctors->where('address',  'like' , '%'.$request->input('address').'%');
        }
        if ($request->input('branch_id')) {
            $branch = Branch::find($request->input('branch_id'));
            $doctor_ids = $branch->doctors()->pluck('doctors.id')->toArray();
            $doctors = $doctors->whereIn('id', $doctor_ids);
            return response()->json(['status' => 200, 'data' => $doctors->get() ]);
        }
        return response()->json(['status' => 200, 'data' => $doctors->latest()->paginate(10)] , 200);
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
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $doctor = Doctor::find($id);
        User::where('id', $doctor->user_id)->delete();
        Doctor::where('id', $id)->delete();

        return response()->json(['status' => 200 , 'message' => 'Deleted Successfully'] , 200);
    }
}
