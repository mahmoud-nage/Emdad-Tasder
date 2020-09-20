<?php

namespace App\Http\Controllers;

use App\BannerAffiliate;
use App\BusinessSetting;
use App\Payment;
use App\PaymentRequest;
use App\Product;
use Illuminate\Http\Request;

class AffiliateController extends Controller
{
    public function index()
    {
        return view('affiliates.index');
    }

    public function products()
    {
        $products = Product::where('is_affiliate', 1)->latest()->get();
        return view('affiliates.products', compact('products'));
    }

    public function add_products(Request $request)
    {
        Product::whereIn('id', $request->input('products'))->update(['is_affiliate' => 1]);
        $request->session()->flash('success', 'Done Successfully');
        return back();
    }

    public function remove_products($id, Request $request)
    {
        Product::where('id', $id)->update(['is_affiliate' => 0]);
        $request->session()->flash('success', 'Done Successfully');
        return back();
    }

    public function banners()
    {
        $banners = BannerAffiliate::latest()->get();
        return view('affiliates.banners', compact('banners'));
    }

    public function payments()
    {
        $payments = PaymentRequest::with('Affiliate')->whereNotNull('affiliate_id')->latest()->get();
        return view('affiliates.payments', compact('payments'));
    }

    public function create_payment(Request $request)
    {
        $payment = new Payment;
        $payment->affiliate_id = $request->input('affiliate_id');
        $payment->amount = $request->input('amount');
        $payment->payment_method = $request->input('payment_method');
        $payment->status = 1;
        $payment->save();
        return back();
    }

    public function add_banner(Request $request)
    {
        if ($request->hasFile('photo')) {
            $banner = new BannerAffiliate();
            $banner->photo = $request->photo->store('uploads/banners');
            $banner->type = $request->type;
            $banner->save();
            flash(__('Banner has been inserted successfully'))->success();
        }
        return back();
    }

    public function update_banner($id, Request $request)
    {
        if ($request->hasFile('photo')) {
            $banner = BannerAffiliate::find($id);
            $banner->photo = $request->photo->store('uploads/banners');
            $banner->type = $request->type;
            $banner->save();
            flash(__('Banner has been updated successfully'))->success();
        }
        return back();
    }

    public function remove_banner($id)
    {
        BannerAffiliate::where('id', $id)->delete();

        flash(__('Banner has been deleted successfully'))->success();

        return redirect()->route('affiliates.banners');

    }

    public function reports()
    {
        return view('affiliates.reports');
    }

    public function requests()
    {
        $requests = PaymentRequest::with('Affiliate')->where("status","pending")->whereNotNull('affiliate_id')->latest()->get();
        return view('affiliates.requests', compact('requests'));
    }

    public function settings()
    {
        $coupon_percentage = BusinessSetting::where('type', 'coupon_percentage')->first();
        $accept_card = BusinessSetting::where('type', 'accept_card')->first();
        $accept_kiosk = BusinessSetting::where('type', 'accept_kiosk')->first();
        $accept_token = BusinessSetting::where('type', 'accept_token')->first();
        $accept_card_id = BusinessSetting::where('type', 'accept_card_id')->first();
        $accept_kiosk_id = BusinessSetting::where('type', 'accept_kiosk_id')->first();
        $affiliate_percentage = BusinessSetting::where('type', 'affiliate_percentage')->first();
        $affiliate_max_discount = BusinessSetting::where('type', 'affiliate_max_discount ')->first();
        $egy_mail = BusinessSetting::where('type', 'egy_mail')->first();
        $paypal_payment = BusinessSetting::where('type', 'paypal_payment ')->first();
        $bank = BusinessSetting::where('type', 'bank ')->first();
        return view('affiliates.settings', compact('affiliate_max_discount', 'affiliate_percentage', 'coupon_percentage', 'accept_card',
            'accept_kiosk', 'egy_mail', 'accept_card_id', 'accept_kiosk_id', 'accept_token','paypal_payment','bank'));
    }

    public function update_settings(Request $request)
    {
        if ($request->input('types')) {
            foreach ($request->input('types') as $key => $type) {
                BusinessSetting::where('type', 'coupon_percentage')->update(['value' => $request->input('values')[$key]]);
            }
        }
        if ($request->input('affiliate_percentage')) {
            BusinessSetting::where('type', 'affiliate_percentage')->update(['value' => $request->input('affiliate_percentage')]);
        }
        if ($request->input('affiliate_max_discount')) {
            BusinessSetting::where('type', 'affiliate_max_discount')->update(['value' => $request->input('affiliate_max_discount')]);
        }
        if ($request->input('paypal_payment')) {
            BusinessSetting::where('type', 'paypal_payment')->update(['value' => $request->input('paypal_payment')]);
        }
        if ($request->input('bank')) {
            BusinessSetting::where('type', 'bank')->update(['value' => $request->input('bank')]);
        }
        if ($request->input('egy_mail')) {
            BusinessSetting::where('type', 'egy_mail')->update(['value' => 1]);
        } else {
            BusinessSetting::where('type', 'egy_mail')->update(['value' => 0]);
        }
        if ($request->input('accept_card')) {
            BusinessSetting::where('type', 'accept_card')->update(['value' => 1]);
        } else {
            BusinessSetting::where('type', 'accept_card')->update(['value' => 0]);
        }
        if ($request->input('accept_kiosk')) {
            BusinessSetting::where('type', 'accept_kiosk')->update(['value' => 1]);
        } else {
            BusinessSetting::where('type', 'accept_kiosk')->update(['value' => 0]);
        }
        flash(__('Updated successfully'))->success();
        return back();
    }
}
