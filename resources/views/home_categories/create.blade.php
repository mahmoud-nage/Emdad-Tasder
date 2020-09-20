<div class="panel">
    <div class="panel-heading">
        <h3 class="panel-title">{{__('Home Categories')}}</h3>
    </div>

    <!--Horizontal Form-->
    <!--===================================================-->
    <form class="form-horizontal" action="{{ route('home_categories.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="type" value="{{$type}}">
        <div class="panel-body">
            <div class="form-group" id="category">
                <label class="col-lg-2 control-label">{{__('Category')}}</label>
                <div class="col-lg-7">
                    <select class="form-control select2" name="category_id" id="category_id" required>
                        @foreach(\App\Category::where('type', $type)->get() as $category)
                            @if (\App\HomeCategory::where('category_id', $category->id)->first() == null)
                                <option value="{{$category->id}}">{{__($category['name_'.app()->getLocale()])}}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
            </div>
            
             <div class="form-group" id="subcategory">
                                <label class="col-lg-2 control-label">{{__('Subcategory')}}
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="col-lg-7">
                                    <select class="form-control select2 @error('subcategory_id') is-invalid @enderror"
                                        name="subcategory_id" id="subcategory_id" required>

                                    </select>
                                    @error('subcategory_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
            
            <div class="form-group" id="subsubcategory">
                <label class="col-lg-2 control-label">{{__('Sub Subcategory')}}</label>
                <div class="col-lg-7">
                    <select class="form-control select2-max-4" name="subsubcategories[]" id="subsubcategory_id" data-placeholder="Choose Options (max 4)" multiple required>
                        
                    </select>
                </div>
            </div>
        </div>
        <div class="panel-footer text-right">
            <button class="btn btn-purple" type="submit">{{__('Save')}}</button>
        </div>
    </form>
    <!--===================================================-->
    <!--End Horizontal Form-->

</div>

<script type="text/javascript">

    $(document).ready(function(){
        
        
        
        $('#category_id').on('change', function () {
            get_subcategories_by_category();
        });

        $('#subcategory_id').on('change', function () {
            get_subsubcategories_by_subcategory();
        });

        $('#subsubcategory_id').on('change', function () {
            get_brands_by_subsubcategory();
        });
        
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
                get_subsubcategories_by_subcategory();
            });
        }

        function get_subsubcategories_by_subcategory() {
            var subcategory_id = $('#subcategory_id').val();
            $.post('{{ route('subsubcategories.get_subsubcategories_by_subcategory') }}', {
                _token: '{{ csrf_token() }}',
                subcategory_id: subcategory_id
            }, function (data) {
                console.log(data);
                $('#subsubcategory_id').html(null);
                for (var i = 0; i < data.length; i++) {
                    $('#subsubcategory_id').append($('<option>', {
                        value: data[i].id,
                        text: data[i].name +' ('+data[i].number_of_products+' products)'
                    }));
                    $(".demo-select2-max-4").select2({
                        maximumSelectionLength: 4
                    });
                    $(".demo-select2-max-4").on("select2:select", function (evt) {
                		  var element = evt.params.data.element;
                		  var $element = $(element);
                		  $element.detach();
                		  $(this).append($element);
                		  $(this).trigger("change");
                	});
                }
            });
        }
        
        

        get_subcategories_by_category();
        get_subsubcategories_by_subcategory();

    });
</script>
