<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['middleware' => 'api.locale'], function () {

    Route::group(['namespace' => 'Web', 'prefix' => 'web'], function () {


        Route::group(['prefix' => 'cities'], function () { // done

            Route::get('/', 'CityController@index')->name('api.cities.web');

        });

        Route::group(['prefix' => 'areas'], function () {  // done
            Route::get('/', 'AreaController@index')->name('api.areas.web');
        });

        Route::group(['prefix' => 'zones'], function () {  /// done
            Route::get('/', 'ZoneController@index')->name('api.zones.web');
        });


        Route::group(['prefix' => 'addresses'], function () {  /// done

            Route::get('/', 'AddressController@index')->name('api.addresses.web');

            Route::get('/store', 'AddressController@store')->name('api.addresses.store.web'); 

            Route::get('/destroy', 'AddressController@destroy')->name('api.addresses.destroy.web'); 

        });

        Route::group(['prefix' => 'wishlists'], function () {  /// done

            Route::get('/', 'WishlistController@index')->name('api.wishlists.web');

            Route::post('/', 'WishlistController@store')->name('api.wishlists.store.web');
            
            Route::delete('/', 'WishlistController@remove')->name('api.wishlists.remove.web');

        });

        Route::group(['prefix' => 'categories'], function () {  /// done

            Route::get('/', 'CategoryController@index')->name('api.categories.web');

        });

        Route::group(['prefix' => 'subCategories'], function () {  /// done

            Route::get('/', 'CategoryController@subCategories')->name('api.sub.categories.web');

        });

        Route::group(['prefix' => 'subsubCategories'], function () {  /// done

            Route::get('/', 'CategoryController@subsubCategories')->name('api.sub.categories.web');

        });



        Route::group(['prefix' => 'orders'], function () {  /// test

            Route::get('/', 'OrderController@index')->name('api.orders.web');

            Route::get('/show', 'OrderController@show')->name('api.orders.show.web');

            Route::post('/cancel', 'OrderController@cancel')->name('api.orders.cancel.web');

        });



        Route::group(['prefix' => 'cart'], function () {  /// test

            Route::get('/', 'CartController@index')->name('api.cart.web');

            Route::post('/', 'CartController@store')->name('api.cart.store.web');

            // Route::post('/addtocart', 'CartController@addToCart')->name('api.cart.addToCart.web');

            Route::post('/update', 'CartController@update')->name('api.cart.update.web');

            Route::post('/delete', 'CartController@destroy')->name('api.cart.delete.web');

        });

    });

    Route::group(['namespace' => 'Admin', 'prefix' => 'admin', 'middleware' => 'auth'], function () {
        Route::group(['prefix' => 'payment_requests'], function () {

            Route::post('/confirmPayment', 'PaymentRequestController@confirmPayment')->name('api.admin.payment_requests.confirmPayment');

        });

        Route::group(['prefix' => 'sliders'], function () {

            Route::get('/', 'SliderController@index')->name('api.sliders');

            Route::post('/', 'SliderController@store')->name('api.sliders.store');

            Route::post('/update/{id}', 'SliderController@update')->name('api.sliders.update');

            Route::post('/{id}', 'SliderController@destroy')->name('api.sliders.delete');

        });

        Route::group(['prefix' => 'affiliates'], function () {

            Route::get('/', 'AffiliateController@index')->name('api.affiliates');

            Route::get('/{id}', 'AffiliateController@show')->name('api.affiliates.show');

            Route::post('/update/{id}', 'AffiliateController@update')->name('api.affiliates.update');

            Route::post('/{id}', 'AffiliateController@destroy')->name('api.affiliates.delete');

        });

        Route::group(['prefix' => 'users'], function () {

            Route::get('/', 'UserController@index')->name('api.users');

        });

        Route::group(['prefix' => 'sizes'], function () {

            Route::get('/', 'SizeController@index')->name('api.sizes');

            Route::post('/', 'SizeController@store')->name('api.sizes.store');

            Route::post('/update/{id}', 'SizeController@update')->name('api.sizes.update');

            Route::post('/{id}', 'SizeController@destroy')->name('api.sizes.delete');

        });

        Route::group(['prefix' => 'options'], function () {

            Route::get('/', 'OptionController@index')->name('api.options');

            Route::post('/', 'OptionController@store')->name('api.options.store');

            Route::post('/update/{id}', 'OptionController@update')->name('api.options.update');

            Route::post('/{id}', 'OptionController@destroy')->name('api.options.delete');

        });

        Route::group(['prefix' => 'cities'], function () {

            Route::get('/', 'CityController@index')->name('api.cities');

            Route::post('/', 'CityController@store')->name('api.cities.store');

            Route::post('/update/{id}', 'CityController@update')->name('api.cities.update');

            Route::post('/{id}', 'CityController@destroy')->name('api.cities.delete');

        });

        Route::group(['prefix' => 'areas'], function () {

            Route::get('/', 'AreaController@index')->name('api.areas');

            Route::post('/', 'AreaController@store')->name('api.areas.store');

            Route::post('/update/{id}', 'AreaController@update')->name('api.areas.update');

            Route::post('/{id}', 'AreaController@destroy')->name('api.areas.delete');

        });

        Route::group(['prefix' => 'zones'], function () {

            Route::get('/', 'ZoneController@index')->name('api.zones');

            Route::post('/', 'ZoneController@store')->name('api.zones.store');

            Route::post('/update/{id}', 'ZoneController@update')->name('api.zones.update');

            Route::post('/{id}', 'ZoneController@destroy')->name('api.zones.delete');

        });

        Route::group(['prefix' => 'categories'], function () {

            Route::get('/', 'CategoryController@index')->name('api.categories.index.admin');

            Route::post('/{id}', 'CategoryController@destroy')->name('api.categories.delete.admin');

        });

        Route::group(['prefix' => 'promos'], function () {

            Route::get('/', 'PromoCodeController@index')->name('api.promos.index.admin');

            Route::post('/{id}', 'PromoCodeController@destroy')->name('api.promos.delete.admin');

        });

        Route::group(['prefix' => 'notifications'], function () {

            Route::get('/', 'NotificationController@index')->name('api.notifications.index');

            Route::post('/seen', 'NotificationController@seen')->name('api.notifications.seen');

        });

        Route::group(['prefix' => 'subCategories'], function () {

            Route::get('/', 'SubCategoryController@index')->name('api.sub.categories.index.admin');

            Route::post('/{id}', 'SubCategoryController@destroy')->name('api.sub.categories.delete.admin');

        });

        Route::group(['prefix' => 'branches'], function () {

            Route::get('/', 'BranchController@index')->name('api.branches.index');

            Route::post('/update_status/{id}', 'BranchController@updateStatus')->name('api.branches.update.status');

            Route::post('/{id}', 'BranchController@destroy')->name('api.branches.delete');

        });

        Route::group(['prefix' => '/messages'], function () {

            Route::get('/', 'MessageController@index')->name('api.messages');

            Route::get('/more', 'MessageController@more')->name('api.messages.more');

            Route::post('/seen', 'MessageController@seen')->name('api.messages.seen');

            Route::post('/admin', 'MessageController@store')->name('api.messages.store.admin');

        });

        Route::group(['prefix' => '/conversations'], function () {

            Route::get('/admin', 'ConversationController@index')->name('api.conversations');

            Route::get('/admin/inbox', 'ConversationController@inbox')->name('api.conversations.inbox');

            Route::post('/admin', 'ConversationController@store')->name('api.conversations.store');

        });

        Route::group(['prefix' => 'meals'], function () {

            Route::get('/', 'MealController@index')->name('api.meals.index.admin');

            Route::post('/{id}', 'MealController@destroy')->name('api.doctors.delete.admin');

        });

        Route::group(['prefix' => 'orders'], function () {

            Route::get('/', 'OrderController@index')->name('api.orders.index');

            Route::post('/update/{id}', 'OrderController@update')->name('api.orders.update');

            Route::post('/{id}', 'OrderController@destroy')->name('api.orders.delete');

        });

        Route::group(['prefix' => 'offers'], function () {

            Route::get('/', 'OfferController@index')->name('api.offers.index');

            Route::post('/{id}', 'OfferController@destroy')->name('api.offers.delete');

        });

        Route::group(['prefix' => 'specialities'], function () {

            Route::get('/', 'SpecialityController@index')->name('api.specialities.index');

            Route::post('/update_status/{id}', 'SpecialityController@updateStatus')->name('api.specialities.update.status');

            Route::post('/{id}', 'SpecialityController@destroy')->name('api.specialities.delete');

        });
    });

    Route::group(['namespace' => 'Affiliate', 'prefix' => 'affiliate'], function () {

        Route::group(['prefix' => 'products'], function () {

            Route::get('/', 'ProductController@index')->name('api.affiliate.products');

        });

        Route::group(['prefix' => 'urls'], function () {

            Route::get('/', 'CouponUrlController@index')->name('api.affiliate.urls');

            Route::post('/', 'CouponUrlController@store')->name('api.affiliate.urls.store');

        });
        Route::group(['prefix' => 'coupon'], function () {

            Route::post('/', 'Coupon2Controller@store')->name('api.affiliate.coupon.store');

        });

        Route::group(['prefix' => '/messages'], function () {

            Route::get('/', 'MessageController@index')->name('api.affiliate.messages');

            Route::get('/more', 'MessageController@more')->name('api.affiliate.messages.more');

            Route::post('/seen', 'MessageController@seen')->name('api.affiliate.messages.seen');

            Route::post('/affiliate', 'MessageController@store')->name('api.affiliate.messages.store');

        });

        Route::group(['prefix' => 'categories'], function () {

            Route::get('/', 'CategoryController@index')->name('api.affiliate.categories');

        });

        Route::group(['prefix' => 'sub_categories'], function () {
            Route::get('/', 'SubCategoryController@index')->name('api.affiliate.sub_categories');
        });

    });

    Route::get('/home', 'HomeController@index');
    Route::get('/newFaceoffers', 'HomeController@newFaceoffers');

    Route::group(['prefix' => 'reset_password'], function () {

        Route::post('/update_password', 'AuthController@resetPassword');

        Route::post('/send_mail', 'AuthController@sendMail');

        Route::post('/checkCode', 'AuthController@checkCode');

    });

    Route::group(['prefix' => 'register'], function () {

        Route::post('/', 'RegisterController@store');

        Route::post('/send_sms', 'RegisterController@send_sms');

        Route::post('/verification', 'RegisterController@verification');

    });

    Route::group(['prefix' => 'products'], function () {

        Route::get('/', 'ProductController@index');

        Route::get('/show', 'ProductController@show');

        Route::get('/variant_price', 'ProductController@variant_price'); // new get option price and quantity input['product_id' as 'id', 'options_selected']
        Route::get('/variant_options', 'ProductController@variant_options'); // new get options related ['product_id' as 'id', 'option_selected']

    });

    Route::group(['prefix' => 'reviews'], function () {

        Route::get('/', 'ReviewController@index');

        Route::post('/', 'ReviewController@store');

    });

    Route::group(['prefix' => 'orders'], function () {

        Route::get('/', 'OrderController@index');

        Route::post('/', 'OrderController@store');

        Route::post('/cancel', 'OrderController@cancel');

        Route::get('/show', 'OrderController@show');

    });

    Route::group(['prefix' => 'countries'], function () {

        Route::get('/', 'CountryController@index');

    });

    Route::group(['prefix' => 'cities'], function () {

        Route::get('/', 'CityController@index');

    });

    Route::group(['prefix' => 'areas'], function () {

        Route::get('/', 'AreaController@index');

    });

    Route::group(['prefix' => 'zones'], function () {

        Route::get('/', 'ZoneController@index');

    });

    Route::group(['prefix' => 'categories'], function () {

        Route::get('/', 'CategoryController@index');

    });

    Route::group(['prefix' => 'sub_categories'], function () {

        Route::get('/', 'SubCategoryController@index');

    });

    Route::group(['prefix' => 'sub_sub_categories'], function () {

        Route::get('/', 'SubSubCategoryController@index');

    });

    Route::group(['prefix' => 'offers'], function () {

        Route::get('/', 'FlashDealController@index');

    });

    Route::group(['prefix' => 'sellers'], function () {

        Route::get('/', 'SellerController@index');

        Route::get('/show', 'SellerController@show');

    });

    Route::group(['prefix' => 'settings'], function () {

        Route::get('/', 'SettingController@index');

    });

    Route::group(['middleware' => 'auth:api'], function () {

        Route::group(['prefix' => 'whishlist'], function () {

            Route::get('/', 'WhishlistController@index');

            Route::post('/', 'WhishlistController@store');

        });

        Route::group(['prefix' => 'profile'], function () {

            Route::get('/', 'UserController@show');

            Route::post('/update', 'UserController@update');

        });

        Route::group(['prefix' => 'contact'], function () {

            Route::post('/', 'ContactController@store');

        });

    });

    Route::group(['prefix' => 'login'], function () {

        Route::post('/', 'AuthController@store');

    });

    Route::group(['prefix' => 'socialLogin'], function () {

        Route::post('/', 'AuthController@socialLogin');

    });


    Route::group(['prefix' => 'complaints'], function () {

        Route::get('/', 'ComplaintController@index');

        Route::post('/', 'ComplaintController@store');

    });

    Route::group(['prefix' => 'addresses'], function () {

        Route::get('/', 'AddressController@index');

        Route::post('/', 'AddressController@store');

        Route::post('/delete', 'AddressController@destroy');

    });

//     Route::group(['prefix' => 'productReviews'], function () {

//         Route::get('/reviews', 'ProductReviewController@product');
// //        Route::get('/user', 'ProductReviewController@getUserReviews');

// //        Route::get('/userReviews', 'ProductReviewController@getUserReviews');

//         Route::post('/create', 'ProductReviewController@store');

//     });

    Route::group(['prefix' => 'notifications'], function () {

        Route::get('/', 'NotificationController@index');
        Route::post('/seen', 'NotificationController@seen');
        Route::get('/getSeen', 'NotificationController@getSeen');

    });

    Route::post('/checkPromoCode', 'CouponController@checkPromoCode')->name('api.cart.checkPromoCode');

    Route::post('/addtocart', 'CartController@addToCart')->name('api.cart.addToCart');

    Route::post('/addToMyCart', 'CartController@addToMyCart')->name('api.cart.addToMyCart');

    Route::post('/getMyCart', 'CartController@getMyCart')->name('api.cart.getMyCart');

    Route::post('/removeFromCart', 'CartController@removeFromCart')->name('api.cart.removeFromCart');

    Route::post('/updateMyCart', 'CartController@updateMyCart')->name('api.cart.updateMyCart');

    Route::post('/checkout', 'CartController@checkout')->name('api.cart.checkout');

    Route::post('/confirmCheckout', 'CartController@confirmCheckout')->name('api.cart.confirmCheckout');

    Route::post('/singleHistory', 'OrderController@singleHistory')->name('api.order.singleHistory');

    Route::get('/search', 'OrderController@search')->name('api.search');

    Route::post('/updateProfile', 'ProfileController@update')->name('api.updateProfile');

});
