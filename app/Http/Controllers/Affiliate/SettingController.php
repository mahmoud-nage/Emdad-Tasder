<?php

namespace App\Http\Controllers\Affiliate;

use App\Affiliate;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class SettingController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $affiliate = auth()->user()->Affiliate;
        return view('affiliate.settings.index' , compact('user' , 'affiliate'));
    }
    public function update(Request $request)
    {
        $user = auth()->user();
        $affiliate = auth()->user()->Affiliate;
        if ($request->hasFile('avatar')){
            User::where('id' , $user->id)->update(['avatar' => $request->avatar->store('uploads/users') ]);
        }
        if ($request->input('password')){
            $this->validate(request(),[
                'password' => 'required|confirmed|min:6'
            ]);
            User::where('id' , $user->id)->update(['password' => Hash::make($request->input('password')) ]);
        }
        User::where('id' , $user->id)->update([
            'name' => $request->input('name'),
            'phone' => $request->input('phone'),
            'country' => $request->input('country'),
        ]);
        Affiliate::where('id' , $affiliate->id)->update([
            'full_name' => $request->input('full_name'),
            'SSN' => $request->input('SSN'),
            'bank_account_status' => $request->input('bank_account_status'),
            'bank_name' => $request->input('bank_name'),
            'bank_account_username' => $request->input('bank_account_username'),
            'bank_account_number' => $request->input('bank_account_number'),
            'egyptian_mail_status' => $request->input('egyptian_mail_status'),
            'payment_method' => $request->input('payment_method'),
        ]);
        flash('updated successfully');
        return back();
    }
}
