<?php

namespace App\Http\Controllers;

use App\BusinessSetting;
use App\Events\NewNotificationUser;
use App\Http\Controllers\AramexShipmentController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\SmsaShipmentController;
use App\Notification;
use App\Order;
use App\Payment;
use App\User;
use App\Area;
use App\City;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use LaravelFCM\Facades\FCM;
use LaravelFCM\Message\OptionsBuilder;
use LaravelFCM\Message\PayloadDataBuilder;
use LaravelFCM\Message\PayloadNotificationBuilder;

class AcceptCardController extends Controller
{
    public function payment($o_id)
    {
        $api_key = isset(\App\BusinessSetting::where('type', 'ACCEPT_KEY')->first()->value) ? \App\BusinessSetting::where('type', 'ACCEPT_KEY')->first()->value : '';
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://accept.paymobsolutions.com/api/auth/tokens",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "{\r\n  \"api_key\": \"" . $api_key . "==\"\r\n}",
            CURLOPT_HTTPHEADER => array(
                "Content-Type: application/json",
                "Postman-Token: 087342cd-c673-4b48-acd8-b051902f83cd",
                "cache-control: no-cache",
            ),
        ));
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            $order = Order::findOrFail($o_id);
            $payment_id = mt_rand(1000000000, 9999999999);
            $marchent_id = json_decode($response)->profile->id;
            $token = json_decode($response)->token;
            $merchant_order_id = $payment_id;

            $currncy = $order->country->Currency->code;
            if (!$currncy) {
                $currncy = "EGP";
            }

            if ($currncy == 'EGP') {
                $convert_amount = $order->grand_total;
            } else {
                $convert_amount = $this->exchange($currncy, 'EGP', $order->grand_total);
            }
            $currncy = 'EGP';

            $amount = ceil($convert_amount);

            $order_id = $this->paymentOrder($amount, $token, $marchent_id, $merchant_order_id, $currncy);

            $shipping_address = json_decode($order->shipping_address);
            $name = explode(' ', $shipping_address->name);
            $first_name = $name[0];
            $last_name = isset($name[1]) ? $name[1] : $name[0];
            $email = isset($shipping_address->email) && $shipping_address->email != null ? $shipping_address->email : $order->user->email;
            $phone = $shipping_address->phone ? $shipping_address->phone : $order->user->phone;
            $building_no = $shipping_address->building_no ? $shipping_address->building_no : 'NA';
            $floor_no = $shipping_address->floor_no ? $shipping_address->floor_no : 'NA';
            $apartment_no = $shipping_address->apartment_no ? $shipping_address->apartment_no : 'NA';
            $postal_code = $shipping_address->postal_code ? $shipping_address->postal_code : 'NA';
            $country = $shipping_address->country;
            $city = $shipping_address->city ? City::find($shipping_address->city)->name_en : 'NA';
            // $area = $shipping_address->area ? Area::find($shipping_address->area)->name_en : 'NA';

            $payment_token = $this->paymentOrder3($token, $order_id, $amount, $first_name, $last_name, $email, $phone, $currncy, $building_no, $floor_no, $apartment_no, $postal_code, $country, $city);
            $order->payment_id = $payment_id;
            $payment_details = [
                'payment_id' => $payment_id,
                'order_id' => $order_id,
                'payment_token' => $payment_token,
            ];
            $order->payment_details = json_encode($payment_details);
            $order->save();
            return $payment_token;
        }
    }

    public function paymentOrder($amout, $token, $marchent_id, $merchant_order_id, $currncy)
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://accept.paymobsolutions.com/api/ecommerce/orders",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => '{
                  "auth_token": "' . $token . '",
                  "delivery_needed": "false",
                  "merchant_id": "' . $marchent_id . '",
                  "amount_cents": "' . $amout . '",
                  "currency": "' . $currncy . '",
                  "merchant_order_id": ' . $merchant_order_id . ',
                  "items": []
                }',
            CURLOPT_HTTPHEADER => array(
                "cache-control: no-cache",
                "content-type: application/json",
                "postman-token: d6e574d0-432d-e5bb-35f7-a7be2eda5964",
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            return json_decode($response)->id;
        }
    }

    public function paymentOrder3($token, $id, $amout, $first_name, $last_name, $email, $phone, $currncy, $building_no, $floor_no, $apartment_no, $postal_code, $country, $city)
    {
        $integration_id = isset(\App\BusinessSetting::where('type', 'ACCEPT_CARD_INTEGRATION_ID')->first()->value) ? \App\BusinessSetting::where('type', 'ACCEPT_CARD_INTEGRATION_ID')->first()->value : '';

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://accept.paymobsolutions.com/api/acceptance/payment_keys",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => '{
              "auth_token": "' . $token . '",
              "amount_cents": "' . $amout . '",
              "expiration": 3600,
              "order_id": "' . $id . '",
              "billing_data": {
                "email": "' . $email . '",
                "first_name": "' . $first_name . '",
                "last_name": "' . $last_name . '",
                "street": "NA",
                "phone_number": "' . $phone . '",
                "shipping_method": "Creadit Card",
                "apartment": "' . $apartment_no . '",
                "floor": "' . $floor_no . '",
                "building": "' . $building_no . '",
                "state": "NA",
                "city": "' . $city . '",
                "country": "' . $country . '",
                "postal_code": "' . $postal_code . '"
            },
              "currency": "' . $currncy . '",
              "integration_id":  "' . $integration_id . '",
              "lock_order_when_paid": "false"
            }',
            CURLOPT_HTTPHEADER => array(
                "cache-control: no-cache",
                "content-type: application/json",
                "postman-token: 9348e50b-2adf-fd81-d46d-fb4b2251438a",
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            return json_decode($response)->token;
        }
    }

    public function paymentOrder4($token)
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://accept.paymobsolutions.com/api/acceptance/payments/pay",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => '{"source": {"identifier": "AGGREGATOR", "subtype": "AGGREGATOR"},"payment_token": "' . $token . '"}',
            CURLOPT_HTTPHEADER => array(
                "cache-control: no-cache",
                "content-type: application/json",
                "postman-token: 9348e50b-2adf-fd81-d46d-fb4b2251438a",
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            return json_decode($response);
        }
    }

    public function get_hmac($payment)
    {
        $values = $payment->payment_key_claims->amount_cents . $payment->order->created_at . $payment->order->currency .
        $payment->error_occured . $payment->has_parent_transaction . $payment->id . $payment->payment_key_claims->integration_id . $payment->is_3d_secure . $payment->is_auth .
        $payment->is_capture . $payment->is_refunded . $payment->is_standalone_payment . $payment->is_voided . $payment->order->id . $payment->owner . $payment->pending .
        $payment->source_data->pan . $payment->source_data->sub_type . $payment->source_data->type . $payment->success;
        $hmac_secret = '68AFFA6B2DDBEFBB0D3412331E3FA4F8';
        return hash_hmac('SHA512', $hmac_secret, $values);
    }

    public function callbackNotification(Request $request)
    {
        $success = $request->success;
        $order_id = $request->merchant_order_id;
        if ($success == "true") {
            $order = Order::where('payment_id', $order_id)->first();
            if ($order) {
                $order->status_id = 3;
                $order->payment_status = 'paid';
                foreach ($order->orderDetails as $key => $orderDetail) {
                    $orderDetail->delivery_status = 'on_delivery';
                    $orderDetail->payment_status = 'paid';
                    $orderDetail->save();
                }

                if ($order->shipment_type == 1) { // check smsa activation
                    $smsa_shipment = new SmsaShipmentController;
                    $shipment = $smsa_shipment->goToShipment($order->id, $type = 1);
                    if ($shipment) {
                        $status = 1;
                    } else {
                        $status = 0;
                    }

                } elseif ($order->shipment_type == 2) {
                    $aramex_shipment = new AramexShipmentController;
                    $shipment = $aramex_shipment->goToShipment($order->id, $type = 1);
                    if ($shipment) {
                        $status = 1;
                    } else {
                        $status = 0;
                    }

                }else if($order->shipment_type == 0){
                    $status = 1;
                }
                if ($order->save() && $status) {
                    if ($order->type == 1) {
                        $user = $order->user;
                        $notification = Notification::create([
                            'title' => 'تمت عملية الدفع بنجاح',
                            'body' => 'تم فتح التقارير للخدمة المطلوبة',
                            'type' => 'request_paid',
                            'user_service_id' => 1,
                        ]);
                        $token = $user->api_token;
                        $notification->users()->attach($user);
                        $optionBuilder = new OptionsBuilder();
                        $optionBuilder->setTimeToLive(60 * 20);
                        $notificationBuilder = new PayloadNotificationBuilder($notification->title);
                        $notificationBuilder->setBody($notification->body)
                            ->setSound('default');
                        $dataBuilder = new PayloadDataBuilder();
                        $dataBuilder->addData(['a_data' => 'my_data']);
                        $option = $optionBuilder->build();
                        $fcm_notification = $notificationBuilder->build();
                        $data = $dataBuilder->build();
                        $downstreamResponse = FCM::sendTo($token, $option, $fcm_notification, $data);
                        broadcast(new NewNotificationUser($notification, $user));
                        return response()->json(['status' => 200, 'message' => 'Done Successfully']);
                    } else {
                        $request->session()->forget('cart_' . get_country()->code);
                        $request->session()->forget('order_id');
                        flash(__('Done Successfully'))->success();
                        return view('frontend.track_order', compact('order'));
                    }
                }

            }
        } else {
            if ($order->type == 0) {
                flash(__('messages.error_msg'))->error();
                $order = Order::where('payment_id', $order_id)->first();
                $token = json_decode($order->payment_details)->payment_token;
                return view('frontend.payment.AcceptCard', compact('token'))->with('error', __('messages.error_msg'));
            }
        }
    }
    public function exchange($from, $to = 'EGP', $amount)
    {
        // set API Endpoint, access key, required parameters
        $access_key = 'b52147bd8fe8a9706304';
        // initialize CURL:
        $ch = curl_init('https://free.currconv.com/api/v7/convert?compact=ultra&apiKey=' . $access_key . '&q=' . $from . '_' . $to . '');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // get the JSON data:
        $json = curl_exec($ch);
        curl_close($ch);

        // Decode JSON response:
        $conversionResult = json_decode($json, true);

        // access the conversion result
        return $conversionResult['' . $from . '_' . $to] * $amount;
    }

}
