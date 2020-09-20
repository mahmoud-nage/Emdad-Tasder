<?php

namespace App\Http\Controllers\API\Admin;

use App\Appointment;
use App\OriginalAppointment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OriginalAppointmentController extends Controller
{
    public function index(Request $request)
    {
        $appointments = OriginalAppointment::with('getDay')->where('doctor_id' , $request->input('doctor_id'))->get();
        return response()->json(['status' => 200 , 'data' => $appointments]);
    }

    public function destroy($id ,Request $request)
    {
        $original = OriginalAppointment::find($id);
        Appointment::where('day' , $original->day)->where('date' , '>=' , Carbon::now()->toDateString())->where('status' , 1)->where('from_time' , $original->from_time)->where('to_time' , $original->to_time)->delete();
        OriginalAppointment::where('id' , $id)->delete();

        return response()->json(['status' => 200 , 'message' => 'deleted successfully']);
    }
}
