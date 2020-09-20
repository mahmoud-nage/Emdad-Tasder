<!--NAVBAR-->
<!--===================================================-->
<header id="navbar">
    <div id="navbar-container" class="boxed">

        @php
            $generalsetting = \App\GeneralSetting::first();
        @endphp

        <!--Brand logo & name-->
        <!--================================-->
        <div class="navbar-header">
            <a href="{{route('admin.dashboard', auth()->user()->country)}}" class="navbar-brand">
                @if($generalsetting->logo != null)
                    <img src="{{ asset($generalsetting->admin_logo) }}" class="brand-icon" alt="{{ $generalsetting->site_name }}">
                @else
                    <img src="{{ asset('img/logo_shop.png') }}" class="brand-icon" alt="{{ $generalsetting->site_name }}">
                @endif
                <div class="brand-title">
                    <span class="brand-text">{{ $generalsetting->site_name }}</span>
                </div>
            </a>
        </div>
        <!--================================-->
        <!--End brand logo & name-->


        <!--Navbar Dropdown-->
        <!--================================-->
        <div class="navbar-content">

            <ul class="nav navbar-top-links">

                <!--Navigation toogle button-->
                <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                <li class="tgl-menu-btn">
                    <a class="mainnav-toggle" href="#">
                        <i class="demo-pli-list-view"></i>
                    </a>
                </li>
                <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                <!--End Navigation toogle button-->



                {{-- <!--Search-->
                <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                <li>
                    <div class="custom-search-form">
                        <label class="btn btn-trans" for="search-input" data-toggle="collapse" data-target="#nav-searchbox">
                            <i class="demo-pli-magnifi-glass"></i>
                        </label>
                    </div>
                </li>
                <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                <!--End Search--> --}}

            </ul>
            <ul class="nav navbar-top-links">

                @php
                    $orders = DB::table('orders')
                                ->orderBy('code', 'desc')
                                ->join('order_details', 'orders.id', '=', 'order_details.order_id')
                                ->where('order_details.seller_id', Auth::user()->id)
                                ->where('orders.viewed', 0)
                                ->select('orders.id')
                                ->distinct()
                                ->count();
                    // $sellers = \App\Seller::where('verification_status', 0)->where('verification_info', '!=', null)->count();
                    // $shipment_order_pending = \App\Order::where('shipment_type', 2)->where('shipment_status',0)->count();
                    // $product_pending = \App\Product::where('added_by', 'seller')->where('confirmed',0)->count();
                    // $request_seller_payment = \App\SellerPayment::where('status', 1)->count();
                     $customer_support_ticket = \App\Ticket::where('type', 1)->where('viewed',0)->count();
                    // $seller_support_ticket = \App\Ticket::where('type', 2)->where('viewed',0)->count();
                @endphp

                {{--
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle  top-bar-item" id="dropdownMenu1" data-toggle="dropdown" role="button"
                        aria-haspopup="true" aria-expanded="false">
                        @php
                            $c = session()->get('country')?session()->get('country'):auth()->user()->country;
                            $logo = $countries->where('code', $c)->first();
                        @endphp
                        @if(isset($logo->icon))
                        <img width="24" height="16" src="{{asset($logo->icon)}}" alt="">
                        @else
                        {{$c}}
                        @endisset
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                        <li>
                        <form action="{{route('country.change')}}" class="shipping-form">
                            <input type="hidden" name="type" value="1">
                                <div class="form-group">
                                    <select name="country" class="form-control">
                                        @foreach ($countries as $item)
                                            <option value="{{$item->code}}" @if($item->code == session()->get('country')) selected @endif>{{$item['name_'.app()->getLocale()]}}</option>
                                        @endforeach
                                    </select>
                                        <button class="btn btn-purple" type="submit">{{__('general.submit')}}</button>
                                </div>
                            </form>
                        </li>
                    </ul>
                    </li> --}}
                <li class="dropdown" id="lang-change">
                    @php
                        if(Session::has('locale')){
                            $locale = Session::get('locale', Config::get('app.locale'));
                        }
                        else{
                            $locale = 'en';
                        }
                    @endphp
                    <a href="" class="dropdown-toggle top-bar-item" data-toggle="dropdown">
                        <img src="{{ asset('frontend/images/icons/flags/'.$locale.'.png') }}" class="flag" style="margin-right:6px;"><span class="language">{{ \App\Language::where('code', $locale)->first()->name }}</span>
                    </a>
                    <ul class="dropdown-menu">
                        @foreach (\App\Language::all() as $key => $language)
                            <li class="dropdown-item @if($locale == $language) active @endif">
                                <a href="#" data-flag="{{ $language->code }}"><img src="{{ asset('frontend/images/icons/flags/'.$language->code.'.png') }}" class="flag" style="margin-right:6px;"><span class="language">{{ $language->name }}</span></a>
                            </li>
                        @endforeach
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" data-toggle="dropdown" class="dropdown-toggle" aria-expanded="true">
                        <i class="demo-pli-bell"></i>
                        @if($orders > 0 || $customer_support_ticket)
                            <span class="badge badge-header badge-danger"></span>
                        @endif
                    </a>

                    <!--Notification dropdown menu-->
                    <div class="dropdown-menu dropdown-menu-md dropdown-menu-right" style="opacity: 1;">
                        <div class="nano scrollable has-scrollbar" style="height: 265px;">
                            <div class="nano-content" tabindex="0" style="right: -17px;">
                                <ul class="head-list">
                                    @if($orders > 0)
                                        <li>
                                            <a class="media" href="{{ route('orders.index.admin') }}" style="position:relative">
                                                <span class="badge badge-header badge-info" style="right:auto;left:3px;"></span>
                                                <div class="media-body">
                                                    <p class="mar-no text-nowrap text-main text-semibold">{{ $orders }} new order(s)</p>
                                                </div>
                                            </a>
                                        </li>
                                    @endif
                                    @if($customer_support_ticket > 0)
                                        <li>
                                            <a class="media" href="{{ route('support_ticket.admin_index', $type=1) }}" style="position:relative">
                                                <span class="badge badge-header badge-info" style="right:auto;left:3px;"></span>
                                                <div class="media-body">
                                                    <p class="mar-no text-nowrap text-main text-semibold">{{ $customer_support_ticket }} new Customer Support Ticket(s)</p>
                                                </div>
                                            </a>
                                        </li>
                                    @endif
{{--                                    @if($seller_support_ticket > 0)--}}
{{--                                        <li>--}}
{{--                                            <a class="media" href="{{ route('support_ticket.admin_index', $type=2) }}" style="position:relative">--}}
{{--                                                <span class="badge badge-header badge-info" style="right:auto;left:3px;"></span>--}}
{{--                                                <div class="media-body">--}}
{{--                                                    <p class="mar-no text-nowrap text-main text-semibold">{{ $seller_support_ticket }} new Seller Support Ticket(s)</p>--}}
{{--                                                </div>--}}
{{--                                            </a>--}}
{{--                                        </li>--}}
{{--                                    @endif--}}
{{--                                    @if($request_seller_payment > 0)--}}
{{--                                        <li>--}}
{{--                                            <a class="media" href="{{ route('sellers.payment_histories') }}" style="position:relative">--}}
{{--                                                <span class="badge badge-header badge-info" style="right:auto;left:3px;"></span>--}}
{{--                                                <div class="media-body">--}}
{{--                                                    <p class="mar-no text-nowrap text-main text-semibold">{{ $request_seller_payment }} new Request Seller Payment(s)</p>--}}
{{--                                                </div>--}}
{{--                                            </a>--}}
{{--                                        </li>--}}
{{--                                    @endif--}}
{{--                                    @if($shipment_order_pending > 0)--}}
{{--                                        <li>--}}
{{--                                            <a class="media" href="{{ route('aramex_pickup.index') }}" style="position:relative">--}}
{{--                                                <span class="badge badge-header badge-info" style="right:auto;left:3px;"></span>--}}
{{--                                                <div class="media-body">--}}
{{--                                                    <p class="mar-no text-nowrap text-main text-semibold">{{ $shipment_order_pending }} Order has been went to Shipment(s)</p>--}}
{{--                                                </div>--}}
{{--                                            </a>--}}
{{--                                        </li>--}}
{{--                                    @endif--}}
{{--                                    @if($product_pending > 0)--}}
{{--                                        <li>--}}
{{--                                            <a class="media" href="{{ route('products.seller') }}" style="position:relative">--}}
{{--                                                <span class="badge badge-header badge-info" style="right:auto;left:3px;"></span>--}}
{{--                                                <div class="media-body">--}}
{{--                                                    <p class="mar-no text-nowrap text-main text-semibold">{{ $product_pending }} new Seller Product(s)</p>--}}
{{--                                                </div>--}}
{{--                                            </a>--}}
{{--                                        </li>--}}
{{--                                    @endif--}}
{{--                                    @if($sellers > 0)--}}
{{--                                        <li>--}}
{{--                                            <a class="media" href="{{ route('sellers.index') }}">--}}
{{--                                                <div class="media-body">--}}
{{--                                                    <p class="mar-no text-nowrap text-main text-semibold">{{__('New verification request(s)')}}</p>--}}
{{--                                                </div>--}}
{{--                                            </a>--}}
{{--                                        </li>--}}
{{--                                    @endif--}}
                                </ul>
                            </div>
                            <div class="nano-pane" style="">
                                <div class="nano-slider" style="height: 170px; transform: translate(0px, 0px);"></div>
                            </div>
                        </div>
                    </div>
                </li>

                <!--User dropdown-->
                <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                <li id="dropdown-user" class="dropdown">
                    <a href="#" data-toggle="dropdown" class="dropdown-toggle text-right">
                        <span class="ic-user pull-right">

                            <i class="demo-pli-male"></i>
                        </span>
                    </a>

                    <div class="dropdown-menu dropdown-menu-sm dropdown-menu-right panel-default">
                        <ul class="head-list">
                            <li>
                                <a href="{{ route('profile.index') }}"><i class="demo-pli-male icon-lg icon-fw"></i> {{__('Profile')}}</a>
                            </li>
                            <li>
                                <a href="{{ route('logout')}}"><i class="demo-pli-unlock icon-lg icon-fw"></i> {{__('Logout')}}</a>
                            </li>
                        </ul>
                    </div>
                </li>
                <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                <!--End user dropdown-->
            </ul>
        </div>
        <!--================================-->
        <!--End Navbar Dropdown-->

    </div>
</header>
