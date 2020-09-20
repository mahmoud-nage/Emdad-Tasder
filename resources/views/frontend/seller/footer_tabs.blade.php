<br><br><br><br>
<div class="footer-tabs-wrapper" >
    <div class="container">
        <div class="row">
            <div class="col-xs-3">
                <a href="{{route('sellerpolicy',['country' => get_country()->code])}}" class="footer-tab">
                    <div class="footer-tab-img">
                        <img src="{{asset('assets/seller/images/tab-1.png')}}" alt="">
                    </div>
                    <div class="footer-tab-title">
                        
                        {{__('general.seller_policy')}}
                    </div>
                </a>
            </div>
            <div class="col-xs-3">
                <a href="{{route('returnpolicy',['country' => get_country()->code])}}" class="footer-tab">
                    <div class="footer-tab-img">
                        <img src="{{asset('assets/seller/images/tab-2.png')}}" alt="">
                    </div>
                    <div class="footer-tab-title">
                        
                        {{__('general.return_policy')}}
                    </div>
                </a>
            </div>
            <div class="col-xs-3">
                <a href="{{route('supportpolicy',['country' => get_country()->code])}}" class="footer-tab">
                    <div class="footer-tab-img">
                        <img src="{{asset('assets/seller/images/tab-3.png')}}" alt="">
                    </div>
                    <div class="footer-tab-title">
                        
                        {{__('general.support_policy')}}
                    </div>
                </a>
            </div>
            <div class="col-xs-3">
                <a href="{{ route('profile',['country' => get_country()->code]) }}" class="footer-tab">
                    <div class="footer-tab-img">
                        <img src="{{asset('assets/seller/images/tab-4.png')}}" alt="">
                    </div>
                    <div class="footer-tab-title">
                        {{__('general.manage_profile')}}
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>