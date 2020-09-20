@extends('layouts.app')

@section('content')

    <div class="row">
        <form class="form form-horizontal mar-top" action="{{route('products.store')}}" method="POST"
              enctype="multipart/form-data" id="choice_form">
            @csrf
            <input type="hidden" name="added_by" value="admin">
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
                                               value="{{old('name_ar')}}" name="name_ar"
                                               placeholder="{{__('Product Name Ar')}}" required>
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
                                               value="{{old('name_en')}}" name="name_en"
                                               placeholder="{{__('Product Name En')}}" oninvalid="alert('You must fill Product Name En!');" required>
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
                                                name="category_id" id="category_id" oninvalid="alert('You must fill Product Category!');" required>
                                            @foreach($categories as $category)
                                                <option value="{{$category->id}}">
                                                    {{ \App::isLocale('ar') ? $category->name_ar : $category->name_en }} &nbsp;
                                                </option>
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
                                                name="subcategory_id" id="subcategory_id" oninvalid="alert('You must fill Product Subcategory!');" required>

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
                                                <option value="{{$unit->id}}">
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
                                               name="tags[]" placeholder="Type to add a tag" data-role="tagsinput">
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
                                    <label
                                        class="col-lg-2 control-label @error('photos') is-invalid @enderror">{{__('Main Images')}}
                                        <span class="text-danger">*</span>
                                        <br><small class="text-danger text-xs">Ext Only: (jpg|jpeg|png|tiff|webp|gif)</small>
                                        <br><small class="text-danger text-xs">Best Size: (450*450)</small>

                                    </label>
                                    <div class="col-lg-7">
                                        <div id="photos">

                                        </div><br>
                                        @error('photos')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label
                                        class="col-lg-2 control-label @error('thumbnail_img') is-invalid @enderror">{{__('Thumbnail Image')}}
                                        <span class="text-danger">*</span>
                                        <br><small class="text-danger text-xs">Ext Only: (jpg|jpeg|png|tiff|webp|gif)</small>
                                        <br><small class="text-danger text-xs">Best Size: (200*230)</small>

                                    </label>
                                    <div class="col-lg-7">
                                        <div id="thumbnail_img">

                                        </div>
                                        @error('thumbnail_img')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label
                                        class="col-lg-2 control-label @error('featured_img') is-invalid @enderror">{{__('Featured')}}
                                        <span class="text-danger">*</span>
                                        <br><small class="text-danger text-xs">Ext Only: (jpg|jpeg|png|tiff|webp|gif)</small>
                                        <br><small class="text-danger text-xs">Best Size: (200*230)</small>
                                    </label>
                                    <div class="col-lg-7">
                                        <div id="featured_img">

                                        </div>
                                        @error('featured_img')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label
                                        class="col-lg-2 control-label @error('flash_deal_img') is-invalid @enderror">{{__('Flash Deal')}}
                                        <span class="text-danger">*</span>
                                        <br><small class="text-danger text-xs">Ext Only: (jpg|jpeg|png|tiff|webp|gif)</small>
                                        <br><small class="text-danger text-xs">Best Size: (200*230)</small>
                                    </label>
                                    <div class="col-lg-7">
                                        <div id="flash_deal_img">

                                        </div>
                                        @error('flash_deal_img')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div id="demo-stk-lft-tab-4" class="tab-pane fade">
                                <div class="form-group">
                                    <label class="col-lg-2 control-label">{{__('Meta Title')}}
                                    </label>
                                    <div class="col-lg-7">
                                        <input type="text" class="form-control @error('meta_title') is-invalid @enderror"
                                               value="{{old('meta_title')}}" name="meta_title"
                                               placeholder="{{__('Meta Title')}}">
                                        @error('meta_title')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-2 control-label">{{__('Description')}}
                                    </label>
                                    <div class="col-lg-7">
                                    <textarea name="meta_description" rows="8"
                                              class="form-control @error('meta_description') is-invalid @enderror">{{old('meta_description')}}</textarea>
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
                                        <br><small class="text-danger text-xs">Best Size: (200*230)</small>
                                    </label>
                                    <div class="col-lg-7">
                                        <div id="meta_photo">

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
                                                           class="form-control @error('unit_price') is-invalid @enderror" oninvalid="alert('You must fill Product Unit price!');" required>
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
                                                           name="tax[]" value="0"
                                                           class="form-control @error('tax') is-invalid @enderror" required>
                                                    @error('tax')
                                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                                    @enderror
                                                </div>
                                                <div class="col-lg-1">
                                                    <select class="select2  @error('tax_type') is-invalid @enderror"
                                                            name="tax_type[]" required>
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
                                                           name="discount[]"
                                                           class="form-control @error('discount') is-invalid @enderror" value="0"
                                                           required>
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
                                            <div class="sku_combination" id="sku_combination">
                                            </div>
                                        </div>

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
                                          name="description_ar" oninvalid="alert('You must fill Product Description Ar!');" required>{{old('description_ar')}}</textarea>
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
                                          name="description_en" oninvalid="alert('You must fill Product Description En!');" required>{{old('description_en')}}</textarea>
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
                                        <input type="date" class="form-control" name="Season_from">
                                    </div>

                                    <label class="col-sm-2 control-label" for="start_date">
                                        {{__('Date To')}}
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-sm-4">
                                        <input type="date" class="form-control" name="Season_to">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-lg-2 control-label">{{__('Season Msg Ar')}}
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-lg-9">
                            <textarea class="editor @error('Season_msg_ar') is-invalid @enderror"
                                      name="Season_msg_ar" oninvalid="alert('You must fill Product Season Msg Ar!');" required>{{old('Season_msg_ar')}}</textarea>
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
                                      name="Season_msg_en" oninvalid="alert('You must fill Product Season Msg En!');" required>{{old('Season_msg_en')}}</textarea>
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
                    <button type="submit" name="button" class="btn btn-info">{{ __('Save') }}</button>
                </div>
            </div>
        </form>
    </div>

@endsection

@section('script')

    <script type="text/javascript">
        var i = 0;
        var ii = 0;
        let x, val, countries;
        countries = {!! \App\Country::all() !!};

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

            if($("#choice_photos"+el1+" input[type='file']").length){
                console.log($("input[name='"+name+"']").length, name);
            }else{
                $("#choice_photos"+el1).spartanMultiImagePicker({
                    fieldName: 'choice_photos'+$("#choice_photos"+el1).data('id_1')+'_'+$("#choice_options_" + el1).val(),
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
            }

        }

        $(".countries_num").keyup(function () {
            val = $(this).val();
            $(".prices").html(' ');
            if (val > 0) {
                for (x = 0; x < val; x++) {
                    $(".prices").append('<div class="form-group"><label class="col-lg-2 control-label">Country</label><div class="col-lg-7"><select name="country[]" class="form-control select2" required><option value="">Select Country</option>@foreach(\App\Country::all() as $country)<option value="{{ $country->id }}">{{ $country->name }}</option>@endforeach</select></div></div><div class="form-group"><label class="col-lg-2 control-label">Unit price</label><div class="col-lg-7"><input type="number" min="0" value="0" step="0.01" placeholder="Unit price" name="unit_price[]" class="form-control" required></div></div><div class="form-group"><label class="col-lg-2 control-label">Purchase price</label><div class="col-lg-7"><input type="number" min="0" value="0" step="0.01" placeholder="Purchase price" name="purchase_price[]" class="form-control" required></div></div><div class="form-group"><label class="col-lg-2 control-label">Tax</label><div class="col-lg-7"><input type="number" min="0" value="0" step="0.01" placeholder="Tax" name="tax[]" class="form-control" required></div><div class="col-lg-1"><select class="select2" name="tax_type[]"><option value="amount">$</option><option value="percent">%</option></select></div></div><div class="form-group"><label class="col-lg-2 control-label">Discount</label><div class="col-lg-7"><input type="number" min="0" value="0" step="0.01" placeholder="Discount" name="discount[]" class="form-control" required></div><div class="col-lg-1"><select class="select2" name="discount_type[]"><option value="amount">$</option><option value="percent">%</option></select></div></div><hr><div class="sku_combination" id="sku_combination"></div>');
                }
            }
            update_sku();
            $('.demo-select2').select2();
        });
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
                    $('.demo-select2').select2();
                }
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
                    $('.demo-select2').select2();
                }
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
                    $('.demo-select2').select2();
                }
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
