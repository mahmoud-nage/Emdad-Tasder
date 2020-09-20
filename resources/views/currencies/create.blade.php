@extends('layouts.app')

@section('content')

    <div class="col-lg-6 col-lg-offset-3">
        <div class="panel">
            <div class="panel-heading">
                <h3 class="panel-title">{{__('Create Currency')}}</h3>
            </div>

            <!--Horizontal Form-->
            <!--===================================================-->
            <form class="form-horizontal" action="{{ route('currencies.store') }}" method="POST"
                  enctype="multipart/form-data">
                @csrf
                <div class="panel-body">
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="name_ar">{{__('Name AR')}}</label>
                        <div class="col-sm-10">
                            <input type="text" placeholder="{{__('Name AR')}}" id="name_ar" name="name_ar" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="name_en">{{__('Name EN')}}</label>
                        <div class="col-sm-10">
                            <input type="text" placeholder="{{__('Name EN')}}" id="name_en" name="name_en" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="symbol">{{__('Symbol')}}</label>
                        <div class="col-sm-10">
                            <input type="text" placeholder="{{__('Symbol')}}" id="symbol" name="symbol" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="exchange_rate">{{__('Exchange rate')}}</label>
                        <div class="col-sm-10">
                            <input type="text" placeholder="{{__('Exchange rate')}}" id="exchange_rate" name="exchange_rate" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="code">{{__('Code')}}</label>
                        <div class="col-sm-10">
                            <input type="text" placeholder="{{__('Code')}}" id="code" name="code" class="form-control" required>
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
    </div>

@endsection
@section('script')
    <script>
        $('document').ready(function () {
            $('.demo-select2').select2();
            $("#icon").spartanMultiImagePicker({
                fieldName: 'icon',
                maxCount: 1,
                rowHeight: '200px',
                groupClassName: 'col-md-4 col-sm-4 col-xs-6',
                maxFileSize: '',
                dropFileLabel: "Drop Here",
                onExtensionErr: function (index, file) {
                    console.log(index, file, 'extension err');
                    alert('Please only input png or jpg type file')
                },
                onSizeErr: function (index, file) {
                    console.log(index, file, 'file size too big');
                    alert('File size too big');
                }
            });
        });
    </script>
@stop
