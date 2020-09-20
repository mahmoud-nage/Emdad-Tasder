@extends('layouts.app')

@section('content')

<div class="row">
    <div class="col-sm-12">
        <a href="{{ route('blog.create')}}" class="btn btn-rounded btn-info pull-right">{{__('Add New Blog')}}</a>
    </div>
</div>

<br>

<!-- Basic Data Tables -->
<!--===================================================-->
<div class="panel">
    <div class="panel-heading">
        <h3 class="panel-title">{{__('Blog')}}</h3>
    </div>
    <div class="panel-body">
        <table class="table table-striped table-bordered demo-dt-basic" cellspacing="0" width="100%">
            <thead>
            <tr>
                <th>#</th>
                <th>{{__('image')}}</th>
                <th>{{__('title')}}</th>
                <th>{{__('content')}}</th>
                <th>{{__('video')}}</th>
                <th width="10%">{{__('Options')}}</th>
            </tr>
            </thead>
            <tbody>
            @foreach($blogs as $key => $blog)
            <tr>
                <td>{{$key+1}}</td>
                <td><img style="width: 12rem;height: 12rem" src="{{asset($blog->image)}}"></td>
                <td>{{$blog->title}}</td>
                <td>{{$blog->article}}</td>
                <td><a href="{{$blog->video}}">Youtube Link</a></td>
                 <td>
                    <div class="btn-group dropdown">
                                <button class="btn btn-primary dropdown-toggle dropdown-toggle-icon" data-toggle="dropdown" type="button">
                                    {{__('Actions')}} <i class="dropdown-caret"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-right">
                                    <li><a href="{{route('blog.edit', encrypt($blog->id))}}">{{__('Edit')}}</a></li>
                                    <li><a onclick="confirm_modal('{{route('blog.destroy', $blog->id)}}');">{{__('Delete')}}</a></li>
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

