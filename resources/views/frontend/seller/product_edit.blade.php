@extends('frontend.layouts.app')
@section('title' , __('general.edit_product') )
@section('meta')
<meta name="keywords" content="{{ $seo_setting->keyword }}">
<meta name="description" content="{{ $seo_setting->description}}">
<meta property="og:title" content="{{__('general.edit_product')}}" />
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
                <form class="form-style" action="{{route('products.update', ['country' => get_country()->code,'id'=>$product->id])}}" method="POST"
                      enctype="multipart/form-data" id="choice_form">
                    <input name="_method" type="hidden" value="POST">
                    <input type="hidden" name="id" value="{{ $product->id }}">
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
                                    <span class="text-muted font-size-12">*</span></label>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-lg-8">
                                    <input type="text" class="form-control @error('name_ar') is-invalid @enderror" name="name_ar"
                                           value="{{ $product->name_ar }}"
                                           placeholder="{{__('forms.name_ar')}}">
                                           @error('name_ar')
                                           <span class="invalid-feedback" role="alert">
                                               <strong>{{ $message }}</strong>
                                           </span>
                                         @enderror
                                </div>
                            </div>

                            <div class="row form-group">
                                <div class="col-xs-12 col-sm-6 col-lg-4">
                                    <label>{{__('forms.name_en')}}<span class="text-muted font-size-12">*</span></label>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-lg-8">
                                    <input type="text" class="form-control @error('name_en') is-invalid @enderror" name="name_en"
                                           value="{{ $product->name_en }}"
                                           placeholder="{{__('forms.name_en')}}">
                                           @error('name_en')
                                           <span class="invalid-feedback" role="alert">
                                               <strong>{{ $message }}</strong>
                                           </span>
                                         @enderror
                                </div>
                            </div>

                            <div class="row form-group">
                                <div class="col-xs-12 col-sm-6 col-lg-4">
                                    <label>{{__('general.category')}}<span class="text-muted font-size-12">*</span></label>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-lg-8">
                                    <select id="categories" name="category_id" class="form-control @error('category_id') is-invalid @enderror">
                                        <option value="" selected disabled>{{__('general.category')}}</option>
                                        @foreach(\App\Category::all() as $category)
                                            <option
                                                value="{{ $category->id }}"
                                                @if($category->id == $product->category_id) selected @endif>{{ app()->isLocale('ar') ? $category->name_ar : $category->name_en }} 	&nbsp; ( {{__('general.commission').': '. $category->vendor_commission}} % )</option>
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
                                    <label>{{__('general.sub_category')}}<span class="text-muted font-size-12">*</span></label>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-lg-8">
                                    <select id="subcategories" name="subcategory_id" class="form-control @error('subcategory_id') is-invalid @enderror">
                                        <option value="" selected disabled>{{__('general.sub_category')}}</option>
                                        @foreach(\App\SubCategory::all() as $category)
                                            <option
                                                value="{{ $category->id }}"
                                                @if($category->id == $product->subcategory_id) selected @endif>{{ app()->isLocale('ar') ? $category->name_ar : $category->name_en }}</option>
                                        @endforeach
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
                                    <label>{{__('general.sub_sub_category')}}<span class="text-muted font-size-12">*</span></label>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-lg-8">
                                    <select id="subsubcategories" name="subsubcategory_id" class="form-control @error('subsubcategory_id') is-invalid @enderror">
                                        <option value="" selected disabled>{{__('general.sub_sub_category')}}</option>
                                        @foreach(\App\SubSubCategory::all() as $category)
                                            <option
                                                value="{{ $category->id }}"
                                                @if($category->id == $product->subsubcategory_id) selected @endif>{{ app()->isLocale('ar') ? $category->name_ar : $category->name_en }}</option>
                                        @endforeach
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
                                    <label>{{__('general.brand')}}<span class="text-muted font-size-12">*</span></label>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-lg-8">
                                    <select id="brands" name="brand_id" class="form-control @error('brand_id') is-invalid @enderror">
                                        <option value="" selected disabled>{{__('general.brand')}}</option>
                                        @foreach(\App\Brand::all() as $brand)
                                            <option
                                                value="{{ $brand->id }}"
                                                @if($brand->id == $product->brand_id) selected @endif>{{ $brand->name }}</option>
                                        @endforeach
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
                                    <label>{{__('general.product_unit')}}<span class="text-muted font-size-12">*</span></label>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-lg-8">
                                    <input type="text" class="form-control @error('unit') is-invalid @enderror" name="unit" value="{{ $product->unit }}"
                                           placeholder="{{__('general.product_unit')}}">
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
                                    <input type="text" class="form-control @error('tags') is-invalid @enderror" name="tags[]" value="{{ $product->tags }}"
                                           data-role="tagsinput" placeholder="Type & hit enter">
                                           @error('tags')
                                           <span class="invalid-feedback" role="alert">
                                               <strong>{{ $message }}</strong>
                                           </span>
                                         @enderror
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-xs-12 col-sm-6 col-lg-4">
                                    <label>{{__('general.main_quantity')}}
                                                                                                            <span class="text-muted font-size-12">* <br>(When you have no choice)</span>
</label>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-lg-8">
                                   <input type="number" class="form-control @error('main_quantity') is-invalid @enderror" value="{{ $product->main_quantity }}"  name="main_quantity" id="main_quantity"
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
                                            <input type="file" name="photos[]" id="photos_image_file" onchange="update_file('photos_image_file','photos_msg')" accept="image/*" class="chooseFile @error('photos') is-invalid @enderror">
                                            
                                            <div class="file-select-name noFile" id="photos_msg">{{__('general.no_chosen')}}</div>
                                            <div class="file-select-button fileName" id="show_image">
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
                                <div class="col-xs-12">
                                    
                                       @if(is_array(json_decode($product->photos)))
                                        @foreach (json_decode($product->photos) as $key => $photo)
                                                    <div class="col-sm-3 col-xs-6">
                                                        <div class="img-upload-preview">
                                                            <img src="{{ asset($photo) }}" alt="" class="img-responsive">
                                                            <input type="hidden" name="previous_photos[]" id="previous_photos" value="{{ $photo }}">
                                                            <button type="button" class="btn btn-danger close-btn remove-files"><i
                                                        class="fa fa-times"></i></button>
                                                        </div>
                                                    </div>
                                                    @endforeach
                                                    @endif

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
                                            <input type="file" name="thumbnail_img" id="thumbnail_image_file" onchange="update_file('thumbnail_image_file','thumbnail_msg')" accept="image/*" class="chooseFile @error('thumbnail_img') is-invalid @enderror">
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
                                 <div class="col-xs-12">
                                    <hr>
                                                @if ($product->thumbnail_img != null)
                                                    <div class="col-sm-3 col-xs-6">
                                                        <div class="img-upload-preview">
                                                            <img src="{{ asset($product->thumbnail_img) }}" alt="" class="img-responsive">
                                                            <input type="hidden" name="previous_thumbnail_img" value="{{ $product->thumbnail_img }}">

                                                            <button type="button" class="btn btn-danger close-btn remove-files"><i
                                                        class="fa fa-times"></i></button>
                                                        </div>
                                                    </div>
                                                    @endif

                                                    </div>
                                
                               
                            </div>
                            <div class="row form-group">
                                <div class="col-xs-12 col-sm-6 col-lg-4">
                                    <label>{{__('general.featured_image')}}  
                                                                        <span class="text-muted font-size-12">*</span>
                                    <br><span class="text-muted font-size-12">Ext Only: (jpg|jpeg|png|tiff|webp|gif)</span>
                                    <br><span class="text-muted font-size-12">Best Size: (200*230)</span></label>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-lg-8">
                                    <div class="file-upload">
                                        <div class="file-select">
                                            <input type="file" name="featured_img" id="featured_image_file" onchange="update_file('featured_image_file','featured_msg')" accept="image/*" class="chooseFile @error('featured_img') is-invalid @enderror">
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
                                        <div class="col-xs-12">
                                    <hr>
                                                @if ($product->featured_img != null)
                                                    <div class="col-sm-3 col-xs-6">
                                                        <div class="img-upload-preview">
                                                            <img src="{{ asset($product->featured_img) }}" alt="" class="img-responsive">
                                                            <input type="hidden" name="previous_featured_img" value="{{ $product->featured_img }}">
                                                            <button type="button" class="btn btn-danger close-btn remove-files"><i
                                                        class="fa fa-times"></i></button>
                                                        </div>
                                                    </div>
                                                    @endif

                                                    </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-xs-12 col-sm-6 col-lg-4">
                                    <label>{{__('general.flash_image')}}                                     <span class="text-muted font-size-12">*</span>
                                    <br><span class="text-muted font-size-12">Ext Only: (jpg|jpeg|png|tiff|webp|gif)</span>
                                    <br><span class="text-muted font-size-12">Best Size: (200*230)</span>
                                    </label>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-lg-8">
                                    <div class="file-upload">
                                        <div class="file-select">
                                            <input type="file" name="flash_deal_img" id="flash_image_file" onchange="update_file('flash_image_file','flash_msg')" accept="image/*" class="chooseFile @error('flash_deal_img') is-invalid @enderror">
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
                                <div class="col-xs-12">
                                    <hr>
                                                @if ($product->flash_deal_img != null)
                                                    <div class="col-sm-3 col-xs-6">
                                                        <div class="img-upload-preview">
                                                            <img src="{{ asset($product->flash_deal_img) }}" alt="" class="img-responsive">
                                                            <input type="hidden" name="previous_flash_deal_img" value="{{ $product->flash_deal_img }}">
                                                            <button type="button" class="btn btn-danger close-btn remove-files"><i
                                                        class="fa fa-times"></i></button>
                                                        </div>
                                                    </div>
                                                    @endif

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
                                    <label>{{__('general.meta_title')}}</label>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-lg-8">
                                    <input type="text" class="form-control @error('meta_title') is-invalid @enderror" name="meta_title" value="{{ $product->meta_title }}" placeholder="Meta Tag">
                                    @error('meta_title')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                  @enderror
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-xs-12 col-sm-6 col-lg-4">
                                    <label>{{__('forms.description_ar')}}<span class="text-muted font-size-12">*</span></label>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-lg-8">
                                    <textarea name="description_ar" rows="6" class="form-control @error('description_ar') is-invalid @enderror">{{ $product->description_ar }}</textarea>
                                    @error('description_ar')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                  @enderror
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-xs-12 col-sm-6 col-lg-4">
                                    <label>{{__('forms.description_en')}}<span class="text-muted font-size-12">*</span></label>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-lg-8">
                                    <textarea name="description_en" rows="6" class="form-control @error('description_en') is-invalid @enderror">{{ $product->description_en }}</textarea>
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
                                            <div class="file-select-button fileName">
                                                <i class="fa fa-photo"></i>
                                                Upload
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                                                                    <div class="col-xs-12">
                                    <hr>
                                                @if ($product->meta_img != null)
                                                    <div class="col-sm-3 col-xs-6">
                                                        <div class="img-upload-preview">
                                                            <img src="{{ asset($product->meta_img) }}" alt="" class="img-responsive">
                                                            <input type="hidden" name="previous_meta_img"  value="{{ $product->meta_img }}">
                                                            <button type="button" class="btn btn-danger close-btn remove-files"><i
                                                        class="fa fa-times"></i></button>
                                                        </div>
                                                    </div>
                                                    @endif

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
                                <div class="col-xs-12 col-sm-6 col-lg-4">
                                    <label>{{__('general.colors')}}</label>
                                </div>

                                
                                                                <div id="" class="row form-group">
                                <div class="col-sm-12">
                               <div class="customer_choice_options" id="customer_choice_options">
                                @foreach ($product->choices()->where('name_en' , '!=' , 'colors')->get() as $key =>
                                $choice)
                                <div class="form-group">

                                    <div class="col-lg-3">
                                        <input type="hidden" name="choice_no[]" value="{{ $key }}">
                                        <input type="text" class="form-control" name="choice_ar[]"
                                            value="{{ $choice->name_ar }}" placeholder="Choice Title Arabic">
                                    </div>

                                    <div class="col-lg-3">
                                        <input type="text" class="form-control" name="choice[]"
                                            value="{{ $choice->name_en }}" placeholder="Choice English Title">
                                    </div>

                                    <div class="col-lg-3"><button type="button" class="btn btn-info"
                                            onclick="add_more_customer_option({{$key}})"
                                            id="add_option">{{ __('general.add_more_option') }}</button></div>

                                    <div class="col-lg-2"><button onclick="delete_row(this)"
                                            class=" btn btn-danger close-btn"><i
                                                class="fa fa-times"></i></button></div> <br>
                                    <div style="margin: 30px" class="row" id="customer_options{{$key}}">

                                        @foreach ($choice->options as $key1 => $option)
                                        <div class="row form-group">

                                            <div class="col-lg-2">
                                                    <input type="hidden" name="option_no{{$key}}[]" value="{{ $key1 }}">
                                                <input type="text" class="form-control"
                                                    name="choice_options_ar{{$key}}[]"
                                                    value="{{ $option->value_ar }}"
                                                    placeholder="Option Arabic values"></div>

                                            <div class="col-lg-2"><input type="text" class="form-control"
                                            name="choice_options_{{$key}}[]" id="choice_options_{{$key}}_{{$key1}}"
                                                    onchange="add_image_option({{$key}},{{$key1}});update_sku()"
                                                    value="{{ $option->value_en }}"
                                                    placeholder="Option English values"></div>

                                                    @if($option->image != null)
                                                    <div class="col-sm-3 col-xs-6">
                                                        <div class="img-upload-preview">
                                                            <img src="{{ asset($option->image) }}" alt="" class="img-responsive">
                                                            <input type="hidden" name="choice_photos{{$key}}_{{$option->value_en}}" value="{{ $option->image }}">
                                                            <button type="button" class="btn btn-danger close-btn remove-files"><i
                                                        class="fa fa-times"></i></button>
                                                        </div>
                                                    </div>
                                                     <div class="col-sm-3"><div id="choice_photos{{$key}}_{{$key1}}" data-id_1="{{$key}}" data-id_2="{{$key1}}"></div></div>
                                                    <div class="col-lg-2" id="btn-add"><button style="display:none" type="button" class="btn btn-primary" onclick="add_image_option({{$key}},{{$key1}})">{{__('general.add_image')}}</button></div>
                                                       
                                                    @else
                                                        <div class="col-sm-3"><div id="choice_photos{{$key}}_{{$key1}}" data-id_1="{{$key}}" data-id_2="{{$key1}}"></div></div>
                                                        <div class="col-lg-2"><button type="button" class="btn btn-primary" onclick="add_image_option({{$key}},{{$key1}})">{{__('general.add_image')}}</button></div>
                                                    @endif
                                                    
                                            <div class="col-lg-2"><button onclick="delete_row(this)"
                                                    class="btn btn-danger close-btn"><i
                                                        class=" fa fa-times"></i></button></div>

                                        </div>
                                        @endforeach


                                    </div>
                                </div>

                                @endforeach
                            </div>
                            </div></div>
                            <div class="form-group">
                                <div class="col-lg-2">
                                    <button type="button" class="btn btn-info"
                                        onclick="add_more_customer_choice_option()">{{ __('general.add_more_choice') }}</button>
                                </div>
                            </div>
                            </div>
                       
                        </div>
                    </div>
                    <!-- Price -->
                    <div class="section-wrapper">
                        <div class="section-header">
                            {{__('forms.price')}}
                        </div>
                        @php
                            $country = isset(auth()->user()->Country) ? auth()->user()->Country : \App\Country::first();
                                $product_country = \Illuminate\Support\Facades\DB::table('product_countries')->where('product_id' , $product->id)
                            ->where('country_id' , $country->id)->first();
                        @endphp
                                                        @php
                                $product_countries =
                                \Illuminate\Support\Facades\DB::table('product_countries')->where('product_id' ,
                                $product->id)->where('country_id' , $country->id)->first();
                                $combinations =
                                \App\Variation::where('product_id',$product->id)->where('product_country_id' ,
                                get_country()->id)->get();
                                @endphp
                        <input type="hidden" name="countries[]"
                               value="{{ isset(auth()->user()->Country) ? auth()->user()->Country->id : \App\Country::first()->id }}">
                        <div class="section-body">
                            <div class="row form-group">
                                <div class="col-xs-12 col-sm-6 col-lg-4">
                                    <label>{{__('general.unit_price')}}<span class="text-muted font-size-12">*</span></label>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-lg-8">
                                    <input type="text" name="unit_price[]" value="{{ $product_country->unit_price }}" class="form-control @error('unit_price') is-invalid @enderror"
                                           onchange="update_sku()" placeholder="0">
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
                            <!--        <input type="number" min="0" step="0.01" name="purchase_price[]" value="{{ $product_country->purchase_price }}" class="form-control @error('purchase_price') is-invalid @enderror"-->
                            <!--               onchange="update_sku()" placeholder="0">-->
                            <!--               @error('purchase_price')-->
                            <!--        <span class="invalid-feedback" role="alert">-->
                            <!--            <strong>{{ $message }}</strong>-->
                            <!--        </span>-->
                            <!--      @enderror-->
                            <!--    </div>-->
                            <!--</div>-->
                            <div class="row form-group">
                                <div class="col-xs-12 col-sm-6 col-lg-4">
                                    <label>{{__('general.tax')}}</label>
                                </div>
                                <div class="col-xs-8 col-sm-4 col-lg-6">
                                    <input type="number" min="0" step="0.01" name="tax[]" value="{{ $product_country->tax }}" class="form-control @error('tax') is-invalid @enderror" onchange="update_sku()"
                                           placeholder="0">
                                           @error('tax')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                  @enderror
                                </div>
                                <div class="col-xs-4 col-sm-2 col-lg-2">
                                    <select class="form-control" name="tax_type[]"  onchange="" required>
                                        <option value="amount" @if($product_country->tax_type == 'amount') selected @endif>$</option>
                                        <option value="percent" @if($product_country->tax_type == 'percent') selected @endif>%</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-xs-12 col-sm-6 col-lg-4">
                                    <label>{{__('general.discount')}}</label>
                                </div>
                                <div class="col-xs-8 col-sm-4 col-lg-6">
                                    <input type="number" min="0" step="0.01" name="discount[]" value="{{ $product_country->discount }}" class="form-control @error('discount') is-invalid @enderror" onchange="update_sku()"
                                           placeholder="0">
                                           @error('discount')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                  @enderror

                                </div>
                                <div class="col-xs-4 col-sm-2 col-lg-2">
                                    <select class="form-control" name="discount_type[]" onchange="" required>
                                        <option value="amount" @if($product_country->discount_type == 'amount') selected @endif>$</option>
                                        <option value="percent" @if($product_country->discount_type == 'percent') selected @endif>%</option>
                                    </select>
                                </div>
                            </div>
  <div class="sku_combination" id="sku_combination">
                                        @if(count($combinations) > 0)
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <td class="text-center">
                                                        <label for="" class="control-label">{{__('Status')}}</label>
                                                    </td>
                                                    <td class="text-center">
                                                        <label for="" class="control-label">{{__('Variant')}}</label>
                                                    </td>
                                                    <td class="text-center">
                                                        <label for=""
                                                            class="control-label">{{__('Variant Price')}}</label>
                                                    </td>
                                                    <td class="text-center">
                                                        <label for="" class="control-label">{{__('SKU')}}</label>
                                                    </td>
                                                    <td class="text-center">
                                                        <label for="" class="control-label">{{__('general.quantity')}}</label>
                                                    </td>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($combinations as $key => $combination)
                                                <tr>
                                                    <td>
                                                        <input type="checkbox" name="check_{{ substr($combination->sku,1,10000)}}[]" @if($combination->status) checked @endif class="form-control">
                                                    </td>
                                                    <td>
                                                        <label for=""
                                                            class="control-label">{{ substr($combination->sku,1,10000) }}</label>
                                                    </td>
                                                    <td>
                                                        <input type="number"
                                                            name="price_{{ substr($combination->sku,1,10000) }}[]"
                                                            value="{{ $combination->price }}" min="0" step="0.01"
                                                            class="form-control" required>
                                                    </td>
                                                    <td>
                                                        <input type="text"
                                                            name="sku_{{ substr($combination->sku,1,10000) }}[]"
                                                            value="{{ $combination->sku }}" class="form-control"
                                                            required>
                                                    </td>
                                                    <td>
                                                        <input type="number"
                                                            name="qty_{{ substr($combination->sku,1,10000) }}[]"
                                                            value="{{ $combination->qty }}" min="0" step="1"
                                                            class="form-control" required>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                        @endif
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

    <!-- Modal -->
    <div style="position: relative;bottom: -40px;">
        @include('frontend.seller.footer_tabs')
    </div>
@endsection

@section('script')
    <script type="text/javascript">
    
    function update_file(upload_id,msg_id){
                var str = $('#'+upload_id).val();
                filename = str.substr(12);
                console.log(filename,msg_id);
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
        });


        var i = $('input[name="choice_no[]"').last().val();
        if (isNaN(i)) {
            i = 0;
        }

        function add_more_customer_choice_option() {
            i++;
            $('#customer_choice_options').append('<div class="row form-group"><div class="col-lg-3"><input type="hidden" name="choice_no[]" value="' + i + '"><input type="text" class="form-control" name="choice_ar[]" value="" placeholder="Choice Title Arabic" required></div><div class="col-lg-3"><input type="text" class="form-control" name="choice[]" value="" placeholder="Choice Title English" required></div><div class="col-lg-3"><button type="button" class="btn btn-info"onclick="add_more_customer_option('+i+')" id="add_option">{{ __('general.add_more_option') }}</button></div><div class="col-lg-2"><button onclick="delete_row(this)" class="btn btn-danger close-btn"><i class="fa fa-times"></i></button></div> <br> <div style="margin: 30px" class="row" id="customer_options'+i+'"></div> </div>');
        }
        function add_more_customer_option(el) {
            var ii = $('input[name="option_no'+el+'[]"]').last().val();
            console.log(ii,'input[name="option_no'+el+'[]"]');
            if (isNaN(ii)) {
            ii = -1;
        }
            ii++;
            $('#customer_options'+el).append('<div class="row form-group"><div class="col-lg-2"><input type="hidden" name="option_no'+el+'[]" value="'+ii+'"><input type="text" class="form-control" name="choice_options_ar' + el + '[]" placeholder="choice Arabic values" required></div><div class="col-lg-2"><input type="text" class="form-control" name="choice_options_' + el + '[]" id="choice_options_'+ ii +'" onchange="update_sku()" placeholder="choice English values" required></div><div class="col-sm-3"><div id="choice_photos'+el+'_'+ii+'" data-id_1="'+el+'" data-id_2="'+ii+'"></div> </div>'
            +'<div class="col-lg-2"><button type="button" class="btn btn-primary" onclick="add_image_option('+el+','+ii+')">{{__('general.add_image')}}</button></div><div class="col-lg-2"><button onclick="delete_row(this)" class="btn btn-danger close-btn"><i class="fa fa-times"></i></button></div></div>');
        }
        
              $(document).ready(function(){
            $('.remove-files').on('click', function(){
                console.log('okkkk');
                $(this).parents(".col-sm-3").remove();
                $('#btn-add button').css('display', 'block');
            });
        });

        function add_image_option(el,el1){
            var name = 'choice_photos'+el+'_'+$("#choice_options_"+ el+"_"+el1+"").val();
            if($("#choice_photos"+el+"_"+el1+" input[type='file']").length){
                console.log($("input[name='"+name+"']").length, name);
            }else{
                console.log(name);
                        var name1 = 'choice_photos'+el+'_'+$("#choice_options_"+ el+"_"+el1+"").val();
            var shopSliderAdd =  '<div class="col-md-12">\n' +
                '<input type="file" name="'+name1+'"  class="dropify" data-multiple-caption="{count} files selected" multiple accept="image/*" />\n' +
                '</div>';
            $('#choice_photos'+el+'_'+el1).append(shopSliderAdd);

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

        var photo_id = $('#previous_photos').length + 1;
    console.log(photo_id);
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
