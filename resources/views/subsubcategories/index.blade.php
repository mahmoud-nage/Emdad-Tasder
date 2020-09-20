@extends('layouts.app')

@section('content')

    <div class="row">
        <div class="col-sm-12">
            <a href="{{ route('subsubcategories.create')}}"
               class="btn btn-rounded btn-info pull-right">{{__('Add New Sub Subcategory')}}</a>
        </div>
    </div>

    <br>

    <!-- Basic Data Tables -->
    <!--===================================================-->
    <div class="panel">
        <div class="panel-heading">
            <h3 class="panel-title">{{__('Subsubcategories')}}</h3>
        </div>
        <div class="panel-body">
            <table class="table table-striped table-bordered demo-dt-basic" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th>#</th>
                    <th>{{__('Sub Subcategory')}}</th>
                    <th>{{__('Subcategory')}}</th>
                    <th>{{__('Category')}}</th>
                    <th>{{__('Brands')}}</th>
                    <th>{{__('Image')}}</th>
                    <th>{{__('Featured')}}</th>
                    <th width="10%">{{__('Options')}}</th>
                </tr>
                </thead>
                <tbody>
                @foreach($subsubcategories as $key => $subsubcategory)
                    <tr>
                        <td>{{$key+1}}</td>
                        <td>{{__($subsubcategory->name_en)}}</td>
                        <td>{{$subsubcategory->subcategory->name_en}}</td>
                        <td>{{$subsubcategory->subcategory->category->name_en}}</td>
                        <td>
                            @php
                                $jsonArrayBrands = json_decode($subsubcategory->brands);
                            @endphp
                            @if(isset($jsonArrayBrands)&&!is_null($jsonArrayBrands)&&is_array($jsonArrayBrands))
                                @foreach(json_decode($subsubcategory->brands) as $brand_id)
                                    @if (\App\Brand::find($brand_id) != null)
                                        <span class="badge badge-info">{{\App\Brand::find($brand_id)->name}}</span>
                                    @endif
                                @endforeach
                            @endif

                        </td>
                        <td><img class="img-md" src="{{ asset($subsubcategory->image) }}" alt="{{__('Image')}}"></td>
                        <td>
                            <label class="switch">
                            <input onchange="update_featured(this)" value="{{ $subsubcategory->id }}" type="checkbox" <?php if($subsubcategory->featured == 1) echo "checked";?> >
                            <span class="slider round"></span></label></td>
                        <td>
                            <div class="btn-group dropdown">
                                <button class="btn btn-primary dropdown-toggle dropdown-toggle-icon"
                                        data-toggle="dropdown" type="button">
                                    {{__('Actions')}} <i class="dropdown-caret"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-right">
                                    <li>
                                        <a href="{{route('subsubcategories.edit', encrypt($subsubcategory->id))}}">{{__('Edit')}}</a>
                                    </li>
                                    <li>
                                        <!--<a onclick="confirm_modal('{{route('subsubcategories.destroy', $subsubcategory->id)}}');">{{__('Delete')}}</a>-->
                                    </li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

        </div>
    </div>

@endsection
@section('script')
    <script type="text/javascript">
        function update_featured(el){
            if(el.checked){
                var status = 1;
            }
            else{
                var status = 0;
            }
            $.post('{{ route('subsubcategories.featured') }}', {_token:'{{ csrf_token() }}', id:el.value, status:status}, function(data){
                if(data == 1){
                    showAlert('success', 'Featured subsubcategories updated successfully');
                }
                else{
                    showAlert('danger', 'Something went wrong');
                }
            });
        }
    </script>
@endsection
