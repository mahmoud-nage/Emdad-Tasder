<?php
Route::group(['middleware' => ['guest.affiliate']], function () {

    Route::group(['prefix' => 'login'], function () {

        Route::get('/', 'AuthController@index')->name('affiliate.login');

        Route::post('/', 'AuthController@store')->name('affiliate.login.store');

    });

    Route::group(['prefix' => 'register'], function () {

        Route::get('/', 'RegisterController@index')->name('affiliate.register');
        Route::post('/', 'RegisterController@store')->name('affiliate.register.store');
        Route::post('/', 'RegisterController@storeUser')->name('affiliate.register.storeUser');

    });
});

Route::group(['middleware' => ['auth.affiliate', 'affiliate']], function () {

    Route::get('/logout', 'AuthController@destroy')->name('affiliate.login.delete');
    Route::get('/', 'HomeController@index')->name('affiliate.dashboard');

    Route::get('/personalInfo', 'RegisterController@persoalInfo')->name('affiliate.personal_info');
    Route::get('/createCoupon', 'RegisterController@createCoupon')->name('affiliate.createCoupon');
    Route::post('/registerCoupon', 'RegisterController@storeCoupon')->name('affiliate.register.storeCoupon');
    Route::post('/storeInfo', 'RegisterController@storeInfo')->name('affiliate.register.storeInfo');

    Route::group(['prefix' => 'profile'], function () {

        Route::get('/', 'ProfileController@index')->name('affiliate.profile.index');

        Route::post('/{id}', 'ProfileController@update')->name('affiliate.profile.update');

    });
    Route::group(['middleware' => 'affiliate.approved'], function () {

        Route::group(['prefix' => 'reports'], function () {

            Route::get('/earnings', 'ReportController@earnings')->name('affiliate.reports.earnings');

            Route::get('/orders', 'ReportController@orders')->name('affiliate.reports.orders');

        });
        Route::group(['prefix' => 'coupon'], function () {

            Route::get('/coupon', 'CouponController@create')->name('affiliate.coupon.create');

            Route::post('/', 'CouponController@store')->name('affiliate.coupon.store');

        });

        Route::group(['prefix' => 'urls'], function () {

            Route::get('/', 'CouponUrlController@index')->name('affiliate.urls.index');

            Route::get('/create', 'CouponUrlController@create')->name('affiliate.urls.create');

            Route::post('/', 'CouponUrlController@store')->name('affiliate.urls.store');

            Route::post('/{id}', 'CouponUrlController@destroy')->name('affiliate.urls.delete');

        });

        Route::group(['prefix' => 'banners'], function () {

            Route::get('/earnings', 'BannerAffiliateController@index')->name('affiliate.banners.index');

        });

        Route::group(['prefix' => 'tickets'], function () {

            Route::get('/', 'TicketController@index')->name('affiliate.tickets.index');

            Route::get('/{id}', 'TicketController@show')->name('affiliate.tickets.show');

            Route::post('/', 'TicketController@store')->name('affiliate.tickets.store');

        });

        Route::group(['prefix' => 'products'], function () {

            Route::get('/', 'ProductController@index')->name('affiliate.products.index');

        });

        Route::group(['prefix' => 'payment_requests'], function () {

            Route::get('/', 'PaymentRequestController@create')->name('affiliate.payment_requests.create');
            Route::get('/index', 'PaymentRequestController@index')->name('affiliate.payment_requests.index');
            Route::post('/', 'PaymentRequestController@store')->name('affiliate.payment_requests.store');

        });

    });
    Route::group(['prefix' => 'settings'], function () {

        Route::get('/', 'SettingController@index')->name('affiliate.settings.index');

        Route::post('/', 'SettingController@update')->name('affiliate.settings.update');

    });

});
