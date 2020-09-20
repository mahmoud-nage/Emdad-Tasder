@extends('affiliate.layouts.app')

@section('content')


    <div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="banners">



        <!-- end:: Subheader -->

        <!-- begin:: Content -->
        <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">

            <div class="kt-portlet kt-portlet--mobile">
                <div class="kt-portlet__head kt-portlet__head--lg">
                    <div class="kt-portlet__head-label">
										<span class="kt-portlet__head-icon">
											<i class="kt-font-brand flaticon2-box"></i>
										</span>
                        <h3 class="kt-portlet__head-title">
                            Banners
                        </h3>
                    </div>
                </div>
                <div class="kt-portlet__body">

                    <!--begin: Search Form -->
                    <table class="table table-striped- table-bordered table-hover table-checkable" id="kt_table_1">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>{{__('Photo')}}</th>
                            <th>{{__('URL')}}</th>
                            <th>{{__('Type')}}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach(\App\BannerAffiliate::all() as $key => $banner)
                            <tr>
                                <td>{{$key+1}}</td>
                                <td><a href="{{ asset($banner->photo) }}" target="_blank">
                                        <img class="img-md" src="{{ asset($banner->photo)}}" alt="banner Image" width="200">
                                    </a></td>
                                <td>{{ $banner->url }}</td>
                                <td>{{ $banner->type }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                    <!--end: Search Form -->
                </div>


            </div>
        </div>
        <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">New URL</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form>
                        <div class="modal-body">
                            <form>
                                <div class="form-group">
                                    <label for="recipient-name" class="col-form-label">Type:</label>
                                    <select name="type" class="form-control" required>
                                        <option value="">Type</option>
                                        <option value="home">Home</option>
                                        <option value="offers">Offers</option>
                                        <option value="products">Products</option>
                                        <option value="product">Product</option>
                                    </select>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Create</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>

        <!-- end:: Content -->
    </div>


@stop
