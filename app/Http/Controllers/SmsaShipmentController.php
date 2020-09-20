<?php

namespace App\Http\Controllers;

use Alhoqbani\SmsaWebService\Models\Customer;
use Alhoqbani\SmsaWebService\Models\Shipment;
use Alhoqbani\SmsaWebService\Models\Shipper;
use Alhoqbani\SmsaWebService\Smsa;
use App\BusinessSetting;
use App\City;
use App\Http\Controllers\Controller;
use App\Order;
use App\Shipper as Shippers;

class SmsaShipmentController extends Controller
{
    public function __construct()
    {
        if (\App\BusinessSetting::where('type', 'shipment_smsa')->first()->value == 0) {
            flash(__('Smsa Shipment is not activate, go to activation method to active it'));
            return back();
        }
    }

    public function goToShipment($order_id, $type = 0)
    {
        $order = Order::find($order_id);
        $items_count = $order->orderDetails->sum('quantity');
        $products_description = "";
        foreach ($order->orderDetails as $key => $orderDetail) {
            $orderDetaill = $orderDetail->with('product')->first();
            $options = isset($orderDetail->Variation) ? '( ' . $orderDetail->Variation->getChoice() . ' )' : '';
            $products_description .= $orderDetail->product['name_en'] . '' . $options;
        }
        $currncy = $order->country->Currency->code;

        if ($type) {
            $total_price_withShipping = 0;
        } else {
            $total_price_withShipping = $order->grand_total;
        }

        $user = $order->user;
        $shipping_address = (array) json_decode($order->shipping_address);
        $city = City::find($shipping_address['city']);
        // start samsa shiping.
        $passKey = isset(\App\BusinessSetting::where('type', 'SAMSA_PASS_KEY')->first()->value) ? \App\BusinessSetting::where('type', 'SAMSA_PASS_KEY')->first()->value : '';
        $smsa = new Smsa($passKey);
        // Create a customer
        $customer = new Customer(
            $shipping_address['name'], //customer name
            $shipping_address['phone'], // mobile number. must be > 9 digits
            $shipping_address['address_details'], // street address
            $city['name_en'], // city
            'Egypt'
        );

        $shipper = Shippers::first();

        $shipper = new Shipper(
            $shipper->name, // shipper name
            $shipper->contact_name, // contact name
            $shipper->address, // address line 1
            $shipper->city->name_en, // city
            $shipper->country->name_en, // country
            $shipper->phone// phone
        );

        $shipment = new Shipment(
            $order->code, // Refrence number
            $customer, // Customer object
            Shipment::TYPE_DLV, // Shipment type.
            $shipper,
            $items_count,
            $total_price_withShipping,
            $products_description,
            $currncy
        );

        try {
            $awb = $smsa->createShipment($shipment);
            $ref_number = $shipment->getReferenceNumber();
            $order->ref_number = $ref_number;
            $order->awb = $awb->data;
            $order->save();
            return 1;
        } catch (\Alhoqbani\SmsaWebService\Exceptions\FailedResponse $e) {
            return 0;
            echo $e->getMessage();
        }

// end samsa shiping.
    }
    public function CancelShipment($awb)
    {
        if (\App\BusinessSetting::where('type', 'shipment_smsa')->first()->value == 0) {
            return response()->json(['status' => 500, 'message' => 'Smsa Shipment is not activate, go to activation method to active it']);
        }

        $status = $this->statusShipment($awb);
        if ($status == 'DATA RECEIVED') { // status conditions to approved canel this order
            try {
                $passKey = isset(\App\BusinessSetting::where('type', 'SAMSA_PASS_KEY')->first()->value) ? \App\BusinessSetting::where('type', 'SAMSA_PASS_KEY')->first()->value : '';

                $smsa = new Smsa($passKey);
                $reson = 'client cancel this order';
                $result = $smsa->cancel($awb, $reson);
                return 1;
            } catch (\Alhoqbani\SmsaWebService\Exceptions\FailedResponse $e) {
                return 0;
                echo $e->getMessage();
            }
        } else {
            return response()->json(['status' => 500, 'message' => 'The order has been shipped and cannot be canceled now']);
        }
    }

    public function statusShipment($awb)
    {
        try {
            // $passKey = env('SAMSA_PASS_KEY');
            $passKey = isset(\App\BusinessSetting::where('type', 'SAMSA_PASS_KEY')->first()->value) ? \App\BusinessSetting::where('type', 'SAMSA_PASS_KEY')->first()->value : '';

            $smsa = new Smsa($passKey);
            $result = $smsa->status($awb);
            return $result->data;
        } catch (\Alhoqbani\SmsaWebService\Exceptions\RequestError $e) {
            return response()->json(['status' => 500, 'message' => 'Something went wrong']);
            echo $e->getMessage();
        }
    }

    public function PrintShipmentInvoice($awb, $ref)
    {
        if (\App\BusinessSetting::where('type', 'shipment_smsa')->first()->value == 0) {
            flash(__('Smsa Shipment is not activate, go to activation method to active it'));
            return back();
        }
        try {
            $passKey = isset(\App\BusinessSetting::where('type', 'SAMSA_PASS_KEY')->first()->value) ? \App\BusinessSetting::where('type', 'SAMSA_PASS_KEY')->first()->value : '';

            $smsa = new Smsa($passKey);
            $pdf = $smsa->awbPDF($awb);
            header('Content-type: application/octet-stream');
            header('Content-disposition: attachment;filename=' . $ref . '.pdf');
            echo $pdf->data;die();

        } catch (\Alhoqbani\SmsaWebService\Exceptions\RequestError $e) {
            return response()->json(['status' => 500, 'message' => 'Something went wrong']);
            echo $e->getMessage();
        }
    }

    public function SmsaCities()
    {
        if (\App\BusinessSetting::where('type', 'shipment_smsa')->first()->value == 0) {
            flash(__('Smsa Shipment is not activate, go to activation method to active it'));
            return back();
        }
        // $passKey = env('SAMSA_PASS_KEY');
        $passKey = isset(\App\BusinessSetting::where('type', 'SAMSA_PASS_KEY')->first()->value) ? \App\BusinessSetting::where('type', 'SAMSA_PASS_KEY')->first()->value : '';
        $smsa = new Smsa($passKey);
        $smsa->shouldUseExceptions = false; // Disable throwing exceptions by the library

        $cities = $smsa->cities();

        if ($cities->success) {
            dd($cities->data);
        } else {
            dd($cities->error);
        }
    }

    public function trackShipment($awb)
    {
        if (\App\BusinessSetting::where('type', 'shipment_smsa')->first()->value == 0) {
            flash(__('Smsa Shipment is not activate, go to activation method to active it'));
            return back();
        }
        try {
            $passKey = isset(\App\BusinessSetting::where('type', 'SAMSA_PASS_KEY')->first()->value) ? \App\BusinessSetting::where('type', 'SAMSA_PASS_KEY')->first()->value : '';
            $smsa = new Smsa($passKey);
            $result = $smsa->track($awb);
            return $result;
        } catch (\Alhoqbani\SmsaWebService\Exceptions\RequestError $e) {
            return response()->json(['status' => 500, 'message' => 'Something went wrong']);
            echo $e->getMessage();
        }
    }

}
