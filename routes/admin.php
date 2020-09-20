<?php

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register admin routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/admin', 'HomeController@admin_dashboard')->name('admin.dashboard')->middleware(['auth', 'admin']);
Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'admin']], function () {

    Route::get('/update_image', 'ProductController@update_image')->name('update_image');

    Route::group(['prefix' => 'affiliate'], function () {
        Route::get('/', 'AffiliateController@index')->name('affiliates.index');

        Route::get('/reports', 'AffiliateController@reports')->name('affiliates.reports');

        Route::get('/payments', 'AffiliateController@payments')->name('affiliates.payments');

        Route::post('/payments', 'AffiliateController@create_payment')->name('affiliates.payments.store');

        Route::get('/products', 'AffiliateController@products')->name('affiliates.products');

        Route::post('/products', 'AffiliateController@add_products')->name('affiliates.products.store');

        Route::get('/products/delete/{id}', 'AffiliateController@remove_products')->name('affiliates.products.delete');

        Route::get('/requests', 'AffiliateController@requests')->name('affiliates.requests');

        Route::get('/banners', 'AffiliateController@banners')->name('affiliates.banners');

        Route::post('/banners', 'AffiliateController@add_banner')->name('affiliates.banners.store');

        Route::post('/banners/update/{id}', 'AffiliateController@update_banner')->name('affiliates.banners.update');

        Route::get('/banners/{id}', 'AffiliateController@remove_banner')->name('affiliates.banners.destroy');

        Route::get('/settings', 'AffiliateController@settings')->name('affiliates.settings');

        Route::post('/settings', 'AffiliateController@update_settings')->name('affiliates.settings.update');

    });
    Route::resource('categories', 'CategoryController');
    Route::get('/categories/destroy/{id}', 'CategoryController@destroy')->name('categories.destroy');
    Route::post('/categories/featured', 'CategoryController@updateFeatured')->name('categories.featured');
    Route::post('/subsubcategories/featured', 'SubSubCategoryController@updateFeatured')->name('subsubcategories.featured');
//     Route::post('/subcategories/get_subcategories_by_category', 'SubCategoryController@get_subcategories_by_category')->name('subcategories.get_subcategories_by_category');
// Route::post('/subsubcategories/get_subsubcategories_by_subcategory', 'SubSubCategoryController@get_subsubcategories_by_subcategory')->name('subsubcategories.get_subsubcategories_by_subcategory');
// Route::post('/subsubcategories/get_brands_by_subsubcategory', 'SubSubCategoryController@get_brands_by_subsubcategory')->name('subsubcategories.get_brands_by_subsubcategory');
        Route::get('categories_vendor_commission', function(){
        return view('categories.vendor_commission');
    })->name('categories.vendor_commission');

    Route::post('categories/vendor_commission/update', 'CategoryController@vendor_commission_update')
    ->name('categories.vendor_commission.update');

    Route::resource('subcategories', 'SubCategoryController');
    Route::get('/subcategories/destroy/{id}', 'SubCategoryController@destroy')->name('subcategories.destroy');
    Route::get('/areas', 'AreaController@index')->name('areas.index');

        Route::group(['prefix' => 'cities'], function () {

        Route::get('/', 'CityController@index')->name('cities.index');
        Route::post('/update/shipment', 'CityController@update_shipment_status')->name('cities.update.shipment.status');
        Route::get('/edit/{id}', 'CityController@edit')->name('cities.edit');
        Route::post('/update/{id}', 'CityController@update')->name('cities.update');
                Route::get('/create', 'CityController@create')->name('cities.create');
        Route::post('/', 'CityController@store')->name('cities.store');

    });



    Route::get('/zones', 'ZoneController@index')->name('zones.index');

    Route::resource('subsubcategories', 'SubSubCategoryController');
    Route::get('/subsubcategories/destroy/{id}', 'SubSubCategoryController@destroy')->name('subsubcategories.destroy');

    Route::resource('brands', 'BrandController');
    Route::get('/brands/destroy/{id}', 'BrandController@destroy')->name('brands.destroy');

    Route::get('/packages', 'ProductController@packages')->name('packages.index');
    Route::get('/products/admin', 'ProductController@admin_products')->name('products.admin');
    Route::get('/products/seller', 'ProductController@seller_products')->name('products.seller');
    Route::get('/products/seller/pendding', 'ProductController@seller_pendding_products')->name('products.seller.pendding');
    Route::get('/products/create', 'ProductController@create')->name('products.create');
    Route::get('/products/admin/{id}/edit', 'ProductController@admin_product_edit')->name('products.admin.edit');
    Route::get('/products/seller/{id}/edit', 'ProductController@seller_product_edit')->name('products.seller.edit');
    Route::post('/products/todays_deal', 'ProductController@updateTodaysDeal')->name('products.todays_deal');
    Route::post('/products/get_products_by_subsubcategory', 'ProductController@get_products_by_subsubcategory')->name('products.get_products_by_subsubcategory');
    Route::any('seller/payments/confirmed', 'SellerController@confirmPayment')->name('seller.confirmPayment');

    Route::any('/products_seller', 'ProductController@seller_products')->name('seller.products');  // new
    Route::any('/orders_seller', 'OrderController@sales')->name('seller.orders');   // new

        Route::get('invoice/admin/{order_id}', 'InvoiceController@admin_invoice_download')->name('admin.invoice.download');



    // order shipment
    Route::any('/goToShipment/{order_id}', 'OrderController@goToShipment');   // send order request
    Route::any('/cancelShipment/{order_id}', 'OrderController@CancelShipment');   // cancel order request
    Route::any('/printShipment/{order_id}', 'OrderController@PrintShipmentInvoice')->name('shipment.invoice.download');   // print shipment invoice
    Route::any('/statusShipment/{order_id}', 'OrderController@statusShipment');   // status of order shipment
    Route::any('/trackShipment/{order_id}', 'OrderController@trackShipment');   // status of order shipment
    // Route::any('/SmsaCities', 'SmsaShipmentController@SmsaCities');   //  get all shipment cities available


    // // for test
    // // smsa shipment
    // Route::any('/goToShipment/{order_id}', 'SmsaShipmentController@goToShipment');   // send order request
    // Route::any('/cancelShipment/{awb}', 'SmsaShipmentController@CancelShipment');   // cancel order request
    // Route::any('/printShipment/{awb}/{ref}', 'SmsaShipmentController@PrintShipmentInvoice')->name('shipment.invoice.download');   // print shipment invoice
    // Route::any('/statusShipment/{awb}', 'SmsaShipmentController@statusShipment');   // status of order shipment
    // Route::any('/trackShipment/{awb}', 'SmsaShipmentController@trackShipment');   // status of order shipment
    // Route::any('/SmsaCities', 'SmsaShipmentController@SmsaCities');   //  get all shipment cities available

        // aramex shipment
    Route::any('/createPickup', 'AramexShipmentController@createPickup')->name('aramex_pickup.create');   // send order request
    Route::any('/cancelPickup/{id}', 'AramexShipmentController@cancelPickup')->name('aramex_pickup.cancel');   // new
    Route::any('/aramex_pickups', 'AramexShipmentController@aramex_pickups')->name('aramex_pickup.index');   // new

    Route::any('/goToShipment/{order_id}', 'AramexShipmentController@goToShipment');   // cancel order request
    Route::any('/calculateRate/{order_id}', 'AramexShipmentController@calculateRate');   // print shipment invoice
    Route::any('/trackShipments/{shipment_no}', 'AramexShipmentController@trackShipments');   // status of order shipment
    Route::any('/fetchCountries', 'AramexShipmentController@fetchCountries');   // status of order shipment
    Route::any('/fetchCities/{country_id}', 'AramexShipmentController@fetchCities');   //  get all shipment cities available


    // shipper info
    Route::resource('shippers', 'ShipperController'); // new
    Route::get('shop_settings', 'ShopController@get_view')->name('shop.settings'); // new
    Route::put('shop_settings_save', 'ShopController@set_data')->name('shop.settings.save'); // new


    Route::resource('sellers', 'SellerController');
    Route::get('/sellers/destroy/{id}', 'SellerController@destroy')->name('sellers.destroy');
    Route::get('/sellers/view/{id}/verification', 'SellerController@show_verification_request')->name('sellers.show_verification_request');
    Route::get('/sellers/approve/{id}', 'SellerController@approve_seller')->name('sellers.approve');

    Route::post('/sellers/approved', 'SellerController@update_verify_ajax')->name('sellers.approved');

    Route::get('/sellers/reject/{id}', 'SellerController@reject_seller')->name('sellers.reject');
    Route::post('/sellers/payment_modal', 'SellerController@payment_modal')->name('sellers.payment_modal');

    // Route::any('/seller/payments', 'PaymentController@payment_histories')->name('sellers.payment_histories');
    Route::any('/seller/payments', 'SellerController@seller_payments')->name('sellers.payment_histories');

    Route::get('/seller/payments/show/{id}', 'PaymentController@show')->name('sellers.payment_history');

    Route::resource('blog', 'BlogController');
    Route::get('/blog/destroy/{id}', 'BlogController@destroy')->name('blog.destroy');
    Route::resource('blogDepartment', 'BlogDepartmentController');
    Route::get('/blogDepartment/destroy/{id}', 'BlogDepartmentController@destroy')->name('blogDepartment.destroy');
    Route::resource('notification', 'NotificationController');
    Route::resource('customers', 'CustomerController');
    Route::get('/customers/destroy/{id}', 'CustomerController@destroy')->name('customers.destroy');

    Route::get('/newsletter', 'NewsletterController@index')->name('newsletters.index');
    Route::post('/newsletter/send', 'NewsletterController@send')->name('newsletters.send');

    Route::resource('profile', 'ProfileController');

    Route::post('/business-settings/update', 'BusinessSettingsController@update')->name('business_settings.update');
    Route::post('/business-settings/update/activation', 'BusinessSettingsController@updateActivationSettings')->name('business_settings.update.activation');
    Route::get('/activation', 'BusinessSettingsController@activation')->name('activation.index');
    Route::get('/coupon-affiliate', 'BusinessSettingsController@couponAffiliateValue')->name('coupon.affiliate.settings');
    Route::post('/coupon-affiliate', 'BusinessSettingsController@changeCouponAffiliateValue')->name('coupon.affiliate.settings.store');
    Route::get('/payment-method', 'BusinessSettingsController@payment_method')->name('payment_method.index');
    Route::get('/social-login', 'BusinessSettingsController@social_login')->name('social_login.index');
    Route::get('/smtp-settings', 'BusinessSettingsController@smtp_settings')->name('smtp_settings.index');
    Route::get('/google-analytics', 'BusinessSettingsController@google_analytics')->name('google_analytics.index');
    Route::get('/facebook-chat', 'BusinessSettingsController@facebook_chat')->name('facebook_chat.index');
    Route::get('/facebook-blog', 'BusinessSettingsController@facebook_blog')->name('facebook_blog.index');
    Route::post('/env_key_update', 'BusinessSettingsController@env_key_update')->name('env_key_update.update');
    Route::post('/payment_method_update', 'BusinessSettingsController@payment_method_update')->name('payment_method.update');

    Route::post('/shipment_method_update', 'BusinessSettingsController@shipment_method_update')->name('shipment_method.update');  // new 9-8-2020
    Route::get('/shipment-method', 'BusinessSettingsController@shipment_method')->name('shipment_method.index');  // new 9-8-2020

    Route::post('/google_analytics', 'BusinessSettingsController@google_analytics_update')->name('google_analytics.update');
    Route::post('/facebook_chat', 'BusinessSettingsController@facebook_chat_update')->name('facebook_chat.update');
    Route::post('/facebook_blog_update', 'BusinessSettingsController@facebook_blog_update')->name('facebook_blog.update');
    Route::get('/currency', 'CurrencyController@currency')->name('currency.index');
    Route::get('/currency/get_currency', 'CurrencyController@get_currency')->name('currency.get_currency');

    Route::post('/currency/update', 'CurrencyController@updateCurrency')->name('currency.update');
    Route::post('/your-currency/update', 'CurrencyController@updateYourCurrency')->name('your_currency.update');
    Route::get('/verification/form', 'BusinessSettingsController@seller_verification_form')->name('seller_verification_form.index');
    Route::post('/verification/form', 'BusinessSettingsController@seller_verification_form_update')->name('seller_verification_form.update');
    Route::get('/vendor_commission', 'BusinessSettingsController@vendor_commission')->name('business_settings.vendor_commission');
    Route::post('/vendor_commission_update', 'BusinessSettingsController@vendor_commission_update')->name('business_settings.vendor_commission.update');

    Route::resource('/languages', 'LanguageController');
    Route::post('/languages/update_rtl_status', 'LanguageController@update_rtl_status')->name('languages.update_rtl_status');
    Route::get('/languages/destroy/{id}', 'LanguageController@destroy')->name('languages.destroy');
    Route::get('/languages/{id}/edit', 'LanguageController@edit')->name('languages.edit');
    Route::post('/languages/{id}/update', 'LanguageController@update')->name('languages.update');
    Route::post('/languages/key_value_store', 'LanguageController@key_value_store')->name('languages.key_value_store');

    Route::get('/frontend_settings/home', 'HomeController@home_settings')->name('home_settings.index');
    Route::post('/frontend_settings/home/top_10', 'HomeController@top_10_settings')->name('top_10_settings.store');
    Route::post('/frontend_settings/home/main_banners', 'HomeController@main_banners')->name('main_banners.store');
    Route::get('/sellerpolicy/{type}', 'PolicyController@index')->name('sellerpolicy.index');
    Route::get('/returnpolicy/{type}', 'PolicyController@index')->name('returnpolicy.index');
    Route::get('/supportpolicy/{type}', 'PolicyController@index')->name('supportpolicy.index');
    Route::get('/terms/{type}', 'PolicyController@index')->name('terms.index');
    Route::get('/privacypolicy/{type}', 'PolicyController@index')->name('privacypolicy.index');

    Route::any('update_delivery', 'OrderController@update_delivery_status');

    //Policy Controller
    Route::post('/policies/store', 'PolicyController@store')->name('policies.store');

    Route::group(['prefix' => 'frontend_settings'], function () {
        Route::resource('sliders', 'SliderController');
        Route::get('/sliders/destroy/{id}', 'SliderController@destroy')->name('sliders.destroy');

        Route::resource('home_banners', 'BannerController');
        Route::get('/home_banners/create/{position}', 'BannerController@create')->name('home_banners.create');
        Route::post('/home_banners/update_status', 'BannerController@update_status')->name('home_banners.update_status');
        Route::get('/home_banners/destroy/{id}', 'BannerController@destroy')->name('home_banners.destroy');

        Route::resource('home_categories', 'HomeCategoryController');
        Route::get('/home_categories/destroy/{id}', 'HomeCategoryController@destroy')->name('home_categories.destroy');
        Route::post('/home_categories/update_status', 'HomeCategoryController@update_status')->name('home_categories.update_status');
        Route::post('/home_categories/get_subsubcategories_by_category', 'HomeCategoryController@getSubSubCategories')->name('home_categories.get_subsubcategories_by_category');
    });

    Route::resource('roles', 'RoleController');
    Route::get('/roles/destroy/{id}', 'RoleController@destroy')->name('roles.destroy');

    Route::resource('staffs', 'StaffController');
    Route::get('/staffs/destroy/{id}', 'StaffController@destroy')->name('staffs.destroy');

    Route::resource('flash_deals', 'FlashDealController');
    Route::get('/flash_deals/destroy/{id}', 'FlashDealController@destroy')->name('flash_deals.destroy');

    Route::get('flash_deal_country_products', 'FlashDealController@flash_deal_country_products')->name('flash_deals.country.products');

    Route::post('/flash_deals/update_status', 'FlashDealController@update_status')->name('flash_deals.update_status');



    Route::post('/flash_deals/product_discount', 'FlashDealController@product_discount')->name('flash_deals.product_discount');
    Route::post('/flash_deals/product_discount_edit', 'FlashDealController@product_discount_edit')->name('flash_deals.product_discount_edit');

    Route::get('/orders', 'OrderController@admin_orders')->name('orders.index.admin');
    Route::get('/orders/{id}/show', 'OrderController@show')->name('orders.show');
    Route::get('/sales/{id}/show', 'OrderController@sales_show')->name('sales.show');
    Route::get('/orders/destroy/{id}', 'OrderController@destroy')->name('orders.destroy');
    Route::get('/sales', 'OrderController@sales')->name('sales.index');

    Route::resource('links', 'LinkController');
    Route::get('/links/destroy/{id}', 'LinkController@destroy')->name('links.destroy');

    Route::resource('generalsettings', 'GeneralSettingController');
    Route::get('/logo', 'GeneralSettingController@logo')->name('generalsettings.logo');
    Route::post('/logo', 'GeneralSettingController@storeLogo')->name('generalsettings.logo.store');
    Route::get('/color', 'GeneralSettingController@color')->name('generalsettings.color');
    Route::post('/color', 'GeneralSettingController@storeColor')->name('generalsettings.color.store');

    Route::resource('seosetting', 'SEOController');

    Route::post('/pay_to_seller', 'CommissionController@pay_to_seller')->name('commissions.pay_to_seller');

    //Reports
    Route::get('/stock_report', 'ReportController@stock_report')->name('stock_report.index');
    Route::get('/in_house_sale_report', 'ReportController@in_house_sale_report')->name('in_house_sale_report.index');
    Route::get('/seller_report', 'ReportController@seller_report')->name('seller_report.index');
    Route::get('/seller_sale_report', 'ReportController@seller_sale_report')->name('seller_sale_report.index');
    Route::get('/wish_report', 'ReportController@wish_report')->name('wish_report.index');

    //Coupons
    Route::resource('coupon', 'CouponController');
    Route::post('/coupon/get_form', 'CouponController@get_coupon_form')->name('coupon.get_coupon_form');
    Route::post('/coupon/get_form_edit', 'CouponController@get_coupon_form_edit')->name('coupon.get_coupon_form_edit');
    Route::get('/coupon/destroy/{id}', 'CouponController@destroy')->name('coupon.destroy');

    //Reviews
    Route::get('/reviews/admin', 'ReviewController@index')->name('reviews.index');
    Route::post('/reviews/published', 'ReviewController@updatePublished')->name('reviews.published');

    //Support_Ticket
    Route::get('support_ticket/{type}', 'SupportTicketController@admin_index')->name('support_ticket.admin_index');
    Route::get('support_ticket/{id}/show', 'SupportTicketController@admin_show')->name('support_ticket.admin_show');
    Route::post('support_ticket/reply', 'SupportTicketController@admin_store')->name('support_ticket.admin_store');

    //Countries

    Route::group(['prefix' => 'countries'], function () {

        Route::get('/', 'CountryController@index')->name('countries.index');

        Route::get('/create', 'CountryController@create')->name('countries.create');

        Route::post('/', 'CountryController@store')->name('countries.store');

        Route::get('/edit/{id}', 'CountryController@edit')->name('countries.edit');

        Route::post('/update/{id}', 'CountryController@update')->name('countries.update');

        Route::post('/updatePaymentMethod', 'CountryController@updatePaymentMethod')->name('country.updatePaymentMethod');

        Route::post('/updatestatus', 'CountryController@updatestatus')->name('country.updatestatus');

            Route::post('/update_default', 'CountryController@update_default')->name('country.update_default');


    });

    //Currencies

    Route::group(['prefix' => 'currencies'], function () {

        Route::get('/', 'CurrencyController@index')->name('currencies.index');

        Route::get('/create', 'CurrencyController@create')->name('currencies.create');

        Route::post('/', 'CurrencyController@store')->name('currencies.store');

        Route::get('/edit/{id}', 'CurrencyController@edit')->name('currencies.edit');

        Route::post('/update/{id}', 'CurrencyController@update')->name('currencies.update');

    });
    //Deliveries

    Route::group(['prefix' => 'deliveries'], function () {

        Route::get('/', 'DeliveryController@index')->name('deliveries.index');

        Route::get('/create', 'DeliveryController@create')->name('deliveries.create');

        Route::post('/', 'DeliveryController@store')->name('deliveries.store');

        Route::get('/edit/{id}', 'DeliveryController@edit')->name('deliveries.edit');

        Route::post('/update/{id}', 'DeliveryController@update')->name('deliveries.update');

        Route::post('/{id}', 'DeliveryController@destroy')->name('deliveries.destroy');

    });

    //payment requests

    Route::group(['prefix' => 'payment_requests'], function () {

        Route::get('/', 'PaymentRequestController@index')->name('payment_requests.index');

        Route::get('/show/{id}', 'PaymentRequestController@show')->name('payment_requests.show');

        Route::get('/create', 'PaymentRequestController@create')->name('payment_requests.create');

        Route::post('/confirmPayment', 'PaymentRequestController@confirmPayment')->name('admin.payment_requests.confirmPayment');

    });

    // units

    Route::resource('units', 'UnitController');
    Route::post('units/update_status', 'UnitController@update_status')->name('units.update_status');
    Route::post('events/update_status', 'EventController@update_status')->name('events.update_status');
    Route::post('galleries/update_status', 'GalleryController@update_status')->name('galleries.update_status');

    Route::resource('events', 'EventController');
    Route::resource('galleries', 'GalleryController');

    Route::resource('eventCategories', 'EventCategoryController');


});
