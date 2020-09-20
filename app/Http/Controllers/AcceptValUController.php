<?php

namespace App\Http\Controllers;

use App\Events\NewNotificationUser;
use App\Notification;
use App\Order;
use App\Payment;
use App\User;
use App\UserOffer;
use App\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use LaravelFCM\Message\OptionsBuilder;
use LaravelFCM\Message\PayloadDataBuilder;
use LaravelFCM\Message\PayloadNotificationBuilder;

class AcceptValUController extends Controller
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

            // $payment_id = generateUniqueNumber();
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
            $amount = ceil($convert_amount);

            $order_id = $this->paymentOrder($amount, $token, $marchent_id, $merchant_order_id, $currncy);
            $shipping_address = json_decode($order->shipping_address);
            $name = explode(' ', $shipping_address->name);
            $first_name = $name[0];
            $last_name = isset($name[1]) ? $name[1] : $name[0];
            $email = isset($shipping_address->email) && $shipping_address->email != null ? $shipping_address->email : $order->user->email;
            $phone = $shipping_address->phone;
            $payment_token = $this->paymentOrder3($token, $order_id, $amount, $first_name, $last_name, $email, $phone, $currncy);
            $response = $this->paymentOrder4($payment_token);
            $refNum = $response->data->bill_reference;
            $message = 'تم استلام طلبك بنجاح الرقم المرجعى للمدفوعات طريقة الدفع:' . $refNum . '  رجاء التوجه إلى أقرب فرع أمان أو مصاري و أسأل عن مدفوعات اكسبت و أخبرهم بالرقم المرجعي';
            $payment_details = [
                'order_id' => $order_id,
                'refNum' => $refNum,
                'message' => $message,
            ];
            $order->payment_details = json_encode($payment_details);
            $order->save();
            return $message;
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
                  "currency": ' . $currncy . ',
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

    public function paymentOrder3($token, $id, $amout, $first_name, $last_name, $email, $phone, $currncy)
    {
        $integration_id = isset(\App\BusinessSetting::where('type', 'ACCEPT_VALU_INTEGRATION_ID')->first()->value) ? \App\BusinessSetting::where('type', 'ACCEPT_VALU_INTEGRATION_ID')->first()->value : '';

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
                "apartment": "NA",
                "email": "' . $email . '",
                "floor": "NA",
                "first_name": "' . $first_name . '",
                "street": "NA",
                "building": "NA",
                "phone_number": "' . $phone . '",
                "shipping_method": "NA",
                "postal_code": "01898",
                "city": "NA",
                "country": "NA",
                "last_name": "' . $last_name . '",
                "state": "NA"
              },
              "currency": ' . $currncy . ',
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
            dd($response);
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
            CURLOPT_POSTFIELDS => '{"source": {"identifier": "01019050578", "down_payment": "1000", "subtype": "VALU"},"payment_token": "' . $token . '"}',
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
        $success = json_decode(json_encode($request->input('obj')))->success;
        $order_id = json_decode(json_encode($request->input('obj')))->order->id;

        $userService = UserService::where('id', Payment::where('payment_id', $order_id)->first()->user_service_id)->first();
        $user = User::find($userService->user_id);
        $notification = Notification::create([
            'title' => 'تمت عملية الدفع بنجاح',
            'body' => 'تم فتح التقارير للخدمة المطلوبة',
            'type' => 'request_paid',
            'user_service_id' => $userService->id,
        ]);
        $token = User::where('id', $user->id)->pluck('Token')->toArray();
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
        if ($success == true) {
            $payment = Payment::where('payment_id', $order_id)->first();
            $order = Order::find($payment->order_id);
            Payment::where('payment_id', $order_id)->update(['status' => 1]);
            if (isset($payment->coupon_id)) {
                DB::table('users_coupons')->where('coupon_id', $payment->coupon_id)->where('user_id', $payment->user_id)->update(['status' => 1]);
            }
            if (isset($order->user_offer_id)) {
                $userOffer = UserOffer::find($order->user_offer_id);
                UserService::where('id', $userOffer->first_user_service_id)->update(['status' => 1]);
                UserService::where('id', $userOffer->second_user_service_id)->update(['status' => 1]);
            } else {
                UserService::where('id', Payment::where('payment_id', $order_id)->first()->user_service_id)->update(['status' => 1]);
            }
            $userCoupon = DB::table('users_coupons')->where('user_service_id', $userService->id)->first();
            if (isset($userCoupon)) {
                $userCoupon->update(['status' => 1]);
            }
            $downstreamResponse = FCM::sendTo($token, $option, $fcm_notification, $data);
            broadcast(new NewNotificationUser($notification, $user));
        }
        return response()->json(['status' => 200, 'message' => 'Done Successfully']);
    }

}
