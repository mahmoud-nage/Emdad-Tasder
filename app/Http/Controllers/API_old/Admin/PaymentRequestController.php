<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use App\PaymentRequest;
use Illuminate\Http\Request;

class PaymentRequestController extends Controller
{

    public function confirmPayment(Request $request)
    {
        $paymentRequest = PaymentRequest::where('id',$request->input('paymentId'))->first();
        if ($request->hasFile('file')) {
            $image = $request->file('file');
            $img = Image::make($image->getRealPath());
            $size = $img->filesize();
            $data = getimagesize($image);
            $width = $size > 400000 ? $data[0] / 4 : $data[0];
            $height = $size > 400000 ? $data[1] / 4 : $data[1];
            $img = $img->resize($width, $height);
            $fileName = md5($image->getClientOriginalName() . time()) . "." . $image->getClientOriginalExtension();
            $img->save(public_path('/uploads/admin/payments/confirmed' . $fileName));
            dd("image",$img);
        }
        dd($paymentRequest->toArray(),$request->all());
        //change status of payment request to confirmed.
    }
}
