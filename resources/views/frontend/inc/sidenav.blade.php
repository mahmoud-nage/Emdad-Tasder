<!-- Side Menu -->
<div id="mySidenav" class="sidenav">
    <div class="menu-contents">
        <ul class="links">
            <li><a href="{{ route('home',['country' => get_country()->code]) }}"><span class="fa fa-home"></span> {{__('general.home')}}</a></li>

            <li class="panel panel-default">
                <div class="panel-heading" role="tab" id="accountHeadingOne">
                    <h4 class="panel-title">
                        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#accountCollapseOne" aria-expanded="false" aria-controls="collapseOne">
                            @auth{{auth()->user()->name}}@else{{__('general.login')}}@endauth
                        </a>
                    </h4>
                </div>
                <div id="accountCollapseOne" class="panel-collapse collapse " role="tabpanel" aria-labelledby="accountHeadingOne">
                    <div class="panel-body">
                @auth
                <ul class="" style="margin:auto 10px">
                    <li><a href="{{ route('dashboard',['country' => get_country()->code]) }}">{{__('general.dashboard')}}</a></li>
                    <li><a href="{{ route('purchase_history.index',['country' => get_country()->code]) }}">{{__('general.purchase_history')}}</a></li>
                    <li><a href="{{ route('wishlists.index',['country' => get_country()->code]) }}">{{__('general.favorites')}}</a></li>
                    <li><a href="{{ route('support_ticket.index',['country' => get_country()->code]) }}">{{__('general.support_ticket')}}</a></li>
                @if(auth()->user()->user_type == 'seller')
                
                <li class="{{ areActiveRoutesHome(['seller_products'])}}">
            <a href="{{ route('seller_products', ['country' => get_country()->code]) }}">
                {{__('general.products')}}
            </a>
        </li >
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
                    <li><a href="{{ route('logout',['country' => get_country()->code]) }}">{{__('general.logout')}}</a></li>
                </ul>
                
                @else
                <div class="padding-10 text-center">
                    <a href="{{ route('user.login',['country' => get_country()->code]) }}" class="btn btn-main btn-second">{{__('general.login')}} <img src="{{ asset('assets/web/newface/images/user2.png') }}"
                            alt=""></a>
                </div>
                <h5 class="color-main text-center">Dont have an Account ?</h5>
                <h5 class="color-second text-center"><a href="register.html" class="color-second">Sign
                        Up now</a></h5>
                @endauth
                    </div>
                </div>

                <div class="panel-heading" role="tab" id="manHeadingOne">
                    <h4 class="panel-title">
                        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#manCollapseOne" aria-expanded="false" aria-controls="collapseOne">
                            {{__('general.man')}}
                        </a>
                    </h4>
                </div>
                <div id="manCollapseOne" class="panel-collapse collapse " role="tabpanel" aria-labelledby="manHeadingOne">
                    <div class="panel-body">
                        <ul class="">
                            @foreach($categories->where('type',2) as $category)
                            <li class="panel panel-default" style="margin:auto 10px">
                                <div class="panel-heading" role="tab" id="manHeadingOne">
                                    <h4 class="panel-title">
                                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion"
                                           href="#collapse{{ $category->id }}" aria-expanded="false"
                                           aria-controls="collapseTwo" >
                                            {{ app()->isLocale('ar') ? $category->name_ar : $category->name_en }}
                                </a>
                                </h4>
                                </div>
                                <div id="collapse{{ $category->id }}" class="panel-collapse collapse" role="tabpanel"
                                     aria-labelledby="headingTwo">
                                    <div class="panel-body">
                                        <ul class="">
                                            @foreach($category->subcategories as $subcategory)
                                                <li style="margin:auto 10px">
                                                    <a href="{{ route('products.subcategory', ['country' => get_country()->code, 'subcategory_slug' => $subcategory->slug ]) }}">{{ app()->isLocale('ar') ? $subcategory->name_ar : $subcategory->name_en }}</a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                        </li>
                        @endforeach
                        </ul>
                    </div>
                </div>
            </li>

            <li class="panel panel-default">
                <div class="panel-heading" role="tab" id="womenHeadingOne">
                    <h4 class="panel-title">
                        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#womenCollapseOne" aria-expanded="false" aria-controls="collapseOne">
                            {{__('general.women')}}
                        </a>
                    </h4>
                </div>
                <div id="womenCollapseOne" class="panel-collapse collapse " role="tabpanel" aria-labelledby="womenHeadingOne">
                    <div class="panel-body">
                        <ul class="">
                            @foreach($categories->where('type',1) as $category)
                            <li class="panel panel-default" style="margin:auto 10px">
                                <div class="panel-heading" role="tab" id="womenHeadingOne">
                                    <h4 class="panel-title">
                                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion"
                                           href="#collapse{{ $category->id }}" aria-expanded="false"
                                           aria-controls="collapseTwo" >
                                            {{ app()->isLocale('ar') ? $category->name_ar : $category->name_en }}
                                </a>
                                </h4>
                                </div>
                                <div id="collapse{{ $category->id }}" class="panel-collapse collapse" role="tabpanel"
                                     aria-labelledby="headingTwo">
                                    <div class="panel-body">
                                        <ul class="">
                                            @foreach($category->subcategories as $subcategory)
                                                <li style="margin:auto 10px">
                                                    <a href="{{ route('products.subcategory',['country' => get_country()->code, 'subcategory_slug' => $subcategory->slug ]) }}">{{ app()->isLocale('ar') ? $subcategory->name_ar : $subcategory->name_en }}</a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                        </li>
                        @endforeach
                        </ul>
                    </div>
                </div>
            </li>
            <li class="panel panel-default">
                <div class="panel-heading" role="tab" id="countryHeadingOne">
                    <h4 class="panel-title">
                        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#countrysCollapseOne" aria-expanded="false" aria-controls="collapseOne">
                            {{__('general.country')}}
                        </a>
                    </h4>
                </div>
                <div id="countrysCollapseOne" class="panel-collapse collapse " role="tabpanel" aria-labelledby="countryHeadingOne">
                    <div class="panel-body">
                        <ul class="">
                            @foreach($countries as $item)
                        <li><a tabindex="-1"
                            href="{{ route('country.change',['country' => get_country()->code]) }}?country={{ $item->code }}">
                            {{ app()->isLocale('ar') ? $item->name_ar : $item->name_en }}
                        </a></li>
                        @endforeach
                        </ul>
                    </div>
                </div>
            </li>
        </ul>
    </div>
</div>





