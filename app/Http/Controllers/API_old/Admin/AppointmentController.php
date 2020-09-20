<?php

namespace App\Http\Controllers\API\Admin;

use App\Appointment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AppointmentController extends Controller
{
    public function index(Request $request)
    {
        $appointments = Appointment::with('getDay' , 'Doctor')->where('date','>=',Carbon::now()->toDateString());
        if ($request->input('doctor_id')){
            $appointments = $appointments->where('doctor_id' , $request->input('doctor_id'));
        }
        return response()->json(['status' => 200 , 'data' => $appointments->paginate(30)]);
    }
    public function destroy($id ,Request $request)
    {
        Appointment::where('id' , $id)->delete();
        return response()->json(['status' => 200 , 'message' => 'deleted successfully']);
    }
}
