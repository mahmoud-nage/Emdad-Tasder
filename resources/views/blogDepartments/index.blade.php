@extends('layouts.app')

@section('content')

<div class="row">
    <div class="col-sm-12">
        <a href="{{ route('blogDepartment.create')}}" class="btn btn-rounded btn-info pull-right">{{__('Add New Blog Department')}}</a>
    </div>
</div>

<br>

<!-- Basic Data Tables -->
<!--===================================================-->
<div class="panel">
    <div class="panel-heading">
        <h3 class="panel-title">{{__('Blog Department')}}</h3>
    </div>
    <div class="panel-body">
        <table class="table table-striped table-bordered demo-dt-basic" cellspacing="0" width="100%">
            <thead>
            <tr>
                <th>#</th>
                <th>{{__('name_ar')}}</th>
                <th>{{__('name_en')}}</th>
                <th width="10%">{{__('Options')}}</th>
            </tr>
            </thead>
            <tbody>
            @foreach($blogDepartments as $key => $blog)
            <tr>
                <td>{{$key+1}}</td>
                <td>{{$blog->name_ar}}</td>
                <td>{{$blog->name_en}}</td>
                <td>
                  <div class="btn-group dropdown">
                     <button class="btn btn-primary dropdown-toggle dropdown-toggle-icon" data-toggle="dropdown" type="button">
                                    {{__('Actions')}} <i class="dropdown-caret"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-right">
                                    <li><a href="{{route('blogDepartment.edit', encrypt($blog->id))}}">{{__('Edit')}}</a></li>
                                    <li><a onclick="confirm_modal('{{route('blogDepartment.destroy', $blog->id)}}');">{{__('Delete')}}</a></li>
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

