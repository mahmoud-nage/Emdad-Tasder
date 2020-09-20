<?php

namespace App\Http\Controllers\Affiliate;

use App\Address;
use App\Affiliate;
use App\CouponAffiliate;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    public function index()
    {
        return view('affiliate.register.register');
    }

    public function persoalInfo()
    {
        $user = auth()->user();
        return view('affiliate.register.personal_info', compact('user'));
    }

    public function createCoupon()
    {
        $user = auth()->user();
        return view('affiliate.register.coupon', compact('user'));
    }

    public function store(Request $request)
    {
        $this->validate(request(), [
            'name' => 'required',
            'email' => 'required',
            'birth_date' => 'required',
            'password' => 'required|confirmed',
            'city_id' => 'required',
            'country' => 'required',
            'postal_code' => 'required',
            'address_details' => 'required',
            'phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
            'coupon' => 'required',
            'remember' => 'required',
        ]);
        $couponAffiliate = CouponAffiliate::where('code', $request->coupon)->get();
        if (isset($couponAffiliate) && !is_null($couponAffiliate) && count($couponAffiliate) > 0) {
            return redirect()->back()->withInput()->withErrors(['coupon' => 'This coupon already taken']);
        }
        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'country' => $request->input('country'),
            'birth_date' => $request->input('birth_date'),
            'phone' => $request->input('phone'),
            'user_type' => 'affiliate',
        ]);
        $address = Address::create([
            'city_id' => $request->input('city_id'),
            'area_id' => $request->input('area_id'),
            'address_details' => $request->input('address_details'),
            'phone' => $request->input('phone'),
        ]);
        $affiliate = Affiliate::create([
            'user_id' => $user->id,
            'address_id' => $address->id,
        ]);
        CouponAffiliate::create([
            'affiliate_id' => $affiliate->id,
            'code' => $request->coupon,
        ]);
        auth()->login($user);
        return redirect()->route('affiliate.dashboard');
    }

    public function storeUser(Request $request)
    {
        $rules = [
            'email' => 'required|unique:users,email',
            'name' => 'required',
            'password' => 'required|confirmed',
            'remember' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return back()->withInput()->withErrors($validator->errors());
        } else {
            $user = User::create([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'password' => Hash::make($request->input('password')),
                'country' => "EG",
                'birth_date' => $request->input('birth_date'),
                'phone' => $request->input('phone'),
                'user_type' => 'affiliate',
            ]);
            $affiliate = Affiliate::create([
                'user_id' => $user->id,
            ]);
            auth()->login($user);
            return redirect()->route('affiliate.personal_info');
        }
    }

    public function storeInfo(Request $request)
    {
        $rules = [
            'birth_date' => 'required',
            'country' => 'required',
            'address_details' => 'required',
            'phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return back()->withInput()->withErrors($validator->errors());
        } else {
            $user = auth()->user();
            $userInfo = $request->all();
            $userInfo['address'] = $request->input('address_details');
            $user->update($userInfo);
            $address = Address::create([
                'city_id' => $request->input('city_id'),
                'area_id' => $request->input('area_id'),
                'address_details' => $request->input('address_details'),
                'phone' => $request->input('phone'),
                'user_id' => $user->id,
            ]);
            $affiliate = Affiliate::where('user_id', $user->id)->first();
            $affiliate->update(['address_id' => $address->id]);
            $couponAffiliate = CouponAffiliate::where('affiliate_id', $affiliate->id)->first();
            if (!isset($couponAffiliate) || is_null($couponAffiliate)) {
                CouponAffiliate::create([
                    'affiliate_id' => $affiliate->id,
                ]);
            }
            return redirect()->route('affiliate.createCoupon');
        }
    }

    public function storeCoupon(Request $request)
    {
        $rules = [
            'coupon' => 'required|unique:coupon_affiliates,code',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return back()->withInput()->withErrors($validator->errors());
        } else {
            $user = auth()->user();
            $affiliate = $user->Affiliate;
            $couponAffiliate = CouponAffiliate::where('affiliate_id', $affiliate->id)->first();
            if (!isset($couponAffiliate) || is_null($couponAffiliate)) {
                CouponAffiliate::create([
                    'affiliate_id' => $affiliate->id,
                    'code' => $request->coupon,
                ]);
            }else{
                $couponAffiliate->update([ 'code' => $request->coupon]);
            }
            return redirect()->route('affiliate.dashboard');
        }
    }
}
