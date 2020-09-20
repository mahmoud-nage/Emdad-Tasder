@extends('layouts.app')

@section('content')

<div class="col-sm-12">
    <div class="panel">
        <div class="panel-heading">
            <h3 class="panel-title">{{__('Flash Deal Information')}}</h3>
        </div>

        <!--Horizontal Form-->
        <!--===================================================-->
        <form class="form-horizontal" action="{{ route('flash_deals.update', $flash_deal->id) }}" method="POST"
            enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="_method" value="PATCH">
            <div class="panel-body">
                <div class="form-group">
                    <label class="col-sm-3 control-label" for="name">{{__('Title Ar')}}</label>
                    <div class="col-sm-9">
                        <input type="text" placeholder="{{__('Title Ar')}}" id="name" name="title_ar"
                            value="{{ $flash_deal->title_ar }}" class="form-control" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label" for="name">{{__('Title En')}}</label>
                    <div class="col-sm-9">
                        <input type="text" placeholder="{{__('Title En')}}" id="name" name="title_en"
                            value="{{ $flash_deal->title_en }}" class="form-control" required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-lg-3 control-label">{{__('Image')}}
                        <span class="text-danger">*</span>
                        <br><small class="text-danger text-xs">Ext Only: (jpg|jpeg|png|tiff|webp|gif)</small>
                        <br><small class="text-danger text-xs">Best Size: (200*200)</small>                                </label>
                    <div class="col-lg-9">
                        <div id="photo">
                            @if ($flash_deal->photo != null)
                                <div class="col-md-4 col-sm-4 col-xs-6">
                                    <div class="img-upload-preview">
                                        <img src="{{ asset($flash_deal->photo) }}" alt=""
                                             class="img-responsive">
                                        <input type="hidden" name="previous_thumbnail_img"
                                               value="{{ $flash_deal->photo }}">
                                        <button type="button" class="btn btn-danger close-btn remove-files"><i
                                                class="fa fa-times"></i></button>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                    @error('photo')
                    <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                    @enderror
                </div>


                <div class="form-group">
                    <label class="col-sm-3 control-label" for="name">{{__('Country')}}
                                        <span class='text-danger'>*</span>
</label>
                    <div class="col-sm-9">
                        <select name="country_id" id="country" required class="form-control select2  @error('country_id') is-invalid @enderror">
                            @foreach($countries as $country)
                                <option value="{{$country->id}}" @if($country->id == $flash_deal->country_id) selected @endif>{{__($country->name_en)}}</option>
                            @endforeach
                        </select>
                        @error('country_id')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                      @enderror
                    </div>
                </div>


                <div class="form-group">
                    <label class="col-sm-3 control-label" for="start_date">{{__('Date')}}</label>
                    <div class="col-sm-9">
                        <div id="demo-dp-range">
                            <div class="input-daterange input-group" id="datepicker">
                                <input type="text" class="form-control" name="start_date"
                                    value="{{ date('m/d/Y', $flash_deal->start_date) }}">
                                <span class="input-group-addon">{{__('to')}}</span>
                                <input type="text" class="form-control" name="end_date"
                                    value="{{ date('m/d/Y', $flash_deal->end_date) }}">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-3 control-label" for="products">{{__('Products')}}</label>
                    <div class="col-sm-9">
                        <select name="product_countries[]" id="products" class="form-control select2" multiple required
                            data-placeholder="Choose Products">
                            @foreach(\Illuminate\Support\Facades\DB::table('product_countries')->where('country_id', $flash_deal->country_id)->latest()->get() as
                            $productCountry)
                            @php
                            $product = \App\Product::find($productCountry->product_id);
                            $country = \App\Country::find($flash_deal->country_id);
                            $flash_deal_product = \App\FlashDealProduct::where('flash_deal_id',
                            $flash_deal->id)->where('product_id', $productCountry->product_id)
                            ->where('country_id', $productCountry->country_id)->first();
                            @endphp
                            <option value="{{$productCountry->id}}"
                                <?php if($flash_deal_product != null) echo "selected";?>> @if($product != null &&
                                $country != null) {{$product->name_en}} - {{ $country->name_en }} @endif</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <br>
                <div class="form-group" id="discount_table">

                </div>
            </div>
            <div class="panel-footer text-right">
                <button class="btn btn-purple" type="submit">{{__('Save')}}</button>
            </div>
        </form>
        <!--===================================================-->
        <!--End Horizontal Form-->

    </div>
</div>

@endsection

@section('script')
<script type="text/javascript">
    $(document).ready(function(){

            get_flash_deal_discount();

            $('#products').on('change', function(){
                get_flash_deal_discount();
            });

            function get_flash_deal_discount(){
                var product_ids = $('#products').val();
                if(product_ids.length > 0){
                    $.post('{{ route('flash_deals.product_discount_edit') }}', {_token:'{{ csrf_token() }}', product_ids:product_ids, flash_deal_id:{{ $flash_deal->id }}}, function(data){
                        $('#discount_table').html(data);
                        $('.demo-select2').select2();
                    });
                }
                else{
                    $('#discount_table').html(null);
                }
            }

                        $('#country').on('change', function(){
                var country_id = $('#country').val();
                    $.get('{{ route('flash_deals.country.products') }}', {country_id:country_id}, function(data){
                        console.log(data);
                                $('#products').find('option').remove().end();
                                $.each(data.data, function(k, v) {
                                    $('#products').append('<option value='+ v.id +'>'+ v.name_en +' - '+ v.country_name +'</option>');
                                });
                    });
            });
        $("#photo").spartanMultiImagePicker({
            fieldName: 'photo',
            maxCount: 1,
            rowHeight: '200px',
            groupClassName:   'col-md-4 col-sm-4 col-xs-6 @error("photo") is-invalid @enderror',
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
</script>
@endsection
