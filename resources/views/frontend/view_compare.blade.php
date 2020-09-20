@extends('frontend.layouts.app')
@section('title' , __('general.comparison'))
@section('meta')
<meta name="keywords" content="{{ $seo_setting->keyword }}">
<meta name="description" content="{{ $seo_setting->description}}">
<meta property="og:title" content="{{__('general.comparison')}}" />
<meta property="og:description" content="{{ $seo_setting->description}}" />
@endsection
@section('content')

    <div class="breadcrumb-area">
        <div class="container">
            <div class="row">
                <div class="col">
                    <ul class="breadcrumb">

                    </ul>
                </div>
                <div class="col">
                    <div class="text-right">
                        <a href="{{ route('compare.reset') }}" style="text-decoration: none;" class="btn btn-link btn-base-5 btn-sm">{{__('general.reset_compare')}}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <section class="gry-bg py-4">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="card mb-4">
                        <div class="card-header text-center p-2">
                            <div class="heading-5">{{__('general.comparison')}}</div>
                        </div>
                        @if(Session::has('compare'))
                            @if(count(Session::get('compare')) > 0)
                                <div class="card-body">
                                    <table class="table table-bordered compare-table mb-0">
                                        <thead>
                                            <tr>
                                                <th scope="col" style="width:16%" class="font-weight-bold">
                                                    {{__('forms.name')}}
                                                </th>
                                                @foreach (Session::get('compare') as $key => $item)
                                                    <th scope="col" style="width:28%" class="font-weight-bold">
                                                        <a href="{{ route('product', \App\Product::find($item)->slug) }}">{{ app()->isLocale('ar') ? \App\Product::find($item)->name_ar : \App\Product::find($item)->name_en }}</a>
                                                    </th>
                                                @endforeach
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <th scope="row">{{__('general.image')}}</th>
                                                @foreach (Session::get('compare') as $key => $item)
                                                    <td>
                                                        <img src="{{ asset(\App\Product::find($item)->thumbnail_img) }}" alt="Product Image" class="img-fluid py-4" width="100">
                                                    </td>
                                                @endforeach
                                            </tr>
                                            <tr>
                                                <th scope="row">{{__('forms.price')}}</th>
                                                @foreach (Session::get('compare') as $key => $item)
                                                    <td>{{ single_price(\App\Product::find($item)->unit_price) }}</td>
                                                @endforeach
                                            </tr>
                                            <tr>
                                                <th scope="row">{{__('general.brand')}}</th>
                                                @foreach (Session::get('compare') as $key => $item)
                                                    <td>{{ \App\Product::find($item)->brand->name }}</td>
                                                @endforeach
                                            </tr>
                                            <tr>
                                                <th scope="row">{{__('general.sub_category')}}</th>
                                                @foreach (Session::get('compare') as $key => $item)
                                                    <td>{{ \App\Product::find($item)->subsubcategory->name }}</td>
                                                @endforeach
                                            </tr>
                                            <tr>
                                                <th scope="row">{{__('general.description')}}</th>
                                                @foreach (Session::get('compare') as $key => $item)
                                                    <td><?php echo \App\Product::find($item)->description; ?></td>
                                                @endforeach
                                            </tr>
                                            <tr>
                                                <th scope="row"></th>
                                                @foreach (Session::get('compare') as $key => $item)
                                                    <td class="text-center py-4">
                                                        <button type="button" class="btn btn-main" onclick="showAddToCartModal({{ $item }})">
                                                            <i class="icon ion-android-cart"></i>{{__('general.add_to_cart')}}
                                                        </button>
                                                    </td>
                                                @endforeach
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            @endif
                        @else
                            <div class="card-body">
                                <p>{{__('general.compare_empty')}}</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="modal fade" id="addToCart" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-zoom product-modal" id="modal-size" role="document">
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

@endsection

@section('script')
    <script type="text/javascript">
    function showAddToCartModal(id){
        if(!$('#modal-size').hasClass('modal-lg')){
            $('#modal-size').addClass('modal-lg');
        }
        $('#addToCart').modal();
        $.post('{{ route('cart.showCartModal') }}', {_token:'{{ csrf_token() }}', id:id}, function(data){
            $('.c-preloader').hide();
            $('#addToCart-modal-body').html(data);
            $('#slideshow').desoSlide({
                thumbs: $('#slideshow_thumbs .swiper-slide > a'),
                thumbEvent: 'click',
                first: 0,
                effect: 'none',
                overlay: 'none',
                controls: {
                    show: false,
                    keys: false
                },
            });
        });
    }

    function addToCart(){
        $('.c-preloader').show();
        $.ajax({
           type:"POST",
           url:'{{ route('cart.addToCart') }}',
           data:$('#option-choice-form').serialize(),
           success: function(data){
               $('.c-preloader').hide();
               $('#modal-size').removeClass('modal-lg');
               $('#addToCart-modal-body').html(data);
               updateNavCart();
           }
       });
    }
    </script>
@endsection
