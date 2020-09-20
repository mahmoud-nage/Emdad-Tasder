@extends('layouts.app')

@section('content')

    <div class="row">
        <form class="form form-horizontal mar-top" action="{{route('products.update', $product->id)}}" method="POST"
              enctype="multipart/form-data" id="choice_form">
            <input name="_method" type="hidden" value="POST">
            <input type="hidden" name="id" value="{{ $product->id }}">
            @csrf
            <div class="panel">
                <div class="panel-heading">
                    <h3 class="panel-title">{{__('Product Information')}}</h3>
                </div>
                <div class="panel-body">
                    <div class="tab-base tab-stacked-left">
                        <!--Nav tabs-->
                        <ul class="nav nav-tabs">
                            <li class="active">
                                <a data-toggle="tab" href="#demo-stk-lft-tab-1" aria-expanded="true">{{__('General')}}</a>
                            </li>
                            <li class="">
                                <a data-toggle="tab" href="#demo-stk-lft-tab-2" aria-expanded="false">{{__('Images')}}</a>
                            </li>
                            <!--<li class="">-->
                            <!--    <a data-toggle="tab" href="#demo-stk-lft-tab-3"-->
                        <!--       aria-expanded="false">{{__('Videos')}}</a>-->
                            <!--</li>-->
                            <li class="">
                                <a data-toggle="tab" href="#demo-stk-lft-tab-4"
                                   aria-expanded="false">{{__('Meta Tags')}}</a>
                            </li>
                            <li class="">
                                <a data-toggle="tab" href="#demo-stk-lft-tab-5"
                                   aria-expanded="false">{{__('Customer Choice')}}</a>
                            </li>
                            <li class="">
                                <a data-toggle="tab" href="#demo-stk-lft-tab-6" aria-expanded="false">{{__('Price')}}</a>
                            </li>
                            <li class="">
                                <a data-toggle="tab" href="#demo-stk-lft-tab-7"
                                   aria-expanded="false">{{__('Description')}}</a>
                            </li>
                        {{-- <li class="">
                                <a data-toggle="tab" href="#demo-stk-lft-tab-8" aria-expanded="false">Display Settings</a>
                            </li> --}}
                        <!--<li class="">-->
                            <!--    <a data-toggle="tab" href="#demo-stk-lft-tab-9"-->
                        <!--       aria-expanded="false">{{__('Shipping Info')}}</a>-->
                            <!--</li>-->
                            <!--<li class="">-->
                            <!--    <a data-toggle="tab" href="#demo-stk-lft-tab-10"-->
                        <!--       aria-expanded="false">{{__('PDF Specification')}}</a>-->
                            <!--</li>-->
                            <li class="">
                                <a data-toggle="tab" href="#demo-stk-lft-tab-11"
                                   aria-expanded="false">{{__('Season')}}</a>
                            </li>
                        </ul>

                        <!--Tabs Content-->
                        <div class="tab-content">
                            <div id="demo-stk-lft-tab-1" class="tab-pane fade active in">
                                <div class="form-group">
                                    <label class="col-lg-2 control-label">{{__('Product Name Ar')}}
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-lg-7">
                                        <input type="text" class="form-control @error('name_ar') is-invalid @enderror"
                                               name="name_ar" placeholder="{{__('Product Name Ar')}}"
                                               value="{{$product->name_ar}}" oninvalid="alert('You must fill Product Name Ar!');"  required>
                                        @error('name_ar')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-2 control-label">{{__('Product Name En')}}
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-lg-7">
                                        <input type="text" class="form-control @error('name_en') is-invalid @enderror"
                                               name="name_en" placeholder="{{__('Product Name Ar')}}"
                                               value="{{$product->name_en}}" oninvalid="alert('You must fill Product Name En!');"  required>
                                        @error('name_en')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group" id="category">
                                    <label class="col-lg-2 control-label">{{__('Category')}}
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-lg-7">
                                        <select class="form-control select2 @error('category_id') is-invalid @enderror"
                                                name="category_id" id="category_id" oninvalid="alert('You must fill Product Category!');"  required>
                                            <option>Select an option</option>

                                            @foreach(\App\Category::all() as $category)
                                                <option value="{{$category->id}}"
                                                <?php if ($product->category_id == $category->id) echo "selected"; ?>>
                                                    {{__($category['name_'.app()->getLocale()])}}
                                            @endforeach
                                        </select>
                                        @error('category_id')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group" id="subcategory">
                                    <label class="col-lg-2 control-label">{{__('Subcategory')}}
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-lg-7">
                                        <select class="form-control select2 @error('subcategory_id') is-invalid @enderror"
                                                name="subcategory_id" id="subcategory_id" oninvalid="alert('You must fill Product Subcategory!');"  required>

                                        </select>
                                        @error('subcategory_id')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group" id="unit">
                                    <label class="col-lg-2 control-label">{{__('Unit')}}
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-lg-7">
                                        <select class="form-control select2 @error('unit_id') is-invalid @enderror"
                                                name="unit_id" id="unit_id" oninvalid="alert('You must fill Product Unit!');" required>
                                            @foreach($units as $unit)
                                                <option value="{{$unit->id}}" @if($unit->id == $product->unit_id) selected @endif>
                                                    {{ \App::isLocale('ar') ? $unit->name_ar : $unit->name_en }} &nbsp;
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('unit_id')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-2 control-label">{{__('Tags')}}</label>
                                    <div class="col-lg-7">
                                        <input type="text" class="form-control @error('tags') is-invalid @enderror"
                                               name="tags[]" id="tags" value="{{ $product->tags }}"
                                               placeholder="Type to add a tag" data-role="tagsinput">
                                        @error('tags')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div id="demo-stk-lft-tab-2" class="tab-pane fade">
                                <div class="form-group">
                                    <label class="col-lg-2 control-label">{{__('Main Images')}}
                                        <span class="text-danger">*</span>
                                        <br><small class="text-danger text-xs">Ext Only: (jpg|jpeg|png|tiff|webp|gif)</small>
                                        <br><small class="text-danger text-xs">Best Size: (450*450)</small></label>
                                    <div class="col-lg-7">
                                        <div id="photos">
                                            @if(is_array(json_decode($product->photos)))
                                                @foreach (json_decode($product->photos) as $key => $photo)
                                                    <div class="col-md-4 col-sm-4 col-xs-6">
                                                        <div class="img-upload-preview">
                                                            <img src="{{ asset($photo) }}" alt="" class="img-responsive">
                                                            <input type="hidden" name="previous_photos[]" value="{{ $photo }}">
                                                            <button type="button" class="btn btn-danger close-btn remove-files"><i
                                                                    class="fa fa-times"></i></button>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @endif
                                        </div>
                                    </div>
                                    @error('photos')
                                    <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-2 control-label">{{__('Thumbnail Image')}}
                                        <span class="text-danger">*</span>
                                        <br><small class="text-danger text-xs">Ext Only: (jpg|jpeg|png|tiff|webp|gif)</small>
                                        <br><small class="text-danger text-xs">Best Size: (200*230)</small>                                </label>
                                    <div class="col-lg-7">
                                        <div id="thumbnail_img">
                                            @if ($product->thumbnail_img != null)
                                                <div class="col-md-4 col-sm-4 col-xs-6">
                                                    <div class="img-upload-preview">
                                                        <img src="{{ asset($product->thumbnail_img) }}" alt=""
                                                             class="img-responsive">
                                                        <input type="hidden" name="previous_thumbnail_img"
                                                               value="{{ $product->thumbnail_img }}">
                                                        <button type="button" class="btn btn-danger close-btn remove-files"><i
                                                                class="fa fa-times"></i></button>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    @error('thumbnail_img')
                                    <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-2 control-label">{{__('Featured')}}
                                        <span class="text-danger">*</span>
                                        <br><small class="text-danger text-xs">Ext Only: (jpg|jpeg|png|tiff|webp|gif)</small>
                                        <br><small class="text-danger text-xs">Best Size: (200*230)</small>                                </label>
                                    <div class="col-lg-7">
                                        <div id="featured_img">
                                            @if ($product->featured_img != null)
                                                <div class="col-md-4 col-sm-4 col-xs-6">
                                                    <div class="img-upload-preview">
                                                        <img src="{{ asset($product->featured_img) }}" alt=""
                                                             class="img-responsive">
                                                        <input type="hidden" name="previous_featured_img"
                                                               value="{{ $product->featured_img }}">
                                                        <button type="button" class="btn btn-danger close-btn remove-files"><i
                                                                class="fa fa-times"></i></button>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    @error('featured_img')
                                    <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-2 control-label">{{__('Flash Deal')}}
                                        <span class="text-danger">*</span>
                                        <br><small class="text-danger text-xs">Ext Only: (jpg|jpeg|png|tiff|webp|gif)</small>
                                        <br><small class="text-danger text-xs">Best Size: (200*230)</small>                                </label>
                                    <div class="col-lg-7">
                                        <div id="flash_deal_img">
                                            @if ($product->flash_deal_img != null)
                                                <div class="col-md-4 col-sm-4 col-xs-6">
                                                    <div class="img-upload-preview">
                                                        <img src="{{ asset($product->flash_deal_img) }}" alt=""
                                                             class="img-responsive">
                                                        <input type="hidden" name="previous_flash_deal_img"
                                                               value="{{ $product->flash_deal_img }}">
                                                        <button type="button" class="btn btn-danger close-btn remove-files"><i
                                                                class="fa fa-times"></i></button>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    @error('flash_deal_img')
                                    <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                    @enderror
                                </div>
                            </div>
                            <div id="demo-stk-lft-tab-4" class="tab-pane fade">
                                <div class="form-group">
                                    <label class="col-lg-2 control-label">{{__('Meta Title')}}</label>
                                    <div class="col-lg-7">
                                        <input type="text" class="form-control @error('meta_title') is-invalid @enderror"
                                               name="meta_title" value="{{ $product->meta_title }}"
                                               placeholder="{{__('Meta Title')}}">
                                        @error('meta_title')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-2 control-label">{{__('Description')}}</label>
                                    <div class="col-lg-7">
                                    <textarea name="meta_description" rows="8"
                                              class="form-control @error('meta_description') is-invalid @enderror">{{ $product->meta_description }}</textarea>
                                        @error('meta_description')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-2 control-label">{{ __('Meta Image') }}
                                        <span class="text-danger">*</span>
                                        <br><small class="text-danger text-xs">Ext Only: (jpg|jpeg|png|tiff|webp|gif)</small>
                                        <br><small class="text-danger text-xs">Best Size: (200*230)</small></label>
                                    <div class="col-lg-7">
                                        <div id="meta_photo">
                                            @if ($product->meta_img != null)
                                                <div class="col-md-4 col-sm-4 col-xs-6">
                                                    <div class="img-upload-preview">
                                                        <img src="{{ asset($product->meta_img) }}" alt=""
                                                             class="img-responsive">
                                                        <input type="hidden" name="previous_meta_img"
                                                               value="{{ $product->meta_img }}"
                                                               class=" @error('discount') is-invalid @enderror">
                                                        <button type="button" class="btn btn-danger close-btn remove-files"><i
                                                                class="fa fa-times"></i></button>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    @error('meta_img')
                                    <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                    @enderror
                                </div>
                            </div>
                            <div id="demo-stk-lft-tab-5" class="tab-pane fade">

                                <div class="customer_choice_options" id="customer_choice_options">

                                    @foreach ($product->choices()->where('name_en' , '!=' , 'colors')->get() as $key =>
                                    $choice)
                                        <div class="form-group">

                                            <div class="col-lg-3">
                                                <input type="hidden" name="choice_no[]" value="{{ $key }}">
                                                <input type="text" class="form-control @error('choice_ar') is-invalid @enderror"
                                                       name="choice_ar[]" value="{{ $choice->name_ar }}"
                                                       placeholder="Choice Title Arabic">
                                                @error('choice_ar')
                                                <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                                @enderror
                                            </div>

                                            <div class="col-lg-3">
                                                <input type="text" class="form-control @error('choice') is-invalid @enderror"
                                                       name="choice[]" value="{{ $choice->name_en }}"
                                                       placeholder="Choice English Title">
                                                @error('choice')
                                                <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                                @enderror
                                            </div>

                                            <div class="col-lg-3"><button type="button" class="btn btn-info"
                                                                          onclick="add_more_customer_option({{$key}})"
                                                                          id="add_option">{{ __('Add more option') }}</button></div>

                                            <div class="col-lg-2"><button onclick="delete_row(this)"
                                                                          class="btn btn-danger btn-icon"><i
                                                        class="demo-psi-recycling icon-lg"></i></button></div> <br>
                                            <div style="margin: 30px" class="row" id="customer_options{{$key}}">

                                                @foreach ($choice->options as $key1 => $option)
                                                    <div class="form-group">

                                                        <div class="col-lg-2">
                                                            <input type="hidden" name="option_no{{$key}}[]" value="{{ $key1 }}">
                                                            <input type="text" class="form-control"
                                                                   name="choice_options_ar{{$key}}[]" value="{{ $option->value_ar }}"
                                                                   placeholder="Option Arabic values">
                                                        </div>

                                                        <div class="col-lg-2"><input type="text" class="form-control"
                                                                                     name="choice_options_{{$key}}[]"
                                                                                     id="choice_options_{{$key}}_{{$key1}}" onchange="update_sku()"
                                                                                     value="{{ $option->value_en }}" placeholder="Option English values">
                                                        </div>

                                                        @if($option->image != null)
                                                            <div class="col-md-4">
                                                                <div class="img-upload-preview">
                                                                    <img src="{{ asset($option->image) }}" alt=""
                                                                         class="img-responsive">
                                                                    <input type="hidden"
                                                                           name="choice_photos{{$key}}_{{$key1}}"
                                                                           value="{{ $option->image }}">
                                                                    <button type="button"
                                                                            class="btn btn-danger close-btn remove-files"><i
                                                                            class="fa fa-times"></i></button>
                                                                </div>
                                                            </div>


                                                            <div  class="col-md-3"  id="choice_photos{{$key}}_{{$key1}}" style="display:none"></div>
                                                            <div class="col-lg-2" id="add_new_photo"><button type="button" class="btn btn-info"
                                                                                                             onclick="add_image({{$key}},{{$key1}})">{{ __('Add Photo ') }}</button></div>
                                                        @else
                                                            <div class="col-lg-3">
                                                                <div id="choice_photos{{$key}}_{{$key1}}" data-id_1="{{$key}}"
                                                                     data-id_2="{{$key1}}"></div>
                                                            </div>
                                                            <div class="col-lg-2"><button type="button" class="btn btn-info"
                                                                                          onclick="add_image({{$key}},{{$key1}})">{{ __('Add Photo ') }}</button></div>

                                                        @endif

                                                        <div class="col-lg-2"><button onclick="delete_row(this)"
                                                                                      class="btn btn-danger btn-icon"><i
                                                                    class="demo-psi-recycling icon-lg"></i></button></div>

                                                    </div>
                                                @endforeach


                                            </div>
                                        </div>

                                    @endforeach
                                </div>
                                <div class="form-group">
                                    <div class="col-lg-2">
                                        <button type="button" class="btn btn-info"
                                                onclick="add_more_customer_choice_option()">{{ __('Add more customer choice option') }}</button>
                                    </div>
                                </div>
                            </div>
                            <div id="demo-stk-lft-tab-6" class="tab-pane fade">

                                <div class="prices">

                                    @foreach(\App\Country::all() as $country)
                                        @if($product->countries->contains($country->id))
                                            @php
                                                $product_countries =
                                                \Illuminate\Support\Facades\DB::table('product_countries')->where('product_id' ,
                                                $product->id)->where('country_id' , $country->id)->first();
                                                $combinations =
                                                \App\Variation::where('product_id',$product->id)->where('product_country_id' ,
                                                $country->id)->get();
                                            @endphp
                                            <div>
                                                <input type="hidden" name="countries[]" value="{{ $country->id }}">
                                                <div class="text-center">
                                                    <button type="button" class="btn btn-primary"
                                                            readonly>{{ \App::isLocale('ar') ? $country->name_ar : $country->name_en }}</button>
                                                    <button type="button" class="btn btn-danger"
                                                            onclick="if(confirm('Will you remove this country?')) $(this).parent().parent().remove()">
                                                        <span class="fa fa-close"></span></button>
                                                    <hr>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-lg-2 control-label">{{__('Unit price')}}
                                                        <span class="text-danger">*</span>
                                                    </label>
                                                    <div class="col-lg-7">
                                                        <input type="text" placeholder="{{__('Unit price')}}" name="unit_price[]"
                                                               class="form-control @error('unit_price') is-invalid @enderror"
                                                               value="{{$product_countries->unit_price}}" oninvalid="alert('You must fill Product Unit price!');"  required>
                                                        @error('unit_price')
                                                        <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-lg-2 control-label">{{__('Tax')}}</label>
                                                    <div class="col-lg-7">
                                                        <input type="number" min="0" step="0.01" placeholder="{{__('tax')}}"
                                                               name="tax[]" class="form-control @error('tax') is-invalid @enderror"
                                                               value="{{$product_countries->tax}}" required>
                                                        @error('tax')
                                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                                        @enderror
                                                    </div>
                                                    <div class="col-lg-1">
                                                        <select class="select2 @error('tax_type') is-invalid @enderror"
                                                                name="tax_type[]" required>
                                                            <option value="amount"
                                                            <?php if ($product_countries->tax_type == 'amount') echo "selected";?>>
                                                                $
                                                            </option>
                                                            <option value="percent"
                                                            <?php if ($product_countries->tax_type == 'percent') echo "selected";?>>
                                                                %
                                                            </option>
                                                        </select>
                                                        @error('tax_type')
                                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-lg-2 control-label">{{__('Discount')}}</label>
                                                    <div class="col-lg-7">
                                                        <input type="number" min="0" step="0.01" placeholder="{{__('Discount')}}"
                                                               name="discount[]"
                                                               class="form-control @error('discount') is-invalid @enderror"
                                                               value="{{ $product_countries->discount }}" required>
                                                        @error('discount')
                                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                                        @enderror
                                                    </div>
                                                    <div class="col-lg-1">
                                                        <select class="select2 @error('discount_type') is-invalid @enderror"
                                                                name="discount_type[]" required>
                                                            <option value="amount"
                                                            <?php if ($product_countries->discount_type == 'amount') echo "selected";?>>
                                                                $
                                                            </option>
                                                            <option value="percent"
                                                            <?php if ($product_countries->discount_type == 'percent') echo "selected";?>>
                                                                %
                                                            </option>
                                                        </select>
                                                        @error('discount_type')
                                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <br>

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
                                                                    <label for="" class="control-label">{{__('Variant Price')}}</label>
                                                                </td>
                                                                <td class="text-center">
                                                                    <label for="" class="control-label">{{__('SKU')}}</label>
                                                                </td>
                                                                <td class="text-center">
                                                                    <label for="" class="control-label">{{__('Quantity')}}</label>
                                                                </td>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            @foreach ($combinations as $key => $combination)
                                                                @php
                                                                    $str = substr($combination->sku,1,10000);
                                                                @endphp
                                                                <tr>
                                                                    <td>
                                                                        <input type="checkbox"
                                                                               name="check_{{ substr($combination->sku,1,10000) }}[]"
                                                                               class="form-control" @if($combination->status) checked @endif>
                                                                    </td>
                                                                    <td>
                                                                        <label for="" class="control-label">{{ $str }}</label>
                                                                    </td>
                                                                    <td>
                                                                        <input type="number" name="price_{{ $str }}[]"
                                                                               value="{{ $combination->price }}" min="0" step="0.01"
                                                                               class="form-control" required>
                                                                    </td>
                                                                    <td>
                                                                        <input type="text" name="sku_{{ $str }}[]"
                                                                               value="{{ $combination->sku }}" class="form-control" required>
                                                                    </td>
                                                                    <td>
                                                                        <input type="number" name="qty_{{ $str }}[]"
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
                                        @else
                                            <div>
                                                <input type="hidden" name="countries[]" value="{{ $country->id }}">
                                                <div class="text-center">
                                                    <button type="button" class="btn btn-primary"
                                                            readonly>{{ \App::isLocale('ar') ? $country->name_ar : $country->name_en }}</button>
                                                    <button type="button" class="btn btn-danger"
                                                            onclick="if(confirm('Will you remove this country?')) $(this).parent().parent().remove()">
                                                        <span class="fa fa-close"></span></button>
                                                    <hr>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-lg-2 control-label">{{__('Unit price')}}
                                                        <span class="text-danger">*</span>
                                                    </label>
                                                    <div class="col-lg-7">
                                                        <input type="text" placeholder="{{__('Unit price')}}" name="unit_price[]"
                                                               class="form-control @error('unit_price') is-invalid @enderror" oninvalid="alert('You must fill Product Unit price!');"  required>
                                                        @error('unit_price')
                                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-lg-2 control-label">{{__('Tax')}}</label>
                                                    <div class="col-lg-7">
                                                        <input type="number" min="0" step="0.01" placeholder="{{__('tax')}}" name="tax[]"
                                                               class="form-control @error('tax') is-invalid @enderror" value="0" required>
                                                        @error('tax')
                                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                                        @enderror
                                                    </div>
                                                    <div class="col-lg-1">
                                                        <select class="select2 @error('tax_type') is-invalid @enderror" name="tax_type[]"
                                                                required>
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
                                                <div class="form-group">
                                                    <label class="col-lg-2 control-label">{{__('Discount')}}</label>
                                                    <div class="col-lg-7">
                                                        <input type="number" min="0" step="0.01" placeholder="{{__('Discount')}}"
                                                               name="discount[]" class="form-control @error('discount') is-invalid @enderror"
                                                               value="0" required>
                                                        @error('discount')
                                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                                        @enderror
                                                    </div>
                                                    <div class="col-lg-1">
                                                        <select class="select2 @error('discount_type') is-invalid @enderror"
                                                                name="discount_type[]" required>
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
                                                <br>
                                                <div class="sku_combination">
                                                </div>
                                            </div>

                                        @endif
                                    @endforeach

                                </div>
                            </div>
                            <div id="demo-stk-lft-tab-7" class="tab-pane fade">
                                <div class="form-group">
                                    <label class="col-lg-2 control-label">{{__('Description Ar')}}
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-lg-9">
                            <textarea class="editor @error('description_ar') is-invalid @enderror"
                                      name="description_ar" oninvalid="alert('You must fill Product Description Ar!');"  required>{{$product->description_ar}}</textarea>
                                        @error('description_ar')
                                        <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-2 control-label">{{__('Description En')}}
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-lg-9">
                            <textarea class="editor @error('description_en') is-invalid @enderror"
                                      name="description_en" oninvalid="alert('You must fill Product Description En!');"  required>{{$product->description_en}}</textarea>
                                        @error('description_en')
                                        <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>



                            <div id="demo-stk-lft-tab-11" class="tab-pane fade">

                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="start_date">
                                        {{__('Date From')}}
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-sm-4">
                                        <input type="date" class="form-control" name="Season_from" value="{{date('Y-m-d', $product->Season_from)}}">
                                    </div>

                                    <label class="col-sm-2 control-label" for="start_date">
                                        {{__('Date To')}}
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-sm-4">
                                        <input type="date" class="form-control" name="Season_to" value="{{date('Y-m-d', $product->Season_to)}}">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-lg-2 control-label">{{__('Season Msg Ar')}}
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-lg-9">
                            <textarea class="editor @error('Season_msg_ar') is-invalid @enderror"
                                      name="Season_msg_ar" oninvalid="alert('You must fill Product Season Msg Ar!');" required>{{$product->Season_msg_ar}}</textarea>
                                        @error('Season_msg_ar')
                                        <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-2 control-label">{{__('Season Msg En')}}
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-lg-9">
                            <textarea class="editor @error('Season_msg_en') is-invalid @enderror"
                                      name="Season_msg_en" oninvalid="alert('You must fill Product Season Msg En!');" required>{{$product->Season_msg_en}}</textarea>
                                        @error('Season_msg_en')
                                        <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="panel-footer text-right">
                    <button type="submit" name="button" class="btn btn-purple">{{ __('Save') }}</button>
                </div>
            </div>
        </form>
    </div>

@endsection

@section('script')

    <script type="text/javascript">
        var count;
        var i = $('input[name="choice_no[]"').last().val();
        if (isNaN(i)) {
            i = 0;
        }

        $(".add_countries").click(function () {
            count = $(".sku_combination").length + 1;
            $(".prices").append('<div class="form-group"><label class="col-lg-2 control-label">Country</label><div class="col-lg-7"><select name="country[]" class="form-control select2" required><option value="">Select Country</option>@foreach(\App\Country::all() as $country)<option value="{{ $country->id }}">{{ $country->name }}</option>@endforeach</select></div></div><div class="form-group"><label class="col-lg-2 control-label">Unit price</label><div class="col-lg-7"><input type="number" min="0" value="0" step="0.01" placeholder="Unit price" name="unit_price[]" class="form-control" required></div></div><div class="form-group"><label class="col-lg-2 control-label">Purchase price</label><div class="col-lg-7"><input type="number" min="0" value="0" step="0.01" placeholder="Purchase price" name="purchase_price[]" class="form-control" required></div></div><div class="form-group"><label class="col-lg-2 control-label">Tax</label><div class="col-lg-7"><input type="number" min="0" value="0" step="0.01" placeholder="Tax" name="tax[]" class="form-control" required></div><div class="col-lg-1"><select class="select2" name="tax_type[]"><option value="amount">$</option><option value="percent">%</option></select></div></div><div class="form-group"><label class="col-lg-2 control-label">Discount</label><div class="col-lg-7"><input type="number" min="0" value="0" step="0.01" placeholder="Discount" name="discount[]" class="form-control" required></div><div class="col-lg-1"><select class="select2" name="discount_type[]"><option value="amount">$</option><option value="percent">%</option></select></div></div><hr><div class="sku_combination' + count + '" id="sku_combination"></div>');
            $.ajax({
                type: "POST",
                url: '{{ route('products.sku_combination_edit') }}',
                data: $('#choice_form').serialize(),
                success: function (data) {
                    $('.sku_combination' + count).html(data);
                }
            });
            $('.demo-select2').select2();
        });

        function add_more_customer_choice_option() {
            i++;
            $('#customer_choice_options').append('<div class="form-group"><div class="col-lg-3"><input type="hidden" name="choice_no[]" value="' + i + '"><input type="text" class="form-control" name="choice_ar[]" value="" placeholder="Choice Title Arabic" required></div><div class="col-lg-3"><input type="text" class="form-control" name="choice[]" value="" placeholder="Choice Title English" required></div><div class="col-lg-3"><button type="button" class="btn btn-info"onclick="add_more_customer_option('+i+')" id="add_option">{{ __('general.add_more_option') }}</button></div><div class="col-lg-2"><button onclick="delete_row(this)" class="btn btn-danger btn-icon"><i class="fa fa-times"></i></button></div> <br> <div style="margin: 30px" class="row" id="customer_options'+i+'"></div> </div>');
        }
        function add_more_customer_option(el) {
            var ii = $('input[name="option_no'+el+'[]"').last().val();
            if (isNaN(ii)) {
                ii = -1;
            }
            ii++;
            $('#customer_options'+el).append('<div class="row form-group"><div class="col-lg-2"><input type="text" class="form-control" name="choice_options_ar' + el + '[]" placeholder="choice Arabic values" required></div><div class="col-lg-2"><input type="text" class="form-control" name="choice_options_' + el + '[]" id="choice_options_'+el+'_'+ii+'" onchange="update_sku()" placeholder="choice English values" required></div><div class="col-sm-3"><div id="choice_photos'+el+'_'+ii+'"></div> </div>'
                +'<div class="col-lg-2"><button type="button" class="btn btn-primary" onclick="add_image('+el+','+ii+')">{{__('general.add_image')}}</button></div><div class="col-lg-2"><button onclick="delete_row(this)" class="btn btn-danger btn-icon"><i class="fa fa-times"></i></button></div></div>');

        }

        function add_image(el,el1){
            var name = 'choice_photos'+$("#choice_photos"+el1).data('id_1')+'_'+$("#choice_options_" + el1).val();

            $('#choice_photos'+el+'_'+el1).css('display', 'block');

            if($("#choice_photos"+el1+" input[type='file']").length){
                console.log($("input[name='"+name+"']").length, name);
            }else{
                console.log(el,el1);

                $("#choice_photos"+el+"_"+el1).spartanMultiImagePicker({
                    // fieldName: 'choice_photos'+el+'_'+$('#choice_options_'+el+'_'+el1).val(),
                    fieldName: 'choice_photos'+el+'_'+el1,
                    maxCount: 1,
                    rowHeight: '150px',
                    groupClassName:   'col-md-12 @error("choice_photos'+el1+'") is-invalid @enderror',
                    maxFileSize:      '',
                    allowedExt:       'jpg|jpeg|png|tiff|webp|gif',
                    dropFileLabel : "Drop Here",
                    onExtensionErr : function(index, file){
                        console.log(index, file,  'extension err');
                        alert('Please only input png or jpg or jpeg or tiff or webp or gif type file')
                    },
                    onSizeErr: function (index, file) {
                        console.log(index, file, 'file size too big');
                        alert('File size too big');
                    }
                });
            }}

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

        function delete_row(em) {
            $(em).closest('.form-group').remove();
            update_sku();
        }

        function update_sku() {
            $.ajax({
                type: "POST",
                url: '{{ route('products.sku_combination') }}',
                data: $('#choice_form').serialize(),
                success: function (data) {
                    $('.sku_combination').html(data);
                }
            });
        }

        function get_subcategories_by_category() {
            var category_id = $('#category_id').val();
            $.post('{{ route('subcategories.get_subcategories_by_category') }}', {
                _token: '{{ csrf_token() }}',
                category_id: category_id
            }, function (data) {
                $('#subcategory_id').html(null);
                for (var i = 0; i < data.length; i++) {
                    $('#subcategory_id').append($('<option>', {
                        value: data[i].id,
                        text: data[i].name
                    }));
                }
                $("#subcategory_id > option").each(function () {
                    if (this.value == '{{$product->subcategory_id}}') {
                        $("#subcategory_id").val(this.value).change();
                    }
                });

                $('.demo-select2').select2();

                get_subsubcategories_by_subcategory();
            });
        }

        function get_subsubcategories_by_subcategory() {
            var subcategory_id = $('#subcategory_id').val();
            $.post('{{ route('subsubcategories.get_subsubcategories_by_subcategory') }}', {
                _token: '{{ csrf_token() }}',
                subcategory_id: subcategory_id
            }, function (data) {
                $('#subsubcategory_id').html(null);
                for (var i = 0; i < data.length; i++) {
                    $('#subsubcategory_id').append($('<option>', {
                        value: data[i].id,
                        text: data[i].name
                    }));
                }
                $("#subsubcategory_id > option").each(function () {
                    if (this.value == '{{$product->subsubcategory_id}}') {
                        $("#subsubcategory_id").val(this.value).change();
                    }
                });

                $('.demo-select2').select2();

                get_brands_by_subsubcategory();
            });
        }

        function get_brands_by_subsubcategory() {
            var subsubcategory_id = $('#subsubcategory_id').val();
            $.post('{{ route('subsubcategories.get_brands_by_subsubcategory') }}', {
                _token: '{{ csrf_token() }}',
                subsubcategory_id: subsubcategory_id
            }, function (data) {
                $('#brand_id').html(null);
                for (var i = 0; i < data.length; i++) {
                    $('#brand_id').append($('<option>', {
                        value: data[i].id,
                        text: data[i].name
                    }));
                }
                $("#brand_id > option").each(function () {
                    if (this.value == '{{$product->brand_id}}') {
                        $("#brand_id").val(this.value).change();
                    }
                });

                $('.demo-select2').select2();

            });
        }

        $(document).ready(function () {
            $('#container').removeClass('mainnav-lg').addClass('mainnav-sm');
            get_subcategories_by_category();
            $("#photos").spartanMultiImagePicker({
                fieldName: 'photos[]',
                maxCount: 10,
                rowHeight: '200px',
                groupClassName:   'col-md-4 col-sm-4 col-xs-6 @error("photos") is-invalid @enderror',
                maxFileSize:      '',
                allowedExt:       'jpg|jpeg|png|tiff|webp|gif',
                dropFileLabel : "Drop Here",
                onExtensionErr : function(index, file){
                    console.log(index, file,  'extension err');
                    alert('Please only input png or jpg or jpeg or tiff or webp or gif type file')
                },
                onSizeErr: function (index, file) {
                    console.log(index, file, 'file size too big');
                    alert('File size too big');
                }
            });
            $("#thumbnail_img").spartanMultiImagePicker({
                fieldName: 'thumbnail_img',
                maxCount: 1,
                rowHeight: '200px',
                groupClassName:   'col-md-4 col-sm-4 col-xs-6 @error("thumbnail_img") is-invalid @enderror',
                maxFileSize:      '',
                allowedExt:       'jpg|jpeg|png|tiff|webp|gif',
                dropFileLabel : "Drop Here",
                onExtensionErr : function(index, file){
                    console.log(index, file,  'extension err');
                    alert('Please only input png or jpg or jpeg or tiff or webp or gif type file')
                },
                onSizeErr: function (index, file) {
                    console.log(index, file, 'file size too big');
                    alert('File size too big');
                }
            });
            $("#featured_img").spartanMultiImagePicker({
                fieldName: 'featured_img',
                maxCount: 1,
                rowHeight: '200px',
                groupClassName:   'col-md-4 col-sm-4 col-xs-6 @error("featured_img") is-invalid @enderror',
                maxFileSize:      '',
                allowedExt:       'jpg|jpeg|png|tiff|webp|gif',
                dropFileLabel : "Drop Here",
                onExtensionErr : function(index, file){
                    console.log(index, file,  'extension err');
                    alert('Please only input png or jpg or jpeg or tiff or webp or gif type file')
                },
                onSizeErr: function (index, file) {
                    console.log(index, file, 'file size too big');
                    alert('File size too big');
                }
            });
            $("#flash_deal_img").spartanMultiImagePicker({
                fieldName: 'flash_deal_img',
                maxCount: 1,
                rowHeight: '200px',
                groupClassName:   'col-md-4 col-sm-4 col-xs-6 @error("flash_deal_img") is-invalid @enderror',
                maxFileSize:      '',
                allowedExt:       'jpg|jpeg|png|tiff|webp|gif',
                dropFileLabel : "Drop Here",
                onExtensionErr : function(index, file){
                    console.log(index, file,  'extension err');
                    alert('Please only input png or jpg or jpeg or tiff or webp or gif type file')
                },
                onSizeErr: function (index, file) {
                    console.log(index, file, 'file size too big');
                    alert('File size too big');
                }
            });
            $("#meta_photo").spartanMultiImagePicker({
                fieldName: 'meta_img',
                maxCount: 1,
                rowHeight: '200px',
                groupClassName:   'col-md-4 col-sm-4 col-xs-6 @error("meta_img") is-invalid @enderror',
                maxFileSize:      '',
                allowedExt:       'jpg|jpeg|png|tiff|webp|gif',
                dropFileLabel : "Drop Here",
                onExtensionErr : function(index, file){
                    console.log(index, file,  'extension err');
                    alert('Please only input png or jpg or jpeg or tiff or webp or gif type file')
                },
                onSizeErr: function (index, file) {
                    console.log(index, file, 'file size too big');
                    alert('File size too big');
                }
            });

            $('.remove-files').on('click', function () {
                $(this).parents(".col-md-4").remove();

            });
        });

        $('#category_id').on('change', function () {
            get_subcategories_by_category();
        });

        $('#subcategory_id').on('change', function () {
            get_subsubcategories_by_subcategory();
        });

        $('#subsubcategory_id').on('change', function () {
            get_brands_by_subsubcategory();
        });

    </script>

@endsection
