<?php

namespace App\Http\Controllers\API\Web;

use App\Appointment;
use App\Branch;
use App\Doctor;
use App\Favourite;
use App\Speciality;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class DoctorController extends Controller
{
    public function index(Request $request)
    {
        $doctors = Doctor::with('specialities' , 'appointments' , 'reviews' , 'Avatar' , 'branches')->latest();
        $locale = $request->input('locale');
        if ($request->input('branch_name')){
            $branches = Branch::where('name_ar' , 'like' , '%'.$request->input('branch_name').'%')->orWhere('name_en' , 'like' , '%'.$request->input('branch_name').'%')->pluck('id')->toArray();
            $doctor_ids = DB::table('doctor_branch')->whereIn('branch_id' , $branches)->pluck('doctor_id')->toArray();
            $doctors = $doctors->whereIn('id' , $doctor_ids);
        }
        if ($request->input('city')) {
            $branches = Branch::where('city_id' , $request->input('city'))->pluck('id')->toArray();
            $doctor_ids = DB::table('doctor_branch')->whereIn('branch_id' , $branches)->pluck('doctor_id')->toArray();
            $doctors = $doctors->whereIn('id' , $doctor_ids);
        }
        if ($request->input('speciality_id')){
            $speciality = Speciality::find($request->input('speciality_id'));
            $doctor_ids = $speciality->doctors()->pluck('doctors.id')->toArray();
            $doctors = $doctors->whereIn('id' , $doctor_ids);
        }
        if ($request->input('doctor_name')) {
            $doctors = $doctors->where('name_ar', 'like', '%' . $request->input('doctor_name') . '%')->orWhere('name_en', 'like', '%' . $request->input('doctor_name') . '%');
        }
        if ($request->input('gender')) {
            $doctors = $doctors->where('gender',$request->input('gender'));
        }
        if ($request->input('fees_from') & $request->input('fees_to')) {
            $doctors = $doctors->whereBetween('fees', [$request->input('fees_from') , $request->input('fees_to')]);
        }

        if ($request->input('title')) {
            $doctors = $doctors->where('title_id', $request->input('title') );
        }
        if ($request->input('date')) {
            if($request->input('date') != 0){
                $doctor_ids = Appointment::where('date' , $request->input('date'))->pluck('doctor_id')->toArray();
                $doctors = $doctors->whereIn('id' , $doctor_ids);
            }
        }

        $doctors = $doctors->paginate(10);
        return view('web.partials.doctors' , compact('doctors' , 'locale'));
    }

    public function next_appointment(Request $request)
    {
        return response()->json(['status' => 200 , 'data' => get_next_appointment($request->input('doctor_id'))]);
    }
}
