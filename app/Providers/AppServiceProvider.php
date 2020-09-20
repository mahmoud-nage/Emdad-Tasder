<?php

namespace App\Providers;

use App\Brand;
use App\Banner;
use App\Event;
use App\Gallery;
use App\Slider;
use App\Country;
use App\SeoSetting;
use App\Product;
use App\Category;
use App\HomeCategory;
use App\GeneralSetting;
use App\BusinessSetting;
use App\Unit;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Http\Request;
use GeoIP;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // $geoip = GeoIP::setIp(request()->ip());
        // $country_coude = $geoip->getCountryCode();
        // $country = Country::where('status',1)->where('code', $country_coude)->first();
        // session()->put('country', $country->code);
        // //Check for 'lang' cookie
        // $countries = $countries = Country::where('status',1)->get();
        // //Get visitors IP
        // $ip = request()->ip();
        // //Get visitors Geo info based on his IP
        // $arr_ip = GeoIP::getLocation($ip);
        // // $geo = GeoIP::getLocation($ip);
        // //Get visitors country name
        // $country = $geo['country'];

        // dd($country,$ip,$geo);

        Schema::defaultStringLength(191);

        if (auth()->check()) {
            session()->put('country', auth()->user()->country);
        } else {
            session()->get('country') ? session()->get('country') : session()->put('country', 'EG');
        }

        if (Schema::hasTable('categories')) {
            $categories = Category::all();
            view()->share('categories', $categories);
        }

        if (Schema::hasTable('seo_settings')) {
            $seo_setting = SeoSetting::first();
            view()->share('seo_setting', $seo_setting);
        }
        if (Schema::hasTable('brands')) {
            $brands = Brand::all();
            view()->share('brands', $brands);
        }
        if (Schema::hasTable('units')) {
            $units = Unit::where('active', 1)->get();
            view()->share('units', $units);
        }
        if (Schema::hasTable('countries')) {
            $countries = Country::where('status', 1)->get();
            view()->share('countries', $countries);
        }
        if (Schema::hasTable('sliders')) {
            $sliders = Slider::where('published', 1)->where('type', 'web')->latest()->get();
            view()->share('sliders', $sliders);
        }
        if (Schema::hasTable('banners')) {
            $banners = Banner::where('published', 1)->where('type', 'web')->latest()->get();
            view()->share('banners', $banners);
        }
        if (Schema::hasTable('home_categories')) {
            $home_categories = HomeCategory::where('status', 1)->latest()->take(10)->get();
            view()->share('home_categories_sliders', $home_categories);
        }

        if (Schema::hasTable('general_settings')) {
            $general_setting = GeneralSetting::first();
            view()->share('general_setting', $general_setting);
        }
        if (Schema::hasTable('business_settings')) {
            $business_settings = BusinessSetting::all();
            view()->share('business_settings', $business_settings);
        }

        if (Schema::hasTable('events')) {
            $events = Event::all();
            view()->share('events', $events);
        }

        if (Schema::hasTable('galleries')) {
            $galleries = Gallery::all();
            view()->share('galleries', $galleries);
        }


    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

    }
}
