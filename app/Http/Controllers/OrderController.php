<?php

namespace App\Http\Controllers;

use DB;
use PDF;
use Auth;
use Mail;
use Session;
use App\Area;
use App\City;
use App\Color;
use App\Order;
use App\Seller;
use App\Status;
use App\Product;
use App\CouponUrl;
use App\Variation;
use App\CouponUsage;
use App\OrderDetail;
use App\GeneralSetting;
use App\BusinessSetting;
use Illuminate\Http\Request;
use App\Mail\InvoiceEmailManager;
use Alhoqbani\SmsaWebService\Smsa;
use Illuminate\Support\Facades\Validator;
use Alhoqbani\SmsaWebService\Models\Shipper;
use Alhoqbani\SmsaWebService\Models\Customer;
use Alhoqbani\SmsaWebService\Models\Shipment;
use App\Http\Controllers\SmsaShipmentController;
use App\Http\Controllers\AramexShipmentController;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource to seller.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = DB::table('orders')
            ->orderBy('id', 'desc')
            ->join('order_details', 'orders.id', '=', 'order_details.order_id')
            ->where('order_details.seller_id', Auth::user()->id)
            ->select('orders.id')
            ->distinct()
            ->paginate(9);

        return view('frontend.seller.orders', compact('orders'));
    }

    /**
     * Display a listing of the resource to admin.
     *
     * @return \Illuminate\Http\Response
     */
    public function admin_orders(Request $request)
    {
        $cou = 0;
        $type= 'In House Orders';
        if($request->has('country_id')){
            $cou = $request->country_id;
            $orders = DB::table('orders')
                ->orderBy('id', 'desc')
                ->join('order_details', 'orders.id', '=', 'order_details.order_id')
                ->where('country_id', $request->country_id)
                ->join('users', 'order_details.seller_id', '=', 'users.id')
                ->where('users.user_type', '=', 'admin')
                ->select('orders.id')
                ->distinct()
                ->get();
            return view('orders.index', compact('orders', 'type', 'cou'));
        }
           $orders = DB::table('orders')
                ->orderBy('id', 'desc')
                ->join('order_details', 'orders.id', '=', 'order_details.order_id')
                ->where('viewed', 0)
                ->join('users', 'order_details.seller_id', '=', 'users.id')
                ->where('users.user_type', '=', 'admin')
                ->select('orders.id')
                ->distinct()
                ->get();
                return view('orders.index', compact('orders', 'type', 'cou'));
    }

    /**
     * Display a listing of the sales to admin.
     *
     * @return \Illuminate\Http\Response
     */
    public function sales(Request $request)
    {
        $cou = 0;
        $type= 'Seller Orders';
        if($request->has('seller_id')){
            $orders = DB::table('orders')
            ->orderBy('id', 'desc')
            ->join('order_details', 'orders.id', '=', 'order_details.order_id')
            ->where('order_details.seller_id', $request->seller_id)
            ->select('orders.id')
            ->distinct()
            ->get();
            $seller = Seller::where('user_id', $request->seller_id)->first();
            return view('sellers.orders', compact('orders', 'seller', 'type', 'cou'));
        }
        if($request->has('country_id')){
            $cou = $request->country_id;
            $orders = DB::table('orders')
                ->orderBy('id', 'desc')
                ->join('order_details', 'orders.id', '=', 'order_details.order_id')
                ->where('country_id', $request->country_id)
                ->join('users', 'order_details.seller_id', '=', 'users.id')
                ->where('users.user_type', '!=', 'admin')
                ->select('orders.id')
                ->distinct()
                ->get();
            return view('orders.index', compact('orders', 'type', 'cou'));
        }
           $orders = DB::table('orders')
                ->orderBy('id', 'desc')
                ->join('order_details', 'orders.id', '=', 'order_details.order_id')
                ->where('viewed', 0)
                ->join('users', 'order_details.seller_id', '=', 'users.id')
                ->where('users.user_type', '!=', 'admin')
                ->select('orders.id')
                ->distinct()
                ->get();
                return view('orders.index', compact('orders', 'type', 'cou'));

    }

    /**
     * Display a single sale to admin.
     *
     * @return \Illuminate\Http\Response
     */
    public function sales_show($id)
    {
        $order = Order::findOrFail(decrypt($id));
        $order->viewed = 1;
        $order->save();
        return view('sales.show', compact('order'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $country = session()->get('country');
        if(!isset($request->session()->get('shipping_info')['address_id']) || !session()->has('cart_'.$country)){
            flash(__('messages.error_msg'))->error();
            return redirect()->route('cart');
        }

        $order = new Order;
        if (Auth::check()) {
            $order->user_id = Auth::user()->id;
        } else {
            $order->guest_id = mt_rand(100000, 999999);
        }


        $order->shipping_address = json_encode($request->session()->get('shipping_info'));
        $order->payment_type = $request->payment_option;
        $order->code = date('Ymd-his');
        $order->date = strtotime('now');
        $order->country_id = get_country()->id;

        if ($order->save()) {
                if(isset($request->session()->get('shipping_info')['address_id'])){
                    $order->address_id = $request->session()->get('shipping_info')['address_id'];
                }
            
            // else{
            //         $addr = auth()->user()->addresses()->create(
            //             [
            //                 'city_id'=>$request->session()->get('shipping_info')['city'],
            //                 'area_id'=>$request->session()->get('shipping_info')['area'],
            //                 'zone_id'=>$request->session()->get('shipping_info')['zone'],
            //                 'address_details'=>$request->session()->get('shipping_info')['address_details'],
            //                 'building_no'=>$request->session()->get('shipping_info')['building_no'],
            //                 'floor_no'=>$request->session()->get('shipping_info')['floor_no'],
            //                 'apartment_no'=>$request->session()->get('shipping_info')['apartment_no'],
            //                 'postal_code'=>$request->session()->get('shipping_info')['postal_code'],
            //                 'phone'=>$request->session()->get('shipping_info')['phone'],
            //                 'name'=>$request->session()->get('shipping_info')['name'],
            //                 'email' => auth()->user()->email,
            //             ]);
            //         $order->address_id = $addr->id;
            // }
            
            
            $subtotal = 0;
            $tax = 0;
            $city = City::find($request->session()->get('shipping_info')['city']);
            $shipping = $city ? $city->delivery_price : 0;
            foreach (Session::get('cart_'.$country) as $key => $cartItem) {
                // dd($cartItem);
                $product = Product::find($cartItem['id']);
                $subtotal += $cartItem['price'] * $cartItem['quantity'];
                $tax += $cartItem['tax'] * $cartItem['quantity'];
                               

                if (isset($cartItem['variations']))
                    $product_variation = $cartItem['variations'];
                if (isset($product_variation) && !is_null($product_variation)) {
                    $variations = Variation::find($product_variation);
                    if (isset($variations) && !is_null($variations)){
                        $variations->qty -= $cartItem['quantity'];
                    $variations->save();}
                }
                $order_detail = new OrderDetail;
                $order_detail->order_id = $order->id;
                $order_detail->seller_id = $product->user_id;
                $order_detail->product_id = $product->id;
                if (isset($product_variation)){
                    $order_detail->variation_id = $product_variation;
                }
                else{
                    $order_detail->variation_id = null;
                    $product->main_quantity -= $cartItem['quantity'];
                }
                $order_detail->price = $cartItem['price'] * $cartItem['quantity'];
                $order_detail->commission = $cartItem['price'] * $cartItem['quantity'] * ($product->category->vendor_commission/100);;
                $order_detail->tax = $cartItem['tax'] * $cartItem['quantity'];
                $order_detail->shipping_cost = $shipping;
                $order_detail->quantity = $cartItem['quantity'];
                $order_detail->save();
                $product->num_of_sale++;
                $product->save();
            }

            $order->grand_total = $subtotal + $tax + $shipping;
            if (Session::has('coupon_discount')) {
                $order->grand_total -= Session::get('coupon_discount');
                
                $order->coupon_discount = Session::get('coupon_discount');

                $coupon_usage = new CouponUsage;
                $coupon_usage->user_id = Auth::user()->id;
                $coupon_usage->coupon_id = Session::get('coupon_id');
                $coupon_usage->save();
            } elseif (Session::has('coupon_url')) {
                if (CouponUrl::find(session()->get('coupon_url'))) {
                    $affiliate_id = CouponUrl::find(session()->get('coupon_url'))->affiliate_id;
                    $value = BusinessSetting::where('type', 'coupon_affiliate_value')->first()->value;
                    $discount = explode('_', $value)[0];
                    $type = explode('_', $value)[1];

                    if (Order::where('user_id', auth()->user()->id)->where('coupon_url_id', session()->get('coupon_url'))->first() == null) {
                        if ($type == 'amount') {
                            $order->grand_total -= $discount;
                            $order->coupon_discount = $discount;
                        } else {
                            $order->grand_total -= ($order->grand_total * $discount) / 100;
                            $order->coupon_discount = ($order->grand_total * $discount) / 100;
                        }
                        $order->affiliate_id = $affiliate_id;
                        $order->coupon_url_id = session()->get('coupon_url');
                    }
                }
            }
            session()->forget('coupon_url');
            session()->forget('coupon_affiliate');
            if($order->grand_total < 0){$order->grand_total=0;}
            $order->save();
            if(\App\BusinessSetting::where('type', 'shipment_smsa')->first()->value == 1 && $order->addresses->City->smsa == 1){
                $order->shipment_type = 1;
            }elseif(\App\BusinessSetting::where('type', 'shipment_aramex')->first()->value == 1 && $order->addresses->City->aramex == 1){
                $order->shipment_type = 2;
            }else{
                $order->shipment_type = 0;
            }
            $order->save();
                $request->session()->put('order_id', $order->id);
                session()->forget('shipping_info');
                session()->forget('cart_'.$country);
            }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
        $order = Order::findOrFail(decrypt($id));
        $order->viewed = 1;
        $order->save();
        return view('orders.show', compact('order'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        if ($order != null) {
            foreach ($order->orderDetails as $key => $orderDetail) {
                $orderDetail->delete();
            }
            $order->delete();
            
            if($order->shipment_type == 1){ // check smsa activation
                $smsa_shipment = new SmsaShipmentController;
                $shipment = $smsa_shipment->CancelShipment($order->awb); // cancel shipment also if allowed
            }elseif($order->shipment_type == 2){
                $aramex_shipment = new AramexShipmentController;
                $shipment = $aramex_shipment->CancelShipment($order->awb); // cancel shipment also if allowed
            }
            
            flash('Order has been deleted successfully')->success();
        } else {
            flash('Something went wrong')->error();
        }
        return back();
    }

    public function order_details(Request $request)
    {
        $this->validate(request() , [
            'order_id' => 'required|exists:orders,id',
        ]);
        $order = Order::findOrFail($request->order_id);
        return view('frontend.partials.order_details_seller', compact('order'));
    }

    public function update_delivery_status(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'order_id' => 'required|exists:orders,id',
            'status' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 500, 'message' => $validator->errors()->messages()]);
        }
        
        $order = Order::find($request->order_id);
        $staus_id = Status::where('name_en', $request->status)->pluck('id')[0];
        if($order->status_id < $staus_id){
        $order->status_id = $staus_id;
        $order->is_cancelled = 0;
        if($request->status == 'delivered'){
            $order->payment_status = 'paid';
        }
        foreach ($order->orderDetails as $key => $orderDetail) {
            $orderDetail->delivery_status = $request->status;
        if($request->status == 'delivered'){
            $orderDetail->payment_status = 'paid';
        }
        if($request->status == 'Canceled'){
            $qty = $orderDetail->quantity;
            if($orderDetail->Variation){
                
                $orderDetail->Variation->qty += $qty;
                $orderDetail->Variation->save();
            }else{
                $orderDetail->product->main_quantity += $qty;
                $orderDetail->product->save();
            }
        }
            $orderDetail->save();
        }
        $save = $order->save();
        if($save && $request->status == 'on_delivery'){  /// create smsa shipment
        if($order->shipment_type == 1){ // check smsa activation
            $smsa_shipment = new SmsaShipmentController;
            $shipment = $smsa_shipment->goToShipment($order->id,$type=0);
            if($shipment){
            $order->shipment_type = 1;
            $order->save();
                return response()->json(['status' => 200, 'message' => 'Smsa Request was sent successfully']);
            }
            else {return response()->json(['status' => 500, 'message' => 'Something went wrong']);}
            
        }elseif($order->shipment_type == 2){
            $aramex_shipment = new AramexShipmentController;
            $shipment = $aramex_shipment->goToShipment($order->id,$type=0);
            if($shipment){
                $order->shipment_type = 2;
                $order->save();
                return response()->json(['status' => 200, 'message' => 'Aramex Request was sent successfully']);
            }
            else
                return response()->json(['status' => 500, 'message' => 'Something went wrong']);
        }elseif($order->shipment_type == 0){
            return response()->json(['status' => 200, 'message' => 'Request was sent successfully']);
        }
        
        }
        
        
        if($save && $request->status == 'Canceled' && $order->awb != null){  /// cancel smsa shipment
        
            if(\App\BusinessSetting::where('type', 'shipment_smsa')->first()->value == 1 && $order->shipment_type == 1){ // check smsa activation
                $smsa_shipment = new SmsaShipmentController;
                $shipment = $smsa_shipment->CancelShipment($order->awb); // cancel shipment also if allowed
                if($shipment)
                    return response()->json(['status' => 200, 'message' => 'This Order Canceled Successfully']);
                else
                    return response()->json(['status' => 500, 'message' => 'Something went wrong']);
                    
            }
            elseif(\App\BusinessSetting::where('type', 'shipment_aramex')->first()->value == 1 && $order->shipment_type == 2){
                // $aramex_shipment = new AramexShipmentController;
                // $shipment = $aramex_shipment->CancelShipment($order->awb); // cancel shipment also if allowed
                // if($shipment)
                    return response()->json(['status' => 200, 'message' => 'This Order Canceled Successfully']);
                // else
                //     return response()->json(['status' => 500, 'message' => 'Something went wrong']);
                    
            }

        } 
        
        return response()->json(['status' => 200, 'message' => 'Delivery status has been updated']);
        
    }
    return response()->json(['status' => 500, 'message' => 'It is not allowed to return to its previous condition']);
    }

    public function update_payment_status($status, $order_id)
    {
        $order = Order::findOrFail($request->order_id);
        foreach ($order->orderDetails as $key => $orderDetail) {
            $orderDetail->update(['payment_status' => $request->input('status')]);
        }
        $order->payment_status = $request->input('status');
        $order->save();
        return 1;
    }
    
    public function statusShipment($order_id)
    {
        $order = Order::find($order_id);
        
        if(\App\BusinessSetting::where('type', 'shipment_smsa')->first()->value == 1 && $order->shipment_type == 1){ // check smsa activation
                $smsa_shipment = new SmsaShipmentController;
                $shipment = $smsa_shipment->statusShipment($order->awb); // cancel shipment also if allowed
                
                if($shipment)
                    return $shipment;
                else
                    return '';
                    
            }elseif(\App\BusinessSetting::where('type', 'shipment_aramex')->first()->value == 1 && $order->shipment_type == 2){
                $aramex_shipment = new AramexShipmentController;
                $shipment = $aramex_shipment->statusShipment($order->awb); // cancel shipment also if allowed
                if($shipment)
                    return $shipment;
                else
                    return '';
                    
            }
    }

    public function PrintShipmentInvoice($order_id)
    {
        $order = Order::find($order_id);
        
        if(\App\BusinessSetting::where('type', 'shipment_smsa')->first()->value == 1 && $order->shipment_type == 1){ // check smsa activation
                $smsa_shipment = new SmsaShipmentController;
                $shipment = $smsa_shipment->PrintShipmentInvoice($order->awb, $order->ref_number); // print shipment also if allowed
            }elseif(\App\BusinessSetting::where('type', 'shipment_aramex')->first()->value == 1 && $order->shipment_type == 2){
                $aramex_shipment = new AramexShipmentController;
                $shipment = $aramex_shipment->PrintShipmentInvoice($order->awb, $order->ref_number); // print shipment also if allowed
            }
    }

    //  public function SmsaCities()
    //  {
    //              if(\App\BusinessSetting::where('type', 'shipment_smsa')->first()->value == 0){
    //         flash(__('Smsa Shipment is not activate, go to activation method to active it'));   
    //         return back();
    //     }
    //     $passKey = env('SAMSA_PASS_KEY');
    //     $smsa = new Smsa($passKey);
    //     $smsa->shouldUseExceptions = false; // Disable throwing exceptions by the library

    //     $cities = $smsa->cities();

    //     if( $cities->success) {
    //         dd($cities->data);
    //     } else {
    //         dd($cities->error);
    //     }
    //  }
     
public function trackShipment($awb){
        $order = Order::find($order_id);
        
        if(\App\BusinessSetting::where('type', 'shipment_smsa')->first()->value == 1 && $order->shipment_type == 1){ // check smsa activation
                $smsa_shipment = new SmsaShipmentController;
                $shipment = $smsa_shipment->PrintShipmentInvoice($order->awb, $order->ref_number); // print shipment also if allowed
                if($shipment)
                    return $shipment;
                else
                    return '';
                    
            }elseif(\App\BusinessSetting::where('type', 'shipment_aramex')->first()->value == 1 && $order->shipment_type == 2){
                $aramex_shipment = new AramexShipmentController;
                $shipment = $aramex_shipment->trackShipments($order->awb);; // print shipment also if allowed
                if($shipment)
                    print_r($shipment) ;
                else
                    return '';
                    
            }
     } 
     
     
}
