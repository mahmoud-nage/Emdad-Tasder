@extends('layouts.app')

@section('content')

<div class="tab-base">

    <!--Nav Tabs-->
    <ul class="nav nav-tabs">
        <li class="active">
            <a data-toggle="tab" href="#demo-lft-tab-1" aria-expanded="true">{{ __('Home Man slider') }}</a>
        </li>
        <li class="">
            <a data-toggle="tab" href="#demo-lft-tab-10" aria-expanded="true">{{ __('Home Women slider') }}</a>
        </li>
        <li class="">
            <a data-toggle="tab" href="#demo-lft-tab-2" aria-expanded="false">{{ __('Home banner') }}</a>
        </li>
        <!--{{-- <li class="">-->
        <!--    <a data-toggle="tab" href="#demo-lft-tab-3" aria-expanded="false">{{ __('Home Women banner') }}</a>-->
        <!--</li> --}}-->
        <!--<li class="">-->
        <!--    <a data-toggle="tab" href="#demo-lft-tab-4" aria-expanded="false">{{ __('Home Man categories') }}</a>-->
        <!--</li>-->
        <!--<li class="">-->
        <!--    <a data-toggle="tab" href="#demo-lft-tab-9" aria-expanded="false">{{ __('Home Women categories') }}</a>-->
        <!--</li>-->
        <li class="">
            <a data-toggle="tab" href="#demo-lft-tab-5" aria-expanded="true">{{ __('App Man slider') }}</a>
        </li>
         <li class="">
            <a data-toggle="tab" href="#demo-lft-tab-6" aria-expanded="false">{{ __('App Women slider') }}</a>
        </li>
        <li class="">
            <a data-toggle="tab" href="#demo-lft-tab-7" aria-expanded="false">{{ __('App banner') }}</a>
        </li>
        <li class="">
            <a data-toggle="tab" href="#demo-lft-tab-8" aria-expanded="false">{{ __('Main banner') }}</a>
        </li>
    </ul>

    <!--Tabs Content-->
    <div class="tab-content">
        <div id="demo-lft-tab-1" class="tab-pane fade active in">

            <div class="row">
                <div class="col-sm-12">
                    <a onclick="add_slider('web',1,0)"
                        class="btn btn-rounded btn-info pull-right">{{__('Add New Slider')}}</a>
                </div>
            </div>

            <br>

            <div class="panel">
                <div class="panel-heading">
                    <h3 class="panel-title">{{__('Home Man slider')}}</h3>
                </div>
                <div class="panel-body">
                    <table class="table table-striped table-bordered demo-dt-basic" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>{{__('Photo')}}</th>
                                <th>{{__('Country')}}</th>
                                <th>{{__('Published')}}</th>
                                <th width="10%">{{__('Options')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach(\App\Slider::where('type' , 'web')->where('type1',1)->where('type2',0)->get() as
                            $key => $slider)
                            <tr>
                                <td>{{$key+1}}</td>
                                <td><img class="img-md" src="{{ asset($slider->photo)}}" alt="Slider Image"></td>
                                <td>{{ $countries->where('id',$slider->country_id)->first()['name_'.app()->getLocale()] }}</td>
                                <td><label class="switch">
                                        <input onchange="update_slider_published(this)" value="{{ $slider->id }}"
                                            type="checkbox" <?php if($slider->published == 1) echo "checked";?>>
                                        <span class="slider round"></span></label></td>
                                <td>
                                    <div class="btn-group dropdown">
                                        <button class="btn btn-primary dropdown-toggle dropdown-toggle-icon"
                                            data-toggle="dropdown" type="button">
                                            {{__('Actions')}} <i class="dropdown-caret"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-right">
                                            <!--<li><a onclick="confirm_modal('{{route('sliders.destroy', $slider->id)}}');">{{__('Delete')}}</a></li>-->
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
        <div id="demo-lft-tab-10" class="tab-pane fade active in">

            <div class="row">
                <div class="col-sm-12">
                    <a onclick="add_slider('web',2,0)"
                        class="btn btn-rounded btn-info pull-right">{{__('Add New Slider')}}</a>
                </div>
            </div>

            <br>

            <div class="panel">
                <div class="panel-heading">
                    <h3 class="panel-title">{{__('Home Women slider')}}</h3>
                </div>
                <div class="panel-body">
                    <table class="table table-striped table-bordered demo-dt-basic" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>{{__('Photo')}}</th>
                                <th>{{__('Country')}}</th>
                                <th>{{__('Published')}}</th>
                                <th width="10%">{{__('Options')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach(\App\Slider::where('type' , 'web')->where('type1',2)->where('type2',0)->get() as
                            $key => $slider)
                            <tr>
                                <td>{{$key+1}}</td>
                                <td><img class="img-md" src="{{ asset($slider->photo)}}" alt="Slider Image"></td>
                                <td>{{ $countries->where('id',$slider->country_id)->first()['name_'.app()->getLocale()] }}</td>
                                <td><label class="switch">
                                        <input onchange="update_slider_published(this)" value="{{ $slider->id }}"
                                            type="checkbox" <?php if($slider->published == 1) echo "checked";?>>
                                        <span class="slider round"></span></label></td>
                                <td>
                                    <div class="btn-group dropdown">
                                        <button class="btn btn-primary dropdown-toggle dropdown-toggle-icon"
                                            data-toggle="dropdown" type="button">
                                            {{__('Actions')}} <i class="dropdown-caret"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-right">
                                            <!--<li><a onclick="confirm_modal('{{route('sliders.destroy', $slider->id)}}');">{{__('Delete')}}</a></li>-->
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
        <div id="demo-lft-tab-2" class="tab-pane fade">
            <div class="row">
                <div class="col-sm-12">
                    <a onclick="add_banner('web',0,0)" class="btn btn-rounded btn-info pull-right">{{__('Add New Banner')}}</a>
                </div>
            </div>

            <br>

            <div class="panel">
                <div class="panel-heading">
                    <h3 class="panel-title">{{__('Home banner')}}</h3>
                </div>
                <div class="panel-body">
                    <table class="table table-striped table-bordered demo-dt-basic" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>{{__('Photo')}}</th>
                                <th>{{__('Position')}}</th>
                                <th>{{__('Country')}}</th>
                                <th>{{__('Published')}}</th>
                                <th width="10%">{{__('Options')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach(\App\Banner::where('type' , 'web')->get() as $key => $banner)
                            <tr>
                                <td>{{$key+1}}</td>
                                <td><img class="img-md" src="{{ asset($banner->photo)}}" alt="banner Image"></td>
                                <td>{{ __('Banner Position ') }}{{ $banner->position }}</td>
                                <td>{{ $countries->where('id',$banner->country_id)->first()['name_'.app()->getLocale()] }}</td>
                                <td><label class="switch">
                                        <input onchange="update_banner_published(this)" value="{{ $banner->id }}"
                                            type="checkbox" <?php if($banner->published == 1) echo "checked";?>>
                                        <span class="slider round"></span></label></td>
                                <td>
                                    <div class="btn-group dropdown">
                                        <button class="btn btn-primary dropdown-toggle dropdown-toggle-icon"
                                            data-toggle="dropdown" type="button">
                                            {{__('Actions')}} <i class="dropdown-caret"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-right">
                                            <li><a onclick="edit_home_banner({{ $banner->id }},'web',0,0)">{{__('Edit')}}</a>
                                            </li>
                                            <!--<li><a onclick="confirm_modal('{{route('home_banners.destroy', $banner->id)}}');">{{__('Delete')}}</a></li>-->
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
        <div id="demo-lft-tab-3" class="tab-pane fade">

            <div class="row">
                <div class="col-sm-12">
                    <a onclick="add_banner_2()" class="btn btn-rounded btn-info pull-right">{{__('Add New Banner')}}</a>
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
                                <th>{{__('Position')}}</th>
                                <th>{{__('Published')}}</th>
                                <th width="10%">{{__('Options')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach(\App\Banner::where('position', 2)->get() as $key => $banner)
                            <tr>
                                <td>{{$key+1}}</td>
                                <td><img class="img-md" src="{{ asset($banner->photo)}}" alt="banner Image"></td>
                                <td>{{ __('Banner Position ') }}{{ $banner->position }}</td>
                                <td><label class="switch">
                                        <input onchange="update_banner_published(this)" value="{{ $banner->id }}"
                                            type="checkbox" <?php if($banner->published == 1) echo "checked";?>>
                                        <span class="slider round"></span></label></td>
                                <td>
                                    <div class="btn-group dropdown">
                                        <button class="btn btn-primary dropdown-toggle dropdown-toggle-icon"
                                            data-toggle="dropdown" type="button">
                                            {{__('Actions')}} <i class="dropdown-caret"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-right">
                                            <li><a onclick="edit_home_banner_2({{ $banner->id }})">{{__('Edit')}}</a>
                                            </li>
                                            <!--<li><a onclick="confirm_modal('{{route('home_banners.destroy', $banner->id)}}');">{{__('Delete')}}</a></li>-->
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
        <div id="demo-lft-tab-4" class="tab-pane fade">

            <div class="row">
                <div class="col-sm-12">
                    <a onclick="add_home_man_category()"
                        class="btn btn-rounded btn-info pull-right">{{__('Add New Category')}}</a>
                </div>
            </div>

            <br>

            <div class="panel">
                <div class="panel-heading">
                    <h3 class="panel-title">{{__('Man Home Categories')}}</h3>
                </div>
                <div class="panel-body">
                    <table class="table table-striped table-bordered demo-dt-basic" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>{{__('Category')}}</th>
                                <th>{{__('Subsubcategories')}}</th>
                                <th>{{ __('Status') }}</th>
                                <th width="10%">{{__('Options')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach(\App\HomeCategory::where('type',2)->latest()->get() as $key => $home_category)
                            <tr>
                                <td>{{$key+1}}</td>
                                <td>{{$home_category->category['name_'.app()->getLocale()]}}</td>
                                <td>
                                    @foreach (json_decode($home_category->subsubcategories) as $key =>
                                    $subsubcategory_id)
                                    @if (\App\SubSubCategory::find($subsubcategory_id) != null)
                                    <span
                                        class="badge badge-info">{{\App\SubSubCategory::find($subsubcategory_id)['name_'.app()->getLocale()]}}</span>
                                    @endif
                                    @endforeach
                                </td>
                                <td><label class="switch">
                                        <input onchange="update_home_category_status(this)"
                                            value="{{ $home_category->id }}" type="checkbox"
                                            <?php if($home_category->status == 1) echo "checked";?>>
                                        <span class="slider round"></span></label></td>
                                <td>
                                    <div class="btn-group dropdown">
                                        <button class="btn btn-primary dropdown-toggle dropdown-toggle-icon"
                                            data-toggle="dropdown" type="button">
                                            {{__('Actions')}} <i class="dropdown-caret"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-right">
                                            <li><a
                                                    onclick="edit_home_category({{ $home_category->id }})">{{__('Edit')}}</a>
                                            </li>
                                            <!--<li><a onclick="confirm_modal('{{route('home_categories.destroy', $home_category->id)}}');">{{__('Delete')}}</a></li>-->
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
        <div id="demo-lft-tab-9" class="tab-pane fade">

            <div class="row">
                <div class="col-sm-12">
                    <a onclick="add_home_women_category()"
                        class="btn btn-rounded btn-info pull-right">{{__('Add New Category')}}</a>
                </div>
            </div>

            <br>

            <div class="panel">
                <div class="panel-heading">
                    <h3 class="panel-title">{{__('Women Home Categories')}}</h3>
                </div>
                <div class="panel-body">
                    <table class="table table-striped table-bordered demo-dt-basic" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>{{__('Category')}}</th>
                                <th>{{__('Subsubcategories')}}</th>
                                <th>{{ __('Status') }}</th>
                                <th width="10%">{{__('Options')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach(\App\HomeCategory::where('type',1)->latest()->get() as $key => $home_category)
                            <tr>
                                <td>{{$key+1}}</td>
                                <td>{{$home_category->category['name_'.app()->getLocale()]}}</td>
                                <td>
                                    @foreach (json_decode($home_category->subsubcategories) as $key =>
                                    $subsubcategory_id)
                                    @if (\App\SubSubCategory::find($subsubcategory_id) != null)
                                    <span
                                        class="badge badge-info">{{\App\SubSubCategory::find($subsubcategory_id)['name_'.app()->getLocale()]}}</span>
                                    @endif
                                    @endforeach
                                </td>
                                <td><label class="switch">
                                        <input onchange="update_home_category_status(this)"
                                            value="{{ $home_category->id }}" type="checkbox"
                                            <?php if($home_category->status == 1) echo "checked";?>>
                                        <span class="slider round"></span></label></td>
                                <td>
                                    <div class="btn-group dropdown">
                                        <button class="btn btn-primary dropdown-toggle dropdown-toggle-icon"
                                            data-toggle="dropdown" type="button">
                                            {{__('Actions')}} <i class="dropdown-caret"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-right">
                                            <li><a
                                                    onclick="edit_home_category({{ $home_category->id }})">{{__('Edit')}}</a>
                                            </li>
                                            <!--<li><a onclick="confirm_modal('{{route('home_categories.destroy', $home_category->id)}}');">{{__('Delete')}}</a></li>-->
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
        
        <div id="demo-lft-tab-5" class="tab-pane fade active in">

            <div class="row">
                <div class="col-sm-12">
                    <a onclick="add_slider('mobile',1,0)"
                        class="btn btn-rounded btn-info pull-right">{{__('Add New Slider')}}</a>
                </div>
            </div>

            <br>

            <div class="panel">
                <div class="panel-heading">
                    <h3 class="panel-title">{{__('App Man slider')}}</h3>
                </div>
                <div class="panel-body">
                    <table class="table table-striped table-bordered demo-dt-basic" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>{{__('Photo')}}</th>
                                <th>{{__('Country')}}</th>
                                <th>{{__('Published')}}</th>
                                <th width="10%">{{__('Options')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach(\App\Slider::where('type' , 'mobile')->where('type1',1)->where('type2',0)->get() as
                            $key => $slider)
                            <tr>
                                <td>{{$key+1}}</td>
                                <td><img class="img-md" src="{{ asset($slider->photo)}}" alt="Slider Image"></td>
                                <td>{{ $countries->where('id',$slider->country_id)->first()['name_'.app()->getLocale()] }}</td>
                                <td><label class="switch">
                                        <input onchange="update_slider_published(this)" value="{{ $slider->id }}"
                                            type="checkbox" <?php if($slider->published == 1) echo "checked";?>>
                                        <span class="slider round"></span></label></td>
                                <td>
                                    <div class="btn-group dropdown">
                                        <button class="btn btn-primary dropdown-toggle dropdown-toggle-icon"
                                            data-toggle="dropdown" type="button">
                                            {{__('Actions')}} <i class="dropdown-caret"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-right">
                                            <!--<li><a onclick="confirm_modal('{{route('sliders.destroy', $slider->id)}}');">{{__('Delete')}}</a></li>-->
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
        <div id="demo-lft-tab-6" class="tab-pane fade active in">

            <div class="row">
                <div class="col-sm-12">
                    <a onclick="add_slider('mobile',2,0)"
                        class="btn btn-rounded btn-info pull-right">{{__('Add New Slider')}}</a>
                </div>
            </div>

            <br>

            <div class="panel">
                <div class="panel-heading">
                    <h3 class="panel-title">{{__('App Women slider')}}</h3>
                </div>
                <div class="panel-body">
                    <table class="table table-striped table-bordered demo-dt-basic" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>{{__('Photo')}}</th>
                                <th>{{__('Country')}}</th>
                                <th>{{__('Published')}}</th>
                                <th width="10%">{{__('Options')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach(\App\Slider::where('type' , 'mobile')->where('type1',2)->where('type2',0)->get() as
                            $key => $slider)
                            <tr>
                                <td>{{$key+1}}</td>
                                <td><img class="img-md" src="{{ asset($slider->photo)}}" alt="Slider Image"></td>
                                <td>{{ $countries->where('id',$slider->country_id)->first()['name_'.app()->getLocale()] }}</td>
                                <td><label class="switch">
                                        <input onchange="update_slider_published(this)" value="{{ $slider->id }}"
                                            type="checkbox" <?php if($slider->published == 1) echo "checked";?>>
                                        <span class="slider round"></span></label></td>
                                <td>
                                    <div class="btn-group dropdown">
                                        <button class="btn btn-primary dropdown-toggle dropdown-toggle-icon"
                                            data-toggle="dropdown" type="button">
                                            {{__('Actions')}} <i class="dropdown-caret"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-right">
                                            <!--<li><a onclick="confirm_modal('{{route('sliders.destroy', $slider->id)}}');">{{__('Delete')}}</a></li>-->
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
        <div id="demo-lft-tab-7" class="tab-pane fade">
            <div class="row">
                <div class="col-sm-12">
                    <a onclick="add_banner('mobile',0,0)" class="btn btn-rounded btn-info pull-right">{{__('Add New Banner')}}</a>
                </div>
            </div>

            <br>

            <div class="panel">
                <div class="panel-heading">
                    <h3 class="panel-title">{{__('App banner')}}</h3>
                </div>
                <div class="panel-body">
                    <table class="table table-striped table-bordered demo-dt-basic" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>{{__('Photo')}}</th>
                                <th>{{__('Position')}}</th>
                                <th>{{__('Country')}}</th>
                                <th>{{__('Published')}}</th>
                                <th width="10%">{{__('Options')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach(\App\Banner::where('type' , 'mobile')->get() as $key => $banner)
                            <tr>
                                <td>{{$key+1}}</td>
                                <td><img class="img-md" src="{{ asset($banner->photo)}}" alt="banner Image"></td>
                                <td>{{ __('Banner Position ') }}{{ $banner->position }}</td>
                                <td>{{ $countries->where('id',$banner->country_id)->first()['name_'.app()->getLocale()] }}</td>
                                <td><label class="switch">
                                        <input onchange="update_banner_published(this)" value="{{ $banner->id }}"
                                            type="checkbox" <?php if($banner->published == 1) echo "checked";?>>
                                        <span class="slider round"></span></label></td>
                                <td>
                                    <div class="btn-group dropdown">
                                        <button class="btn btn-primary dropdown-toggle dropdown-toggle-icon"
                                            data-toggle="dropdown" type="button">
                                            {{__('Actions')}} <i class="dropdown-caret"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-right">
                                            <li><a onclick="edit_home_banner({{ $banner->id }},'mobile',0,0)">{{__('Edit')}}</a>
                                            </li>
                                            <!--<li><a onclick="confirm_modal('{{route('home_banners.destroy', $banner->id)}}');">{{__('Delete')}}</a></li>-->
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
        
        
        <div id="demo-lft-tab-8" class="tab-pane fade">
            <div class="panel">
                <div class="panel-heading">
                    <h3 class="panel-title">{{__('Main banner')}}</h3>
                </div>

                <!--Horizontal Form-->
                <!--===================================================-->
                <form class="form-horizontal" action="{{ route('main_banners.store') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="panel-body">
                        <div class="form-group">
                            <label class="col-sm-3" for="url">{{__('main banner')}}</label>
                            <div class="col-sm-9">
                                <input class="form-control" name="main_banner"
                                    value="{{\App\GeneralSetting::first()->main_banner}}" type="text" minlength="3"
                                    maxlength="30">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3" for="url">{{__('secondary banner 1')}}</label>
                            <div class="col-sm-9">
                                <input class="form-control" name="secondary_banner[]"
                                    value="{{unserialize(\App\GeneralSetting::first()->secondary_banner)[0]}}"
                                    type="text" minlength="3" maxlength="30">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3" for="url">{{__('secondary banner 2')}}</label>
                            <div class="col-sm-9">
                                <input class="form-control" name="secondary_banner[]"
                                    value="{{unserialize(\App\GeneralSetting::first()->secondary_banner)[1]}}"
                                    type="text" minlength="3" maxlength="30">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3" for="url">{{__('secondary banner 3')}}</label>
                            <div class="col-sm-9">
                                <input class="form-control" name="secondary_banner[]"
                                    value="{{unserialize(\App\GeneralSetting::first()->secondary_banner)[2]}}"
                                    type="text" minlength="3" maxlength="30">
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
    </div>
</div>

@endsection

@section('script')

<script type="text/javascript">
    function updateSettings(el, type){
        if($(el).is(':checked')){
            var value = 1;
        }
        else{
            var value = 0;
        }
        $.post('{{ route('business_settings.update.activation') }}', {_token:'{{ csrf_token() }}', type:type, value:value}, function(data){
            if(data == 1){
                showAlert('success', 'Settings updated successfully');
            }
            else{
                showAlert('danger', 'Something went wrong');
            }
        });
    }

    function add_slider(t,t1,t2){
        $.get('{{ route('sliders.create')}}', {type:t, type1:t1, type2:t2}, function(data){
            if(t == 'web'){
                if(t1==1 && t2==0)
                    $('#demo-lft-tab-1').html(data);
                else if(t1==2 && t2==0)
                    $('#demo-lft-tab-10').html(data);
            }else if(t == 'mobile'){
                if(t1==1 && t2==0)
                    $('#demo-lft-tab-5').html(data);
                else if(t1==2 && t2==0)
                    $('#demo-lft-tab-6').html(data);
            }
        });
    }

    function add_banner(t,t1,t2){
        $.get('{{ route('home_banners.create', 1)}}', {type:t, type1:t1, type2:t2}, function(data){
            if(t == 'web'){
                if(t1==0 && t2==0)
                    $('#demo-lft-tab-2').html(data);
                // else if(t1==2 && t2==0)
                //     $('#demo-lft-tab-10').html(data);
            }else if(t == 'mobile'){
                                if(t1==0 && t2==0)
                    $('#demo-lft-tab-7').html(data);
            }
        });
    }

    function add_banner_1(){
        $.get('{{ route('home_banners.create', 1)}}', {}, function(data){
            $('#demo-lft-tab-2').html(data);
        });
    }

    function add_banner_2(){
        $.get('{{ route('home_banners.create', 2)}}', {}, function(data){
            $('#demo-lft-tab-3').html(data);
        });
    }

    function add_banner_app(){
        $.get('{{ route('home_banners.create', 1)}}', {type:'mobile'}, function(data){
            $('#demo-lft-tab-7').html(data);
        });
    }

    function edit_home_banner(id,t,t1,t2){
        var url = '{{ route("home_banners.edit", "home_banner_id") }}';
        url = url.replace('home_banner_id', id);
        $.get(url, {}, function(data){
            if(t == 'web'){
                if(t1==0 && t2==0)
                    $('#demo-lft-tab-2').html(data);
                // else if(t1==2 && t2==0)
                //     $('#demo-lft-tab-10').html(data);
            }else if(t == 'mobile'){
                if(t1==0 && t2==0)
                    $('#demo-lft-tab-7').html(data);
            }
            
            $('.demo-select2-placeholder').select2();
        });
    }

    function edit_home_banner_1(id){
        var url = '{{ route("home_banners.edit", "home_banner_id") }}';
        url = url.replace('home_banner_id', id);
        $.get(url, {}, function(data){
            $('#demo-lft-tab-2').html(data);
            $('.demo-select2-placeholder').select2();
        });
    }

    function edit_home_banner_2(id){
        var url = '{{ route("home_banners.edit", "home_banner_id") }}';
        url = url.replace('home_banner_id', id);
        $.get(url, {}, function(data){
            $('#demo-lft-tab-3').html(data);
            $('.demo-select2-placeholder').select2();
        });
    }

    function add_home_man_category(){
        $.get('{{ route('home_categories.create')}}?type=2', {}, function(data){
            $('#demo-lft-tab-4').html(data);
            $('.demo-select2-placeholder').select2();
        });
    }

    function add_home_women_category(){
        $.get('{{ route('home_categories.create')}}?type=1', {}, function(data){
            $('#demo-lft-tab-9').html(data);
            $('.demo-select2-placeholder').select2();
        });
    }

    function edit_home_women_category(id){
        var url = '{{ route("home_categories.edit", "home_category_id") }}?type=1';
        url = url.replace('home_category_id', id);
        $.get(url, {}, function(data){
            $('#demo-lft-tab-9').html(data);
            $('.demo-select2-placeholder').select2();
        });
    }

    function edit_home_man_category(id){
        var url = '{{ route("home_categories.edit", "home_category_id") }}?type=2';
        url = url.replace('home_category_id', id);
        $.get(url, {}, function(data){
            $('#demo-lft-tab-4').html(data);
            $('.demo-select2-placeholder').select2();
        });
    }

    function update_home_category_status(el){
        if(el.checked){
            var status = 1;
        }
        else{
            var status = 0;
        }
        $.post('{{ route('home_categories.update_status') }}', {_token:'{{ csrf_token() }}', id:el.value, status:status}, function(data){
            if(data == 1){
                showAlert('success', 'Home Page Category status updated successfully');
            }
            else{
                showAlert('danger', 'Something went wrong');
            }
        });
    }

    function update_banner_published(el){
        if(el.checked){
            var status = 1;
        }
        else{
            var status = 0;
        }
        $.post('{{ route('home_banners.update_status') }}', {_token:'{{ csrf_token() }}', id:el.value, status:status}, function(data){
            if(data == 1){
                showAlert('success', 'Banner status updated successfully');
            }
            else{
                showAlert('danger', 'Maximum 4 banners to be published');
            }
        });
    }

    function update_slider_published(el){
        if(el.checked){
            var status = 1;
        }
        else{
            var status = 0;
        }
        var url = '{{ route('sliders.update', 'slider_id') }}';
        url = url.replace('slider_id', el.value);

        $.post(url, {_token:'{{ csrf_token() }}', status:status, _method:'PATCH'}, function(data){
            if(data == 1){
                showAlert('success', 'Published sliders updated successfully');
            }
            else{
                showAlert('danger', 'Something went wrong');
            }
        });
    }
</script>

@endsection