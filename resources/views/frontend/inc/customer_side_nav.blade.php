<div class="main-sidebar">
    <div class="profile-sidebar">
        <div class="user-img">
            @php
                $image = isset(Auth::user()->avatar) ? Auth::user()->avatar : 'https://kooledge.com/assets/default_medium_avatar-57d58da4fc778fbd688dcbc4cbc47e14ac79839a9801187e42a796cbd6569847.png';
            @endphp
            <img src="{{ asset($image) }}" alt="">

        </div>
        <div class="owner-name">
            {{ Auth::user()->name }}
        </div>
        <ul class="profile-menu">
            <li class="{{ request()->route()->getName() == 'dashboard' ? 'active' : '' }}">
                <a href="{{ route('dashboard', ['country' => get_country()->code]) }}" class="">
                    <img src="{{ asset('assets/web/images/Group 1605.png') }}" alt="">
                    {{__('general.dashboard')}}
                </a>
            </li>
            <li class="{{ request()->route()->getName() == 'purchase_history.index' ? 'active' : '' }}">
                <a href="{{ route('purchase_history.index', ['country' => get_country()->code]) }}">
                    <img src="{{ asset('assets/web/images/Group 1606.png') }}" alt="">
                    {{__('general.purchase_history')}}
                </a>
            </li>
            <li class="{{ request()->route()->getName() == 'wishlists.index' ? 'active' : '' }}">
                <a href="{{ route('wishlists.index', ['country' => get_country()->code]) }}">
                    <img src="{{ asset('assets/web/images/Group 1623.png') }}" alt="">
                    {{__('admin.favourites')}}
                </a>
            </li>
            <li class="{{ request()->route()->getName() == 'profile' ? 'active' : '' }}">
                <a href="{{ route('profile', ['country' => get_country()->code]) }}">
                    <img src="{{ asset('assets/web/images/Group 1653.png') }}" alt="">
                    {{__('general.profile')}}
                </a>
            </li>
            <!--<li class="{{ request()->route()->getName() == 'wallet.index' ? 'active' : '' }}">-->
            <!--    <a href="{{ route('wallet.index', ['country' => get_country()->code]) }}">-->
            <!--        <img src="{{ asset('assets/web/images/Group 1655.png') }}" alt="">-->
            <!--        {{__('general.my_wallet')}}-->
            <!--    </a>-->
            <!--</li>-->
            <li class="{{ request()->route()->getName() == 'support_ticket.index' ? 'active' : '' }}">
                <a href="{{ route('support_ticket.index', ['country' => get_country()->code]) }}">
                    <img src="{{ asset('assets/web/images/Group 1658.png') }}" alt="">
                    {{__('general.support_ticket')}}
                </a>
            </li>
        </ul>
        <div class="text-center">
            <a href="{{ route('shops.create', ['country' => get_country()->code]) }}" class="btn btn-main">
                {{__('general.be_a_seller')}}
            </a>
        </div>

    </div>
</div>
