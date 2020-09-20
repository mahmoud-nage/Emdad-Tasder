<?php

use Spatie\Sitemap\SitemapGenerator;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|*

//*/


Route::get('sitemap', function () {
    SitemapGenerator::create('https://example.com')->writeToFile($path);
    return 'Site Map Created';
});
Route::get('/sitemap.xml', function () {
    return base_path('sitemap.xml');
});


Auth::routes(['verify' => true]);
Route::get('/', 'HomeController@index')->name('home');
Route::get('/logout', '\App\Http\Controllers\Auth\LoginController@logout')->name('logout');
Route::post('/language', 'LanguageController@changeLanguage')->name('language.change');
Route::get('/country', 'HomeController@change_country')->name('country.change');

Route::group(['prefix' => '{country}', 'where' => ['country' => '^([^\s admin]+)'], 'middleware' => 'country'], function () {

    Route::post('/currency', 'CurrencyController@changeCurrency')->name('currency.change');
    Route::get('/social-login/redirect/{provider}', 'Auth\LoginController@redirectToProvider')->name('social.login');
    Route::get('/social-login/{provider}/callback', 'Auth\LoginController@handleProviderCallback')->name('social.callback');
    Route::get('/users/login', 'HomeController@login')->name('user.login');
    Route::get('/users/registration', 'HomeController@registration')->name('user.registration');
    Route::post('/users/login', 'HomeController@user_login')->name('user.login.submit');
    Route::post('/users/login/cart', 'HomeController@cart_login')->name('cart.login.submit');
    Route::get('/about-us', function () {
        return view('frontend.about_us');
    })->name('about_us');

    Route::get('/contact-us', function () {
        return view('frontend.contact_us');
    })->name('contact_us');


    Route::get('/', 'HomeController@index')->name('home');
    Route::get('/blog', 'HomeController@blog')->name('blog');
    Route::get('/blog/show/{id}', 'HomeController@blogShow')->name('blogShow');

    Route::get('/product/{slug}', 'HomeController@product')->name('product');
    Route::get('/products', 'HomeController@listing')->name('products');
    Route::get('/search?category={category_slug}', 'HomeController@search')->name('products.category');
    Route::get('/search?subcategory={subcategory_slug}', 'HomeController@search')->name('products.subcategory');
    Route::get('/search?subsubcategory={subsubcategory_slug}', 'HomeController@search')->name('products.subsubcategory');
    Route::get('/search?brand={brand_slug}', 'HomeController@search')->name('products.brand');
    Route::post('/product/variant_price', 'HomeController@variant_price')->name('products.variant_price');

    Route::post('/product/variant_option', 'HomeController@variant_options')->name('products.variant_option');

    Route::get('/shops/visit/{slug}', 'HomeController@shop')->name('shop.visit');
    Route::get('/shops/visit/{slug}/{type}', 'HomeController@filter_shop')->name('shop.visit.type');

    Route::get('/cart', 'CartController@index')->name('cart');
    Route::post('/cart/nav-cart-items', 'CartController@updateNavCart')->name('cart.nav_cart');

    Route::any('/cart/show-cart-modal', 'CartController@showCartModal')->name('cart.showCartModal');

    Route::post('/cart/addtocart', 'CartController@addToCart')->name('cart.addToCart');
    Route::post('/cart/removeFromCart', 'CartController@removeFromCart')->name('cart.removeFromCart');
    Route::post('/cart/updateQuantity', 'CartController@updateQuantity')->name('cart.updateQuantity');

//Paypal START
    Route::get('/paypal/payment/done', 'PaypalController@getDone')->name('payment.done');
    Route::get('/paypal/payment/cancel', 'PaypalController@getCancel')->name('payment.cancel');
//Paypal END

// SSLCOMMERZ Start
    Route::get('/sslcommerz/pay', 'PublicSslCommerzPaymentController@index');
    Route::POST('/sslcommerz/success', 'PublicSslCommerzPaymentController@success');
    Route::POST('/sslcommerz/fail', 'PublicSslCommerzPaymentController@fail');
    Route::POST('/sslcommerz/cancel', 'PublicSslCommerzPaymentController@cancel');
    Route::POST('/sslcommerz/ipn', 'PublicSslCommerzPaymentController@ipn');
//SSLCOMMERZ END

//Stipe Start
    Route::get('stripe', 'StripePaymentController@stripe');
    Route::post('stripe', 'StripePaymentController@stripePost')->name('stripe.post');
//Stripe END

    Route::get('/compare', 'CompareController@index')->name('compare');
    Route::get('/compare/reset', 'CompareController@reset')->name('compare.reset');
    Route::post('/compare/addToCompare', 'CompareController@addToCompare')->name('compare.addToCompare');

    Route::resource('subscribers', 'SubscriberController');

//    Route::get('/brands', 'HomeController@all_brands')->name('brands.all');
    Route::get('/categories', 'HomeController@all_categories')->name('categories.all');
    Route::get('/search', 'HomeController@search')->name('search');
    Route::get('/search?q={search}', 'HomeController@search')->name('suggestion.search');
    Route::post('/ajax-search', 'HomeController@ajax_search')->name('search.ajax');
    Route::post('/config_content', 'HomeController@product_content')->name('configs.update_status');

//    Route::get('/sellerpolicy', 'HomeController@sellerpolicy')->name('sellerpolicy');
    Route::get('/returnpolicy', 'HomeController@returnpolicy')->name('returnpolicy');
    Route::get('/supportpolicy', 'HomeController@supportpolicy')->name('supportpolicy');
    Route::get('/terms', 'HomeController@terms')->name('terms');
    Route::get('/privacypolicy', 'HomeController@privacypolicy')->name('privacypolicy');

    // start new for follow purchase
    Route::get('follow_purchase', function () {
        return view('frontend.follow_purchase');
    })->name('purchase.follow');
    Route::any('get_follow_purchase', 'PurchaseHistoryController@followPurchase')->name('purchase.follow.get');
    // end new for follow purchase

    Route::group(['middleware' => ['user']], function () {
        Route::get('/address/{id}', 'AddressController@destroy')->name('address.remove');
        Route::any('/address', 'AddressController@store')->name('address.create');
        Route::any('/address/{id}', 'AddressController@update')->name('address.update');
        Route::get('/dashboard', 'HomeController@dashboard')->name('dashboard');
        Route::get('/profile', 'HomeController@profile')->name('profile');
        Route::post('/customer/update-profile', 'HomeController@customer_update_profile')->name('customer.profile.update');
        Route::post('/wishlists/remove', 'WishlistController@remove')->name('wishlists.remove');
        Route::get('/wallet', 'WalletController@index')->name('wallet.index');
        Route::resource('support_ticket', 'SupportTicketController');
//        Route::get('support_seller_ticket/{id}', 'SupportTicketController@seller_show')->name('support_ticket.seller_show');
//        Route::post('support_ticket/reply', 'SupportTicketController@seller_store')->name('support_ticket.seller_store');

        Route::any('/track_your_order/{order_id}', 'HomeController@trackOrder')->name('orders.track');
        Route::any('/checkout/payment', 'CheckoutController@checkout')->name('payment.checkout');
        Route::post('/checkout/payment_select', 'CheckoutController@store_shipping_info')->name('checkout.store_shipping_infostore');

        Route::get('/checkout/front', 'CheckoutController@get_shipping_info')->name('checkout.shipping_info');

        Route::get('/checkout/payment_select', 'CheckoutController@get_payment_info')->name('checkout.payment_info');
        Route::post('/checkout/apply_coupon_code', 'CheckoutController@apply_coupon_code')->name('checkout.apply_coupon_code');
        Route::post('/checkout/remove_coupon_code', 'CheckoutController@remove_coupon_code')->name('checkout.remove_coupon_code');


    });

//    Route::group(['prefix' => 'seller'], function () {
//        Route::group(['middleware' => ['seller', 'seller.verified']], function () {
//            Route::post('/seller/update-profile', 'HomeController@seller_update_profile')->name('seller.profile.update');
//
//            Route::get('/product/{id}/edit', 'HomeController@show_product_edit_form')->name('seller.products.edit');
//
//            Route::post('/recharge', 'WalletController@recharge')->name('wallet.recharge');
//            // payment request
//            Route::any('seller/payments/request', 'SellerController@seller_payment_request')->name('seller.seller_payment_request');
//            Route::get('/products/seller', 'HomeController@seller_product_list')->name('seller_products');
//            Route::get('/product/upload/seller', 'HomeController@show_product_upload_form')->name('seller.products.upload');
//
//            Route::resource('payments', 'PaymentController');
//            Route::get('/reviews', 'ReviewController@seller_reviews')->name('reviews.seller');
//        });
//
//        Route::get('/shop/apply_for_verification', 'ShopController@verify_form')->name('shop.verify');
//        Route::post('/shop/apply_for_verification', 'ShopController@verify_form_store')->name('shop.verify.store');
//
//    });

    Route::group(['middleware' => ['auth']], function () {
        Route::resource('wishlists', 'WishlistController');

        Route::get('/purchase_history/cancel/{id}', 'PurchaseHistoryController@cancel')->name('purchase_history.cancel');
        Route::resource('purchase_history', 'PurchaseHistoryController');
        Route::any('/purchase_history/details', 'PurchaseHistoryController@purchase_history_details')->name('purchase_history.details');
        Route::get('/purchase_history/destroy/{id}', 'PurchaseHistoryController@destroy')->name('purchase_history.destroy');
        Route::resource('orders', 'OrderController');
        Route::get('/orders/destroy/{id}', 'OrderController@destroy')->name('orders.destroy');
        Route::post('/orders/details', 'OrderController@order_details')->name('orders.details');
    });


    Route::resource('shops', 'ShopController');


    Route::get('/instamojo/payment/pay-success', 'InstamojoController@success')->name('instamojo.success');

    Route::post('rozer/payment/pay-success', 'RazorpayController@payment')->name('payment.rozer');


    Route::get('/exchange/{from}/{to}', 'HomeController@exchange');

    Route::get('/weaccept-card/payment/chechout/{token}', function ($token) {
        return view('frontend.payment.AcceptCard', compact('token'));
    })->name('weaccept_card.payment');

});
Route::get('/paystack/payment/callback', 'PaystackController@handleGatewayCallback');
Route::get('/weaccept/payment/callback', 'AcceptCardController@callbackNotification');
Route::get('/weaccept-koisk/payment/callback', 'AcceptKioskController@callbackNotification');

Route::get('/products/destroy/{id}', 'ProductController@destroy')->name('products.destroy');
Route::get('/products/duplicate/{id}', 'ProductController@duplicate')->name('products.duplicate');
Route::post('/products/sku_combination', 'ProductController@sku_combination')->name('products.sku_combination');
Route::post('/products/sku_combination_edit', 'ProductController@sku_combination_edit')->name('products.sku_combination_edit');
Route::post('/products/featured', 'ProductController@updateFeatured')->name('products.featured');
Route::post('/products/published', 'ProductController@updatePublished')->name('products.published');
Route::post('/products/todays_deals', 'ProductController@updateTodaysDeal')->name('products.todays_deals');
Route::get('invoice/customer/{order_id}/seller', 'InvoiceController@customer_invoice_download')->name('customer.invoice.download');
Route::get('invoice/seller/{order_id}', 'InvoiceController@seller_invoice_download')->name('seller.invoice.download');
Route::post('/orders/update_delivery_status', 'OrderController@update_delivery_status')->name('orders.update_delivery_status');
Route::post('/orders/update_payment_status', 'OrderController@update_payment_status')->name('orders.update_payment_status');
Route::post('/subcategories/get_subcategories_by_category', 'SubCategoryController@get_subcategories_by_category')->name('subcategories.get_subcategories_by_category');
Route::post('/subsubcategories/get_subsubcategories_by_subcategory', 'SubSubCategoryController@get_subsubcategories_by_subcategory')->name('subsubcategories.get_subsubcategories_by_subcategory');
Route::post('/subsubcategories/get_brands_by_subsubcategory', 'SubSubCategoryController@get_brands_by_subsubcategory')->name('subsubcategories.get_brands_by_subsubcategory');
Route::post('/products/store', 'ProductController@store')->name('products.store');
Route::post('/products/update/{id}', 'ProductController@update')->name('products.update');
Route::resource('/reviews', 'ReviewController');

Route::get('/all-events', function(){
    return view('frontend.all_events');
})->name('all_events');
Route::get('/event/{id}', 'EventController@show')->name('singel_event');

Route::get('/all-galleries', function(){
    return view('frontend.galleries.all_galleries');
})->name('all_galleries');
Route::get('/gallery/{id}', 'GalleryController@show')->name('singel_gallery');

Route::get('/make-deal', function(){
    return view('frontend.make_deal.request_1');
})->name('make_deal1');
Route::post('/submit-request', 'order@make_deal')->name('submit_request');
