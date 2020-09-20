@extends('layouts.app')

@section('content')

    <div class="row">
        <div class="col-sm-12">
            <a href="{{ route('notification.create')}}"
               class="btn btn-rounded btn-info pull-right">
                {{__('Add New Notification')}}</a>
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
                    <th>{{__('title')}}</th>
                    <th>{{__('body')}}</th>
                </tr>
                </thead>
                <tbody>
                @foreach($notifications as $key => $blog)
                    <tr>
                        <td>{{$key+1}}</td>
                        <td>{{$blog->title}}</td>
                        <td>{{$blog->body}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>


@endsection

