<!DOCTYPE html>
<html @if(app()->isLocale('ar')) dir="rtl" lang="ar" @else lang="en" @endif>

<head>
    @if (\App\BusinessSetting::where('type', 'facebook_chat')->first()->value == 1)
    <!-- Load Facebook SDK for JavaScript -->
    @php
    $code = isset($business_settings->where('type',
    'FACEBOOK_PAGE_ID')->first()->value)?$business_settings->where('type', 'FACEBOOK_PAGE_ID')->first()->value:''
    @endphp
    {!! trim($code, '"') !!}
    <!--{{ (int) $code[0] }}-->
    @endif
    @if (\App\BusinessSetting::where('type', 'google_analytics')->first()->value == 1)
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async
        src="https://www.googletagmanager.com/gtag/js?id={{ isset($business_settings->where('type', 'TRACKING_ID')->first()->value)?$business_settings->where('type', 'TRACKING_ID')->first()->value:''}}">
    </script>
    <script>
        window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', {{ isset($business_settings->where('type', 'TRACKING_ID')->first()->value)?$business_settings->where('type', 'TRACKING_ID')->first()->value:''}});
    </script>
    @endif
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="Content-Language" content="{{app()->getLocale()}}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="subject" content="E-Commerce">
    <meta name="copyright" content="Revel Media">
    <meta name="language" content="{{app()->getLocale()}}">
    <meta name="author" content="M & W, ">
    @yield('meta')


    <title> @yield('title') | {{$general_setting->site_name}}</title>
    <!-- Favicon-->
    <link rel="icon" type="image/png" href="{{ asset($general_setting->favicon) }}" />

    <link rel="stylesheet" type="text/css" href="{{ asset('assets/web/newface/css/font-awesome.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/web/newface/css/animate.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/web/newface/css/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/web/newface/css/owl.carousel.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/web/newface/css/owl.theme.default.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/web/newface/css/jquery-ui.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/web/newface/css/jquery-ui.theme.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/web/newface/css/theme.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/web/newface/css/theme-sections.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/web/newface/css/seller.css') }}">

    @if(app()->isLocale('ar'))
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/web/newface/css/bootstrap.rtl.css') }}">
    @endif
    @if(app()->isLocale('ar'))
            <link rel="stylesheet" type="text/css" href="{{ asset('assets/web/newface/css/theme-sections-rtl.css') }}">
    @endif
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />
    <link type="text/css" href="{{ asset('frontend/css/slick.css') }}" rel="stylesheet">
    <link type="text/css" href="{{ asset('frontend/css/xzoom.css') }}" rel="stylesheet">
    <link type="text/css" href="{{ asset('frontend/css/jquery.share.css') }}" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.min.css" rel="stylesheet"
        type="text/css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.css"
        integrity="sha512-nNlU0WK2QfKsuEmdcTwkeh+lhGs6uyOxuUs+n+0oXSYDok5qy0EI0lt01ZynHq6+p/tbgpZ7P+yUb+r71wqdXg=="
        crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.css"
        integrity="sha512-H9jrZiiopUdsLpg94A333EfumgUBpO9MdbxStdeITo+KEIMaNfHNvwyjjDJb+ERPaRS6DpyRlKbvPUasNItRyw=="
        crossorigin="anonymous" />

    @if (\App\BusinessSetting::where('type', 'facebook_pixel')->first()->value == 1)
    @if(app()->isLocale('ar'))
    <script async defer crossorigin="anonymous"
        src="https://connect.facebook.net/ar_AR/sdk.js#xfbml=1&version=v7.0&appId={{isset($business_settings->where('type', 'FACEBOOK_PIXEL_ID')->first()->value)?$business_settings->where('type', 'FACEBOOK_PIXEL_ID')->first()->value:''}}&autoLogAppEvents=1"
        nonce="pintozhf"></script>
    @else
    <script async defer crossorigin="anonymous"
        src="https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v7.0&appId={{isset($business_settings->where('type', 'FACEBOOK_PIXEL_ID')->first()->value)?$business_settings->where('type', 'FACEBOOK_PIXEL_ID')->first()->value:''}}&autoLogAppEvents=1"
        nonce="pintozhf"></script>
    @endif
    <!-- Facebook Pixel Code -->
    <noscript>
        <img height="1" width="1" style="display:none"
            src="https://www.facebook.com/tr?id={{ isset($business_settings->where('type', 'FACEBOOK_PIXEL_ID')->first()->value)?$business_settings->where('type', 'FACEBOOK_PIXEL_ID')->first()->value:'' }}/&ev=PageView&noscript=1" />
    </noscript>
    <!-- End Facebook Pixel Code -->
    @endif

</head>

<body>
    <!-- Navbar-->
    @include('frontend.inc.nav')


    <!-- Side Menu -->
{{--    @include('frontend.inc.sidenav')--}}
    <!-- Carousel -->

    @yield('content')

    <br><br>
    <!-- Footer -->
    @include('frontend.inc.footer')

    @include('partials.modal')

    <div class="modal fade" id="addToCart" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-zoom product-modal" id="modal-size"
            role="document">
            <div class="modal-content position-relative">
                <div class="c-preloader">
                    <i class="fa fa-spin fa-spinner"></i>
                </div>
                <button type="button" class="close absolute-close-btn" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <div id="addToCart-modal-body">

                </div>
            </div>
        </div>
    </div>
    <!-- Modals -->
    <!-- Scripts-->
    <script type="text/javascript" src="{{ asset('assets/web/newface/js/jquery.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/web/newface/js/jquery-ui.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/web/newface/js/bootstrap.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/web/newface/js/owl.carousel.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/web/newface/js/wow.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/web/sliderengine/amazingslider.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/web/sliderengine/initslider-1.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/web/newface/js/main.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/web/newface/js/jquery.waypoints.min.js') }}"></script>

    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@9/dist/sweetalert2.min.js"></script>
    <script src="{{ asset('frontend/js/jquery.share.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/js/dropify.min.js" type="text/javascript">
    </script>

    <!--// sweetalert2-->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    <!--//lazy load image-->
    <script src="https://cdn.jsdelivr.net/npm/lozad/dist/lozad.min.js"></script>

    <script>
        const observer = lozad();
    observer.observe();
    </script>

    <script type="text/javascript">
        function showFrontendAlert(type, message) {
        if (type == 'danger') {
            type = 'error';
        }
        console.log(type, message);
        Swal.fire({
        //   position: 'top-end',
          icon: type,
          title: message,
          showConfirmButton: false,
          timer: 1500
        })
    }
    </script>

    @foreach (session('flash_notification', collect())->toArray() as $message)
    <script type="text/javascript">
        showFrontendAlert('{{ $message['level'] }}', '{{ $message['message'] }}');
    </script>
    @endforeach

    <script>
        $(document).ready(function () {
        $('.select2').select2();

        $(".size-list li,.colors-list li").click(function () {
            var elem = $(this);
            $(this).children().removeClass("active");
            $(this).addClass("active");
            console.log(elem.data('value'));
            $(this).parent().parent().prev().val(elem.data('value'));
            getVariantPrice();
        });





        $('.dropify').dropify();
        $('#share').share({
            networks: ['facebook', 'twitter', 'linkedin', 'instagram'],
            theme: 'square'
        });
        getVariantPrice();
    });

    function plus(elem) {
        elem.parentNode.querySelector('input[type=number]').stepUp();
        getVariantPrice();
    }

    function minus(elem) {
        elem.parentNode.querySelector('input[type=number]').stepDown();
        getVariantPrice();
    }

    $(document).ready(function () {
        if ($('.lang-change').length > 0) {
            $(".lang-change").children().children().each(function () {
                $(this).on('click', function (e) {
                    e.preventDefault();
                    var $this = $(this);
                    var locale = $this.data('flag');
                    $.post('{{ route('language.change',['country' => get_country()->code]) }}', {
                        _token: '{{ csrf_token() }}',
                        locale: locale
                    }, function (data) {
                        location.reload();
                    });

                });
            });
        }

        if ($('#currency-change').length > 0) {
            $('#currency-change .dropdown-item a').each(function () {
                $(this).on('click', function (e) {
                    e.preventDefault();
                    var $this = $(this);
                    var currency_code = $this.data('currency');
                    $.post('{{ route('currency.change',['country' => get_country()->code]) }}', {
                        _token: '{{ csrf_token() }}',
                        currency_code: currency_code
                    }, function (data) {
                        location.reload();
                    });

                });
            });
        }
    });

    $('#search').on('keyup', function () {
        search();
    });

    $('#search').on('focus', function () {
        search();
    });

    function search() {
        var search = $('#search').val();
        if (search.length > 0) {
            $('body').addClass("typed-search-box-shown");

            $('.typed-search-box').removeClass('d-none');
            $('.search-preloader').removeClass('d-none');
            $.post('{{ route('search.ajax',['country' => get_country()->code]) }}', {_token: '{{ @csrf_token() }}', search: search}, function (data) {
                if (data == '0') {
                    // $('.typed-search-box').addClass('d-none');
                    $('#search-content').html(null);
                    $('.typed-search-box .search-nothing').removeClass('d-none').html('Sorry, nothing found for <strong>"' + search + '"</strong>');
                    $('.search-preloader').addClass('d-none');

                } else {
                    $('.typed-search-box .search-nothing').addClass('d-none').html(null);
                    $('#search-content').html(data);
                    $('.search-preloader').addClass('d-none');
                }
            });
        } else {
            $('.typed-search-box').addClass('d-none');
            $('body').removeClass("typed-search-box-shown");
        }
    }

    function updateNavCart() {
        $.post('{{ route('cart.nav_cart',['country' => get_country()->code]) }}', {_token: '{{ csrf_token() }}'}, function (data) {
            $('#cart_items').html(data);
        });
    }

    function removeFromCart(key) {
        $.post('{{ route('cart.removeFromCart',['country' => get_country()->code]) }}', {_token: '{{ csrf_token() }}', key: key}, function (data) {
            updateNavCart();
            $('#cart-summary').html(data);
            if($('html').attr('lang') == 'ar'){
                showFrontendAlert('success', 'تم الحذف من العربه بنجاح');
            }else{
                showFrontendAlert('success', 'Item has been removed from cart');
            }
            $('#cart_items_sidenav').html(parseInt($('#cart_items_sidenav').html()) - 1);
        });
    }

    function addToCompare(id) {
        $.post('{{ route('compare.addToCompare',['country' => get_country()->code]) }}', {_token: '{{ csrf_token() }}', id: id}, function (data) {
            $('#compare').html(data);
                        if($('html').attr('lang') == 'ar'){
            showFrontendAlert('success', 'تمت اضافه المنتج لقائمه المقارنات');
            }else{
            showFrontendAlert('success', 'Item has been added to compare list');
            }
            $('#compare_items_sidenav').html(parseInt($('#compare_items_sidenav').html()) + 1);
        });
    }

    function addToWishList(id, element) {
        console.log('start');
        @if (Auth::check())
        console.log('if');
        $.post('{{ route('wishlists.store',['country' => get_country()->code]) }}', {_token: '{{ csrf_token() }}', id: id}, function (data) {
            if (data != 0) {
                console.log('done');
                element.addClass('active');
            if($('html').attr('lang') == 'ar'){
            showFrontendAlert('success', 'تمت اضافه المنتج لقائمه المفضله');
            }else{
                showFrontendAlert('success', 'Item has been added to wishlist');
            }
            } else {
                if($('html').attr('lang') == 'ar'){
                showFrontendAlert('warning', 'من فضلك سجل الدخول اولا');
                }else{
                    showFrontendAlert('warning', 'Please login first');
                }
            }
        });
        @else
             if($('html').attr('lang') == 'ar'){
                showFrontendAlert('warning', 'من فضلك سجل الدخول اولا');
                }else{
                    showFrontendAlert('warning', 'Please login first');
                }
        @endif
    }

    function showAddToCartModal(id) {
        if (!$('#modal-size').hasClass('modal-lg')) {
            $('#modal-size').addClass('modal-lg');
        }
        $('#addToCart-modal-body').html(null);
        $('#addToCart').modal();
        $('.c-preloader').show();
        $.post('{{ route('cart.showCartModal',['country' => get_country()->code]) }}', {_token: '{{ csrf_token() }}', id: id}, function (data) {
            console.log(data);
            $('.c-preloader').hide();
            $('#addToCart-modal-body').html(data);
            $('.xzoom, .xzoom-gallery').xzoom({
                Xoffset: 20,
                bg: true,
                tint: '#000',
                defaultScale: -1
            });
            getVariantPrice();
        });
    }

    $('#option-choice-form input').on('change', function () {
        getVariantPrice();
    });

    function getVariantPrice() {
        if ($('#option-choice-form input[name=quantity]').val() > 0) {
            $.ajax({
                type: "POST",
                url: '{{ route('products.variant_price',['country' => get_country()->code]) }}',
                data: $('#option-choice-form').serializeArray(),
                success: function (data) {
                    $('#option-choice-form #chosen_price_div').removeClass('d-none');
                    $('#option-choice-form #chosen_price_div #chosen_price').html(data.price);
                    $('#product_details #chosen_price').html(data.unit);
                    if($('html').attr('lang') == 'ar'){

                    if(data.discount != 0){
                        $('#discount').html('سوف توفر '+data.discount);
                    }
                    }else{
                        if(data.discount != 0){
                        $('#discount').html('you will save'+data.discount);
                    }
                    }
                    console.log(data);
                }
            });
        }
    };

            function getVariantOptions(option, id, choice) {

            if ($('#option-choice-form input[name=quantity]').val() > 0) {
                console.log(option, id);
            $.ajax({
                type: "POST",
                url: '{{ route('products.variant_option',['country' => get_country()->code]) }}',
                data: { "_token": "{{ csrf_token() }}","id":id, "option":option,'choice':choice },
                success: function (data) {
                    console.log(data);
                    choice = choice+1;
                    $('#choice_'+choice+'li').remove();
                    $('#choice_'+choice).html(data);
                    console.log($('#choice_'+choice).length);
                },
                 error: function (xhr, ajaxOptions, thrownError) {
        console.log(xhr);
        alert(ajaxOptions);
      }
            });
        }
    }

    function addToCart() {
        $('#addToCart').modal();
        $('.c-preloader').show();
        $.ajax({
            type: "POST",
            url: '{{ route('cart.addToCart',['country' => get_country()->code]) }}',
            data: $('#option-choice-form').serializeArray(),
            success: function (data) {
                $('#addToCart-modal-body').html(null);
                $('.c-preloader').hide();
                $('#modal-size').removeClass('modal-lg');
                $('#addToCart-modal-body').html(data);
                updateNavCart();
                $('#cart_items_sidenav').html(parseInt($('#cart_items_sidenav').html()) + 1);
            }
        });
    }

    function checkAddToCartValidity() {
        var names = {};
        $('#option-choice-form input:radio').each(function () { // find unique names
            names[$(this).attr('name')] = true;
        });
        var count = 0;
        $.each(names, function () { // then count them
            count++;
        });
        if($('input:radio:checked').length == count){
            return true;
        }
        return false;
    }

    function buyNow() {
        $('#addToCart').modal();
        $('.c-preloader').show();
        $.ajax({
            type: "POST",
            url: '{{ route('cart.addToCart',['country' => get_country()->code]) }}',
            data: $('#option-choice-form').serializeArray(),
            success: function (data) {
                $('#addToCart-modal-body').html(null);
                $('.c-preloader').hide();
                $('#modal-size').removeClass('modal-lg');
                $('#addToCart-modal-body').html(data);
                updateNavCart();
                $('#cart_items_sidenav').html(parseInt($('#cart_items_sidenav').html()) + 1);
            }
        });
    }

    function show_purchase_history_details(order_id) {
        $('#order-details-modal-body').html(null);

        if (!$('#modal-size').hasClass('modal-lg')) {
            $('#modal-size').addClass('modal-lg');
        }

        $.post('{{ route('purchase_history.details',['country' => get_country()->code]) }}', {
            _token: '{{ @csrf_token() }}',
            order_id: order_id
        }, function (data) {
            $('#order-details-modal-body').html(data);
            $('#order_details').modal();
            $('.c-preloader').hide();
        });
    }

    function show_order_details(order_id) {
        $('#order-details-modal-body').html(null);

        if (!$('#modal-size').hasClass('modal-lg')) {
            $('#modal-size').addClass('modal-lg');
        }

        $.post('{{ route('orders.details',['country' => get_country()->code]) }}', {_token: '{{ @csrf_token() }}', order_id: order_id}, function (data) {
            $('#order-details-modal-body').html(data);
            $('#order_details').modal();
            $('.c-preloader').hide();
        });
    }

    function cartQuantityInitialize() {
        $('.btn-number').click(function (e) {
            e.preventDefault();

            fieldName = $(this).attr('data-field');
            type = $(this).attr('data-type');
            var input = $("input[name='" + fieldName + "']");
            var currentVal = parseInt(input.val());

            if (!isNaN(currentVal)) {
                if (type == 'minus') {

                    if (currentVal > input.attr('min')) {
                        input.val(currentVal - 1).change();
                    }
                    if (parseInt(input.val()) == input.attr('min')) {
                        $(this).attr('disabled', true);
                    }

                } else if (type == 'plus') {

                    if (currentVal < input.attr('max')) {
                        input.val(currentVal + 1).change();
                    }
                    if (parseInt(input.val()) == input.attr('max')) {
                        $(this).attr('disabled', true);
                    }

                }
            } else {
                input.val(0);
            }
        });

        $('.input-number').focusin(function () {
            $(this).data('oldValue', $(this).val());
        });

        $('.input-number').change(function () {

            minValue = parseInt($(this).attr('min'));
            maxValue = parseInt($(this).attr('max'));
            valueCurrent = parseInt($(this).val());

            name = $(this).attr('name');
            if (valueCurrent >= minValue) {
                $(".btn-number[data-type='minus'][data-field='" + name + "']").removeAttr('disabled')
            } else {
                alert('Sorry, the minimum value was reached');
                $(this).val($(this).data('oldValue'));
            }
            if (valueCurrent <= maxValue) {
                $(".btn-number[data-type='plus'][data-field='" + name + "']").removeAttr('disabled')
            } else {
                alert('Sorry, the maximum value was reached');
                $(this).val($(this).data('oldValue'));
            }


        });
        $(".input-number").keydown(function (e) {
            // Allow: backspace, delete, tab, escape, enter and .
            if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 190]) !== -1 ||
                // Allow: Ctrl+A
                (e.keyCode == 65 && e.ctrlKey === true) ||
                // Allow: home, end, left, right
                (e.keyCode >= 35 && e.keyCode <= 39)) {
                // let it happen, don't do anything
                return;
            }
            // Ensure that it is a number and stop the keypress
            if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                e.preventDefault();
            }
        });
    }

    function imageInputInitialize() {
        $('.custom-input-file').each(function () {
            var $input = $(this),
                $label = $input.next('label'),
                labelVal = $label.html();

            $input.on('change', function (e) {
                var fileName = '';

                if (this.files && this.files.length > 1)
                    fileName = (this.getAttribute('data-multiple-caption') || '').replace('{count}', this.files.length);
                else if (e.target.value)
                    fileName = e.target.value.split('\\').pop();

                if (fileName)
                    $label.find('span').html(fileName);
                else
                    $label.html(labelVal);
            });

            // Firefox bug fix
            $input
                .on('focus', function () {
                    $input.addClass('has-focus');
                })
                .on('blur', function () {
                    $input.removeClass('has-focus');
                });
        });
    }

    </script>

    <script src="{{ asset('frontend/js/bootstrap-tagsinput.min.js') }}"></script>
    <script src="{{ asset('frontend/js/jodit.min.js') }}"></script>
    <script src="{{ asset('frontend/js/xzoom.min.js') }}"></script>
    <!-- The core Firebase JS SDK is always required and must be listed first -->
    <script src="https://www.gstatic.com/firebasejs/7.14.0/firebase-app.js"></script>

    <!-- TODO: Add SDKs for Firebase products that you want to use
     https://firebase.google.com/docs/web/setup#available-libraries -->
    <script src="https://www.gstatic.com/firebasejs/7.14.0/firebase-analytics.js"></script>

    <script>
        // Your web app's Firebase configuration
    var firebaseConfig = {
        apiKey: "AIzaSyBcq1pw3WEKv7Nca6DUQQEWQ4LHpK2vydw",
        authDomain: "newface-cfd25.firebaseapp.com",
        databaseURL: "https://newface-cfd25.firebaseio.com",
        projectId: "newface-cfd25",
        storageBucket: "newface-cfd25.appspot.com",
        messagingSenderId: "294843212946",
        appId: "1:294843212946:web:a27247770f0a792663324b",
        measurementId: "G-9G0MGJRJT5"
    };
    // Initialize Firebase
    firebase.initializeApp(firebaseConfig);
    firebase.analytics();
    </script>


    <!--Spartan Image JavaScript [ REQUIRED ]-->
    <script src="{{ asset('js/spartan-multi-image-picker-min.js') }}"></script>
    @yield('script')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jscroll/2.4.1/jquery.jscroll.min.js"
        integrity="sha512-51l8tSwY8XyM6zkByW3A0E36xeiwDpSQnvDfjBAzJAO9+O1RrEcOFYAs3yIF3EDRS/QWPqMzrl6t7ZKEJgkCgw=="
        crossorigin="anonymous"></script>

    <script type="text/javascript">
        $('ul.pagination').hide();
    $(function() {
        $('.infinite-scroll').jscroll({
            autoTrigger: true,
            loadingHtml: '<img class="center-block" src="{!! asset('assets/web/newface/images/loading.gif') !!}" alt="Loading..." />',
            padding: 0,
            nextSelector: '.pagination li.active + li a',
            contentSelector: 'div.infinite-scroll',
            callback: function() {
                $('ul.pagination').remove();
            }
        });
    });
    </script>


    @section('script')
    <script src="https://cdn.ckeditor.com/4.13.0/standard/ckeditor.js"></script>
    <script>
        CKEDITOR.replace( 'editor1' );
    </script>
    @endsection
</body>
</html>
