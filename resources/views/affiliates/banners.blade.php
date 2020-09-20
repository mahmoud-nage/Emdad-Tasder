@extends('layouts.app')

@section('content')


    <!--Tabs Content-->
    <div id="demo-lft-tab-2">

        <div class="row">
            <div class="col-sm-12">
                <a href="#" data-toggle="modal" data-target="#banners"
                   class="btn btn-rounded btn-info pull-right">{{__('Add New Banner')}}</a>
            </div>
        </div>

        <br>

        <div class="panel">
            <div class="panel-heading">
                <h3 class="panel-title">{{__('Home banner')}} (Max 3 published)</h3>
            </div>
            <div class="panel-body">
                <table class="table table-striped table-bordered demo-dt-basic" cellspacing="0" width="100%">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>{{__('Photo')}}</th>
                        <th>{{__('Type')}}</th>
                        <th width="10%">{{__('Options')}}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach(\App\BannerAffiliate::all() as $key => $banner)
                        <tr>
                            <td>{{$key+1}}</td>
                            <td><img class="img-md" src="{{ asset($banner->photo)}}" alt="banner Image"></td>
                            <td>{{ $banner->type }}</td>
                            <td>
                                <div class="btn-group dropdown">
                                    <button class="btn btn-primary dropdown-toggle dropdown-toggle-icon"
                                            data-toggle="dropdown" type="button">
                                        {{__('Actions')}} <i class="dropdown-caret"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-right">
                                        <li><a href="#" data-toggle="modal"
                                               data-target="#banners{{ $banner->id }}">{{__('Edit')}}</a></li>
                                        <li>
                                            <!--<a onclick="confirm_modal('{{route('affiliates.banners.destroy', $banner->id)}}');">{{__('Delete')}}</a>-->
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        <div class="modal fade" id="banners{{ $banner->id }}" tabindex="-1" role="dialog"
                             aria-labelledby="exampleModalLabel"
                             aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Edit Banner</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form class="form-horizontal"
                                          action="{{ route('affiliates.banners.update' , $banner->id) }}"
                                          method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="modal-body">

                                            <div class="panel-body">
                                                <div class="form-group">
                                                    <label class="col-sm-3" for="url">{{__('Type')}}</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" placeholder="{{__('Type')}}" id="type"
                                                               value="{{$banner->type}}"
                                                               name="type" class="form-control" required>
                                                    </div>
                                                </div>
                                                <br/>
                                                <div class="form-group">
                                                    <div class="col-sm-3">
                                                        <label class="control-label">{{__('Image')}}</label>
                                                    </div>
                                                    <div class="col-sm-9">
                                                        <img src="{{ asset($banner->photo) }}" width="200">
                                                        <input type="file" name="photo">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <div class="panel-footer text-right">
                                                <button class="btn btn-purple" type="submit">{{__('Save')}}</button>
                                            </div>
                                        </div>
                                    </form>

                                </div>
                            </div>
                        </div>

                    @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </div>
    <div class="modal fade" id="banners" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Banner</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form class="form-horizontal" action="{{ route('affiliates.banners.store') }}" method="POST"
                      enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">

                        <div class="panel-body">
                            <div class="form-group">
                                <label class="col-sm-3" for="url">{{__('Type')}}</label>
                                <div class="col-sm-9">
                                    <input type="text" placeholder="{{__('Type')}}" id="type" name="type"
                                           class="form-control" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-3">
                                    <label class="control-label">{{__('Banner Images')}}</label>
                                </div>
                                <div id="photo">

                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <div class="panel-footer text-right">
                            <button class="btn btn-purple" type="submit">{{__('Save')}}</button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>

@endsection

@section('script')
    <script type="text/javascript">
        $(document).ready(function () {
            $("#photo").spartanMultiImagePicker({
                fieldName: 'photo',
                maxCount: 1,
                rowHeight: '200px',
                groupClassName: 'col-md-4 col-sm-9 col-xs-6',
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

        function updateSettings(el, type) {
            if ($(el).is(':checked')) {
                var value = 1;
            } else {
                var value = 0;
            }
            $.post('{{ route('business_settings.update.activation') }}', {
                _token: '{{ csrf_token() }}',
                type: type,
                value: value
            }, function (data) {
                if (data == 1) {
                    showAlert('success', 'Settings updated successfully');
                } else {
                    showAlert('danger', 'Something went wrong');
                }
            });
        }

        function add_slider() {
            $.get('{{ route('sliders.create')}}', {}, function (data) {
                $('#demo-lft-tab-1').html(data);
            });
        }

        function add_banner_1() {
            $.get('{{ route('home_banners.create', 1)}}', {}, function (data) {
                $('#demo-lft-tab-2').html(data);
            });
        }

        function add_banner_2() {
            $.get('{{ route('home_banners.create', 2)}}', {}, function (data) {
                $('#demo-lft-tab-3').html(data);
            });
        }

        function edit_home_banner_1(id) {
            var url = '{{ route("home_banners.edit", "home_banner_id") }}';
            url = url.replace('home_banner_id', id);
            $.get(url, {}, function (data) {
                $('#demo-lft-tab-2').html(data);
                $('.demo-select2-placeholder').select2();
            });
        }

        function edit_home_banner_2(id) {
            var url = '{{ route("home_banners.edit", "home_banner_id") }}';
            url = url.replace('home_banner_id', id);
            $.get(url, {}, function (data) {
                $('#demo-lft-tab-3').html(data);
                $('.demo-select2-placeholder').select2();
            });
        }

        function add_home_category() {
            $.get('{{ route('home_categories.create')}}', {}, function (data) {
                $('#demo-lft-tab-4').html(data);
                $('.demo-select2-placeholder').select2();
            });
        }

        function edit_home_category(id) {
            var url = '{{ route("home_categories.edit", "home_category_id") }}';
            url = url.replace('home_category_id', id);
            $.get(url, {}, function (data) {
                $('#demo-lft-tab-4').html(data);
                $('.demo-select2-placeholder').select2();
            });
        }

        function update_home_category_status(el) {
            if (el.checked) {
                var status = 1;
            } else {
                var status = 0;
            }
            $.post('{{ route('home_categories.update_status') }}', {
                _token: '{{ csrf_token() }}',
                id: el.value,
                status: status
            }, function (data) {
                if (data == 1) {
                    showAlert('success', 'Home Page Category status updated successfully');
                } else {
                    showAlert('danger', 'Something went wrong');
                }
            });
        }

        function update_banner_published(el) {
            if (el.checked) {
                var status = 1;
            } else {
                var status = 0;
            }
            $.post('{{ route('home_banners.update_status') }}', {
                _token: '{{ csrf_token() }}',
                id: el.value,
                status: status
            }, function (data) {
                if (data == 1) {
                    showAlert('success', 'Banner status updated successfully');
                } else {
                    showAlert('danger', 'Maximum 4 banners to be published');
                }
            });
        }

        function update_slider_published(el) {
            if (el.checked) {
                var status = 1;
            } else {
                var status = 0;
            }
            var url = '{{ route('sliders.update', 'slider_id') }}';
            url = url.replace('slider_id', el.value);

            $.post(url, {_token: '{{ csrf_token() }}', status: status, _method: 'PATCH'}, function (data) {
                if (data == 1) {
                    showAlert('success', 'Published sliders updated successfully');
                } else {
                    showAlert('danger', 'Something went wrong');
                }
            });
        }
    </script>

@endsection
