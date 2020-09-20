@extends('frontend.layouts.app')
@section('title' , __('general.add_product') )
@section('meta')
<meta name="keywords" content="{{ $seo_setting->keyword }}">
<meta name="description" content="{{ $seo_setting->description}}">
<meta property="og:title" content="{{__('general.add_product')}}" />
<meta property="og:description" content="{{ $seo_setting->description}}" />
@endsection
@section('content')

    <div class="container-fluid">
        <!-- Content -->
        <div class="page-wrap profile-page">
            <!-- Menu -->
        @include('frontend.inc.seller_side_nav')
        <!--  Content -->
            <div class="main-content">
@include('partials.message')

                <!-- Order -->
                <div class="profile-title">
                    {{__('general.add_new_product')}}
                </div>
                <!-- User Info -->
                <form class="form-style" action="{{route('products.store',['country' => get_country()->code])}}" method="POST"
                      enctype="multipart/form-data" id="choice_form">
                @csrf
                    <input type="hidden" name="added_by" value="seller">
                    <!-- General -->
                    <div class="section-wrapper">
                        <div class="section-header">
                            {{__('general.general')}}
                        </div>
                        <div class="section-body">
                            <div class="row form-group">
                                <div class="col-xs-12 col-sm-6 col-lg-4">
                                    <label>{{__('forms.name_ar')}}
                                                                        <span class="text-muted font-size-12">*</span>
</label>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-lg-8">
                                    <input type="text" class="form-control @error('name_ar') is-invalid @enderror " name="name_ar"
                                           placeholder="{{__('forms.name_ar')}}" value="{{ old('name_ar') }}" required>
                            @error('name_ar')
                              <span class="invalid-feedback" role="alert">
                                  <strong>{{ $message }}</strong>
                              </span>
                            @enderror
                                </div>
                            </div>

                            <div class="row form-group">
                                <div class="col-xs-12 col-sm-6 col-lg-4">
                                    <label>{{__('forms.name_en')}}
                                                                        <span class="text-muted font-size-12">*</span>
</label>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-lg-8">
                                    <input type="text" class="form-control @error('name_en') is-invalid @enderror" name="name_en"
                                           placeholder="{{__('forms.name_en')}}" value="{{ old('name_en') }}" required>
                                           @error('name_en')
                              <span class="invalid-feedback" role="alert">
                                  <strong>{{ $message }}</strong>
                              </span>
                            @enderror
                                </div>
                            </div>

                            <div class="row form-group">
                                <div class="col-xs-12 col-sm-6 col-lg-4">
                                    <label>{{__('general.category')}}
                                                                        <span class="text-muted font-size-12">*</span>
</label>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-lg-8">
                                    <select id="categories" name="category_id" class="form-control @error('category_id') is-invalid @enderror" required>
                                        <option value="" selected disabled>{{__('general.category')}}</option>
                                        @foreach(\App\Category::all() as $category)
                                            <option
                                                value="{{ $category->id }}">{{ app()->isLocale('ar') ? $category->name_ar : $category->name_en }} 	&nbsp; ( {{__('general.commission').': '. $category->vendor_commission}} % )</option>
                                        @endforeach
                                    </select>
                                    @error('category_id')
                              <span class="invalid-feedback" role="alert">
                                  <strong>{{ $message }}</strong>
                              </span>
                            @enderror
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-xs-12 col-sm-6 col-lg-4">
                                    <label>{{__('general.sub_category')}}
                                                                        <span class="text-muted font-size-12">*</span>
</label>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-lg-8">
                                    <select id="subcategories" name="subcategory_id" class="form-control @error('subcategory_id') is-invalid @enderror" required>
                                        <!--<option value="" selected disabled>{{__('general.sub_category')}}</option>-->
                                    </select>
                                    @error('subcategory_id')
                              <span class="invalid-feedback" role="alert">
                                  <strong>{{ $message }}</strong>
                              </span>
                            @enderror
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-xs-12 col-sm-6 col-lg-4">
                                    <label>{{__('general.sub_sub_category')}}
                                                                        <span class="text-muted font-size-12">*</span>
</label>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-lg-8">
                                    <select id="subsubcategories" name="subsubcategory_id" class="form-control @error('subsubcategory_id') is-invalid @enderror" required>
                                        <!--<option value="" selected disabled>{{__('general.sub_sub_category')}}</option>-->
                                    </select>
                                    @error('subsubcategory_id')
                              <span class="invalid-feedback" role="alert">
                                  <strong>{{ $message }}</strong>
                              </span>
                            @enderror
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-xs-12 col-sm-6 col-lg-4">
                                    <label>{{__('general.brand')}}
                                                                        <span class="text-muted font-size-12">*</span>
</label>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-lg-8">
                                    <select id="brands" name="brand_id" class="form-control @error('brand_id') is-invalid @enderror" required>
                                        <!--<option value="" selected disabled>{{__('general.brand')}}</option>-->
                                    </select>
                                    @error('brand_id')
                              <span class="invalid-feedback" role="alert">
                                  <strong>{{ $message }}</strong>
                              </span>
                            @enderror
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-xs-12 col-sm-6 col-lg-4">
                                    <label>{{__('general.product_unit')}}
                                                                        <span class="text-muted font-size-12">*</span>
</label>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-lg-8">
                                    <input type="text" class="form-control @error('unit') is-invalid @enderror" name="unit" placeholder="{{__('general.product_unit')}}" value="{{ old('unit') }}" required>
                                @error('unit')
                              <span class="invalid-feedback" role="alert">
                                  <strong>{{ $message }}</strong>
                              </span>
                            @enderror
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-xs-12 col-sm-6 col-lg-4">
                                    <label>{{__('general.product_tag')}}</label>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-lg-8">
                                    <input type="text" class="form-control @error('tags') is-invalid @enderror"   name="tags[]" data-role="tagsinput" placeholder="Type & hit enter">
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-xs-12 col-sm-6 col-lg-4">
                                    <label>{{__('general.main_quantity')}}
                                                                        <span class="text-muted font-size-12">* <br>(When you have no choice)</span>
</label>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-lg-8">
                                   <input type="number" class="form-control @error('main_quantity') is-invalid @enderror" value="{{ old('main_quantity') }}"  name="main_quantity" id="main_quantity"
                                               value="0" placeholder="Main Quantity">
                                                @error('main_quantity')
                                           <span class="invalid-feedback" role="alert">
                                               <strong>{{ $message }}</strong>
                                           </span>
                                         @enderror
                                </div>
                                
                            </div>
                        </div>
                    </div>
                    <!-- Images -->
                    <div class="section-wrapper">
                        <div class="section-header">
                            {{__('general.images')}}
                        </div>
                        <div class="section-body">
                            <div class="row form-group">
                                <div class="col-xs-12 col-sm-6 col-lg-4">
                                    <label>{{__('general.main_image')}}
                                    <span class="text-muted font-size-12">*</span>
                                    <br><span class="text-muted font-size-12">Ext Only: (jpg|jpeg|png|tiff|webp|gif)</span>
                                    <br><span class="text-muted font-size-12">Best Size: (450*450)</span>
                                    </label>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-lg-8">
                                    <div class="file-upload">
                                        <div class="file-select">
                                            <input type="file" name="photos[]" id="photos_image_file" onchange="update_file('photos_image_file','photos_msg')" accept="image/*" class="chooseFile @error('photos') is-invalid @enderror" required >
                                            <div class="file-select-name noFile" id="photos_msg">{{__('general.no_chosen')}}</div>
                                            <div class="file-select-button fileName">
                                                <i class="fa fa-photo"></i>
                                                Upload
                                            </div>
                                        </div>
                                    </div>
                                    @error('photos')
                              <span class="invalid-feedback" role="alert">
                                  <strong>{{ $message }}</strong>
                              </span>
                            @enderror
                                </div>
                                
                            <div class="col-xs-2"></div>
                            <div id="product-images" class="col-xs-10">
                            </div>
                            
                            </div>
                            <div class="form-group text-right">
                                <button type="button" class="btn btn-accept" onclick="add_more_slider_image()">
                                    {{__('general.add_more')}} +
                                </button>
                            </div>
                            <div class="row form-group">
                                <div class="col-xs-12 col-sm-6 col-lg-4">
                                    <label>{{__('general.main_thumb_image')}} 
                                    <span class="text-muted font-size-12">*</span>
                                    <br><span class="text-muted font-size-12">Ext Only: (jpg|jpeg|png|tiff|webp|gif)</span>
                                    <br><span class="text-muted font-size-12">Best Size: (200*230)</span>
                                    </label>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-lg-8">
                                    <div class="file-upload">
                                        <div class="file-select">
                                            <input type="file" name="thumbnail_img" id="thumbnail_image_file" onchange="update_file('thumbnail_image_file','thumbnail_msg')" accept="image/*" class="chooseFile @error('thumbnail_img') is-invalid @enderror" required>
                                            <div class="file-select-name noFile" id="thumbnail_msg">{{__('general.no_chosen')}}</div>
                                            <div class="file-select-button fileName">
                                                <i class="fa fa-photo"></i>
                                                Upload
                                            </div>
                                        </div>
                                    </div>
                                    @error('thumbnail_img')
                              <span class="invalid-feedback" role="alert">
                                  <strong>{{ $message }}</strong>
                              </span>
                            @enderror
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-xs-12 col-sm-6 col-lg-4">
                                    <label>{{__('general.featured_image')}} 
                                                                        <span class="text-muted font-size-12">*</span>
                                    <br><span class="text-muted font-size-12">Ext Only: (jpg|jpeg|png|tiff|webp|gif)</span>
                                    <br><span class="text-muted font-size-12">Best Size: (200*230)</span>
                                    </label>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-lg-8">
                                    <div class="file-upload">
                                        <div class="file-select">
                                            <input type="file" name="featured_img" id="featured_image_file" onchange="update_file('featured_image_file','featured_msg')" accept="image/*" class="chooseFile @error('featured_img') is-invalid @enderror" required>
                                            <div class="file-select-name noFile" id="featured_msg">{{__('general.no_chosen')}}</div>
                                            <div class="file-select-button fileName">
                                                <i class="fa fa-photo"></i>
                                                Upload
                                            </div>
                                        </div>
                                    </div>
                                    @error('featured_img')
                              <span class="invalid-feedback" role="alert">
                                  <strong>{{ $message }}</strong>
                              </span>
                            @enderror
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-xs-12 col-sm-6 col-lg-4">
                                    <label>{{__('general.flash_image')}} 
                                                                        <span class="text-muted font-size-12">*</span>
                                    <br><span class="text-muted font-size-12">Ext Only: (jpg|jpeg|png|tiff|webp|gif)</span>
                                    <br><span class="text-muted font-size-12">Best Size: (200*230)</span>
                                    </label>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-lg-8">
                                    <div class="file-upload">
                                        <div class="file-select">
                                            <input type="file" name="flash_deal_img" id="flash_image_file" onchange="update_file('flash_image_file','flash_msg')" accept="image/*" class="chooseFile @error('flash_deal_img') is-invalid @enderror" required>
                                            <div class="file-select-name noFile" id="flash_msg">{{__('general.no_chosen')}}</div>
                                            <div class="file-select-button fileName">
                                                <i class="fa fa-photo"></i>
                                                Upload
                                            </div>
                                        </div>
                                    </div>
                                    @error('flash_deal_img')
                              <span class="invalid-feedback" role="alert">
                                  <strong>{{ $message }}</strong>
                              </span>
                            @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Videos -->
                    <div class="section-wrapper">
                        <div class="section-header">
                            {{__('general.product_description')}}
                        </div>
                        <div class="section-body">
                            <div class="row form-group">
                                <div class="col-xs-12 col-sm-6 col-lg-4">
                                    <label>{{__('general.meta_title')}}
                                    </label>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-lg-8">
                                    <input type="text" class="form-control @error('meta_title') is-invalid @enderror" value="{{ old('meta_title') }}" name="meta_title" placeholder="{{__('general.meta_title')}}" >
                                @error('meta_title')
                              <span class="invalid-feedback" role="alert">
                                  <strong>{{ $message }}</strong>
                              </span>
                            @enderror
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-xs-12 col-sm-6 col-lg-4">
                                    <label>{{__('forms.description_ar')}}
                                                                                                            <span class="text-muted font-size-12">*</span>
</label>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-lg-8">
                                    <textarea name="description_ar" rows="6" class="form-control @error('description_ar')  is-invalid @enderror"  required>{{ old('description_ar') }}</textarea>
                                @error('description_ar')
                              <span class="invalid-feedback" role="alert">
                                  <strong>{{ $message }}</strong>
                              </span>
                            @enderror
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-xs-12 col-sm-6 col-lg-4">
                                    <label>{{__('forms.description_en')}}
                                                                                                            <span class="text-muted font-size-12">*</span>
</label>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-lg-8">
                                    <textarea name="description_en" rows="6" class="form-control @error('description_en') is-invalid @enderror"required>{{ old('description_en') }}</textarea>
                                @error('description_en')
                              <span class="invalid-feedback" role="alert">
                                  <strong>{{ $message }}</strong>
                              </span>
                            @enderror
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-xs-12 col-sm-6 col-lg-4">
                                    <label>{{__('general.meta_image')}}
                                                                        <span class="text-muted font-size-12">*</span>
                                    <br><span class="text-muted font-size-12">Ext Only: (jpg|jpeg|png|tiff|webp|gif)</span>
                                    <br><span class="text-muted font-size-12">Best Size: (200*230)</span></label>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-lg-8">
                                    <div class="file-upload">
                                        <div class="file-select">
                                            <input type="file" name="meta_img" id="meta_image_file" onchange="update_file('meta_image_file','meta_msg')" accept="image/*" class="chooseFile">
                                            <div class="file-select-name noFile" id="meta_msg">{{__('general.no_chosen')}}</div>
                                            <div class="file-select-button fileName" id="fileName">
                                                <i class="fa fa-photo"></i>
                                                Upload
                                            </div>
                                        </div>
                                    </div>
                                    @error('meta_img')
                              <span class="invalid-feedback" role="alert">
                                  <strong>{{ $message }}</strong>
                              </span>
                            @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Customer Choice -->
                    <div class="section-wrapper">
                        <div class="section-header">
                            {{__('general.customer_choice')}}
                        </div>
                        <div class="section-body">

                                <div id="" class="row form-group">
                                <div class="col-sm-12">
                                   
                                       <div class="customer_choice_options" id="customer_choice_options">
                                        </div>
                               
                                </div>
                            </div>
                               
                            
                           <div class="form-group">
                                    <div class="col-lg-3">
                                        <button type="button" class="btn btn-info"
                                                onclick="add_more_customer_choice_option()">{{ __('general.add_more_choice') }}</button>
                                    </div>
                                </div>
                        </div>
                    </div>
                    <!-- Price -->
                    <div class="section-wrapper">
                        <div class="section-header">
                             {{__('forms.price')}}
                        </div>
                        <input type="hidden" name="countries[]" value="{{ isset(auth()->user()->Country) ? auth()->user()->Country->id : \App\Country::first()->id }}">
                        <div class="section-body">
                            <div class="row form-group">
                                <div class="col-xs-12 col-sm-6 col-lg-4">
                                    <label>{{__('general.unit_price')}}
                                                                                                            <span class="text-muted font-size-12">*</span>
</label>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-lg-8">
                                    <input type="text"  name="unit_price[]" class="form-control @error('unit_price') is-invalid @enderror"  value="{{ old('unit_price[0]') }}" onchange="update_sku()" placeholder="0" required>
                                @error('unit_price')
                              <span class="invalid-feedback" role="alert">
                                  <strong>{{ $message }}</strong>
                              </span>
                            @enderror
                                </div>
                            </div>
                            <!--<div class="row form-group">-->
                            <!--    <div class="col-xs-12 col-sm-6 col-lg-4">-->
                            <!--        <label>{{__('general.purchase_price')}}</label>-->
                            <!--    </div>-->
                            <!--    <div class="col-xs-12 col-sm-6 col-lg-8">-->
                            <!--        <input type="number" name="purchase_price[]" class="form-control @error('purchase_price') is-invalid @enderror" value="{{ old('purchase_price[0]') }}"  onchange="update_sku()" placeholder="0">-->
                            <!--    </div>-->
                            <!--</div>-->
                            <div class="row form-group">
                                <div class="col-xs-12 col-sm-6 col-lg-4">
                                    <label>{{__('general.tax')}}</label>
                                </div>
                                <div class="col-xs-8 col-sm-4 col-lg-6">
                                    <input type="number" name="tax[]" class="form-control @error('tax') is-invalid @enderror" onchange="update_sku()" value="0" placeholder="0">
                                </div>
                                <div class="col-xs-4 col-sm-2 col-lg-2">
                                    <select class="form-control" name="tax_type[] @error('tax_type') is-invalid @enderror" onchange="update_sku()" required>
                                        <option value="amount">$</option>
                                        <option value="percent">%</option>
                                    </select>
                                    @error('tax_type')
                              <span class="invalid-feedback" role="alert">
                                  <strong>{{ $message }}</strong>
                              </span>
                            @enderror
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-xs-12 col-sm-6 col-lg-4">
                                    <label>{{__('general.discount')}}
                                    </label>
                                </div>
                                <div class="col-xs-8 col-sm-4 col-lg-6">
                                    <input type="number" name="discount[]" class="form-control @error('discount') is-invalid @enderror" value="0" onchange="update_sku()" placeholder="0">

                                </div>
                                <div class="col-xs-4 col-sm-2 col-lg-2">
                                    <select class="form-control @error('discount_type') is-invalid @enderror" name="discount_type[] " onchange="update_sku()" required>
                                        <option value="amount">$</option>
                                        <option value="percent">%</option>
                                    </select>
                                    @error('discount_type')
                              <span class="invalid-feedback" role="alert">
                                  <strong>{{ $message }}</strong>
                              </span>
                            @enderror
                                </div>
                            </div>
                            <div id="sku_combination">
                            </div>
                        </div>

                    </div>
                    <div class="text-right">
                        <button type="submit" class="btn btn-main">{{__('general.save')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div style="position: relative;bottom: -40px;">
        @include('frontend.seller.footer_tabs')
    </div>
@endsection

@section('script')

    <script type="text/javascript">
    
    function update_file(upload_id,msg_id){
                var filename = $('#'+upload_id).val();
                filename = filename.substr(12);
                console.log(filename);
                $('#'+msg_id).html(filename);
    }
        $("#categories").change(function () {
            var options = '<option value="">{{__('general.sub_category')}}</option>';
            var x;
            $.post('{{ route('subcategories.get_subcategories_by_category',['country' => get_country()->code]) }}', {
                _token: '{{ csrf_token() }}',
                category_id: $(this).val()
            }, function (response) {
                for (var i = 0; i < response.length; i++) {
                    var id = response[i].id;
                    var name = response[i].name;
                    options += '<option value="' + id + '">' + name + '</option>'
                }
                $("#subcategories").html(options);
            });
        });

        $("#subcategories").change(function () {
            var options = '<option value="">{{__('general.sub_sub_categories')}}</option>';
            var x;
            $.post('{{ route('subsubcategories.get_subsubcategories_by_subcategory',['country' => get_country()->code]) }}', {
                _token: '{{ csrf_token() }}',
                subcategory_id: $(this).val()
            }, function (data) {
                for (var i = 0; i < data.length; i++) {
                    var id = data[i].id;
                    var name = data[i].name;
                    options += '<option value="' + id + '">' + name + '</option>'
                }
                $("#subsubcategories").html(options);
            });
        });

        $("#subsubcategories").change(function () {
            var options = '<option value="">{{__('general.all_brands')}}</option>';
            var x;
            $.post('{{ route('subsubcategories.get_brands_by_subsubcategory',['country' => get_country()->code]) }}', {
                _token: '{{ csrf_token() }}',
                subsubcategory_id: $(this).val()
            }, function (data) {
                for (var i = 0; i < data.length; i++) {
                    var id = data[i].id;
                    var name = data[i].name;
                    options += '<option value="' + id + '">' + name + '</option>'
                }
                $("#brands").html(options);
            });
        })

        var i = 0;
        var ii = 0;

        function add_more_customer_choice_option() {
            $('#customer_choice_options').append('<div class="form-group"><div class="col-lg-3"><input type="hidden" name="choice_no[]" value="' + i + '"><input type="text" class="form-control" name="choice_ar[]" value="" placeholder="Choice Title Arabic" required></div><div class="col-lg-3"><input type="text" class="form-control" name="choice[]" value="" placeholder="Choice Title English" required></div><div class="col-lg-3"><button type="button" class="btn btn-info"onclick="add_more_customer_option('+i+')" id="add_option">{{ __('general.add_more_option') }}</button></div><div class="col-lg-2"><button onclick="delete_row(this)" class="btn btn-danger btn-icon"><i class="fa fa-times"></i></button></div> <br> <div style="margin: 30px" class="row" id="customer_options'+i+'"></div> </div>');
            i++;
        }
        function add_more_customer_option(el) {
            $('#customer_options'+el).append('<div class="row form-group"><div class="col-lg-2"><input type="text" class="form-control" name="choice_options_ar' + el + '[]" placeholder="choice Arabic values" required></div><div class="col-lg-2"><input type="text" class="form-control" name="choice_options_' + el + '[]" id="choice_options_' + ii +'" onchange="update_sku()" placeholder="choice English values" required></div><div class="col-sm-3"><div id="choice_photos'+ii+'" data-id_1="'+el+'" data-id_2="'+ii+'"></div> </div>'
            +'<div class="col-lg-2"><button type="button" class="btn btn-primary" onclick="add_image('+el+','+ii+')">{{__('general.add_image')}}</button></div><div class="col-lg-2"><button onclick="delete_row(this)" class="btn btn-danger btn-icon"><i class="fa fa-times"></i></button></div></div>');
                ii++;
        }
        

        
        function add_image(el,el1){
            var name = 'choice_photos'+$("#choice_photos"+el1).data('id_1')+'_'+$("#choice_options_" + el1).val();
            console.log(name);
            if($("#choice_photos"+el1+" input[type='file']").length){
                console.log($("input[name='"+name+"']").length, name);
            }else{
                console.log(name);
            var shopSliderAdd =  '<div class="col-md-12">\n' +
                '<input type="file" name="'+name+'"  class="dropify" data-multiple-caption="{count} files selected" accept="image/*" />\n' +
                '</div>';
            $("#choice_photos"+el1).append(shopSliderAdd);

            $('.dropify').dropify();
            }

            }

        $('input[name="colors_active"]').on('change', function () {
            if (!$('input[name="colors_active"]').is(':checked')) {
                $('#colors').prop('disabled', true);
            } else {
                $('#colors').prop('disabled', false);
            }
            update_sku();
        });

        $('#colors').on('change', function () {
            update_sku();
        });

        $('input[name="unit_price"]').on('keyup', function () {
            update_sku();
        });

        $('input[name="name"]').on('keyup', function () {
            update_sku();
        });

        function delete_row(em) {
            $(em).closest('.form-group').remove();
            update_sku();
        }

        function update_sku() {
            $.ajax({
                type: "POST",
                url: '{{ route('products.sku_combination',['country' => get_country()->code]) }}',
                data: $('#choice_form').serialize(),
                success: function (data) {
                    $('#sku_combination').html(data);
                }
            });
        }
        
        var photo_id = 1;
            function add_more_slider_image() {
            var photoAdd = '<div class="row"> <div class="col-xs-12 col-sm-6 col-lg-4" style="margin: 10px 0px;">';
            // photoAdd += '<button type="button" onclick="delete_this_row(this)" class="btn btn-danger close-btn remove-files"><i class="fa fa-times"></i></button>';
            photoAdd += '<button type="button" onclick="delete_this_row(this)" class="btn btn-link btn-icon text-danger"><i class="fa fa-trash-o"></i></button>';
            photoAdd += '</div>';
            photoAdd += '<div class="col-xs-12 col-sm-6 col-lg-8" style="margin: 10px 0px;">';
            photoAdd += '<div class="file-upload">';
            photoAdd += '<div class="file-select">';
            photoAdd += '<input type="file" name="photos[]" id="photos_image_file'+photo_id+'" onchange="update_file(\'photos_image_file'+photo_id+'\',\'photos_msg'+photo_id+'\')" accept="image/*" class="chooseFile">';
            photoAdd += '<div class="file-select-name noFile" id="photos_msg'+photo_id+'">{{__("general.no_chosen")}}</div>';
            photoAdd += '<div class="file-select-button fileName"> <i class="fa fa-photo"></i> Upload </div>';
            photoAdd += '</div>';
            photoAdd += '</div>';
            photoAdd += '</div>';
            photoAdd += '</div>';
            $('#product-images').append(photoAdd);

            photo_id++;
            imageInputInitialize();
        }

        

        function delete_this_row(em) {
            $(em).closest('.row').remove();
        }

    </script>
@endsection
