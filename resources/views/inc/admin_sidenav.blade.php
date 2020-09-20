<!--MAIN NAVIGATION-->
<!--===================================================-->
<nav id="mainnav-container">
    <div id="mainnav">

        <!--Menu-->
        <!--================================-->
        <div id="mainnav-menu-wrap">
            <div class="nano">
                <div class="nano-content">

                    <!--Profile Widget-->
                    <!--================================-->
                    {{-- <div id="mainnav-profile" class="mainnav-profile">
                    <div class="profile-wrap text-center">
                        <div class="pad-btm">
                            <img class="img-circle img-md" src="{{ asset('img/profile-photos/1.png') }}" alt="Profile
                    Picture">
                </div>
                <a href="#profile-nav" class="box-block" data-toggle="collapse" aria-expanded="false">
                    <span class="pull-right dropdown-toggle">
                        <i class="dropdown-caret"></i>
                    </span>
                    <p class="mnp-name">{{Auth::user()->name}}</p>
                    <span class="mnp-desc">{{Auth::user()->email}}</span>
                </a>
            </div>
            <div id="profile-nav" class="collapse list-group bg-trans">
                <a href="#" class="list-group-item">
                    <i class="demo-pli-male icon-lg icon-fw"></i> View Profile
                </a>
                <a href="#" class="list-group-item">
                    <i class="demo-pli-gear icon-lg icon-fw"></i> Settings
                </a>
                <a href="#" class="list-group-item">
                    <i class="demo-pli-information icon-lg icon-fw"></i> Help
                </a>
                <a href="#" class="list-group-item">
                    <i class="demo-pli-unlock icon-lg icon-fw"></i> Logout
                </a>
            </div>
        </div> --}}

        <!--Shortcut buttons-->
        <!--================================-->
        <div id="mainnav-shortcut" class="hidden">
            <ul class="list-unstyled shortcut-wrap">
                <li class="col-xs-3" data-content="My Profile">
                    <a class="shortcut-grid" href="#">
                        <div class="icon-wrap icon-wrap-sm icon-circle bg-mint">
                            <i class="demo-pli-male"></i>
                        </div>
                    </a>
                </li>
                <li class="col-xs-3" data-content="Messages">
                    <a class="shortcut-grid" href="#">
                        <div class="icon-wrap icon-wrap-sm icon-circle bg-warning">
                            <i class="demo-pli-speech-bubble-3"></i>
                        </div>
                    </a>
                </li>
                <li class="col-xs-3" data-content="Activity">
                    <a class="shortcut-grid" href="#">
                        <div class="icon-wrap icon-wrap-sm icon-circle bg-success">
                            <i class="demo-pli-thunder"></i>
                        </div>
                    </a>
                </li>
                <li class="col-xs-3" data-content="Lock Screen">
                    <a class="shortcut-grid" href="#">
                        <div class="icon-wrap icon-wrap-sm icon-circle bg-purple">
                            <i class="demo-pli-lock-2"></i>
                        </div>
                    </a>
                </li>
            </ul>
        </div>
        <!--================================-->
        <!--End shortcut buttons-->


        <ul id="mainnav-menu" class="list-group">

            <!--Category name-->
            {{-- <li class="list-header">Navigation</li> --}}

            <!--Menu list item-->
            <li class="{{ areActiveRoutes(['admin.dashboard'])}}">
                <a class="nav-link" href="{{route('admin.dashboard', auth()->user()->country)}}">
                    <i class="fa fa-home"></i>
                    <span class="menu-title">{{__('Dashboard')}}</span>
                </a>
            </li>

            <!-- Product Menu -->
            @if(Auth::user()->user_type == 'admin' || in_array('1',
            json_decode(Auth::user()->staff->role->permissions)))
            <li>
                <a href="#">
                    <i class="fa fa-shopping-cart"></i>
                    <span class="menu-title">{{__('Products')}}</span>
                    <i class="arrow"></i>
                </a>

                <!--Submenu-->
                <ul class="collapse">
{{--                    <li class="{{ areActiveRoutes(['brands.index', 'brands.create', 'brands.edit'])}}">--}}
{{--                        <a class="nav-link" href="{{route('brands.index')}}">{{__('Brand')}}</a>--}}
{{--                    </li>--}}
                    <li class="{{ areActiveRoutes(['categories.index', 'categories.create', 'categories.edit'])}}">
                        <a class="nav-link" href="{{route('categories.index')}}">{{__('Category')}}</a>
                    </li>
                    <li
                        class="{{ areActiveRoutes(['subcategories.index', 'subcategories.create', 'subcategories.edit'])}}">
                        <a class="nav-link" href="{{route('subcategories.index')}}">{{__('Subcategory')}}</a>
                    </li>
                    <li
                        class="{{ areActiveRoutes(['units.index', 'units.create', 'units.edit'])}}">
                        <a class="nav-link" href="{{route('units.index')}}">{{__('Units')}}</a>
                    </li>
{{--                    <li--}}
{{--                        class="{{ areActiveRoutes(['subsubcategories.index', 'subsubcategories.create', 'subsubcategories.edit'])}}">--}}
{{--                        <a class="nav-link" href="{{route('subsubcategories.index')}}">{{__('Sub Subcategory')}}</a>--}}
{{--                    </li>--}}
                    <li class="{{ areActiveRoutes(['products.admin', 'products.create', 'products.admin.edit'])}}">
                        <a class="nav-link" href="{{route('products.admin')}}">{{__('In House Products')}}</a>
                    </li>
{{--                    @if(\App\BusinessSetting::where('type', 'vendor_system_activation')->first()->value == 1)--}}
{{--                    <li class="{{ areActiveRoutes(['products.seller', 'products.seller.edit'])}}">--}}
{{--                        <a class="nav-link" href="{{route('products.seller')}}">{{__('Seller Products')}}</a>--}}
{{--                    </li>--}}
{{--                    <li class="{{ areActiveRoutes(['products.seller.pendding'])}}">--}}
{{--                        <a class="nav-link"--}}
{{--                            href="{{route('products.seller.pendding')}}">{{__('Seller Pendding Products')}}</a>--}}
{{--                    </li>--}}
{{--                    @endif--}}
                    <li class="{{ areActiveRoutes(['reviews.index'])}}">
                        <a class="nav-link" href="{{route('reviews.index')}}">{{__('Product Reviews')}}</a>
                    </li>
            {{--
            <li class="{{ areActiveRoutes(['packages.index'])}}">
                <a class="nav-link" href="{{route('packages.index')}}">{{__('Packages')}}</a>
            </li>
            --}}
        </ul>
        </li>
        @endif

{{--            @if(Auth::user()->user_type == 'admin' || in_array('15',--}}
{{--            json_decode(Auth::user()->staff->role->permissions)))        --}}
{{--        <li>--}}
{{--            <a href="#">--}}
{{--                <i class="fa fa-money"></i>--}}
{{--                <span class="menu-title">{{__('Affiliate')}}</span>--}}
{{--                <i class="arrow"></i>--}}
{{--            </a>--}}

{{--            <!--Submenu-->--}}
{{--            <ul class="collapse">--}}
{{--                <li class="{{ areActiveRoutes(['affiliates.index'])}}">--}}
{{--                    <a class="nav-link" href="{{route('affiliates.index')}}">{{__('Users')}}</a>--}}
{{--                </li>--}}

{{--                <li class="{{ areActiveRoutes(['affiliates.products'])}}">--}}
{{--                    <a class="nav-link" href="{{route('affiliates.products')}}">{{__('Products')}}</a>--}}
{{--                </li>--}}

{{--                <li class="{{ areActiveRoutes(['affiliates.banners'])}}">--}}
{{--                    <a class="nav-link" href="{{route('affiliates.banners')}}">{{__('Banners')}}</a>--}}
{{--                </li>--}}

{{--                <li class="{{ areActiveRoutes(['affiliates.settings'])}}">--}}
{{--                    <a class="nav-link" href="{{route('affiliates.settings')}}">{{__('Settings')}}</a>--}}
{{--                </li>--}}

{{--                <li class="{{ areActiveRoutes(['affiliates.payments'])}}">--}}
{{--                    <a class="nav-link" href="{{ route('affiliates.payments') }}">{{__('Payments')}}</a>--}}
{{--                </li>--}}

{{--                <li class="{{ areActiveRoutes(['affiliates.requests'])}}">--}}
{{--                    <a class="nav-link" href="{{ route('affiliates.requests') }}">{{__('Requests')}}</a>--}}
{{--                </li>--}}

{{--            </ul>--}}
{{--        </li>--}}
{{--        @endif--}}

            @if(Auth::user()->user_type == 'admin' || in_array('14',
            json_decode(Auth::user()->staff->role->permissions)))
        <li>
            <a href="#">
                <i class="fa fa-flag"></i>
                <span class="menu-title">{{__('Global Settings')}}</span>
                <i class="arrow"></i>
            </a>
            <!--Submenu-->
            <ul class="collapse">
                <li>
                    <a href="#">
                        <i class="fa fa-flag"></i>
                        <span class="menu-title">{{__('Countries')}}</span>
                        <i class="arrow"></i>
                    </a>
                    <!--Submenu-->
                    <ul class="collapse">
                        <li class="{{ areActiveRoutes(['countries.index'])}}">
                            <a class="nav-link" href="{{route('countries.index')}}">{{__('Countries')}}</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="#">
                        <i class="fa fa-flag"></i>
                        <span class="menu-title">{{__('Cities')}}</span>
                        <i class="arrow"></i>
                    </a>

                    <!--Submenu-->
                    <ul class="collapse">
                        <li class="{{ areActiveRoutes(['cities.index'])}}">
                            <a class="nav-link" href="{{route('cities.index')}}">{{__('Cities')}}</a>
                        </li>
                    </ul>
                </li>
                {{-- <li>
                    <a href="#">
                        <i class="fa fa-flag"></i>
                        <span class="menu-title">{{__('Areas')}}</span>
                        <i class="arrow"></i>
                    </a>

                    <!--Submenu-->
                    <ul class="collapse">
                        <li class="{{ areActiveRoutes(['areas.index'])}}">
                            <a class="nav-link" href="{{route('areas.index')}}">{{__('Areas')}}</a>
                        </li>
                    </ul>
                </li> --}}
                <!--<li>-->
                <!--    <a href="#">-->
                <!--        <i class="fa fa-flag"></i>-->
                <!--        <span class="menu-title">{{__('Zones')}}</span>-->
                <!--        <i class="arrow"></i>-->
                <!--    </a>-->

                <!--Submenu-->
                <!--    <ul class="collapse">-->
                <!--        <li class="{{ areActiveRoutes(['zones.index'])}}">-->
                <!--            <a class="nav-link" href="{{route('zones.index')}}">{{__('Zones')}}</a>-->
                <!--        </li>-->
                <!--    </ul>-->
                <!--</li>-->
                <li>
                    <a href="#">
                        <i class="fa fa-dollar"></i>
                        <span class="menu-title">{{__('Currencies')}}</span>
                        <i class="arrow"></i>
                    </a>

                    <!--Submenu-->
                    <ul class="collapse">
                        <li class="{{ areActiveRoutes(['currencies.index'])}}">
                            <a class="nav-link" href="{{route('currencies.index')}}">{{__('Currencies')}}</a>
                        </li>
                    </ul>
                </li>
            </ul>
        </li>
        @endif

        @if(Auth::user()->user_type == 'admin' || in_array('2', json_decode(Auth::user()->staff->role->permissions)))
        <li class="{{ areActiveRoutes(['flash_deals.index', 'flash_deals.create', 'flash_deals.edit'])}}">
            <a class="nav-link" href="{{ route('flash_deals.index') }}">
                <i class="fa fa-bolt"></i>
                <span class="menu-title">{{__('Flash Deal')}}</span>
            </a>
        </li>
        @endif

        @if(Auth::user()->user_type == 'admin' || in_array('2', json_decode(Auth::user()->staff->role->permissions)))
        <li class="{{ areActiveRoutes(['events.index', 'events.create', 'events.edit'])}}">
            <a class="nav-link" href="{{ route('events.index') }}">
                <i class="fa fa-bolt"></i>
                <span class="menu-title">{{__('Events')}}</span>
            </a>
        </li>
        @endif

        @if(Auth::user()->user_type == 'admin' || in_array('2', json_decode(Auth::user()->staff->role->permissions)))
        <li class="{{ areActiveRoutes(['galleries.index', 'galleries.create', 'galleries.edit'])}}">
            <a class="nav-link" href="{{ route('galleries.index') }}">
                <i class="fa fa-bolt"></i>
                <span class="menu-title">{{__('Galleries')}}</span>
            </a>
        </li>
        @endif

        @if(Auth::user()->user_type == 'admin' || in_array('3', json_decode(Auth::user()->staff->role->permissions)))
        @php
        $orders = DB::table('orders')
        ->orderBy('code', 'desc')
        ->join('order_details', 'orders.id', '=', 'order_details.order_id')
        ->where('order_details.seller_id', Auth::user()->id)
        ->where('orders.viewed', 0)
        ->select('orders.id')
        ->distinct()
        ->count();
        @endphp
        <li class="{{ areActiveRoutes(['orders.index.admin', 'orders.show'])}}">
            <a class="nav-link" href="{{ route('orders.index.admin') }}">
                <i class="fa fa-shopping-basket"></i>
                <span class="menu-title">{{__('Inhouse orders')}} @if($orders > 0)<span
                        class="pull-right badge badge-info">{{ $orders }}</span>@endif</span>
            </a>
        </li>
        @endif



{{--        @if(Auth::user()->user_type == 'admin' || in_array('4', json_decode(Auth::user()->staff->role->permissions)))--}}
{{--        @php--}}
{{--        $seller_orders = DB::table('orders')--}}
{{--        ->orderBy('code', 'desc')--}}
{{--        ->join('order_details', 'orders.id', '=', 'order_details.order_id')--}}
{{--        ->where('order_details.seller_id','!=', Auth::user()->id)--}}
{{--        ->where('orders.viewed', 0)--}}
{{--        ->select('orders.id')--}}
{{--        ->distinct()--}}
{{--        ->count();--}}
{{--        @endphp--}}
{{--        <li class="{{ areActiveRoutes(['sales.index', 'sales.show'])}}">--}}
{{--            <a class="nav-link" href="{{ route('sales.index') }}">--}}
{{--                <i class="fa fa-money"></i>--}}
{{--                <span class="menu-title">{{__('Seller Orders')}} @if($seller_orders > 0)<span--}}
{{--                        class="pull-right badge badge-info">{{ $seller_orders }}</span>@endif</span>--}}
{{--            </a>--}}
{{--        </li>--}}
{{--        @endif--}}

{{--        @if(Auth::user()->user_type == 'admin' || in_array('16', json_decode(Auth::user()->staff->role->permissions)) &&--}}
{{--        \App\BusinessSetting::where('type', 'shipment_aramex')->first()->value == 1)--}}
{{--        <li class="{{ areActiveRoutes(['aramex_pickup.index', 'aramex_pickup.create'])}}">--}}
{{--            <a class="nav-link" href="{{ route('aramex_pickup.index') }}">--}}
{{--                <i class="fa fa-money"></i>--}}
{{--                <span class="menu-title">{{__('Shipment Aramex Pichup')}} </span>--}}
{{--            </a>--}}
{{--        </li>--}}
{{--        @endif--}}

{{--        @if((Auth::user()->user_type == 'admin' || in_array('5', json_decode(Auth::user()->staff->role->permissions)))--}}
{{--        && \App\BusinessSetting::where('type', 'vendor_system_activation')->first()->value == 1)--}}
{{--        <li>--}}
{{--            <a href="#">--}}
{{--                <i class="fa fa-user-plus"></i>--}}
{{--                <span class="menu-title">{{__('Sellers')}}</span>--}}
{{--                <i class="arrow"></i>--}}
{{--            </a>--}}

{{--            <!--Submenu-->--}}
{{--            <ul class="collapse">--}}
{{--                <li--}}
{{--                    class="{{ areActiveRoutes(['sellers.index', 'sellers.create', 'sellers.edit', 'sellers.payment_history'])}}">--}}
{{--                    @php--}}
{{--                    $sellers = \App\Seller::where('verification_status', 0)->where('verification_info', '!=',--}}
{{--                    null)->count();--}}
{{--                    @endphp--}}
{{--                    <a class="nav-link" href="{{route('sellers.index')}}">{{__('Seller List')}} @if($sellers > 0)--}}
{{--                        <span class="pull-right badge badge-info">{{ $sellers }}</span> @endif--}}
{{--                    </a>--}}
{{--                </li>--}}
{{--                <li class="{{ areActiveRoutes(['sellers.payment_histories'])}}">--}}
{{--                    <a class="nav-link" href="{{ route('sellers.payment_histories') }}">{{__('Seller Payments')}}</a>--}}
{{--                </li>--}}
{{--                <!--<li class="{{ areActiveRoutes(['business_settings.vendor_commission'])}}">-->--}}
{{--                <!--    <a class="nav-link"-->--}}
{{--                <!--       href="{{ route('business_settings.vendor_commission') }}">{{__('Seller Commission')}}</a>-->--}}
{{--                <!--</li>-->--}}
{{--                <li class="{{ areActiveRoutes(['categories.vendor_commission'])}}">--}}
{{--                    <a class="nav-link"--}}
{{--                        href="{{ route('categories.vendor_commission') }}">{{__('Seller Commission')}}</a>--}}
{{--                </li>--}}
{{--                --}}{{-- <li class="{{ areActiveRoutes(['seller_verification_form.index'])}}">--}}
{{--                    <a class="nav-link"--}}
{{--                        href="{{route('seller_verification_form.index')}}">{{__('Seller Verification Form')}}</a>--}}
{{--                </li> --}}
{{--            </ul>--}}
{{--        </li>--}}
{{--        @endif--}}

        {{--
        @if((Auth::user()->user_type == 'admin' ))
        <li>
            <a href="#">
                <i class="fa fa-user-plus"></i>
                <span class="menu-title">{{__('Blog')}}</span>
                <i class="arrow"></i>
            </a>

            <!--Submenu-->
            <ul class="collapse">
                <li class="{{ areActiveRoutes(['blogDepartment.index', 'blogDepartment.create'])}}">
                    @php
                    $sellers = \App\Seller::where('verification_status', 0)->where('verification_info', '!=',
                    null)->count();
                    @endphp
                    <a class="nav-link" href="{{route('blogDepartment.index')}}">{{__('Blog Departments')}}
                    </a>
                </li>
                <li class="{{ areActiveRoutes(['blog.index', 'blog.create'])}}">
                    <a class="nav-link" href="{{route('blog.index')}}">{{__('Blog List')}}
                    </a>
                </li>
            </ul>
        </li>
        @endif
        --}}

        @if(Auth::user()->user_type == 'admin' || in_array('6', json_decode(Auth::user()->staff->role->permissions)))
        <li>
            <a href="#">
                <i class="fa fa-user-plus"></i>
                <span class="menu-title">{{__('Customers')}}</span>
                <i class="arrow"></i>
            </a>

            <!--Submenu-->
            <ul class="collapse">
                <li class="{{ areActiveRoutes(['customers.index'])}}">
                    <a class="nav-link" href="{{ route('customers.index') }}">{{__('Customer list')}}</a>
                </li>
            </ul>
        </li>
        @endif
        @if(Auth::user()->user_type == 'admin' || in_array('17', json_decode(Auth::user()->staff->role->permissions)))

        <li>
            <a href="#">
                <i class="fa fa-file"></i>
                <span class="menu-title">{{__('Reports')}}</span>
                <i class="arrow"></i>
            </a>

            <!--Submenu-->
            <ul class="collapse">
                <li class="{{ areActiveRoutes(['stock_report.index'])}}">
                    <a class="nav-link" href="{{ route('stock_report.index') }}">{{__('Stock Report')}}</a>
                </li>
                <li class="{{ areActiveRoutes(['in_house_sale_report.index'])}}">
                    <a class="nav-link"
                        href="{{ route('in_house_sale_report.index') }}">{{__('In House Sale Report')}}</a>
                </li>
{{--                <li class="{{ areActiveRoutes(['seller_report.index'])}}">--}}
{{--                    <a class="nav-link" href="{{ route('seller_report.index') }}">{{__('Seller Report')}}</a>--}}
{{--                </li>--}}
{{--                <li class="{{ areActiveRoutes(['seller_sale_report.index'])}}">--}}
{{--                    <a class="nav-link"--}}
{{--                        href="{{ route('seller_sale_report.index') }}">{{__('Seller Based Selling Report')}}</a>--}}
{{--                </li>--}}
                <li class="{{ areActiveRoutes(['wish_report.index'])}}">
                    <a class="nav-link" href="{{ route('wish_report.index') }}">{{__('Product Wish Report')}}</a>
                </li>
            </ul>
        </li>
        @endif

        @if(Auth::user()->user_type == 'admin' || in_array('7', json_decode(Auth::user()->staff->role->permissions)))
        <li>
            <a href="#">
                <i class="fa fa-envelope"></i>
                <span class="menu-title">{{__('Messaging')}}</span>
                <i class="arrow"></i>
            </a>

            <!--Submenu-->
            <ul class="collapse">
                <li class="{{ areActiveRoutes(['newsletters.index'])}}">
                    <a class="nav-link" href="{{route('newsletters.index')}}">{{__('Newsletters')}}</a>
                </li>
            </ul>
        </li>
        @endif

        @if(Auth::user()->user_type == 'admin' || in_array('8', json_decode(Auth::user()->staff->role->permissions)))
        <li>
            <a href="#">
                <i class="fa fa-briefcase"></i>
                <span class="menu-title">{{__('Business Settings')}}</span>
                <i class="arrow"></i>
            </a>

            <!--Submenu-->
            <ul class="collapse">
                <li class="{{ areActiveRoutes(['activation.index'])}}">
                    <a class="nav-link" href="{{route('activation.index')}}">{{__('Activation')}}</a>
                </li>
                <li class="{{ areActiveRoutes(['payment_method.index'])}}">
                    <a class="nav-link" href="{{ route('payment_method.index') }}">{{__('Payment method')}}</a>
                </li>
{{--                <li class="{{ areActiveRoutes(['shipment_method.index'])}}">--}}
{{--                    <a class="nav-link" href="{{ route('shipment_method.index') }}">{{__('Shipment method')}}</a>--}}
{{--                </li>--}}
                <li class="{{ areActiveRoutes(['smtp_settings.index'])}}">
                    <a class="nav-link" href="{{ route('smtp_settings.index') }}">{{__('SMTP Settings')}}</a>
                </li>
                <li class="{{ areActiveRoutes(['google_analytics.index'])}}">
                    <a class="nav-link" href="{{ route('google_analytics.index') }}">{{__('Google Analytics')}}</a>
                </li>
                <li class="{{ areActiveRoutes(['facebook_chat.index'])}}">
                    <a class="nav-link" href="{{ route('facebook_chat.index') }}">{{__('Facebook Chat')}}</a>
                </li>
{{--                <li class="{{ areActiveRoutes(['facebook_blog.index'])}}">--}}
{{--                    <a class="nav-link" href="{{ route('facebook_blog.index') }}">{{__('Facebook Blogs')}}</a>--}}
{{--                </li>--}}
                <li class="{{ areActiveRoutes(['social_login.index'])}}">
                    <a class="nav-link" href="{{ route('social_login.index') }}">{{__('Social Media Login')}}</a>
                </li>
                <li
                    class="{{ areActiveRoutes(['languages.index', 'languages.create', 'languages.store', 'languages.show', 'languages.edit'])}}">
                    <a class="nav-link" href="{{route('languages.index')}}">{{__('Languages')}}</a>
                </li>
{{--                <li class="{{ areActiveRoutes(['coupon.affiliate.settings'])}}">--}}
{{--                    <a class="nav-link"--}}
{{--                        href="{{route('coupon.affiliate.settings')}}">{{__('Coupon affiliate value')}}</a>--}}
{{--                </li>--}}
            </ul>
        </li>
        @endif

        @if(Auth::user()->user_type == 'admin' || in_array('9', json_decode(Auth::user()->staff->role->permissions)))
        <li>
            <a href="#">
                <i class="fa fa-desktop"></i>
                <span class="menu-title">{{__('Frontend Settings')}}</span>
                <i class="arrow"></i>
            </a>

            <!--Submenu-->
            <ul class="collapse">
                <li
                    class="{{ areActiveRoutes(['home_settings.index', 'home_banners.index', 'sliders.index', 'home_categories.index', 'home_banners.create', 'home_categories.create', 'home_categories.edit', 'sliders.create'])}}">
                    <a class="nav-link" href="{{route('home_settings.index')}}">{{__('Home')}}</a>
                </li>
                <li>
                    <a href="#">
                        <span class="menu-title">{{__('Policy Pages')}}</span>
                        <i class="arrow"></i>
                    </a>

                    <!--Submenu-->
                    <ul class="collapse">

{{--                        <li class="{{ areActiveRoutes(['sellerpolicy.index'])}}">--}}
{{--                            <a class="nav-link"--}}
{{--                                href="{{route('sellerpolicy.index', 'seller_policy')}}">{{__('Seller Policy')}}</a>--}}
{{--                        </li>--}}
                        <li class="{{ areActiveRoutes(['returnpolicy.index'])}}">
                            <a class="nav-link"
                                href="{{route('returnpolicy.index', 'return_policy')}}">{{__('Return Policy')}}</a>
                        </li>
                        <li class="{{ areActiveRoutes(['supportpolicy.index'])}}">
                            <a class="nav-link"
                                href="{{route('supportpolicy.index', 'support_policy')}}">{{__('Support Policy')}}</a>
                        </li>
                        <li class="{{ areActiveRoutes(['terms.index'])}}">
                            <a class="nav-link"
                                href="{{route('terms.index', 'terms')}}">{{__('Terms & Conditions')}}</a>
                        </li>
                        <li class="{{ areActiveRoutes(['privacypolicy.index'])}}">
                            <a class="nav-link"
                                href="{{route('privacypolicy.index', 'privacy_policy')}}">{{__('Privacy Policy')}}</a>
                        </li>
                    </ul>

                </li>
                <li class="{{ areActiveRoutes(['links.index', 'links.create', 'links.edit'])}}">
                    <a class="nav-link" href="{{route('links.index')}}">{{__('Useful Link')}}</a>
                </li>
                <li class="{{ areActiveRoutes(['generalsettings.index'])}}">
                    <a class="nav-link" href="{{route('generalsettings.index')}}">{{__('General Settings')}}</a>
                </li>
                <li class="{{ areActiveRoutes(['shop.settings'])}}">
                    <a class="nav-link" href="{{route('shop.settings')}}?type=admin">{{__('Shop Settings')}}</a>
                </li>
                <li class="{{ areActiveRoutes(['generalsettings.logo'])}}">
                    <a class="nav-link" href="{{route('generalsettings.logo')}}">{{__('Logo Settings')}}</a>
                </li>
            </ul>
        </li>
        @endif

        @if(Auth::user()->user_type == 'admin' || in_array('12', json_decode(Auth::user()->staff->role->permissions)))
        <li>
            <a href="#">
                <i class="fa fa-desktop"></i>
                <span class="menu-title">{{__('E-commerce Setup')}}</span>
                <i class="arrow"></i>
            </a>

            <!--Submenu-->
            <ul class="collapse">
                <li>
                    <li class="{{ areActiveRoutes(['coupon.index','coupon.create','coupon.edit',])}}">
                        <a class="nav-link" href="{{route('coupon.index')}}">{{__('Coupon')}}</a>
                    </li>
                </li>
        </ul>
        </li>
        @endif

        @if(Auth::user()->user_type == 'admin' || in_array('13', json_decode(Auth::user()->staff->role->permissions)))
        @php
        $support_ticket = DB::table('tickets')
        ->where('viewed', 0)
        ->select('id')
        ->where('type', 1)->count();
        @endphp
        <li class="{{ areActiveRoutes(['https://newfaceeg.com/admin/support_ticket/1', 'support_ticket.admin_show'])}}">
            <a class="nav-link" href="{{ route('support_ticket.admin_index',1) }}">
                <i class="fa fa-support"></i>
                <span class="menu-title">{{__('Customer Support Ticket')}} @if($support_ticket > 0)<span
                        class="pull-right badge badge-info">{{ $support_ticket }}</span>@endif</span>
            </a>
        </li>
        @php
        $support_ticket = DB::table('tickets')
        ->where('viewed', 0)
        ->select('id')
        ->where('type', 2)->count();
        @endphp
{{--        <li class="{{ areActiveRoutes(['https://newfaceeg.com/admin/support_ticket/2', 'support_ticket.admin_show'])}}">--}}
{{--            <a class="nav-link" href="{{ route('support_ticket.admin_index',2) }}">--}}
{{--                <i class="fa fa-support"></i>--}}
{{--                <span class="menu-title">{{__('Seller Support Ticket')}} @if($support_ticket > 0)<span--}}
{{--                        class="pull-right badge badge-info">{{ $support_ticket }}</span>@endif</span>--}}
{{--            </a>--}}
{{--        </li>--}}
        {{--          @php
                                $support_ticket = DB::table('tickets')
                                            ->where('viewed', 0)
                                            ->select('id')
                                            ->where('type', 3)->count();
                            @endphp
                            <li class="{{ areActiveRoutes(['https://newfaceeg.com/admin/support_ticket/3', 'support_ticket.admin_show'])}}">
        <a class="nav-link" href="{{ route('support_ticket.admin_index',3) }}">
            <i class="fa fa-support"></i>
            <span class="menu-title">{{__('Affiliate Support Ticket')}} @if($support_ticket > 0)<span
                    class="pull-right badge badge-info">{{ $support_ticket }}</span>@endif</span>
        </a>
        </li>
        --}}
        @endif

        @if(Auth::user()->user_type == 'admin' || in_array('11', json_decode(Auth::user()->staff->role->permissions)))
        <li class="{{ areActiveRoutes(['seosetting.index'])}}">
            <a class="nav-link" href="{{ route('seosetting.index') }}">
                <i class="fa fa-search"></i>
                <span class="menu-title">{{__('SEO Setting')}}</span>
            </a>
        </li>
        @endif
        @if(Auth::user()->user_type == 'admin' || in_array('10', json_decode(Auth::user()->staff->role->permissions)))
        <li>
            <a href="#">
                <i class="fa fa-user"></i>
                <span class="menu-title">{{__('Staffs')}}</span>
                <i class="arrow"></i>
            </a>
            <!--Submenu-->
            <ul class="collapse">
                <li class="{{ areActiveRoutes(['staffs.index', 'staffs.create', 'staffs.edit'])}}">
                    <a class="nav-link" href="{{ route('staffs.index') }}">{{__('All staffs')}}</a>
                </li>
                <li class="{{ areActiveRoutes(['roles.index', 'roles.create', 'roles.edit'])}}">
                    <a class="nav-link" href="{{route('roles.index')}}">{{__('Staff permissions')}}</a>
                </li>
{{--                <li class="{{ areActiveRoutes(['shippers.index', 'shippers.create', 'shippers.edit'])}}">--}}
{{--                    <a class="nav-link" href="{{route('shippers.index')}}">{{__('Shipper Info')}}</a>--}}
{{--                </li>--}}
            </ul>
        </li>
        @endif
  {{--
        @if(Auth::user()->user_type == 'admin')
        <li>
            <a href="#">
                <i class="fa fa-user"></i>
                <span class="menu-title">{{__('Payment Requests')}}</span>
                <i class="arrow"></i>
            </a>
            <ul class="collapse">
                <li class="{{ areActiveRoutes(['payment_requests.index'])}}">
                    <a class="nav-link" href="{{ route('payment_requests.index') }}">{{__('All requests')}}</a>
                </li>
            </ul>
        </li>
        @endif
        --}}
        @if(Auth::user()->user_type == 'admin' || in_array('18', json_decode(Auth::user()->staff->role->permissions)))
        <li>
            <a href="#">
                <i class="fa fa-user"></i>
                <span class="menu-title">{{__('Notifications')}}</span>
                <i class="arrow"></i>
            </a>
            <ul class="collapse">
                <li class="{{areActiveRoutes(['notification.index'])}}">
                    <a class="nav-link" href="{{ route('notification.index') }}">{{__('Notifications')}}</a>
                </li>
            </ul>
        </li>
        @endif
        </ul>
    </div>
    </div>
    </div>
    <!--================================-->
    <!--End menu-->

    </div>
</nav>
