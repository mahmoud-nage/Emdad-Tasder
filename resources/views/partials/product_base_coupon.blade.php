<div class="panel-heading">
    <h3 class="panel-title">{{__('Add Your Product Base Coupon')}}</h3>
</div>
<div class="form-group">
    <label class="col-lg-3 control-label" for="coupon_code">{{__('Coupon code')}}
        <span class="text-danger">*</span>
    </label>
    <div class="col-lg-9">
        <input type="text" placeholder="{{__('Coupon code')}}" id="coupon_code" name="coupon_code" class="form-control @error('coupon_code') is-invalid @enderror" value="{{old('coupon_code')}}" required>
        @error('coupon_code')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
</div>
<div class="product-choose-list">
    <div class="product-choose">
        <div class="form-group">
           <label class="col-lg-3 control-label">{{__('Category')}}
            <span class="text-danger">*</span>
        </label>
           <div class="col-lg-9">
              <select class="form-control category_id select2 @error('category_ids') is-invalid @enderror" name="category_ids[]" required>
                  <option value="" selected disabled>Select Category</option>
                 @foreach(\App\Category::all() as $key => $category)
                     <option value="{{$category->id}}">{{$category->name_en}}</option>
                 @endforeach
              </select>
              @error('category_ids')
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
              </span>
              @enderror
           </div>
        </div>
        <div class="form-group" id="subcategory">
           <label class="col-lg-3 control-label">{{__('Sub Category')}}
            <span class="text-danger">*</span>
        </label>
           <div class="col-lg-9">
              <select class="form-control subcategory_id select2 @error('subcategory_ids') is-invalid @enderror" name="subcategory_ids[]" required>

              </select>
              @error('subcategory_ids')
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
              </span>
              @enderror
           </div>
        </div>
        <div class="form-group" id="subsubcategory">
           <label class="col-lg-3 control-label">{{__('Sub Sub Category')}}
            <span class="text-danger">*</span>
        </label>
           <div class="col-lg-9">
              <select class="form-control subsubcategory_id select2 @error('subsubcategory_ids') is-invalid @enderror" name="subsubcategory_ids[]" required>

              </select>
              @error('subsubcategory_ids')
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
              </span>
              @enderror
           </div>
        </div>
        <div class="form-group">
            <label class="col-lg-3 control-label" for="name">{{__('Product')}}
                <span class="text-danger">*</span>
            </label>
            <div class="col-lg-9">
                <select name="product_ids[]" class="form-control product_id select2 @error('product_ids') is-invalid @enderror" required>

                </select>
                @error('product_ids')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>
        <hr>
    </div>
</div>
<div class="more hide">
    <div class="product-choose">
        <div class="form-group">
           <label class="col-lg-3 control-label">{{__('Category')}}
            <span class="text-danger">*</span>
        </label>
           <div class="col-lg-9">
              <select class="form-control category_id @error('category_ids') is-invalid @enderror" name="category_ids[]" onchange="get_subcategories_by_category(this)">
                 <option value="" selected disabled>Select Category</option>
                 @foreach(\App\Category::all() as $key => $category)
                     <option value="{{$category->id}}">{{$category->name_en}}</option>
                 @endforeach
              </select>
              @error('category_ids')
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
              </span>
              @enderror
           </div>
        </div>
        <div class="form-group" id="subcategory">
           <label class="col-lg-3 control-label">{{__('Subcategory')}}
            <span class="text-danger">*</span>
        </label>
           <div class="col-lg-9">
              <select class="form-control subcategory_id @error('subcategory_ids') is-invalid @enderror" name="subcategory_ids[]" onchange="get_subsubcategories_by_subcategory(this)">

              </select>
              @error('subcategory_ids')
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
              </span>
              @enderror
           </div>
        </div>
        <div class="form-group" id="subsubcategory">
           <label class="col-lg-3 control-label">{{__('Sub Sub Category')}}
            <span class="text-danger">*</span>
        </label>
           <div class="col-lg-9">
              <select class="form-control subsubcategory_id @error('subsubcategory_ids') is-invalid @enderror" name="subsubcategory_ids[]" onchange="get_products_by_subsubcategory(this)">

              </select>
              @error('subsubcategory_ids')
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
              </span>
              @enderror
           </div>
        </div>
        <div class="form-group">
            <label class="col-lg-3 control-label" for="name">{{__('Product')}}
                <span class="text-danger">*</span>
            </label>
            <div class="col-lg-9">
                <select name="product_ids[]" class="form-control product_id @error('product_ids') is-invalid @enderror">

                </select>
                @error('product_ids')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>
        <hr>
    </div>
</div>
<div class="text-right">
    <button class="btn btn-primary" type="button" name="button" onclick="appendNewProductChoose()">{{ __('Add More') }}</button>
</div>
<br>
<div class="form-group">
    <label class="col-lg-3 control-label" for="start_date">{{__('Date')}}
        <span class="text-danger">*</span>
    </label>
    <div class="col-lg-9">
        <div id="demo-dp-range">
            <div class="input-daterange input-group" id="datepicker">
                <input type="text" class="form-control @error('start_date') is-invalid @enderror" name="start_date" value="{{old('start_date')}}">
                @error('start_date')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
                <span class="input-group-addon">{{__('to')}}</span>
                <input type="text" class="form-control @error('end_date') is-invalid @enderror" name="end_date" value="{{old('end_date')}}">
                @error('end_date')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>
    </div>
</div>
<div class="form-group">
   <label class="col-lg-3 control-label">{{__('Discount')}}
    <span class="text-danger">*</span>
</label>
   <div class="col-lg-8">
      <input type="number" min="0" step="0.01" placeholder="{{__('Discount')}}" name="discount" value="{{old('discount')}}" class="form-control @error('discount') is-invalid @enderror" required>
      @error('coupon_code')
      <span class="invalid-feedback" role="alert">
          <strong>{{ $message }}</strong>
      </span>
      @enderror
   </div>
   <div class="col-lg-1">
      <select class="select2 @error('discount_type') is-invalid @enderror" name="discount_type">
         <option value="amount">LE</option>
         <option value="percent">%</option>
      </select>
      @error('discount_type')
      <span class="invalid-feedback" role="alert">
          <strong>{{ $message }}</strong>
      </span>
      @enderror
   </div>
</div>


<script type="text/javascript">

    function appendNewProductChoose(){
        $('.product-choose-list').append($('.more').html());
        $('.product-choose-list').find('.product-choose').last().find('.category_id').select2();
    }

    function get_subcategories_by_category(el){
		var category_id = $(el).val();
        console.log(category_id);
        $(el).closest('.product-choose').find('.subcategory_id').html(null);
		$.post('{{ route('subcategories.get_subcategories_by_category') }}',{_token:'{{ csrf_token() }}', category_id:category_id}, function(data){
		    for (var i = 0; i < data.length; i++) {
		      
		        $(el).closest('.product-choose').find('.subcategory_id').append($('<option>', {
		            value: data[i].id,
		            text: data[i].name
		        }));
		    }
            $(el).closest('.product-choose').find('.subcategory_id').select2();
		    get_subsubcategories_by_subcategory($(el).closest('.product-choose').find('.subcategory_id'));
		});
	}

    function get_subsubcategories_by_subcategory(el){
		var subcategory_id = $(el).val();
        console.log(subcategory_id);
        $(el).closest('.product-choose').find('.subsubcategory_id').html(null);
		$.post('{{ route('subsubcategories.get_subsubcategories_by_subcategory') }}',{_token:'{{ csrf_token() }}', subcategory_id:subcategory_id}, function(data){
		    for (var i = 0; i < data.length; i++) {
		      //  console.log(data[i].name);
		        $(el).closest('.product-choose').find('.subsubcategory_id').append($('<option>', {
		            value: data[i].id,
		            text: data[i].name
		        }));
		    }
            $(el).closest('.product-choose').find('.subsubcategory_id').select2();
		    get_products_by_subsubcategory($(el).closest('.product-choose').find('.subsubcategory_id'));
		});
	}

    function get_products_by_subsubcategory(el){
        var subsubcategory_id = $(el).val();
        console.log(subsubcategory_id);
        $(el).closest('.product-choose').find('.product_id').html(null);
        $.post('{{ route('products.get_products_by_subsubcategory') }}',{_token:'{{ csrf_token() }}', subsubcategory_id:subsubcategory_id}, function(data){
            for (var i = 0; i < data.length; i++) {
                $(el).closest('.product-choose').find('.product_id').append($('<option>', {
                    value: data[i].id,
                    text: data[i].name_en
                }));
            }
            $(el).closest('.product-choose').find('.product_id').select2();
        });
    }

    $(document).ready(function(){
        $('.demo-select2').select2();
        //get_subcategories_by_category($('.category_id'));
    });

    $('.category_id').on('change', function() {
        get_subcategories_by_category(this);
    });

    $('.subcategory_id').on('change', function() {
	    get_subsubcategories_by_subcategory(this);
	});

    $('.subsubcategory_id').on('change', function() {
 	    get_products_by_subsubcategory(this);
 	});


</script>
