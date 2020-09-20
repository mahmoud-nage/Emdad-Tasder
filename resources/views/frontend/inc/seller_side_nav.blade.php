<div class="main-sidebar">
    <div class="profile-sidebar">
    <div class="user-img">
        @php
        if(isset(Auth::user()->seller)){
            $image = isset(Auth::user()->shop->logo) ? Auth::user()->shop->logo : isset(Auth::user()->avatar);
        }else{
            $image = isset(Auth::user()->avatar) ? Auth::user()->avatar : 'https://kooledge.com/assets/default_medium_avatar-57d58da4fc778fbd688dcbc4cbc47e14ac79839a9801187e42a796cbd6569847.png';
        }
        @endphp
        <img src="{{ asset($image) }}" alt="">
    </div>
    <div class="owner-name">
            @if(Auth::user()->seller->verification_status == 1)
                <div class="name mb-0">{{ Auth::user()->name }} <span class="ml-2"><i class="fa fa-check-circle" style="color:green"></i></span></div>
            @else
                <div class="name mb-0">{{ Auth::user()->name }} <span class="ml-2"><i class="fa fa-times-circle" style="color:red"></i></span></div>
            @endif
    </div>
    <ul class="profile-menu">
        <li class="{{ areActiveRoutesHome(['dashboard'])}}">
            <a href="{{ route('dashboard', ['country' => get_country()->code]) }}" class="">
                <img src="{{ asset('assets/web/images/Group 1605.png') }}" alt="">
                {{__('general.dashboard')}}
            </a>
        </li>
        <li class="{{ areActiveRoutesHome(['purchase_history.index'])}}">
            <a href="{{ route('purchase_history.index', ['country' => get_country()->code]) }}">
                <img src="{{ asset('assets/web/images/Group 1606.png') }}" alt="">
                {{__('general.purchase_history')}}
            </a>
        </li>
        <li class="{{ areActiveRoutesHome(['wishlists.index'])}}">
            <a href="{{ route('wishlists.index', ['country' => get_country()->code]) }}">
                <img src="{{ asset('assets/web/images/Group 1623.png') }}" alt="">
                {{__('general.favorites')}}
            </a>
        </li>
        <li class="{{ areActiveRoutesHome(['seller_products'])}}">
            <a href="{{ route('seller_products', ['country' => get_country()->code]) }}">
                <img src="{{ asset('assets/web/images/Group 1624.png') }}" alt="">
                {{__('general.products')}}
            </a>
        </li >
        <li class="{{ areActiveRoutesHome(['orders.index'])}}">
            <a href="{{ route('orders.index', ['country' => get_country()->code]) }}">
                <img src="{{ asset('assets/web/images/Group 1625.png') }}" alt="">
                {{__('general.orders')}}
            </a>
        </li>
        <li class="{{ areActiveRoutesHome(['reviews.seller'])}}">
            <a href="{{ route('reviews.seller', ['country' => get_country()->code]) }}">
                <img src="{{ asset('assets/web/images/Path 1265.png') }}" alt="">
                {{__('general.product_rating')}}
            </a>
        </li>
        <li class="{{ areActiveRoutesHome(['shops.index'])}}">
            <a href="{{ route('shops.index', ['country' => get_country()->code]) }}">
                <img src="{{ asset('assets/web/images/Group 1336.png') }}" alt="">
                {{__('forms.settings')}}
            </a>
        </li>
        <li class="{{ areActiveRoutesHome(['payments.index'])}}">
            <a href="{{ route('payments.index', ['country' => get_country()->code]) }}">
                <img src="{{ asset('assets/web/images/Group 1651.png') }}" alt="">
                {{__('general.payment_history')}}
            </a>
        </li>

        <li class="{{ areActiveRoutesHome(['profile'])}}">
            <a href="{{ route('profile', ['country' => get_country()->code]) }}">
                <img src="{{ asset('assets/web/images/Group 1653.png') }}" alt="">
                {{__('general.manage_profile')}}
            </a>
        </li>
        <!--@if (\App\BusinessSetting::where('type', 'wallet_system')->first()->value == 1)-->

        <!--<li class="{{ areActiveRoutesHome(['wallet.index'])}}">-->
        <!--    <a href="{{ route('wallet.index', ['country' => get_country()->code]) }}">-->
        <!--        <img src="{{ asset('assets/web/images/Group 1655.png') }}" alt="">-->
        <!--        {{__('general.my_wallet')}}-->
        <!--    </a>-->
        <!--</li>-->
        <!--@endif-->
        <li class="{{ areActiveRoutesHome(['support_ticket.index'])}}">
            <a href="{{ route('support_ticket.index', ['country' => get_country()->code]) }}">
                <img src="{{ asset('assets/web/images/Group 1658.png') }}" alt="">
                {{__('general.support_ticket')}}
            </a>
        </li>
    </ul>
</div>
            <div class="earning-wrapper">
                <div class="earning-title">{{__('general.earnings')}}</div>
                <div class="earning-current">{{__('general.earn_current_month')}}</div>
                <div class="earning-price danger">
                    @php
                                    $current_month = 0;
                                    $last_month = 0;
                                    $orderDetails = \App\OrderDetail::where('seller_id', auth()->user()->id)->where('delivery_status', 'delivered');
                                    
                                    $total_earning_without_commision = $orderDetails->sum('price');
                                    $total_commision = $orderDetails->sum('commission');
                                    $total_earning = $total_earning_without_commision - $total_commision;
                                        
                                        if($orderDetails != null){
                                        foreach($orderDetails->get() as $orderDetail){
                                        if( (int)date('m', strtotime($orderDetail->created_at)) == (int)date('m')){
                                            $current_month += $orderDetail->price - $orderDetail->commission ;   
                                        }elseif( (int)date('m', strtotime($orderDetail->created_at)) == date('m')-1){
                                            $last_month += $orderDetail->price - $orderDetail->commission;  
                                        }
                                        }
                                        }
                    @endphp
                    
                    
                    {{$current_month}} L.E</div><!-- toogle class success or danger -->
                <div class="earning-total">
                    <div class="title">{{__('general.total_earnings')}}:</div>
                    <div class="price">{{$total_earning}} L.E</div>
                </div>
                <div class="earning-total">
                    <div class="title">{{__('general.Last_month')}}:	</div>
                    <div class="price">{{$last_month}} L.E</div>
                </div>
            </div>
            </div>


