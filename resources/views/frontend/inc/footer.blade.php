
@php
    $settings = \App\GeneralSetting::first();
@endphp


<!-- Footer -->
<footer>
    <div class="footer-contents">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-md-6 col-md-push-3">
                    <div class="socials">
                        <a href="{{$settings->facebook}}" target="_blank"><span class="facebook"><i class="fa fa-facebook"></i></span></a>
                        <a href="{{$settings->twitter}}" target="_blank"><span class="twitter"><i class="fa fa-twitter"></i></span></a>
                        <a href="{{$settings->instagram}}" target="_blank"><span class="instagram"><i class="fa fa-instagram"></i></span></a>
                    </div>

                    <div class="logo">
                        <a href="{{route('home',['country' => get_country()->code])}}" class="logo">
                            <img src="{{asset('assets/web/newface/images/logo-2.png')}}" alt="">
                        </a>
                    </div>
                </div>
                <div class="col-xs-12 col-md-3 col-md-pull-6">
                    <div class="footer-title">Important links</div>
                    <ul class="contact-menu">
                        @foreach (\App\Link::all() as $key => $link)
                            <li><a href="{{ $link->url }}">{{ $link['name_'.app()->getLocale()] }}</a></li>
                        @endforeach

                        @if(!isset(auth()->user()->seller) && false)
                            <li><a href="{{ route('shops.create',['country' => get_country()->code]) }}" class="btn btn-main btn-second">{{__('general.join_a_seller')}}</a></li>
                        @endif
                            <li>
                                <a href="{{route('about_us', get_country()->code)}}">{{__('general.about_us')}}</a>
                            </li>
                            <li>
                                <a href="{{route('contact_us', get_country()->code)}}">{{__('general.contact_us')}}</a>
                            </li>
                    </ul>
                </div>
                <div class="col-xs-12 col-md-3">
                    <div class="footer-title">{{__('general.contact_us')}}</div>
                    <ul class="contact-menu">
                        <li>
                            <i class="fa fa-phone"></i>
                            <a href="tel:{{$settings->phone}}">{{$settings->phone}}</a>
                        </li>
                        <li>
                            <i class="fa fa-envelope"></i>
                            <a href="mailto:{{$settings->email}}">{{$settings->email}}</a>
                        </li>
                        <li>
                            <i class="fa fa-map-marker"></i>
                            <a href="#;">{{app()->getLocale() == 'ar' ? $settings->address_ar : $settings->address}}</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="copyright">
        <div class="powerd">
            <p>
                <span class="mira">
                    <a href="#" target="_blank">{{$settings->site_name}}</a>
                    © <span id="year"></span>
                    All rights reserved
                </span>
                <span class="hidden-xs"> | </span>

                <span class="krito">
                    <a href="http://krito.io/" target="_blank" class="krito-link">

                        Powered by
                        <svg class="svg-krito" xmlns="http://www.w3.org/2000/svg" version="1.1" id="Layer_1" x="0px" y="0px" viewBox="0 0 159.2 222" style="enable-background:new 0 0 159.2 222;" xml:space="preserve">
                <style type="text/css">
                  .st0 {
                      fill: #E40E75;
                  }

                  .st1 {
                      fill: #F69B20;
                  }

                  .st2 {
                      fill: none;
                  }

                  .st3 {
                      fill: #1E1030;
                  }

                  .st4 {
                      fill: #FFFFFF;
                  }

                  .st5 {
                      font-family: 'Microsoft-Yi-Baiti';
                  }

                  .st6 {
                      font-size: 5.5517px;
                  }
                </style>
                <g id="XMLID_13513_">
                  <polygon id="XMLID_13517_" class="st0" points="58,17.8 58,115.1 31,125.2 31,27.5  "></polygon>
                  <polygon id="XMLID_13516_" class="st0" points="58,135.2 85,124.8 85,158.4 112,148.6 112.8,181.5 138.9,172 139.2,203.3    113,213.9 113,181.5 85,191.3 85,157.6 58,167.9  "></polygon>
                  <polygon id="XMLID_13515_" class="st0" points="55,169 55,178.5 34,186.1 34,161.7  "></polygon>
                  <polygon id="XMLID_13514_" class="st0" points="112,83.7 85,94 85,125.9 112,115.9 112.2,83.1 140,72.8 140,40.1 112,50.2  "></polygon>
                </g>
                <g id="XMLID_13506_">
                  <polygon id="XMLID_13512_" class="st1" points="31.2,125.2 57.5,115.1 85.6,124.8 57.7,135.2  "></polygon>
                  <polygon id="XMLID_13511_" class="st1" points="84.7,158.4 111.9,148.6 85.6,138.7 84.7,138.8  "></polygon>
                  <polygon id="XMLID_13510_" class="st1" points="85.1,72.6 112.3,82.6 85.6,93 57.5,82.6  "></polygon>
                  <polygon id="XMLID_13509_" class="st1" points="140.3,39.9 112.3,49.9 85.1,39.2 112.7,30.1  "></polygon>
                  <polygon id="XMLID_13508_" class="st1" points="112.6,161.9 140.2,171.7 112.1,181.7  "></polygon>
                  <polygon id="XMLID_13507_" class="st1" points="57.5,17.8 31.2,27.5 3.1,17.5 30.8,6.8  "></polygon>
                </g>
                <polygon id="XMLID_13505_" class="st2" points="143,37.9 143,40 143,72.8 143,74.6 141,75.4 115.1,85.5 114.9,115.9 114.9,115.9   114.9,117.8 113,118.6 88,127.5 88,136.8 113,145.9 115,146.6 115,147 115,147 115,159.6 140,169.3 140.1,169.3 142,170 142,172.1   142,203.3 142,205.3 140.1,206 140.1,206 140,206 113.4,216.4 112.9,216.6 112,217 110.9,216.6 84.4,206.9 84,206.8 82,206.1   82,193.3 57.5,183.6 32.3,192.7 31.7,193 30.8,193.3 29.8,193 26.8,191.9 3,183.6 0,182.7 0,15.7 2,15 4,14.3 4,14.3 4.2,14.2   31.8,4.1 58.4,15.2 60,15.9 60,78.8 82,70.6 82,37 82.2,37 82.5,37 84.2,36.4 111.8,27.3 112.3,27.2 112.7,27 112.7,27.1   113.7,27.4 141,37.1 141.4,37.3 "></polygon>
                <polygon id="XMLID_13504_" class="st2" points="143,37.9 143,40 143,72.8 143,74.6 141,75.4 115.1,85.5 114.9,115.9 114.9,115.9   114.9,117.8 113,118.6 88,127.5 88,136.8 113,145.9 115,146.6 115,147 115,147 115,159.6 140,169.3 140.1,169.3 142,170 142,172.1   142,203.3 142,205.3 140.1,206 140.1,206 140,206 113.4,216.4 112.9,216.6 112,217 110.9,216.6 84.4,206.9 84,206.8 82,206.1   82,193.3 57.5,183.6 32.3,192.7 31.7,193 30.8,193.3 29.8,193 26.8,191.9 3,183.6 0,182.7 0,15.7 2,15 4,14.3 4,14.3 4.2,14.2   31.8,4.1 58.4,15.2 60,15.9 60,78.8 82,70.6 82,37 82.2,37 82.5,37 84.2,36.4 111.8,27.3 112.3,27.2 112.7,27 112.7,27.1   113.7,27.4 141,37.1 141.4,37.3 "></polygon>
                <path id="XMLID_13503_" class="st3" d="M140,169.3"></path>
                <path id="XMLID_13488_" class="st3" d="M141.4,37.2l-0.4-0.2l-27.3-9.7l-1.1-0.3l-0.3,0.1l-0.5,0.2l-27.6,9.1l-1.7,0.6L82.2,37H82  v33.6l-22,8.2V15.9l-1.6-0.7l-26.7-11L4.1,14.2l-0.1,0v0L2,15l-2,0.7v167l3,0.9l23.8,8.3l3,1l1,0.3l0.9-0.3l0.6-0.2l25.2-9.1  l24.5,9.7v12.8l2,0.7l0.4,0.1l26.4,9.7l1.1,0.4l0.9-0.4l0.5-0.2L140,206h0l0.1,0l1.9-0.7v-2v-31.2V170l-2-0.7l0,0l-25-9.7V147l0,0  v-0.4l-2-0.7l-25-9.1v-9.3l25-8.9l1.9-0.8l-0.1-1.9l0,0l0.1-30.4l26-10l2-0.8v-1.8V39.9v-2.1L141.4,37.2z M115,165.8l15.9,6.1  l-15.9,5.7V165.8z M115,183.8l21.2-7.7l0.2,25.2l-21.4,8.4V183.8z M31.2,24.4l-19.8-7l19.3-7.5l18.9,7.8L31.2,24.4z M55,22v91.1  l-21,7.9V29.5L55,22z M55,178.5l-21,7.6v-24.4l21,7.3V178.5z M39.3,125.1l18.1-6.9l19,7.3l-18.7,6.6L39.3,125.1z M61,162.9v-25.8  l21.3-7.6l0.1,26.1L61,162.9z M109,179.7l-21,7.6l0-27.5l21.1-7.1V179.7z M103.1,148.5l-15.2,5.1l0-10.7L103.1,148.5z M85,90.9  l-19.5-7.9l19.5-7.3l19.2,7.7L85,90.9z M109.2,113.8L88,121.4V96l21.3-8.3L109.2,113.8z M112.3,47L112.3,47l-18.8-7.5l19.1-6.3  l19.1,6.9L112.3,47z M136.9,70.7L115,79.2l0.1-27.3l22.2-7.9L136.9,70.7z"></path>
                <text id="XMLID_11580_" transform="matrix(1 0 0 1 142.6309 169.3438)" class="st4 st5 st6">TM</text>
                </svg>
                        <span class="rito">rito</span>
                    </a>
                </span>
            </p>
        </div>
    </div>

</footer>


