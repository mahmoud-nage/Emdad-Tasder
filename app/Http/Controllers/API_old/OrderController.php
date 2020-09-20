<?php

namespace App\Http\Controllers\API;



use App\Cart;
use App\User;
use App\Coupon;
use App\Address;
use App\Variation;
use App\CouponUsage;
use App\Brand;
use App\Category;
use App\City;
use App\Http\Controllers\Controller;
use App\Http\Controllers\SearchController;
use App\Meal;
use App\Order;
use App\OrderDetail;
use App\OrderDetails;
use App\Point;
use App\Product;
use App\PromoCode;
use App\Seller;
use App\SeoSetting;
use App\Setting;
use App\Size;
use App\SubCategory;
use App\SubSubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $orders = Order::with('orderDetails', 'status')
            ->where('user_id', $request->input('user_id'))->get();
        return response()->json(['status' => 200, 'data' => $orders],200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'api_token' => 'required|exists:users,api_token',
            'user_id' => 'required|exists:users,id',
            'address_id' => 'required|exists:addresses,id',
            'promo_code' => 'nullable|exists:coupons,code',
            'payment_option' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 500, 'message' => $validator->errors()->messages()], 200);
        }

        // create new order for user using his cart info
        // remove user cart
        $lang = 'ar';
        if (!is_null($request->header('lang'))) {
            $lang = $request->header('lang');
        }

        $column = $lang == 'ar' ? 'name_ar' : 'name_en';
        $column_des = $lang == 'ar' ? 'description_ar' : 'description_en';

        $carts = Cart::where('user_id', $request->input('user_id'))->get()->toArray();
        $count = count($carts);
        if($count <= 0){
            return 'cart Empty';
        }

        $address = Address::where('id', $request->input('address_id'))->first();

        $user = User::find($request->input('user_id'));
        $data = [];
        $data['name'] = $address->name?$address->name:$user->name;
        $data['email'] = $user->email;
        $data['address_id'] = $request->input('address_id');
        $data['address_details'] =  $address->address_details;
        $data['building_no'] = $address->building_no;
        $data['floor_no'] = $address->floor_no;
        $data['apartment_no'] = $address->apartment_no;
        $data['city'] = $address->city_id;
        $data['area'] = $address->area_id;
        $data['zone'] = $address->zone_id;
        $data['postal_code'] = $address->postal_code;
        $data['phone'] = $address->phone;
        $data['country'] = $address->City->country['name_'.app()->getLocale()];
        $data['delivery_price'] = $address->City->delivery_price;
        
        $order = new Order;
        $order->code = date('Ymd-his');
        $order->date = strtotime('now');
        $order->user_id = $request->input('user_id');
        $order->payment_type = $request->payment_option;
        $order->address_id = $request->input('address_id');
        $order->shipping_address = json_encode($data);

        if ($order->save()) {
            $subtotal = 0;
            $tax = 0;
            $shipping = $address->city_id ? $address->City->delivery_price : 0;
            foreach ($carts as $key => $cartItem) {

                $product = Product::find($cartItem['product_id']);
                $subtotal += $cartItem['price'] * $cartItem['amount'];
                $tax += $cartItem['tax'] * $cartItem['amount'];
                               

                if (isset($cartItem['variation_id']))
                    $product_variation = $cartItem['variation_id'];
                if (isset($product_variation) && !is_null($product_variation)) {
                    $variations = Variation::find($product_variation);
                    if (isset($variations) && !is_null($variations)){
                        $variations->qty -= $cartItem['amount'];
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
                    $product->main_quantity -= $cartItem['amount'];
                }
                $order_detail->price = $cartItem['price'] * $cartItem['amount'];
                $order_detail->commission = $cartItem['price'] * $cartItem['amount'] * ($product->category->vendor_commission/100);
                $order_detail->tax = $cartItem['tax'] * $cartItem['amount'];
                $order_detail->shipping_cost = $shipping;
                $order_detail->quantity = $cartItem['amount'];
                $order_detail->save();
                $product->num_of_sale++;
                $product->save();
            }

            $order->grand_total = $subtotal + $tax + $shipping;
            $coupon_discount = 0;
            if ($request->has('promo_code') && !is_null($request->promo_code)) {
                    $coupon = Coupon::where('code', $request->promo_code)->first();
                    if ($coupon->discount_type == 'amount') {
                        $coupon_discount = $coupon->discount;
                        $order->grand_total -= $coupon_discount;
                    } else if ($coupon->discount_type == 'percent') {
                        $coupon_discount = $subtotal * ($coupon->discount / 100);
                        $order->grand_total -= $coupon_discount;
                    }

                $order->coupon_discount = $request->coupon_discount;
                $coupon_usage = new CouponUsage;
                $coupon_usage->user_id = $request->user_id;
                $coupon_usage->coupon_id = $coupon->id;
                $coupon_usage->save();
            }

        if($order->grand_total < 0){$order->grand_total=0;}
        $order->save();
        
        Cart::where('user_id', $request->input('user_id'))->delete();
        return $order;
        }
    
    }

        public function singleHistory(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'order_id' => 'required',
            'country_id' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 500, 'message' => $validator->errors()->messages()], 500);
        }
        $order = Order::where('id', $request->input('order_id'))->with('orderDetails', 'status')->first();
        $count = count($order->orderDetails);
        $subOrederPice = 0;
        
                $lang = 'ar';
        if (!is_null($request->header('lang'))) {
            $lang = $request->header('lang');
        }
        
        $column = $lang == 'ar' ? 'name_ar' : 'name_en';
        $column_des = $lang == 'ar' ? 'description_ar' : 'description_en';
        
        
        
        $products = [];
        $order_details=[];
        $_order =[];
        foreach ($order->orderDetails as  $key => $orderDetail){
            $product = Product::where('products.id', $orderDetail->product_id)
                ->join('product_countries', 'products.id', '=', 'product_countries.product_id')
                ->where('product_countries.country_id', $request->input('country_id'))
                ->select('products.id as id', $column . ' as name', 'thumbnail_img', 'featured_img',
                    'flash_deal_img', 'product_countries.unit_price', 'product_countries.discount',
                    'product_countries.discount_type', 'products.category_id', 'products.rating', 'product_countries.purchase_price')->first();
                    
                     $choise = $orderDetail->variation_id?$orderDetail->Variation->getChoice():' ';
                     if($choise != ' '){
                        $products['name'] = $product->name.'( '. $choise .' )';
                     }else{
                         $products['name'] = $product->name;
                     }
                     
                    $subOrederPice += $orderDetail->price;
                    $products['amount'] = $orderDetail->quantity;
                    $products['unit_price'] = $orderDetail->price/$orderDetail->quantity;
                    $order_details[]= $products;
                    
                    
        }
        $_order['order_details'] = $order_details;
        $_order['grand_total'] = $order->grand_total;
        $_order['discount_points'] = $order->coupon_discount;
        $_order['delivery'] = $order->orderDetails->first()->shipping_cost;
        $_order['tax'] = $order->orderDetails->sum('tax');
        $_order['subTotal'] = $subOrederPice;
        $_order['is_cancelled'] = $order->is_cancelled;
        $_order['payment_type'] = $order->payment_type;
        $_order['payment_status'] = $order->payment_status;
        $_order['payment_id'] = $order->payment_id;
        
        return response()->json(['status' => 200, 'data' => $_order], 200);
    }

    public function search(Request $request)
    {

        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'q' => 'required',
            'country_id' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 500, 'message' => $validator->errors()->messages()], 500);
        }
        $lang = 'ar';
        if (!is_null($request->header('lang'))) {
            $lang = $request->header('lang');
        }
        
        $query = $request->q;
        $brand_id = (Brand::where('slug', $request->brand)->first() != null) ? Brand::where('slug', $request->brand)->first()->id : null;
        $sort_by = $request->sort_by;
        $category_id = (Category::where('slug', $request->category)->first() != null) ? Category::where('slug', $request->category)->first()->id : null;
        $subcategory_id = (SubCategory::where('slug', $request->subcategory)->first() != null) ? SubCategory::where('slug', $request->subcategory)->first()->id : null;
        $subsubcategory_id = (SubSubCategory::where('slug', $request->subsubcategory)->first() != null) ? SubSubCategory::where('slug', $request->subsubcategory)->first()->id : null;
        $min_price = $request->min_price;
        $max_price = $request->max_price;
        $seller_id = $request->seller_id;

        $conditions = ['published' => 1];

        if ($brand_id != null) {
            $conditions = array_merge($conditions, ['brand_id' => $brand_id]);
        }
        if ($category_id != null) {
            $conditions = array_merge($conditions, ['category_id' => $category_id]);
        }
        if ($subcategory_id != null) {
            $conditions = array_merge($conditions, ['subcategory_id' => $subcategory_id]);
        }
        if ($subsubcategory_id != null) {
            $conditions = array_merge($conditions, ['subsubcategory_id' => $subsubcategory_id]);
        }
        if ($seller_id != null) {
            $conditions = array_merge($conditions, ['user_id' => Seller::findOrFail($seller_id)->user->id]);
        }

        $products = get_country()->products()->where($conditions);

        if ($min_price != null && $max_price != null) {
            $products = $products->where('product_countries.unit_price', '>=', $min_price)->where('product_countries.unit_price', '<=', $max_price);
        }

        if ($query != null) {
            $searchController = new SearchController;
            $searchController->store($request);
            $products = $products->where('name_ar', 'like', '%' . $query . '%')->orWhere('name_en', 'like', '%' . $query . '%');
        }

        if ($sort_by != null) {
            switch ($sort_by) {
                case '1':
                    $products->orderBy('created_at', 'desc');
                    break;
                case '2':
                    $products->orderBy('created_at', 'asc');
                    break;
                case '3':
                    $products->orderBy('product_countries.unit_price', 'asc');
                    break;
                case '4':
                    $products->orderBy('product_countries.unit_price', 'desc');
                    break;
                default:
                    // code...
                    break;
            }
        }

        $products = filter_products($products)->paginate(12)->appends(request()->query());
        foreach($products as $product){
            $price = $product->api_get_price($product->id, $request->input('country_id'));
            $product->unit_price=$price['unit_price'];
            $product->name = $lang=='ar' ? $product->name_ar : $product->name_en;
        }
        return response()->json(['status' => 200, 'data' => $products], 200);
    }
    
    public function cancel(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'api_token' => 'required',
            'order_id' => 'required|exists:orders,id',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 500, 'message' => $validator->errors()->messages()], 200);
        }
        
        $order = Order::where('id',$request->order_id)->where('is_cancelled',1)->first();
        if ($order != null) {
                $order->is_cancelled = 0;
                $order->status_id = 5;
                $order->save();
            foreach ($order->orderDetails as $key => $orderDetail) {
                $orderDetail->delivery_status = 'Canceled';
                $orderDetail->save();
        }
                    return response()->json(['status' => 200, 'message' => 'Order has been Canceled successfully'], 200);
        } else {
                        return response()->json(['status' => 500, 'message' => 'Something went wrong'], 200);
        }
    }

}
