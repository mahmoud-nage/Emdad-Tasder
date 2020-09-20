<?php

namespace App\Http\Controllers\API\Admin;

use App\Branch;
use App\Reservation;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ReservationController extends Controller
{
    public function index(Request $request)
    {
        $user = User::find($request->input('user_id'));
        $reservations = Reservation::with('User', 'Doctor', 'Branch', 'Appointment', 'Speciality', 'Status', 'Offer')->orderBy('date', 'asc');
        if ($user->type == 'branch'){
            $branch = Branch::find($user->branch_id);
            $doctors = $branch->doctors()->pluck('id')->toArray();
            $reservations = $reservations->whereIn('doctor_id' , $doctors);
        }
        return response()->json(['status' => 200, 'data' => $reservations->latest()->paginate(20) ], 200);
    }

    public function update($id , Request $request)
    {
        $reservation = Reservation::where('id' , $id)->update(['status_id' =>$request->input('status_id')]);
        return response()->json(['status' => 200, 'message' => 'updated successfully'], 200);
    }

    public function destroy($id)
    {
        Reservation::where('id', $id)->delete();
        return response()->json(['status' => 200, 'message' => 'Deleted successfully'], 200);
    }
}
