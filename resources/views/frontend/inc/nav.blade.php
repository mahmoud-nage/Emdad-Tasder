@php
    $settings = \App\GeneralSetting::first();
    $locale = app()->getLocale();
    $country = request()->session()->get('country') ? \App\Country::where('code' ,
    request()->session()->get('country'))->first() : \App\Country::where('code' , 'eg')->first();
    $flash_deal = \App\FlashDeal::where('status', 1)->where('start_date', '<=', today()->timestamp)->where('end_date', '>=', today()->timestamp)->where('country_id', get_country()->id)->get();
@endphp

<!-- Header -->
<nav class="navbar navbar-fixed-top">
    <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                    data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>

            <a class="navbar-brand" href="{{ route('home',['country' => get_country()->code]) }}">
                <img src="{{ asset($general_setting->logo) }}" alt="">
            </a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav navbar-left">
                <li class="active"><a
                        href="{{route('home',['country' => get_country()->code])}}">{{__('general.home')}}</a></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                       aria-expanded="false">
                        {{__('general.categories')}}
                        <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        @foreach($categories as $item)
                            <li><a href="{{ route('categories.all' ,['country' => get_country()->code])}}?id={{$item->id}}">{{ $item['name_'.$locale] }}</a></li>
                        @endforeach
                    </ul>
                </li>


                @if($flash_deal->count() > 0)
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                       aria-expanded="false">
                        {{__('general.deals')}}
                        <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        @foreach($flash_deal as $item)
                            <li><a href="{{ route('search',['country' => get_country()->code]) }}?flash_deal=flash_deal&id={{$item->id}}">{{ $item['title_'.$locale] }}</a></li>
                        @endforeach
                    </ul>
                </li>
                    @endif




                <li>
                    <a href="{{route('about_us', get_country()->code)}}">{{__('general.about_us')}}</a>
                </li>
                <li>
                    <a href="{{route('contact_us', get_country()->code)}}">{{__('general.contact_us')}}</a>
                </li>

                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                        {{__('general.see_more')}}
                                        <span class="caret"></span>
                                    </a>
                                    <ul class="dropdown-menu">
                                        @if($events->count()>0)
                                        <li><a href="{{route('all_events', get_country()->id)}}">{{__('general.events')}}</a></li>
                                        @endif
                                            @if($galleries->count()>0)
                                                <li><a href="{{route('all_galleries', get_country()->id)}}">{{__('general.gallery')}}</a></li>
                                            @endif
                                    </ul>
                                </li>
                                <li>
                                    <a href="{{route('make_deal1', get_country()->id)}}" class="btn btn-request">{{__('general.request_now')}}</a>
                                </li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <!-- Cart-->
{{--                <li>--}}
{{--                    <a href="{{ route('cart',['country' => get_country()->code]) }}" class="btn-cart" type="button">--}}
{{--                        <i class="fa fa-shopping-cart"></i>--}}
{{--                        @if(Session::has('cart_'.session()->get('country')))--}}
{{--                            <span class="badge"--}}
{{--                                  id="cart_items_sidenav">{{ count(Session::get('cart_'.session()->get('country')))}}</span>--}}
{{--                        @else--}}
{{--                            <span class="badge" id="cart_items_sidenav">0</span>--}}
{{--                        @endif--}}
{{--                    </a>--}}
{{--                </li>--}}

                <li class="dropdown login-menu ">
                    @auth
                        <a href="#" class="dropdown-toggle btn-menu btn-login" data-toggle="dropdown" role="button"
                           aria-haspopup="true" aria-expanded="false">
                            <span class="caret"></span>
                            <span class="title">{{auth()->user()->name}}</span>
                            <i class="fa fa-user"></i>
                        </a>
                    @else
                        <a href="#" class="dropdown-toggle btn-menu btn-login" data-toggle="dropdown" role="button"
                           aria-haspopup="true" aria-expanded="false">
                            <span class="caret"></span>
                            <span class="title">{{__('general.login')}}</span>
                            <i class="fa fa-sign-in"></i>
                        </a>
                    @endauth
                    @auth
                        <ul class="dropdown-menu">
                            <li>
                                <a href="{{ route('dashboard',['country' => get_country()->code]) }}">{{__('general.dashboard')}}</a>
                            </li>
                            <li>
                                <a href="{{ route('purchase_history.index',['country' => get_country()->code]) }}">{{__('general.purchase_history')}}</a>
                            </li>
                            <li>
                                <a href="{{ route('wishlists.index',['country' => get_country()->code]) }}">{{__('general.favorites')}}</a>
                            </li>
                            <li>
                                <a href="{{ route('support_ticket.index',['country' => get_country()->code]) }}">{{__('general.support_ticket')}}</a>
                            </li>

                            @if(auth()->user()->user_type == 'seller')

                                <li class="{{ areActiveRoutesHome(['seller_products'])}}">
                                    <a href="{{ route('seller_products', ['country' => get_country()->code]) }}">
                                        {{__('general.products')}}
                                    </a>
                                </li>
                                <li class="">
                                    <a href="{{ route('orders.index', ['country' => get_country()->code]) }}">
                                        {{__('general.orders')}}
                                    </a>
                                </li>
                                <li class="">
                                    <a href="{{ route('reviews.seller', ['country' => get_country()->code]) }}">
                                        {{__('general.product_rating')}}
                                    </a>
                                </li>
                                <li class="">
                                    <a href="{{ route('shops.index', ['country' => get_country()->code]) }}">
                                        {{__('forms.settings')}}
                                    </a>
                                </li>
                                <li class="">
                                    <a href="{{ route('payments.index', ['country' => get_country()->code]) }}">
                                        {{__('general.payment_history')}}
                                    </a>
                                </li>

                                <li class="">
                                    <a href="{{ route('profile', ['country' => get_country()->code]) }}">
                                        {{__('general.manage_profile')}}
                                    </a>
                                </li>

                            @endif
                            <li>
                                <a href="{{ route('logout',['country' => get_country()->code]) }}">{{__('general.logout')}}</a>
                            </li>

                        </ul>
                    @else
                        <ul class="dropdown-menu">
                            <li class="login-wrapper">
                                <div class="padding-10 text-center">
                                    <a href="{{ route('user.login',['country' => get_country()->code]) }}"
                                       class="btn btn-main btn-main">{{__('general.login')}} <i
                                            class="fa fa-sign-in"></i></a>
                                </div>
                                <h5 class="text-center">{{__('general.register_msg')}}</h5>
                                <h5 class="text-center"><a
                                        href="{{ route('user.registration',['country' => get_country()->code]) }}"
                                        class="color-main bold">{{__('general.sign_up_now')}}</a></h5>
                            </li>
                        </ul>
                    @endauth

                </li>

                <li class="select-lang" style="width:100px">
                    @if($locale=='en')
                        <form method="post" action="{{route('language.change',['country' => get_country()->code])}}">
                            @csrf
                            <input name="locale" value="ar" hidden>
                            <button style="color: #00186b !important;" class="btn btn-link" type="submit">عربي</button>
                        </form>
                    @elseif($locale=='ar')
                        <form method="post" action="{{route('language.change',['country' => get_country()->code])}}">
                            @csrf
                            <input name="locale" value="en" hidden>
                            <button style="color: #00186b !important;" class="btn btn-link" type="submit">English
                            </button>
                        </form>
                    @endif
                </li>
                <!--
                                <li class="dropdown shipping-dropdown">
                                    <a href="#" class="dropdown-toggle " id="dropdownMenu1" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                        <img src="assets/images/EGY.png" alt="">
                                    </a>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                        <li>
                                            <div class="shipping-title">Sipping to</div>
                                            <form action="" class="shipping-form">
                                                <div class="form-group">
                                                    <select name="" class="form-control">
                                                        <option value="">Egypt</option>
                                                        <option value="">KSA</option>
                                                        <option value="">UAE</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <div class="radio">
                                                        <label>
                                                            <input type="radio" name="optionsRadios" id="optionsRadios1" value="option1" checked="">
                                                            العربية
                                                        </label>
                                                    </div>
                                                    <div class="radio">
                                                        <label>
                                                            <input type="radio" name="optionsRadios" id="optionsRadios2" value="option2">
                                                            English
                                                        </label>
                                                    </div>
                                                </div>
                                            </form>
                                        </li>
                                    </ul>
                                </li>
                -->
            </ul>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>
